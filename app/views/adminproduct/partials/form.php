<?php
  use Core\FH;
?>
<form action="<?=$this->formAction?>" method="POST" enctype="multipart/form-data">
  <?= FH::csrfInput()?>
  <?= FH::displayErrors($this->displayErrors) ?>
  <?= FH::inputBlock('text', 'Name', 'name', $this->product->name, ['class' => 'form-control input-sm'], ['class' => 'form-group col-md-6']); ?>
  <?= FH::inputBlock('text', 'Price', 'price', $this->product->price, ['class' => 'form-control input-sm'], ['class' => 'form-group col-md-2']); ?>
  <?= FH::inputBlock('text', 'List Price', 'list_price', $this->product->list_price, ['class' => 'form-control input-sm'], ['class' => 'form-group col-md-2']); ?>
  <?= FH::inputBlock('text', 'Shipping', 'shipping', $this->product->shipping, ['class' => 'form-control input-sm'], ['class' => 'form-group col-md-2']); ?>
  <?= FH::selectBlock('Brand', 'brand_id', $this->product->brand_id, $this->brands,['class' => 'form-control input-sm'], ['class' => 'form-group']) ?>
  <?= FH::textareaBlock('Body', 'body', $this->product->body, ['class'=> 'form-control', 'rows' => '6'], ['class' => "form-group"]); ?>
  <label for"productImages" class="control-label">Upload Product Images: </label>
  <input type="file" multiple="multiple" name="productImages[]" id="productImages" />

  <?= FH::submitBlock('Save', ['class' => 'btn btn-large btn-primary'], ['class' => 'text-right col-md-12']) ?>

</form>
