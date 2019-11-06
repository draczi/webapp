<?php $this->setSiteTitle('Add Product') ?>
<?php $this->start('head')?>
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
  tinymce.init({
    selector: '#body'
  });
  </script>
<?php $this->end() ?>
<?php $this->start('body')?>
<h1 class="text-center">Add New Product</h1>
<div class="row">
  <div class="col-md-10 col-md-offset-1 well">
    <?php $this->partial('adminproduct', 'form') ?>
  </div>
</div>
<?php $this->end() ?>
