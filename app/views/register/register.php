<?php
  use Core\FH;
?>
<?php $this->start('head'); ?>
<?php $this->end(); ?>
<?php $this->start('body'); ?>
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
      <div class="row">
          <?= FH::inputBlock('text','Cím', 'address', $this->newUser->address, ['class' => 'form-control'], ['class' => 'form-group col-md-12 ']); ?>
      </div>
      <div class="row">
          <?= FH::inputBlock('text','Város', 'city', $this->newUser->city, ['class' => 'form-control'], ['class' => 'form-group col-md-9 ']); ?>
          <?= FH::inputBlock('text','Irányítószám', 'zip_code', $this->newUser->zip_code, ['class' => 'form-control'], ['class' => 'form-group col-md-3 ']); ?>
      </div>
      <div class="row">
          <?= FH::inputBlock('text','Ország', 'country', $this->newUser->country, ['class' => 'form-control'], ['class' => 'form-group col-md-12 ']); ?>
      </div>
      <div class="row">
          <?= FH::inputBlock('text','Mobiltelefon szám', 'mobile_phone', $this->newUser->mobile_phone, ['class' => 'form-control'], ['class' => 'form-group col-md-6 ']); ?>
          <?= FH::inputBlock('text','Telefonszám', 'phone', $this->newUser->phone, ['class' => 'form-control'], ['class' => 'form-group col-md-6 ']); ?>
      </div>
      <div class="row">
          <?= FH::inputBlock('text','Adószám', 'adoszam', $this->newUser->tax_number, ['class' => 'form-control'], ['class' => 'form-group col-md-6 ']); ?>
          <?= FH::inputBlock('text','Őstermelői igazolvány', 'ostermelo_id', $this->newUser->producer_number, ['class' => 'form-control'], ['class' => 'form-group col-md-6 ']); ?>
      </div>
      <?= FH::submitBlock('Regisztráció', ['class' => 'btn btn-primary btn-large', 'style' => "margin-top: 10px"], ['class' => 'text-right'])?>
    </form>
</div>
</div>
<?php $this->end(); ?>
