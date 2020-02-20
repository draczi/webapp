<?php use Core\FH; ?>
<?php $this->setSiteTitle('Add Product') ?>
<?php $this->start('head')?>

<?php $this->end() ?>
<?php $this->start('body')?>
<h1 class="text-center">Új Kategória létrehozása</h1>
<div class="row">
  <div class="col-md-10 col-md-offset-1 well">
    <?php $this->partial('admin/adminCategories', 'form') ?>
  </div>
</div>
<?php $this->end() ?>
