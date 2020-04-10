<?php use Core\FH; use Core\H;   use App\Models\Bids;?>
<?php $this->start('body'); ?>

<div class="a" style="background-image: url(<?=PROOT?>css/images/header_kep.jpg); background-size: cover; background-repeat: no-repeat; background-position:center; height: 400px; "> </div>
  <div class="search container">
     <?php $this->partial('home/products', 'filterForm') ?>
  </div>
  <main class="products-wrapper col-md-12">
    <?php foreach($this->products as $product) : ?>
      <div class="card">
        <img src="<?= PROOT .$product->url?>" class="card-img-top" alt="<?=$product->product_name?>">
        <div class="card-body">
          <h5 class="card-title"><a href="<?=PROOT?>products/details/<?=$product->id?>"><?=$product->product_name?></a></h5>
          <p class="p-cat"><?=$product->category?></p>
          <?php $bid = Bids::findProductBid($product->id) ?>
          <p class="price"><?=(!empty($bid)) ? $bid->bid_amount : $product->price?> Ft</p>
          <a href="<?=PROOT?>products/details/<?=$product->id?>" class="details-btn">Megtekintés</a>
        </div>
      </div>
    <?php endforeach; ?>
    <div class="d-flex justify-content-center align-items-center mt-3 w-100">
      <?php
        $disableBack = ($this->page == 1)? ' disabled="disabled"' : '';
        $disableNext = ($this->page == $this->totalPages)? ' disabled="disabled"' : '';
        ?>
      <button class="btn btn-light mr-3"<?=$disableBack?> onclick="pager('back')"><i class="fas fa-chevron-left"></i></button>
      <?=$this->page?> of <?=$this->totalPages?>
      <button class="btn btn-light ml-3"<?=$disableNext?> onclick="pager('next')"><i class="fas fa-chevron-right"></i></button>
    </div>
  </main>
</div>

<script>


  function pager(direction){
    var form = document.getElementById('filter-form');
    var input = document.getElementById('page');
    var page = parseInt(input.value,10);
    var newPageValue = (direction === 'next')? page + 1 : page - 1;
    input.value = newPageValue;
    form.submit();
  }


</script>
<?php $this->end(); ?>
