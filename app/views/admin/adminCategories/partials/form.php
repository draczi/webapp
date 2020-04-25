<?php use Core\FH; ?>

<form action="<?=$this->formAction?>" method="POST" enctype="multipart/form-data">
  <?= FH::csrfInput()?>
  <?= FH::displayErrors($this->displayErrors) ?>
  <span class="kotelezo">A * jelölt mezők kitöltése kötekező</span>
  <?= FH::selectBlock('Kategoria *', 'parent', "", $this->category_parent,['class' => 'form-control input-sm'], ['class' => 'form-group col-md-12']) ?>
  <?= FH::inputBlock('text', 'Kategória neve *', 'category_name', $this->categories->category_name, ['class' => 'form-control input-sm'], ['class' => 'form-group col-md-12']); ?>
  <div class="col-md-12 text-right">
      <a href="<?=PROOT?>adminCategories" class="btn btn-large btn-secondary">Mégse</a>
      <?= FH::submitTag('Kategória felvitele', ['class' => 'btn btn-large btn-primary','style' => 'background-color: #17a2b8; border: none;']) ?>
  </div>

</form>
