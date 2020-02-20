<?php
  use Core\FH;
?>
<form action="<?=$this->formAction?>" method="POST" enctype="multipart/form-data">
  <?= FH::csrfInput()?>
  <?= FH::displayErrors($this->displayErrors) ?>
  <div class="row">
  <?= FH::inputBlock('text', 'Termék neve', 'name', $this->product->name, ['class' => 'form-control input-sm'], ['class' => 'form-group col-md-12']); ?>
  </div>
  <div class="row">
  <?= FH::inputBlock('text', 'Kikiáltási ár', 'price', $this->product->price, ['class' => 'form-control input-sm'], ['class' => 'form-group col-md-3']); ?>
  <?= FH::inputBlock('text', 'Minimális ár', 'min_price', $this->product->min_price, ['class' => 'form-control input-sm'], ['class' => 'form-group col-md-3']); ?>
  <?= FH::inputBlock('text', 'Mennyiség', 'quantity', $this->product->quantity, ['class' => 'form-control input-sm'], ['class' => 'form-group col-md-3']); ?>
  <?= FH::inputBlock('text', 'Licitlépcső', 'bid_increment', $this->product->bid_increment, ['class' => 'form-control input-sm'], ['class' => 'form-group col-md-3']); ?>
  <?= FH::selectBlock('Aukció időtartalma', 'auction_time', $this->product->auction_time, $this->auction_time,['class' => 'form-control input-sm'], ['class' => 'form-group col-md-3']) ?>
  </div>
  <?= FH::selectBlock('Kategória', 'category', $this->product->category, $this->categories,['class' => 'form-control input-sm'], ['class' => 'form-group']) ?>
  <?= FH::textareaBlock('Termékleírás', 'description', $this->product->description, ['class'=> 'form-control', 'rows' => '6'], ['class' => "form-group"]); ?>
  <div class="row">
  <label for"productImages" class="control-label" style="margin-left:15px">Képek feltöltése: </label>
  </div>
  <input type="file" multiple="multiple" name="productImages[]" id="productImages" />
  <?= FH::submitBlock('Termék feltöltése', ['class' => 'btn btn-large btn-primary', 'style' => 'margin: 20px 0'], ['class' => 'text-right col-md-12']) ?>

</form>
