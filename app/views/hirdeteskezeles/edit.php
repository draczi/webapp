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
        <form action="" method="POST" enctype="multipart/form-data">
            <?= FH::csrfInput()?>
            <?= FH::displayErrors($this->displayErrors) ?>
            <div class="row">
                <?= FH::inputBlock('text', 'Termék neve', 'product_name', $this->product->product_name, ['class' => 'form-control input-sm'], ['class' => 'form-group col-md-12']); ?>
            </div>
            <div class="row">
                <?= FH::inputBlock('text', 'Kikiáltási ár', 'price', $this->product->price, ['class' => 'form-control input-sm'], ['class' => 'form-group col-md-3']); ?>
                <?= FH::inputBlock('text', 'Mennyiség', 'quantity', $this->product->quantity, ['class' => 'form-control input-sm'], ['class' => 'form-group col-md-3']); ?>
                <?= FH::inputBlock('text', 'Licitlépcső', 'bid_increment', $this->product->bid_increment, ['class' => 'form-control input-sm'], ['class' => 'form-group col-md-3']); ?>
                <?php if ($this->product->create_date == date('Y-m-d')) { ?>
                    <?= FH::selectBlock('Aukció időtartalma', 'auction_time', $this->product->auction_time, $this->auction_time,['class' => 'form-control input-sm'], ['class' => 'form-group col-md-3']) ?>
                <?php } else { ?>
                    <?= FH::selectBlock('Aukció időtartalma', 'auction_time', $this->product->auction_time, $this->auction_time,['class' => 'form-control input-sm', 'disabled' => 'true'], ['class' => 'form-group col-md-3'])?>
                <?php } ?>
            </div>
            <?= FH::selectBlock('Kategória', 'category', $this->product->category, $this->categories,['class' => 'form-control input-sm'], ['class' => 'form-group']) ?>
            <?= FH::textareaBlock('Termékleírás', 'description', $this->product->description, ['class'=> 'form-control', 'rows' => '6'], ['class' => "form-group"]); ?>
            <?php $this->partial('hirdeteskezeles','editImages') ?>
            <div class="row">
                <label for"productImages" class="control-label" style="margin-left:15px">Képek feltöltése: </label>
            </div>
            <input type="file" multiple="multiple" name="productImages[]" id="productImages" />
            <div class="col-md-12 text-right">
                <a href="<?=PROOT?>hirdeteskezeles" class="btn btn-large btn-secondary">Mégse</a>
                <?= FH::submitTag('Módosítás', ['class' => 'btn btn-large btn-primary']) ?>
            </div>
        </form>
    </div>
</div>
<?php $this->end() ?>
