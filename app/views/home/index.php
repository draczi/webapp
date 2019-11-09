<?php $this->start('body');?>
<h1 class="text-center red">Welcome to Isi MVC Framework!</h1>
<main class="products-wrapper">
  <div class="card" style="width: 18rem;">
    <img src="..." class="card-img-top" alt="...">
    <div class="card-body">
      <h5 class="card-title">Card title</h5>
      <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
      <a href="#" class="btn btn-primary">Go somewhere</a>
    </div>
  </div>
</main>

<script>
function ajaxTest() {
  $.ajax({
    type: "POST",
    url : '<?=PROOT?>home/testAjax',
    data: {model_id:45},
    success: function(resp) {
      if(resp.success) {
        window.alert(resp.data.name)
      }
      console.log(resp);
    }
  });
}
</script>
<?php $this->end(); ?>
