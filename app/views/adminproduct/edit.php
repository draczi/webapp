<?php
  use Core\FH;
  use Core\View;
?>
<?php $this->setSiteTitle("Edit " .$this->product->name); ?>
<?php $this->start('head')?>
  <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
  <script>
    tinymce.init({
      selector: '#body'
    });
  </script>
<?php  $this->end() ?>
<?php  $this->start('body') ?>
<div class="row">
  <div class="col-md-10 col-md-offset-1 well">
    <h1 class="text-center">Edit <?= $this->product->name ?></h1>
    <form action="" method="POST" enctype="multipart/form-data">
      <?= FH::csrfInput()?>
      <?= FH::hiddenInput('images_sorted', 'images_sorted') ?>
      <?= FH::displayErrors($this->displayErrors) ?>
      <?= FH::inputBlock('text', 'Name', 'name', $this->product->name, ['class' => 'form-control input-sm'], ['class' => 'form-group col-md-6']); ?>
      <?= FH::inputBlock('text', 'Price', 'price', $this->product->price, ['class' => 'form-control input-sm'], ['class' => 'form-group col-md-2']); ?>
      <?= FH::inputBlock('text', 'List Price', 'list_price', $this->product->list_price, ['class' => 'form-control input-sm'], ['class' => 'form-group col-md-2']); ?>
      <?= FH::inputBlock('text', 'Shipping', 'shipping', $this->product->shipping, ['class' => 'form-control input-sm'], ['class' => 'form-group col-md-2']); ?>
      <?= FH::selectBlock('Brand', 'brand_id', $this->product->brand_id, $this->brands,['class' => 'form-control input-sm'], ['class' => 'form-group']) ?>
      <?= FH::textareaBlock('Body', 'body', $this->product->body, ['class'=> 'form-control', 'rows' => '6'], ['class' => "form-group"]); ?>
      <?php $this->partial('adminproduct','editImages') ?>
      <div class="row">
      <label for"productImages" class="control-label">Upload Product Images: </label>
      <input type="file" multiple="multiple" name="productImages[]" id="productImages" />
    </div>
      <div class="col-md-12 text-right">
          <a href="<?=PROOT?>adminproduct" class="btn btn-large btn-secondary">Cancel</a>
        <?= FH::submitTag('Save', ['class' => 'btn btn-large btn-primary']) ?>
      </div>
    </form>
  </div>
</div>
<?php  $this->end() ?>
