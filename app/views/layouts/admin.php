<?php
  use Core\Session;
?>
<!DOCTYPE html>
<html lang="hu">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?=$this->siteTitle();?></title>
    <link rel="stylesheet" href="<?=PROOT?>css/bootstrap.min.css" media="screen" title="no title" charset="utf-8" integrity=""/>
    <link rel="stylesheet" href="<?=PROOT?>css/custom.css" media="screen" title="no title" charset="utf-8" />
      <link rel="stylesheet" href="<?=PROOT?>js/jquery-ui/jquery-ui.min.css" integrity=""/>
      <link rel="stylesheet" href="<?=PROOT?>css/alertMsg.min.css" media="screen" title="no title" charset="utf-8" integrity="">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity=""></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js" integrity=""></script>
    <script type="text/javascript" src="<?=PROOT?>js/jquery-ui/jquery-ui.min.js" integrity=""></script>
    <script src="<?=PROOT?>js/popper.min.js" crossorigin="anonymous"></script>
    <script src="<?=PROOT?>js/alertMsg.min.js"></script>




    <?= $this->content('head'); ?>

  </head>
  <body>
    <?php include 'admin_main_menu.php' ?>
    <div class="container-fluid" type="min-height: cal(100% - 125px);">
      <?= Session::displayMsg() ?>
      <?=$this->content('body'); ?>
    </div>
  </body>
</html>
