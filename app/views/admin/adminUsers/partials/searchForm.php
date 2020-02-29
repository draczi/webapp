
<?php
  use Core\FH;
?>
<form id="filter-form" action="" method="post" autocomplete="off">
  <div class="row">
    <?= FH::hiddenInput('page',$this->page)?>
    <?= FH::inputBlock('text','Szabadszavas keresés','search',$this->search,['class'=>'form-control form-control-sm'],['class'=>'form-group col-6'])?>
    <?= FH::selectBlock('Kategoria', 'acl', $this->acl, $this->acls,['class' => 'form-control form-control-sm'], ['class' => 'form-group col-3']) ?>
    <?= FH::submitBlock('Keresés', ['class' => 'form-control btn btn-primary admin_search']) ?>
  </div>
</form>
