<?php
use Core\FH;

?>

<form action="" method="POST" enctype="multipart/form-data">
    <?= FH::csrfInput()?>
    <?= FH::displayErrors($this->displayErrors) ?>
    <div class="row">
        <?= FH::selectBlock('Felhasználói szint', 'acl', $this->user->acl, $this->acls,['class' => 'form-control form-control-sm'], ['class' => 'form-group col-3']) ?>
    </div>
    <div class="row">
        <?= FH::inputBlock('text','Felhasználó név', 'username', $this->user->username, ['class' => 'form-control input-sm', 'disabled' => 'true'], ['class' => 'form-group col-md-6']); ?>
        <?= FH::inputBlock('text','E-mail', 'email', $this->user->email, ['class' => 'form-control input-sm', 'disabled' => 'true'], ['class' => 'form-group col-md-6']); ?>
    </div>
    <div class="row">
        <?= FH::inputBlock('text','Vezetéknév', 'lname', $this->user->lname, ['class' => 'form-control input-sm'], ['class' => 'form-group col-md-6']); ?>
        <?= FH::inputBlock('text','Keresztnév', 'fname', $this->user->fname, ['class' => 'form-control input-sm'], ['class' => 'form-group col-md-6']) ?>
    </div>
    <div class="row">
        <?= FH::inputBlock('password','Jelszó', 'password', "", ['class' => 'form-control input-sm'], ['class' => 'form-group col-md-6']); ?>
        <?= FH::inputBlock('password','Jelszó mégegyszer', 'confirm', "", ['class' => 'form-control input-sm'], ['class' => 'form-group col-md-6']); ?>
    </div>
    <div class="row">
        <?= FH::inputBlock('text','Cím', 'address', $this->user->address, ['class' => 'form-control'], ['class' => 'form-group col-md-12 ']); ?>
    </div>
    <div class="row">
        <?= FH::inputBlock('text','Város', 'city', $this->user->city, ['class' => 'form-control'], ['class' => 'form-group col-md-6 ']); ?>
        <?= FH::inputBlock('text','Megye', 'state', $this->user->state, ['class' => 'form-control'], ['class' => 'form-group col-md-3 ']); ?>
        <?= FH::inputBlock('text','Irányítószám', 'zip_code', $this->user->zip_code, ['class' => 'form-control'], ['class' => 'form-group col-md-3 ']); ?>
    </div>
    <div class="row">
        <?= FH::inputBlock('text','Ország', 'country', $this->user->country, ['class' => 'form-control'], ['class' => 'form-group col-md-6 ']); ?>
        <?= FH::inputBlock('text','Mobiltelefon szám', 'mobile_phone', $this->user->mobile_phone, ['class' => 'form-control'], ['class' => 'form-group col-md-3 ']); ?>
        <?= FH::inputBlock('text','Telefonszám', 'phone', $this->user->phone, ['class' => 'form-control'], ['class' => 'form-group col-md-3 ']); ?>
    </div>
    <div class="row">
        <?= FH::inputBlock('text','Adószám', 'tax_number', $this->user->tax_number, ['class' => 'form-control'], ['class' => 'form-group col-md-6 ']); ?>
        <?= FH::inputBlock('text','Őstermelői producer_number', 'ostermelo_id', $this->user->producer_number, ['class' => 'form-control'], ['class' => 'form-group col-md-6 ']); ?>
    </div>
    <div class="col-md-12 text-right">
        <a href="<?=PROOT?>adminUsers" class="btn btn-large btn-secondary">Mégse</a>
        <?= FH::submitTag('Módosítás', ['class' => 'btn btn-large btn-primary','style' => 'background-color: #17a2b8; border: none;']) ?>
    </div>
    </form>
