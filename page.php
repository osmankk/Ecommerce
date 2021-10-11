<?php
   /*
   categories =>[Manage | Edit | Update | Add | Insert | Delete ]
   */
   
$do = isset($_GET['do']) ? $_GET['do']:'Manage';
// if the page is main page 
if ($do == 'Manage') {
    echo "WELCOME IN MANAGE PAGE";
    echo "<br>";
    echo '<a href="?do=Add">Add a new category + </a>';
}elseif ($do == 'Add') {
    echo "WELCOME IN ADD APGE";
}elseif ($do == 'Insert') {
    echo "WELCOME IN INSERT APGE";
}else {
    echo "THERE IS NO PAGE WITH THIS NAME";
}