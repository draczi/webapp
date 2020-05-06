<?php
use Core\FH;
?>
<?php $this->setSiteTitle($this->user->username . "módosítása") ?>
<?php $this->start('body')?>
<h3 class="new-users text-left"><?=$this->user->lname.' '. $this->user->fname ?> (<?=$this->user->username?>) felhasználó módosítása</h3>
<hr/>
<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <form action="<?=PROOT?>register/contact" method="POST" enctype="multipart/form-data">
            <?= FH::csrfInput()?>
            <span class="kotelezo">A * jelölt mezők kitöltése kötekező</span>
            <div class="row">
                <?= FH::labelBlock('Felhasználói szint',  $this->acls[$this->user->acl], ['class'=>'form-control input-sm dataLabel'], ['class' => 'form-group col-md-3']); ?>
            </div>
            <div class="row">
                <?= FH::labelBlock('Felhasználó név *', $this->user->username, ['class'=>'form-control input-sm dataLabel'], ['class' => 'form-group col-md-6']); ?>
                <?= FH::labelBlock('E-mail *', $this->user->email, ['class'=>'form-control input-sm dataLabel'], ['class' => 'form-group col-md-6']); ?>
            </div>
            <div class="row">
                <?= FH::inputBlock('text','Vezetéknév *', 'lname', $this->user->lname, ['class' => 'form-control input-sm'], ['class' => 'form-group col-md-6'], $this->displayErrors); ?>
                <?= FH::inputBlock('text','Keresztnév *', 'fname', $this->user->fname, ['class' => 'form-control input-sm'], ['class' => 'form-group col-md-6'], $this->displayErrors) ?>
            </div>
            <div class="row">
                <?= FH::inputBlock('password','Jelszó *', 'password', "", ['class' => 'form-control input-sm'], ['class' => 'form-group col-md-6'], $this->displayErrors); ?>
                <?= FH::inputBlock('password','Jelszó mégegyszer *', 'confirm', "", ['class' => 'form-control input-sm'], ['class' => 'form-group col-md-6'], $this->displayErrors); ?>
            </div>
            <div class="row">
                <?= FH::inputBlock('text','Cím *', 'address', $this->user->address, ['class' => 'form-control'], ['class' => 'form-group col-md-12 '], $this->displayErrors); ?>
            </div>
            <div class="row">
                <?= FH::inputBlock('text','Város *', 'city', $this->user->city, ['class' => 'form-control'], ['class' => 'form-group col-md-6 '], $this->displayErrors); ?>
                <?= FH::inputBlock('text','Megye', 'state', $this->user->state, ['class' => 'form-control'], ['class' => 'form-group col-md-3 '], $this->displayErrors); ?>
                <?= FH::inputBlock('text','Irányítószám *', 'zip_code', $this->user->zip_code, ['class' => 'form-control'], ['class' => 'form-group col-md-3 '], $this->displayErrors); ?>
            </div>
            <div class="row">
                <?= FH::inputBlock('text','Ország *', 'country', $this->user->country, ['class' => 'form-control'], ['class' => 'form-group col-md-6 '], $this->displayErrors); ?>
                <?= FH::inputBlock('text','Mobiltelefon szám *', 'mobile_phone', $this->user->mobile_phone, ['class' => 'form-control'], ['class' => 'form-group col-md-3 '], $this->displayErrors); ?>
                <?= FH::inputBlock('text','Telefonszám', 'phone', $this->user->phone, ['class' => 'form-control'], ['class' => 'form-group col-md-3 '], $this->displayErrors); ?>
            </div>
            <div class="row">

            </div>
            <div class="row">
                <?= FH::inputBlock('text','Adószám', 'tax_number', $this->user->tax_number, ['class' => 'form-control'], ['class' => 'form-group col-md-6 '], $this->displayErrors); ?>
                <?= FH::inputBlock('text','Őstermelői igazolvány', 'producer_number', $this->user->producer_number, ['class' => 'form-control'], ['class' => 'form-group col-md-6 '], $this->displayErrors); ?>
            </div>
            <div class="row text-right">
                <div class="form-group col-md-2 text-right"><a href="<?=PROOT?>" class="btn btn-large btn-secondary form-control" >Mégse</a></div>
                <?= FH::submitBlock('Adatok Módosítása', ['class' => 'btn btn-large btn-info form-control'], ['class' => 'form-group text-right']) ?>
            </div>

        </form>
    </div>
</div>


<?php $this->end() ?>
