<?php
ini_set('dispaly_errors','on');
$session_name='undefined user';

error_reporting(E_ALL);
if (isset($_SESSION['user'])) {
   $session_name=$_SESSION['user'];
}
   include "admin/connect.php";
   //routes
   $tpl  = 'includes/templates/'; //Template directory
   $lang = 'includes/languages/'; // languages directory
   $css  =  'layout/css/';
   $js   =  'layout/js/';
   $func =  'includes/functions/';
   
  
   include $func.'function.php';
   include $lang.'english.php';
   include $tpl . 'header.php';
   
   
   
 
   