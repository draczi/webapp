<?php $this->setSiteTitle($this->product->title)?>
<?php $this->start('head'); ?>
<?php $this->end() ?>
<?php $this->start('body'); ?>
<h1 class="text-center"><?=$this->product->title?></h1>
<div class="row">
  <!-- column 1 -->
  <div class="col-md-6" >
    <div class="product_img_wrapper">
      <img src="<?=PROOT?>images/catan.jpg" width="200px" height: "200px" />
    </div>
  </div>
  <!-- column 2 -->
  <div class="col-md-6" >
    <p><span>List  Price: </span> <?= $this->product->list_price ?></p>
    <p><span>Price: </span> <?= $this->product->price ?></p>
    <p><span>Shipping: </span> <?= $this->product->shipping ?></p>
    <p><span>Total: </span> <?= $this->product->price + $this->product->shipping ?></p>
    <p><span>Vendor: </span> <?= $this->product->vendor ?></p>
    <p><span>Brand: </span> <?= $this->product->brand ?></p>

    <div class="text-right">
      <button class="btn btn-large btn-danger" onlick="console.log('add to cart')">
        <i class="glyphicon glyphicon-shopping-cart"></i>
        Add To Cart
      </button>
    </div>
  </div>
</div>
<div class="row">
    <div class="col-md-6">
      <h3>Product Description</h3>
      <p>
          <?= $this->product->description ?>
      </p>
    </div>
    <div class="col-md-6">
      <h3>Customer Reviews</h3>
    </div>
</div>
<?php $this->end(); ?>
