<?php
    use Core\FH;
?>
<?php $this->setSiteTitle($this->product->product_name . ' szerkesztése') ?>
<?php $this->start('body')?>
<h3 class="new-product text-left"><?= $this->product->product_name ?> szerkesztése</h3>
<hr/>
<div class="row">
    <div class="product-form col-md-10 ">
        <?php $this->partial('admin/adminProducts/', 'editProduct') ?>
    </div>
</div>
<?php $this->end() ?>
