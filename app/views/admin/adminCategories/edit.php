<?php
  use Core\FH;
  use Core\View;
  use Core\H;
?>
<?php $this->setSiteTitle("Edit " .$this->categories->category_name); ?>


<?php  $this->start('body') ?>
<div class="row">
  <div class="col-md-10 col-md-offset-1 well">
    <h1 class="text-center">Edit <?= $this->categories->category_name ?></h1>
    <form action="" method="POST" enctype="multipart/form-data">
      <?= FH::csrfInput()?>
      <?= FH::displayErrors($this->displayErrors) ?>
      <?= FH::selectBlock('Kategoria', 'parent_id', "", $this->parent,['class' => 'form-control input-sm'], ['class' => 'form-group']) ?>
      <?= FH::inputBlock('text', 'Kategória neve', 'category_name', $this->categories->category_name, ['class' => 'form-control input-sm'], ['class' => 'form-group col-md-2']); ?>
      <div class="col-md-12 text-right">
          <a href="<?=PROOT?>adminCategories" class="btn btn-large btn-secondary">Mégse</a>
        <?= FH::submitTag('Mentés', ['class' => 'btn btn-large btn-primary']) ?>
      </div>
    </form>
  </div>
</div>
<?php  $this->end() ?>
