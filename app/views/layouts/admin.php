<?php
use Core\Session;
use Core\H;
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?=$this->siteTitle();?></title>
    <link rel="stylesheet" href="<?=PROOT?>css/bootstrap.min.css" >
    <link rel="stylesheet" href="<?=PROOT?>css/fontawesome-pro-5.11.2-web/css/all.min.css">
    <link rel="stylesheet" href="<?=PROOT?>css/custom.css" media="screen" title="no title" charset="utf-8" />
    <link rel="stylesheet" href="<?=PROOT?>css/alertMsg.min.css" media="screen" title="no title" charset="utf-8" integrity="">
    <link rel="stylesheet" href="<?=PROOT?>css/bootstrap4/bootstrap.min.css" media="screen" title="no title" charset="utf-8">
<link rel="stylesheet" href="<?=PROOT?>js/jquery-ui/jquery-ui.min.css">
<script src="<?=PROOT?>js/jQuery-3.3.1.min.js"></script>
<script src="<?=PROOT?>js/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="<?=PROOT?>js/bootstrap4/bootstrap.min.js"></script>
<script src="<?=PROOT?>js/alertMsg.min.js?v=<?=VERSION?>"></script>
<script type="text/javascript" src="<?=PROOT?>js/jquery-ui/jquery-ui.min.js"></script>




    <?= $this->content('head'); ?>

</head>
<body style="width: 100%">
    <?php include 'admin_main_menu.php' ?>
    <div class="container-fluid" type="min-height: cal(100% - 125px);" style="min-height: 67vh;">
        <?= Session::displayMsg() ?>
        <?=$this->content('body'); ?>
    </div>

    <footer class="bg-dark" style="color: #fff"><i class="fal fa-copyright"></i> Drácz István Mezőgazdasági Aukciós portál.</footer>


</body>
</html>
