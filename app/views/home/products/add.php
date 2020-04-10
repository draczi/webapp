<?php $this->setSiteTitle('Új termék felvitele') ?>
<?php $this->start('body')?>
<h3 class="new-product text-left">Termék feltöltés</h3>
<hr/>
<div class="row">
  <div class="product-form col-md-10 ">
  <?php $this->partial('home/products', 'form') ?>
  </div>
</div>
<?php $this->end() ?>
