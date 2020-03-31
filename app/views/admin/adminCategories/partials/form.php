<?php use Core\FH; ?>

<form action="<?=$this->formAction?>" method="POST" enctype="multipart/form-data">
  <?= FH::csrfInput()?>
  <?= FH::displayErrors($this->displayErrors) ?>
  <?= FH::selectBlock('Kategoria', 'parent', "", $this->category_parent,['class' => 'form-control input-sm'], ['class' => 'form-group']) ?>
  <?= FH::inputBlock('text', 'Kategória neve', 'category_name', $this->categories->category_name, ['class' => 'form-control input-sm'], ['class' => 'form-group col-md-2']); ?>
  <?= FH::submitBlock('Save', ['class' => 'btn btn-large btn-primary'], ['class' => 'text-right col-md-12']) ?>

</form>
