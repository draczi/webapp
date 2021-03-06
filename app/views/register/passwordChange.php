<?php
    use Core\FH;
?>
<?php $this->setSiteTitle("Jelszó módosítása") ?>
<?php $this->start('body')?>
<h3 class="password_change text-center" >Jelszó csere</h3>
<hr style="margin-bottom: 50px"/>
<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-6 password_container">
        <form action="" method="POST" enctype="multipart/form-data">
            <?= FH::csrfInput()?>
            <?=FH::displayErrors($this->displayErrors) ?>
            <?= FH::hiddenInput('id', $this->user->id); ?>
            <span class="kotelezo">A * jelölt mezők kitöltése kötekező</span>
            <?= FH::inputBlock('password','Jelszó *', 'password', '', ['class' => 'form-control input-sm'], ['class' => 'form-group']); ?>
            <?= FH::inputBlock('password','Jelszó mégegyszer *', 'confirm', '', ['class' => 'form-control input-sm'], ['class' => 'form-group']); ?>
            <?= FH::submitBlock('Save', ['class' => 'btn btn-large btn-info', 'style' => 'width: 100%'], ['class' => 'form-group']); ?>
        </div>
    </form>
</div>
<?php $this->end() ?>
