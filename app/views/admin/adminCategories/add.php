<?php use Core\FH; ?>
<?php $this->setSiteTitle('Új kategória') ?>
<?php $this->start('head')?>

<?php $this->end() ?>
<?php $this->start('body')?>
<h1 class="text-center">Új Kategória létrehozása</h1>
<div class="row">
  <div class="categories-form col-md-6">
    <?php $this->partial('admin/adminCategories', 'form') ?>
  </div>
</div>
<?php $this->end() ?>
