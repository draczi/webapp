<?php use Core\FH; ?>
<form action="../add" method="POST">
  <div class="input-group">
    <label class="sr-only" for="bid">Licit</label>
    <input type="hidden" name="product_id" value="<?=$this->product->id?>" />
    <input type="hidden" name="user_id" value="<?=$this->user->id?>"/>
    <input type="hidden" name="bid_incerement" value="<?=$this->product->bid_increment?>"/>
    <input class="form-control" id="bids" name="bid_amount" value="" placeholder="Licit összeg" />
    <button class="input-group-append btn btn-info" type="submit" style="text-align: center;margin-left: 10px;padding: 0 50px">Licitálok</button>
  </div>
</form>