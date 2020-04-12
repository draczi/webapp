<?php
  use Core\FH;
?>
<?php $this->start('head'); ?>
<?php $this->end(); ?>
<?php $this->setSiteTitle('Bejelentkezés'); ?>

<?php $this->start('body'); ?>
  <div class="login-form col-md-8">
    <form class="form" action="<?=PROOT?>register/login" method="post">
      <?=FH::csrfInput() ?>
      <?=FH::displayErrors($this->displayErrors) ?>
      <h3 class="text-center">Bejelentkezés</h3>
      <?=FH::inputBlock('text', 'Felhasználó név', 'username', $this->login->username, ['class'=>'form-control'], ['class'=>'form-group']) ?>
      <?=FH::inputBlock('password', 'Jelszó', 'password', $this->login->password, ['class'=>'form-control'], ['class'=>'form-group']) ?>
      <?=FH::submitBlock('Bejelentkezés', ['class'=>'btn btn-large btn-primary', 'style' => 'background-color: #17a2b8; border:none; color: #fff '],['class'=>'form-group col-md-3']) ?>
      <div class="text-right">
         <a href="<?=PROOT?>register/forgottenPassword" class="login-text" style="margin-right: 20px;  ">Elfelejtett jelszó</a>
        <a href="<?=PROOT?>register/register" class="login-text">Regisztráció</a>

      </did>
    </form>
  </div>
</div>
<?php $this->end(); ?>
