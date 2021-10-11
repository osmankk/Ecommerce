<?php 
/*
*/
$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

if ($do == 'Manage'){
    echo 'welcome you are in Mange category page';
    echo '<a href="?do=Inswerr"> Add new category +</a>';

}elseif ($do == 'Add'){
    echo 'welcome to ADD apge ';
}elseif ($do == 'Insert'){
    echo 'welcome to Insert apge ';
}else {
    
        echo 'error there is noo page with this name ';
    
}