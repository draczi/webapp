<?php
  use Core\FH;
?>
<?php $this->start('head'); ?>
<?php $this->end(); ?>
<?php $this->start('body'); ?>
<div class="a" style="background-image: url(<?=PROOT?>images/header_kep.jpg); background-size: cover; background-repeat: no-repeat; background-position:center; height: 400px; "> </div>
<div class="regist-container col-md-10">
<div class="regist-form col-md-8">
  <h3 class="text-center">Regisztráció</h3>
    <form action="" class="form" method="post">
      <?=FH::csrfInput() ?>
      <?= FH::displayErrors($this->displayErrors)?>
      <?= FH::inputBlock('text','Vezetéknév', 'lname', $this->newUser->lname, ['class' => 'form-control input-sm'], ['class' => 'form-group']); ?>
      <?= FH::inputBlock('text','Keresztnév', 'fname', $this->newUser->fname, ['class' => 'form-control input-sm'], ['class' => 'form-group']) ?>
      <?= FH::inputBlock('text','E-mail', 'email', $this->newUser->email, ['class' => 'form-control input-sm'], ['class' => 'form-group']); ?>
      <?= FH::inputBlock('text','Felhasználó név', 'username', $this->newUser->username, ['class' => 'form-control input-sm'], ['class' => 'form-group']); ?>
      <?= FH::inputBlock('password','Jelszó', 'password', $this->newUser->password, ['class' => 'form-control input-sm'], ['class' => 'form-group']); ?>
      <?= FH::inputBlock('password','Jelszó mégegyszer', 'confirm', $this->newUser->confirm, ['class' => 'form-control input-sm'], ['class' => 'form-group']); ?>
      <?= FH::submitBlock('Regisztráció', ['class' => 'btn btn-primary btn-large', 'style' => "margin-top: 10px"], ['class' => 'text-right'])?>
    </form>
</div>
</div>
<?php $this->end(); ?>
