<?php use Core\FH; ?>
<form action="../../bids/add" method="POST">
  <div class="input-group">
    <label class="sr-only" for="bid">Licit</label>
    <input type="hidden" name="product_id" value="<?=$this->product->id?>" />
    <input type="hidden" name="vendor" value="<?=$this->product->vendor?>" />
    <input type="hidden" name="user_id" value="<?=$this->user->id?>"/>
    <input type="hidden" name="bid_incerement" value="<?=$this->product->bid_increment?>"/>
    <input type="hidden" name="auction_end" value="<?=$this->product->auction_end?>"/>
    <input type="hidden" name="min_bid_price" value="<?=(empty($this->bid)) ? ($this->product->price + $this->product->bid_increment)  : ($this->bid['bid'] + $this->product->bid_increment)?>"/>
    <input class="form-control" id="bids" name="bid_amount" value="" placeholder="Licit összeg" />
    <button class="input-group-append btn btn-info" type="submit" style="text-align: center;margin-left: 10px;padding: 0 50px">Licitálok</button>
  </div>
</form>
