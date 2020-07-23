
<?php
  use Core\FH;
?>
<form id="filter-form" action="" method="get" autocomplete="off">
  <div class="row">
    <?= FH::hiddenInput('page',$this->page)?>
    <?= FH::inputBlock('text','Keresés','search',$this->search,['class'=>'form-control form-control-sm'],['class'=>'form-group col-4'])?>
    <?= FH::selectBlock('Kategória', 'category', $this->category, $this->categoryOptions,['class' => 'form-control form-control-sm'], ['class' => 'form-group col-3']) ?>
    <?= FH::inputBlock('number','Legalacsonyabb ár','min_price',$this->min_price,['class'=>'form-control form-control-sm','step'=>'any'],['class'=>'form-group col-2'],$this->displayErrors)?>
    <?= FH::inputBlock('number','Legnagyobb ár','max_price',$this->max_price,['class'=>'form-control form-control-sm','step'=>'any'],['class'=>'form-group col-2'])?>
    <?= FH::submitBlock('Keresés', ['class' => 'form-control btn btn-primary', 'style' => 'background: #17a2b8; margin-top: 28px']) ?>
  </div>
</form>
