<?php use Core\FH; use Core\H;   use App\Models\Bids;?>
<?php $this->start('body'); ?>

<div class="a" style="background-image: url(<?=PROOT?>css/images/header_kep.jpg); background-size: cover; background-repeat: no-repeat; background-position:center; height: 400px; "> </div>
  <div class="search container">
    <form id="filter-form" action="" method="post" autocomplete="off">
      <div class="row">
        <?= FH::hiddenInput('page',$this->page)?>
        <?= FH::inputBlock('text','Keresés','search',$this->search,['class'=>'form-control form-control-sm'],['class'=>'form-group col-4'])?>
        <?= FH::selectBlock('Kategoria', 'category', $this->category, $this->categoryOptions,['class' => 'form-control form-control-sm'], ['class' => 'form-group col-3']) ?>
        <?= FH::inputBlock('number','Legalacsonyabb ár','min_price',$this->min_price,['class'=>'form-control form-control-sm','step'=>'any'],['class'=>'form-group col-2'])?>
        <?= FH::inputBlock('number','Legnagyobb ár','max_price',$this->max_price,['class'=>'form-control form-control-sm','step'=>'any'],['class'=>'form-group col-2'])?>
        <?= FH::submitBlock('Keresés', ['class' => 'form-control btn btn-primary', 'style' => 'background: #17a2b8; margin-top: 28px']) ?>
      </div>
    </form>
  </div>
  <main class="products-wrapper col-md-12">
    <?php foreach($this->products as $product) : ?>
      <div class="card">
        <img src="<?= PROOT .$product->url?>" class="card-img-top" alt="<?=$product->product_name?>">
        <div class="card-body">
          <h5 class="card-title"><a href="<?=PROOT?>products/details/<?=$product->id?>"><?=$product->product_name?></a></h5>
          <p class="p-cat"><?=$product->category?></p>
          <?php $bid = Bids::findProductBind($product->id) ?>
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
