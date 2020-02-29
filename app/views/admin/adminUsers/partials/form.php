<?php
  use Core\FH;
?>
<form action="<?=$this->formAction?>" method="POST" enctype="multipart/form-data">
  <?= FH::csrfInput()?>
  <?= FH::displayErrors($this->displayErrors) ?>
  <div class="row">
  <?= FH::inputBlock('text','Vezetéknév', 'lname', '', ['class' => 'form-control'], ['class' => 'form-group col-md-6 ']); ?>
  <?= FH::inputBlock('text','Keresztnév', 'fname', '', ['class' => 'form-control'], ['class' => 'form-group col-md-6']) ?>
</div>
<div class="row">
<?= FH::inputBlock('text','Felhasználó név', 'username','', ['class' => 'form-control '], ['class' => 'form-group col-md-6']); ?>
  <?= FH::inputBlock('text','E-mail', 'email', '', ['class' => 'form-control'], ['class' => 'form-group col-md-6']); ?>
</div>
<div class="row">
  <?= FH::inputBlock('password','Jelszó', 'password','', ['class' => 'form-control '], ['class' => 'form-group col-md-6']); ?>
  <?= FH::inputBlock('password','Jelszó mégegyszer', 'confirm', '', ['class' => 'form-control '], ['class' => 'form-group col-md-6']); ?>
</div>
<div class="row">
<?= FH::selectBlock('Felhasználói szint', 'acl', $this->acl, $this->acls,['class' => 'form-control form-control-sm'], ['class' => 'form-group col-3']) ?>
</div>

<hr style=" margin: 50px auto; background: #E7E7E7">

 <div class="row"><h4 class="user_adatok">Személyes adatok</h4></div>
 <div class="row">
     <?= FH::inputBlock('text','Cím', 'address', '', ['class' => 'form-control'], ['class' => 'form-group col-md-12 ']); ?>
 </div>
 <div class="row">
     <?= FH::inputBlock('text','Város', 'city', '', ['class' => 'form-control'], ['class' => 'form-group col-md-4 ']); ?>
     <?= FH::inputBlock('text','Irányítószám', 'zip_code', '', ['class' => 'form-control'], ['class' => 'form-group col-md-2 ']); ?>
     <?= FH::inputBlock('text','Ország', 'country', '', ['class' => 'form-control'], ['class' => 'form-group col-md-6 ']); ?>
 </div>
 <div class="row">
     <?= FH::inputBlock('text','Mobiltelefon szám', 'mobile_phone', '', ['class' => 'form-control'], ['class' => 'form-group col-md-4 ']); ?>
     <?= FH::inputBlock('text','Telefonszám', 'phone', '', ['class' => 'form-control'], ['class' => 'form-group col-md-4 ']); ?>
 </div>
 <div class="row">
     <?= FH::inputBlock('text','Adószám', 'adoszam', '', ['class' => 'form-control'], ['class' => 'form-group col-md-4 ']); ?>
    <?= FH::inputBlock('text','Őstermelői igazolvány szám', 'ostermelo_id', '', ['class' => 'form-control'], ['class' => 'form-group col-md-4 ']); ?>
 </div>
 <br>
 <div class="row">
     <?= FH::submitBlock('Felhasználó hozzáadása', ['class' => 'btn btn-large btn-primary'], ['class' => 'form-gorup col-md-3']) ?>
 </div>

</form>
