<style>
  .edit-image-wrapper {
    background-color: #eaeaea;
    border-radius: 4px;
    box-shadow: 2px 2px 6px rgba(0,0,0,0.25);
    float: left;
    margin-left: 12px;
    position:relative;


  }
  .img {
    height: 75px;
    width : 100%;

  }
  .sortable-placeholder {
    background-color: #eee;
  }
  .deleteButton {
    position:absolute;
    top: 8px;
    right: 5px;
    color: crimson;
    cursor: pointer;
  }
  .deleteButton:hover {
    color: #aa0000;
  }
</style>
<div id="sortableImages" class="row align-items-center justify-content-start p-2">
      <?php foreach($this->images as $image) : ?>
        <div class="col flex-grow-0" style ="position:relative;"id="image_<?=$image->id?>">

            <div class="edit-image-wrapper" data-id="<?=$image->id?>">
              <span class="deleteButton"  onclick="deleteImage(<?=$image->id?>)"><i class="glyphicon glyphicon-remove"></i></span>
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

function deleteImage(image_id) {
  if(confirm("Are you sure? This cannot be undone!")) {
    jQuery.ajax({
      url : '<?=PROOT?>adminproduct/deleteImage',
      method : 'POST',
      data : {image_id : image_id},
      success: function(resp) {
        if(resp.success) {
          jQuery('#image_'+resp.model_id).remove();
          updateSort();
        }
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
