<?php
  use Core\FH;
?>
<form action="../addMessage" method="POST" enctype="multipart/form-data">
  <?= FH::csrfInput()?>
  <input type="hidden" name="product_id" value="<?=$this->product->id?>" />
  <input type="hidden" name="user_id" value="<?=$this->user->id?>"/>
  <?= FH::textareaBlock('Üzenet *', 'message', "", ['class'=> 'form-control', 'rows' => '6'], ['class' => "form-group"]); ?>
  <?= FH::submitBlock('Üzenet küldés', ['class' => 'btn btn-large btn-primary', 'style' => 'margin: 20px 0; background-color: #17a2b8; color: #fff; border:none'], ['class' => 'text-right col-md-12']) ?>

</form>
