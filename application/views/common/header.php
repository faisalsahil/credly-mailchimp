<!DOCTYPE html>
<html lang="en">
<head>
  <base href="<?php echo base_url(); ?>" />
  <meta charset="utf-8">
  <title><?php echo $heading; ?></title>

  <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
  <!-- <meta name="description" content=""> -->
  <!-- <meta name="author" content=""> -->

  <style type="text/css">
  body {
    padding-top: 60px;
    padding-bottom: 40px;
  }
  .sidebar-nav {
    padding: 9px 0;
  }
  </style>
  
  <!-- Le styles -->

  <?php 
  echo link_css('bootstrap'); 
  echo link_css('style');
  echo link_css('bootstrap-responsive'); 
  echo link_css('datepicker');
  echo link_css('bootstrap-switch');
  echo link_css('font-awesome');
  echo link_css('font-awesome.min');
  echo link_css('dataTables.bootstrap');
  ?>

<!-- <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css"> -->
<!-- <link rel="stylesheet" href="assets/css/font-awesome.css">
 -->
<!-- <meta http-equiv="X-UA-Compatible" content="IE=9; IE=8;" />
 -->
  

  <!-- Fav and touch icons -->
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
  <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
  <link rel="shortcut icon" href="assets/ico/favicon.png">
  
  <script src="assets/js/jquery.js"></script>
  <script src="assets/js/jquery.form.js"></script>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  <script src="assets/js/bootstrap-switch.min.js"></script>  
  <script src="http://malsup.github.com/jquery.form.js"></script> 
 

</head>	
<body style="background-color: #eeeeee;min-width:1250px;">
  