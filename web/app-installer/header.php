<?php
//Direct access not permitted show 404
if(count(get_included_files()) ==1){ header("HTTP/1.0 404 Not Found"); die(); }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Web Application Installer for Vesta CP</title>

    <!-- BootStrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <!-- BootSwatch -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.5/flatly/bootstrap.min.css">   
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    
    <style>
       body { padding-top: 85px; padding-bottom: 40px;}
      .maincontent { padding-bottom: 40px; }
      .footer { margin-top: 25px;}
      .footer > p { text-align: left; font-size: 75%; }
      .navbar-brand { margin: 0px; }
      .navbar-brand:hover { color: #FFF !important;}
      .navbar-brand > .small { font-size: 75%; color: #18bc9c; }
      .text-coll  { font-size: 90%; color: #18bc9c; }
    </style>
    
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <header>
      <div class="navbar navbar-default navbar-fixed-top">
        <div class="container">
          <div class="navbar-header">
            <a href="<?=(htmlspecialchars($_SERVER['PHP_SELF']))?>" class="navbar-brand">Web App<span class="hidden-xs">lication</span> Installer <span class="small hidden-xs">for Vesta CP</span></a>
            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
          </div>
          <div class="navbar-collapse collapse" id="navbar-main">
            <ul class="nav navbar-nav navbar-right">
              <li><a href="<?=('https://'.$_SERVER["HTTP_HOST"])?>">Return to Vesta CP</a></li>
            </ul>
          </div>
        </div>
      </div>
    </header>
    <div class="maincontent">
      <div class="container">
        <?php
         if(isset($_SESSION['user']) && ($_SESSION['user'] == 'admin') && isset($_SESSION['look']) && ($_SESSION['look'] != '')) {
          echo'<div class="alert alert-warning" role="alert"><strong>WARNING YOUR USING ADMIN ACCOUNT TO INSTALL APPS AS "'.$_SESSION['look'].'"</strong></div>';
         } 

         if(isset($_SESSION['error_msg']) && !empty($_SESSION['error_msg'])):
          $errs = explode("#", $_SESSION['error_msg']);
          echo '<div class="alert alert-danger" role="alert"><strong>ERROR:</strong> <ul>';
           foreach ($errs as &$errsmsg) {
            if (!empty($errsmsg)) {
              echo '<li><strong>'.$errsmsg.'</strong></li>';
            }
           }
          echo '</ul></div>';
         endif;
         
         
         if(empty($_SESSION['error_msg']) &&  !empty($_SESSION['ok_msg'])):
           echo '<div class="alert alert-info" role="alert"><strong>'.$_SESSION['ok_msg'].'</strong></div>';
         endif;

        ?>
      </div>