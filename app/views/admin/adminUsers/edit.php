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
        <?php $this->partial('admin/adminUsers', 'editForm') ?>
    </div>
</div>
<?php $this->end() ?>
