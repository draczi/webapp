
<?php $this->setSiteTitle('Új Felhasználó felvitele') ?>
<?php $this->start('body')?>
<h3 class="new-users text-left">Új Felhasználó</h3>
<hr/>
<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <?php $this->partial('admin/adminUsers/', 'form') ?>
    </div>
</div>
<?php $this->end() ?>
