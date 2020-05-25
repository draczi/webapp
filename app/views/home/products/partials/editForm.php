<?php
    use Core\FH;
    $auction_end = new DateTime($this->product->auction_end);
    $create = new DateTime($this->product->created_date);
    $date = $create->diff($auction_end)->format("%a");
?>
<form action="" method="POST" enctype="multipart/form-data">
    <?= FH::csrfInput()?>
    <?= FH::displayErrors($this->displayErrors) ?>
    <span class="kotelezo">A * jelölt mezők kitöltése kötekező</span>
    <div class="row">
        <?= FH::inputBlock('text', 'Termék neve *', 'product_name', $this->product->product_name, ['class' => 'form-control input-sm'], ['class' => 'form-group col-md-12']); ?>
    </div>
    <div class="row">
        <?= FH::labelBlock('Kikiáltási ár *', $this->product->price, ['class' => 'form-control input-sm dataLabel'], ['class' => 'form-group col-md-3']); ?>
        <?= FH::labelBlock('Mennyiség (kg) *', $this->product->quantity, ['class' => 'form-control input-sm dataLabel'], ['class' => 'form-group col-md-3']); ?>
        <?= FH::inputBlock('text', 'Licitlépcső', 'bid_increment', $this->product->bid_increment, ['class' => 'form-control input-sm'], ['class' => 'form-group col-md-3']); ?>
        <?= FH::selectBlock('Aukció időtartalma *', 'auction_time', $date, $this->auction_time,['class' => 'form-control input-sm', 'disabled' => 'true'], ['class' => 'form-group col-md-3'])?>
    </div>
    <?= FH::selectBlock('Kategória *', 'category', $this->product->category, $this->categories,['class' => 'form-control input-sm'], ['class' => 'form-group']) ?>
    <?= FH::textareaBlock('Termékleírás *', 'description', $this->product->description, ['class'=> 'form-control', 'rows' => '6'], ['class' => "form-group"]); ?>
    <?php $this->partial('home/products','editImages') ?>
    <div class="row">
        <label for"productImages" class="control-label" style="margin-left:15px">Képek feltöltése * </label>
    </div>
    <input type="file" multiple="multiple" name="productImages[]" id="productImages" />
    <div class="col-md-12 text-right">
        <a href="<?=PROOT?>products" class="btn btn-large btn-secondary">Mégse</a>
        <?= FH::submitTag('Módosítás', ['class' => 'btn btn-large btn-primary','style' => 'background-color: #17a2b8; border: none;']) ?>
    </div>
</form>
e
