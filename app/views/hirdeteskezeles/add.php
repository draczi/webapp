<?php $this->setSiteTitle('Új termék felvitele') ?>
<?php $this->start('head')?>
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
  tinymce.init({
    selector: '#body'
  });
  </script>
<?php $this->end() ?>
<?php $this->start('body')?>
<h3 class="new-product text-left">Termék feltöltés</h3>
<hr/>
<div class="row">
  <div class="product-form col-md-10 ">
  <?php $this->partial('hirdeteskezeles', 'form') ?>
  </div>
</div>
<?php $this->end() ?>
