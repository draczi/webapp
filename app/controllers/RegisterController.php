<?php
namespace App\Controllers;
use Core\Controller;
use Core\Model;
use Core\Emails;
use Core\Router;
use App\Models\{Users,ResetPasswords,Contacts,Login};
use Core\H;
use Core\Session;

class RegisterController extends Controller {

    public function onConstruct(){
        $this->view->setLayout('default');
    }

    public function loginAction() {
        $loginModel = new Login();
        if($this->request->isPost()) {
            // form validation
            $this->request->csrfCheck();
            $loginModel->assign($this->request->get());
            $loginModel->validator();
            if($loginModel->validationPassed()){
                $user = Users::findByUsername($_POST['username']);
                if($user && password_verify($this->request->get('password'), $user->password)) {
                    $user->belepesDate($user->id);
                    $user->login();
                    if($user->acl == 3) Router::redirect('adminProducts');
                    Router::redirect('');
                }  else {
                    $loginModel->addErrorMessage('username','A felhasználónév, jelszó páros nem megfelelő.');
                }
            }
        }
        $this->view->login = $loginModel;
        $this->view->displayErrors = $loginModel->getErrorMessages();
        $this->view->render('register/login');
    }

    public function logoutAction() {
        if(Users::currentUser()) {
            Users::currentUser()->logout();
        }
        Router::redirect('home');
    }

    public function registerAction() {
        $newUser = new Users();
        if($this->request->isPost()) {
            $this->request->csrfCheck();
            $newUser->assign($this->request->get(),Users::blackListedFormKeys);
            $newUser->confirm =$this->request->get('confirm');
            if($newUser->save()){
                Session::addMsg('success', 'Sikeres regisztráció!');
                Router::redirect('register/login');
            }
        }
        $this->view->newUser = $newUser;
        $this->view->displayErrors = $newUser->getErrorMessages();
        $this->view->render('register/register');
    }

    public function contactAction() {
        $user = Users::currentUser();
        if($this->request->isPost()) {
            $this->request->csrfCheck();
            $user->assign($this->request->get(),Users::blackListedFormKeys);
            $user->confirm =$this->request->get('confirm');
            $user->username = $user->username;
            $user->email = $user->email;
            $user->acl = $user->acl;
            if($user->save()){
                Session::addMsg('success', 'Sikeresen megváltoztattad az adatokat!');
                Router::redirect('/');
            }
        }
        $this->view->acls = Users::getOptionAcls($new = true);
        $this->view->user = $user;
        $this->view->displayErrors = $user->getErrorMessages();
        $this->view->render('register/contact');
    }

    public function passwordChangeAction($token) {
        if (!($userPass = ResetPasswords::findByToken($token))) {
            Session::addMsg('danger', 'Sajnálom ilyen link nem létezik.');
            Router::redirect('');
        }
        $user =  Users::findById($userPass->user_id);
        if($this->request->isPost()) {
            $this->request->csrfCheck();
            if($this->request->get('password') == '' || $this->request->get('confirm') == '') {
                $user->addErrorMessage('password','A jelszó mezők kitöltése kötelező.');
            } elseif ($this->request->get('confirm') != $this->request->get('password')) {
                $user->addErrorMessage('NotMatch', 'Nem egyeznek a jelszavak.');
            } elseif (strlen($this->request->get('password')) < 5) {
                $user->addErrorMessage('password', 'A jelszónak minimum 5 karakter hosszúságúnak kell lennie.');
            }
            if(empty($user->getErrorMessages())) {
                Users::changePassword($user->id,  password_hash($this->request->get('password'), PASSWORD_DEFAULT));
                ResetPasswords::deleteToken($userPass->token);
                Session::addMsg('success', 'Megváltoztatta a jelszavát.');
                Router::redirect('register/login');
            }
        }
        $this->view->user = $user;
        $this->view->displayErrors = $user->getErrorMessages();
        $this->view->render('register/passwordChange');
    }

    public function forgottenPasswordAction() {
        $errorMessage = array();
        $resetPassModel = new ResetPasswords();

        if($this->request->isPost()) {
            $this->request->csrfCheck();
            $resetPassModel->assign($this->request->get());
            $resetPassModel->validator();
            if($resetPassModel->validationPassed()){
                $user = Users::findByEmail($this->request->get('email'));
                if($user) {
                    if($token = ResetPasswords::findByUserId($user->id)) $token->deleteToken($token->token);
                    $resetPassModel->token = $token = uniqid(md5(time())); // random token
                    $resetPassModel->user_id = $user->id;
                    if($resetPassModel->save()){
                        Emails::forgottenPasswordSablon($user->username, $user->email, $token);
                        Session::addMsg('success', 'Jelszava módosításához szükséges linket elküldtük emailben.');
                        Router::redirect('register/login');
                    }
                } else {
                    $resetPassModel->addErrorMessage('email', 'Az e-mail cím nem található az adatbázisban!');
                }
            }
        }
        $this->view->displayErrors = $resetPassModel->getErrorMessages();
        $this->view->render('register/resetPassword');
    }


}
