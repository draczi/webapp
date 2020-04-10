
<?php
  use Core\FH;
?>
<form id="filter-form" action="" method="get" autocomplete="off">
  <div class="row">
    <?= FH::hiddenInput('page',$this->page)?>
    <?= FH::inputBlock('text','Keresés','search',$this->search,['class'=>'form-control form-control-sm'],['class'=>'form-group col-3'])?>
    <?= FH::selectBlock('Kategoria', 'category', $this->category, $this->categoryOptions,['class' => 'form-control form-control-sm'], ['class' => 'form-group col-2']) ?>
    <?= FH::selectBlock('Felhasználó', 'vendor', $this->vendor, $this->vendorOptions,['class' => 'form-control form-control-sm'], ['class' => 'form-group col-2']) ?>
    <?= FH::selectBlock('Aukció típusa', 'actual', $this->actual, $this->statusOptions,['class' => 'form-control form-control-sm'], ['class' => 'form-group col-2']) ?>
    <?= FH::submitBlock('Keresés', ['class' => 'form-control btn btn-primary', 'style' => 'background: #17a2b8; margin-top: 28px']) ?>
  </div>
</form>
