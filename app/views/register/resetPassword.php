<?php
    use Core\FH;
?>
<?php $this->setSiteTitle("Új jelszó") ?>
<?php $this->start('body')?>
<h3 class="password_change text-center" >Jelszó csere</h3>
<hr style="margin-bottom: 50px"/>
<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-6 password_container">
        <form action="" method="POST" enctype="multipart/form-data">
            <?= FH::csrfInput()?>
            <?= FH::hiddenInput('resetPassword', 'resetPassword'); ?>
            <?= FH::inputBlock('text','Email cím', 'email', '', ['class' => 'form-control input-sm'], ['class' => 'form-group'], $this->displayErrors); ?>
            <?= FH::submitBlock('Email küldés', ['class' => 'btn btn-large btn-info', 'style' => 'width: 100%'], ['class' => 'form-group']); ?>
        </div>
    </form>
</div>
<?php $this->end() ?>
