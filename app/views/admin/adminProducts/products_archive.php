<?php use App\Models\Bids; use Core\H; use Core\FH; ?>
<?php $this->setSiteTitle('Termék archiválás') ?>
<?php $this->start('body') ?>
<h1 class="text-center" style="margin-bottom: 50px">Archiválható termékek</h1>
<form action="" method="post" >
<?php if(!empty($this->products)) : ?>
<table class="table table-bordered table-hover table-striped">
  <thead>
    <th>ID</th><th>Termék neve</th><th>Kategória</th><th>Eladó</th><th>Mennyiség</th><th>Kikiáltási ár</th><th>Jelenlegi ár</th><th>Licitlépcső</th><th>Készítés ideje</th><th>Módosítás ideje</th><th>Lejárat ideje</th>
  </thead>
  <tbody>
    <?php foreach($this->products as $product) :  ?>
      <tr data-id="<?=$product->id?>">
        <td><?=$product->id?></td>
        <td><?=$product->product_name?></td>
        <td><?=$product->category?></td>
        <td><?=$product->vendor?></td>
        <td><?=$product->quantity?></td>
        <td><?=$product->price?></td>
        <td><?= ($b = Bids::findProductBid($product->id))?$b->bid_amount:$product->price?></td>
        <td><?=$product->bid_increment?></td>
        <td><?=$product->created_date?></td>
        <td><?=$product->updated_date?></td>
        <td><?=$product->auction_end?></td>
      </tr>
    <?php endforeach; ?>
</tbody>
</table>
    <a href="<?=PROOT?>adminProducts" class="btn btn-large btn-secondary">Vissza</a>
    <?= FH::submitTag('Termékek archiválása', ['class' => 'btn btn-large btn-primary','style' => 'background-color: #17a2b8; border: none;']) ?>
</form>
<?php else : ?>
<h2 class="text-center" style="color: red">Jelenleg nincs archiválható termék!</h2>
  <a href="<?=PROOT?>adminProducts" class="btn btn-large btn-secondary" style="margin-left: 48%; margin-top: 40px">Mégse</a><?php endif ?>
</div>

<?php $this->end() ?>
