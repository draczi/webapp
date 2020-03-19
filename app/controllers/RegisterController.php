<?php
namespace App\Controllers;
use Core\Controller;
use Core\Router;
use App\Models\Users;
use App\Models\resetPassword;
use App\Models\Contacts;
use App\Models\Login;
use Core\H;
use Core\Session;
use Core\Model;


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
                    $remember = $loginModel->getRememberMeChecked();
                    $user->login($remember);
                    Router::redirect('');
                }  else {
                    $loginModel->addErrorMessage('username','There is an error with your username or password');
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
        $contact = Contacts::findByUserId($user->id);
        if (empty($contact)) {
            $contact = new Contacts();
        }
        if($this->request->isPost()) {
            $this->request->csrfCheck();
            $user->assign($this->request->get(),Users::blackListedFormKeys);
            $user->confirm =$this->request->get('confirm');
            if($user->save()){
                if($this->request->get('address') != '' || $this->request->get('city') != '' || $this->request->get('country') != '' || $this->request->get('phone') != '' || $this->request->get('mobile_phone') != '' || $this->request->get('ostermelo_id') != '' || $this->request->get('adoszam') != '' || $this->request->get('zip_code') != '') {

                    $contact -> assign($this->request->get());
                    $contact->user_id = Model::getDb()->lastID();
                    $contact->save();
                }
                Router::redirect('/');
            }
        }
        $this->view->acls = Users::getOptionForForm($new = true);
        $this->view->user = $user;
        $this->view->contact = $contact;
        $this->view->displayErrors = $user->getErrorMessages();
        $this->view->render('register/contact');
    }

    public function passwordChangeAction() {
        $user = Users::currentUser();
        if(password_verify($this->request->get('old_password'), $user->password)) {
            $this->request->csrfCheck();
            $user->assign($this->request->get(),Users::blackListedFormKeys);
            $user->confirm =$this->request->get('confirm');
            if($user->save()){
                Session::addMsg('success', 'Sikeresen megváltoztattad jelszavad!');
                Router::redirect('/');
            }
            $this->view->displayErrors = $user->getErrorMessages();
            $this->view->render('register/passwordChange');
        }
        $this->view->displayErrors = $user->getErrorMessages();
        $this->view->user = $user;
        $this->view->render('register/passwordChange');
    }

    public function resetPasswordAction($token = false) {
        $errorMessage = array();
        $resetPassModel = new resetPassword();
        if(!$token) {

            if($this->request->isPost()) {
                $this->request->csrfCheck();
                $resetPassModel->assign($this->request->get());
                $resetPassModel->validator();
                if($resetPassModel->validationPassed()){
                    $user = Users::findByEmail($this->request->get('email'));
                    if($user) {
                        $resetPassModel->token = $token = uniqid(md5(time())); // ez egy random token
                        if($resetPassModel->save()){
                            $to = $this->request->get('email');
                            $subject = "Password reset link";
                            $message = "<div style='width: 1000px;margin: 20px auto;'><h1 style='text-align:center'>Ez egy jelszó módosító email</h1><br><br><br>
                            <table><h3>Amennyiben nem ön kérte a jelszó emlékeztetőt abban az esetben kérem tekintse tárgytalannak az emailünket.</h3><tr><td>Drácz István</td><td>istvan.dracz@gmail.com</td></tr><tr><td>Click <a href='https://dracz1.51.profitarhely.hu/register/resetPassword/".$token."'>Here</a> to reset your password.</td></tr></table></div>";
                            $headers = "MIME-Version: 1.0". "\r\n";
                            $headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";
                            $headers .= "From: <demo@demo.com" . "\r\n";
                            mail($to, $subject, $message, $headers);
                            Session::addMsg('success', 'Új jelszavát elküldtük emailben.');
                            Router::redirect('register/login');
                        }
                    } else {
                        $resetPassModel->addErrorMessage('email', 'Az email cím nem található az adatbázisban!');
                    }
                }
            }
            $this->view->displayErrors = $resetPassModel->getErrorMessages();
            $this->view->render('register/resetPassword');

        } else {
            if (!($userPass = resetPassword::findByToken($token))) {
                Session::addMsg('danger', 'Sajnálom ilyen link nem létezik.');
                Router::redirect('');
            }
            $user = Users::findUserById($userPass->id);
            if($this->request->isPost()) {
                $this->request->csrfCheck();
                $resetPassModel->assign($this->request->get());
                $resetPassModel->validator(); H::dnd($user);
                if (!$resetPassModel->getErrorMessages()) {
                    Users::modifyPassword($user->id, $this->request->get('password'));
                    Session::addMsg('success', 'Jelszó megváltoztatva');
                } else {
                    H::dnd('van hiba');
                }

              //   if ($this->request->get('confirm') != $this->request->get('password')) {
              //
              //     $errorMessage[] .= "Nem egyezik a két jelszó! <br>";
              // } else if($this->request->get('password') == '' || $this->request->get('confirm') == '') {
              //     $errorMessage[] = "Minden jelszó mezőt ki kell tölteni!";
              // }
            }
            $this->view->user = $user;
            $this->view->displayErrors = $resetPassModel->getErrorMessages();
            $this->view->render('register/resetPasswordForm');
        }


    }


}
