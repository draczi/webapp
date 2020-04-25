<?php
use Core\FH;
?>
<form action="" method="POST" enctype="multipart/form-data">
    <?= FH::csrfInput()?>
    <?= FH::displayErrors($this->displayErrors) ?>
    <span class="kotelezo">A * jelölt mezők kitöltése kötekező</span>
    <div class="row">
        <?= FH::inputBlock('text', 'Termék neve *', 'product_name', $this->product->product_name, ['class' => 'form-control input-sm'], ['class' => 'form-group col-md-12']); ?>
    </div>
    <div class="row">
        <?= FH::inputBlock('text', 'Kikiáltási ár *', 'price', $this->product->price, ['class' => 'form-control input-sm'], ['class' => 'form-group col-md-3']); ?>
        <?= FH::inputBlock('text', 'Mennyiség *', 'quantity', $this->product->quantity, ['class' => 'form-control input-sm'], ['class' => 'form-group col-md-3']); ?>
        <?= FH::inputBlock('text', 'Licitlépcső', 'bid_increment', $this->product->bid_increment, ['class' => 'form-control input-sm'], ['class' => 'form-group col-md-3']); ?>
        <?= FH::selectBlock('Aukció időtartalma *', 'auction_time', $this->product->auction_time, $this->auction_time,['class' => 'form-control input-sm'], ['class' => 'form-group col-md-3']) ?>
    </div>
    <?= FH::selectBlock('Kategória *', 'category', $this->product->category, $this->categories,['class' => 'form-control input-sm'], ['class' => 'form-group']) ?>
    <?= FH::textareaBlock('Termékleírás *', 'description', $this->product->description, ['class'=> 'form-control', 'rows' => '6'], ['class' => "form-group"]); ?>
    <?php $this->partial('admin/adminProducts','editImages') ?>
    <div class="row">
        <label for"productImages" class="control-label" style="margin-left:15px">Képek feltöltése * </label>
    </div>
    <input type="file" multiple="multiple" name="productImages[]" id="productImages" />
    <div class="col-md-12 text-right">
        <a href="<?=PROOT?>adminProducts" class="btn btn-large btn-secondary">Mégse</a>
        <?= FH::submitTag('Módosítás', ['class' => 'btn btn-large btn-primary','style' => 'background-color: #17a2b8; border: none;']) ?>
    </div>
</form>
