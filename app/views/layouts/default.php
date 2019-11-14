<?php
  use Core\Session;
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?=$this->siteTitle();?></title>
    <link rel="stylesheet" href="<?=PROOT?>css/bootstrap.min.css" >
    <link rel="stylesheet" href="<?=PROOT?>css/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="<?=PROOT?>css/custom.css" media="screen" title="no title" charset="utf-8" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" ></script>

    <?= $this->content('head'); ?>

  </head>
  <body>

    <?php include 'main_menu.php' ?>
    <div class="container-fluid" type="min-height: cal(100% - 125px);">
    <?= Session::displayMsg() ?>
    <?=$this->content('body'); ?>
  <div class="subscr">

  </div>

  </body>

</html>
