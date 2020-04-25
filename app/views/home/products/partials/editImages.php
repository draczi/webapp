<div id="sortableImages" class="row align-items-center justify-content-start p-2">
      <?php foreach($this->images as $image) : ?>
        <div class="col flex-grow-0" style ="position:relative; margin-bottom: 20px;"id="image_<?=$image->id?>">

            <div class="edit-image-wrapper" data-id="<?=$image->id?>">
              <span class="deleteButton"  onclick="deleteImage(<?=$image->id?>)"><i class="fa fa-trash-alt" style="color:#17a2b8;box-shadow: 5px 5px 15px rgba(0,0,0,0.6);"></i></span>
              <img src="<?=PROOT.$image->url?>" width="200px" height="200px" />
            </div>
        </div>
      <?php endforeach; ?>
</div>

<script>
function updateSort() {
  var sortedIDs = $("#sortableImages").sortable("toArray"); 
  $('#images_sorted').val(JSON.stringify(sortedIDs));
}

function deleteImage(id){
     if(window.confirm("Biztos, hogy törölni szeretnéd a képet?")){
      jQuery.ajax({
        url : '<?=PROOT?>products/deleteImage',
        method : "POST",
        data : {id : id},
        success: function(resp){
            var msgType = (resp.success)? 'success' : 'danger';
            if(resp.success){
                jQuery('#image_'+resp.model_id).remove();
              updateSort();
            }
            alertMsg(resp.msg, msgType);
          }
      });
    }
  }

jQuery('document').ready(function(){
  jQuery("#sortableImages").sortable({
    axis : "x",
    placeholder : "sortable-placeholder",
    update: function( event, ui) {
      updateSort();
    }
  });
  updateSort();
});

</script>
