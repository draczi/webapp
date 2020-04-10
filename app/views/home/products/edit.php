<?php
use Core\FH;
use Core\View;
?>
<?php $this->setSiteTitle($this->product->product_name . ' szerkesztése') ?>
<?php $this->start('head')?>
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
tinymce.init({
    selector: '#body'
});
</script>
<?php $this->end() ?>
<?php $this->start('body')?>
<h3 class="new-product text-left"><?= $this->product->product_name ?> szerkesztése</h3>
<hr/>
<div class="row">
    <div class="product-form col-md-10 ">
        <?php $this->partial('home/products', 'editForm') ?>
    </div>
</div>
<?php $this->end() ?>
