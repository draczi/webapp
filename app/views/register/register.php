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
      <?= FH::inputBlock('text','Vezetéknév', 'lname', $this->newUser->lname, ['class' => 'form-control input-sm'], ['class' => 'form-group'],$this->displayErrors); ?>
      <?= FH::inputBlock('text','Keresztnév', 'fname', $this->newUser->fname, ['class' => 'form-control input-sm'], ['class' => 'form-group'],$this->displayErrors) ?>
      <?= FH::inputBlock('text','E-mail', 'email', $this->newUser->email, ['class' => 'form-control input-sm'], ['class' => 'form-group'],$this->displayErrors); ?>
      <?= FH::inputBlock('text','Felhasználó név', 'username', $this->newUser->username, ['class' => 'form-control input-sm'], ['class' => 'form-group'],$this->displayErrors); ?>
      <?= FH::inputBlock('password','Jelszó', 'password', $this->newUser->password, ['class' => 'form-control input-sm'], ['class' => 'form-group'],$this->displayErrors); ?>
      <?= FH::inputBlock('password','Jelszó mégegyszer', 'confirm', $this->newUser->confirm, ['class' => 'form-control input-sm'], ['class' => 'form-group'],$this->displayErrors); ?>
      <div class="row">
          <?= FH::inputBlock('text','Cím', 'address', $this->newUser->address, ['class' => 'form-control'], ['class' => 'form-group col-md-12 '],$this->displayErrors); ?>
      </div>
      <div class="row">
          <?= FH::inputBlock('text','Város', 'city', $this->newUser->city, ['class' => 'form-control'], ['class' => 'form-group col-md-9 '],$this->displayErrors); ?>
          <?= FH::inputBlock('text','Irányítószám', 'zip_code', $this->newUser->zip_code, ['class' => 'form-control'], ['class' => 'form-group col-md-3 '],$this->displayErrors); ?>
      </div>
      <div class="row">
          <?= FH::inputBlock('text','Ország', 'country', $this->newUser->country, ['class' => 'form-control'], ['class' => 'form-group col-md-12 '],$this->displayErrors); ?>
      </div>
      <div class="row">
          <?= FH::inputBlock('text','Mobiltelefon szám', 'mobile_phone', $this->newUser->mobile_phone, ['class' => 'form-control'], ['class' => 'form-group col-md-6 '],$this->displayErrors); ?>
          <?= FH::inputBlock('text','Telefonszám', 'phone', $this->newUser->phone, ['class' => 'form-control'], ['class' => 'form-group col-md-6 '],$this->displayErrors); ?>
      </div>
      <div class="row">
          <?= FH::inputBlock('text','Adószám', 'adoszam', $this->newUser->tax_number, ['class' => 'form-control'], ['class' => 'form-group col-md-6 '],$this->displayErrors); ?>
          <?= FH::inputBlock('text','Őstermelői igazolvány', 'ostermelo_id', $this->newUser->producer_number, ['class' => 'form-control'], ['class' => 'form-group col-md-6 '],$this->displayErrors); ?>
      </div>
      <?= FH::submitBlock('Regisztráció', ['class' => 'btn btn-primary btn-large', 'style' => "margin-top: 10px"], ['class' => 'text-right'],$this->displayErrors)?>
    </form>
</div>
</div>
<?php $this->end(); ?>
