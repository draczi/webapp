<?php
  use Core\FH;
?>
<?php $this->start('head'); ?>
<?php $this->end(); ?>

<?php $this->start('body'); ?>
  <div class="col-md-6 col-md-offset-3 well">
    <form class="form" action="<?=PROOT?>register/login" method="post">
      <?=FH::csrfInput() ?>
      <?=FH::displayErrors($this->displayErrors) ?>
      <h3 class="text-center">Log In</h3>
      <?=FH::inputBlock('text', 'Username', 'username', $this->login->username, ['class'=>'form-control'], ['class'=>'form-group']) ?>
      <?=FH::inputBlock('password', 'Password', 'password', $this->login->password, ['class'=>'form-control'], ['class'=>'form-group']) ?>
      <?=FH::checkboxBlock('Remember me', 'remember_me', $this->login->getRememberMeChecked(),[],['class'=>'form-group']); ?>
      <?=FH::submitBlock('Login', ['class'=>'btn btn-large btn-primary'],['class'=>'form-group']) ?>
      <div class="text-right">
        <a href="<?=PROOT?>register/register" class="text-primary">Register</a>
      </did>
    </form>
  </div>
<?php $this->end(); ?>
