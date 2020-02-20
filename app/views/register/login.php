<?php
  use Core\FH;
?>
<?php $this->start('head'); ?>
<?php $this->end(); ?>
<?php $this->setSiteTitle('Bejelentkezés'); ?>

<?php $this->start('body'); ?>
<div class="a" style="background-image: url(<?=PROOT?>images/header_kep.jpg); background-size: cover; background-repeat: no-repeat; background-position:center; height: 400px; "> </div>
  <div class="login-form col-md-8">
    <form class="form" action="<?=PROOT?>register/login" method="post">
      <?=FH::csrfInput() ?>
      <?=FH::displayErrors($this->displayErrors) ?>
      <h3 class="text-center">Bejelentkezés</h3>
      <?=FH::inputBlock('text', 'Felhasználó név', 'username', $this->login->username, ['class'=>'form-control'], ['class'=>'form-group'], $this->displayErrors) ?>
      <?=FH::inputBlock('password', 'Jelszó', 'password', $this->login->password, ['class'=>'form-control'], ['class'=>'form-group']) ?>
      <?=FH::checkboxBlock('Emlékezz rám!', 'remember_me', $this->login->getRememberMeChecked(),[],['class'=>'form-group']); ?>
      <?=FH::submitBlock('Bejelentkezés', ['class'=>'btn btn-large btn-primary'],['class'=>'form-group']) ?>
      <div class="text-right">
        <a href="<?=PROOT?>register/register" class="text-primary">Regisztráció</a>
      </did>
    </form>
  </div>
</div>
<?php $this->end(); ?>
