<?php
  use Core\FH;
  use Core\View;
  use Core\H;
?>
<?php $this->setSiteTitle($this->categories->category_name . ' szerkesztése'); ?>


<?php  $this->start('body') ?>
<div class="row">
  <div class="categories-form col-md-6">
    <h1 class="text-center"><?=$this->categories->category_name?> szerkesztése</h1>
    <?php $this->partial('admin/adminCategories/', 'editForm') ?>
  </div>
</div>
<?php  $this->end() ?>
