<?php
   include "connect.php";
   //routes
   $tpl  = 'includes/templates/'; //Template directory
   $lang = 'includes/languages/'; // languages directory
   $css  =  'layout/css/';
   $js   =  'layout/js/';
   $func =  'includes/functions/';
   
  
   include $func.'function.php';
   include $lang.'english.php';
   include $tpl . 'header.php';
   
  

   // include navbar in all pages expect the one with nonavbar variable

   if (!isset($nonavbar)) {
      include $tpl."navbar.php";
   }
  

   
   
   
 
   