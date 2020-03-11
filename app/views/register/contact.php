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
        <form action="" method="POST" enctype="multipart/form-data">
          <?= FH::csrfInput()?>
          <?= FH::displayErrors($this->displayErrors) ?>
          <?= FH::inputBlock('hidden','', 'id', $this->user->id); ?>
          <div class="row">
          <?= FH::inputBlock('text','Vezetéknév', 'lname', $this->user->lname, ['class' => 'form-control'], ['class' => 'form-group col-md-6 ']); ?>
          <?= FH::inputBlock('text','Keresztnév', 'fname', $this->user->fname, ['class' => 'form-control'], ['class' => 'form-group col-md-6']) ?>
        </div>
        <div class="row">
        <?= FH::inputBlock('text','Felhasználó név', 'username',$this->user->username, ['class' => 'form-control ', 'disabled' => 'true'], ['class' => 'form-group col-md-6']); ?>
            <?= FH::inputBlock('text','E-mail', 'email', $this->user->email, ['class' => 'form-control','disabled' => 'true'], ['class' => 'form-group col-md-6']); ?>
        </div>
        <div class="row">
        <?= FH::selectBlock('Felhasználói szint', 'acl', $this->user->acl, $this->acls,['class' => 'form-control form-control-sm', 'disabled' => 'true'], ['class' => 'form-group col-3']) ?>
    </div>
    <hr style=" margin: 50px auto; background: #E7E7E7">
         <div class="row"><h4 class="user_adatok">Személyes adatok</h4></div>
         <div class="row">
             <?= FH::inputBlock('text','Cím', 'address', $this->contact->address, ['class' => 'form-control'], ['class' => 'form-group col-md-12 ']); ?>
         </div>
         <div class="row">
             <?= FH::inputBlock('text','Város', 'city', $this->contact->city, ['class' => 'form-control'], ['class' => 'form-group col-md-4 ']); ?>
             <?= FH::inputBlock('text','Irányítószám', 'zip_code', $this->contact->zip_code, ['class' => 'form-control'], ['class' => 'form-group col-md-2 ']); ?>
             <?= FH::inputBlock('text','Ország', 'country', $this->contact->country, ['class' => 'form-control'], ['class' => 'form-group col-md-6 ']); ?>
         </div>
         <div class="row">
             <?= FH::inputBlock('text','Mobiltelefon szám', 'mobile_phone', $this->contact->mobile_phone, ['class' => 'form-control'], ['class' => 'form-group col-md-4 ']); ?>
             <?= FH::inputBlock('text','Telefonszám', 'phone', $this->contact->phone, ['class' => 'form-control'], ['class' => 'form-group col-md-4 ']); ?>
         </div>
         <div class="row">
             <?= FH::inputBlock('text','Adószám', 'adoszam', $this->contact->adoszam, ['class' => 'form-control'], ['class' => 'form-group col-md-4 ']); ?>
            <?= FH::inputBlock('text','Őstermelői igazolvány szám', 'ostermelo_id', $this->contact->ostermelo_id, ['class' => 'form-control'], ['class' => 'form-group col-md-4 ']); ?>
         </div>
         <br>
         <div class="row">

             <?= FH::submitBlock('Adatok Módosítása', ['class' => 'btn btn-large btn-info'], ['class' => 'form-gorup col-md-3']) ?>
              <a href="<?=PROOT?>" class="btn btn-large btn-secondary" style="margin-left: -40px">Mégse</a>
         </div>

        </form>
    </div>
</div>


<?php $this->end() ?>
