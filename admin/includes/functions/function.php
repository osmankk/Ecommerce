
<?php
// front end to get cats from database




// the fuchion give the header ther page where you are 


function getTitle(){
    global $pageTitle;
    if (isset($pageTitle)) {
        echo $pageTitle;
    }else {
        echo 'Defualt';
    }
}
function DirectionHome($Msgerror,$url=null,$second=3)
{
    echo "<div class='container text-center' >";
    if ($url == null) {
        $url= 'index.php';
    }else {
        if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !=='') {
            $url= $_SERVER['HTTP_REFERER'];
        }
        else {
            $url= 'index.php';
        }
    }
    echo $Msgerror;
    echo "<div class='alert alert-info'>YOU WILL DIRECT TO THE HOME PAGE AFTER $second SECONDS</div>";
    echo "</div>";
    header("refresh:$second;url=$url");
    exit();
}
function Check_database($selector,$form,$value)
{
    global $con;
    $stmt = $con->prepare("SELECT $selector FROM $form WHERE $selector = ?");
    $stmt->execute(array($value));
    $count = $stmt->rowCount();
    return $count;
}
function CounterItems($selector,$form)
{
    global $con;
    $stmt = $con->prepare("SELECT COUNT($selector) FROM $form");
    $stmt->execute();
    $count = $stmt->fetchColumn();
    return $count;
    
}
function GetLatest($selector, $form, $order, $limits = 5)
{
    global $con;
    $stmt = $con->prepare("SELECT $selector FROM $form ORDER BY $order DESC LIMIT $limits ");
    $stmt->execute();
    $rows = $stmt->fetchAll();
    return $rows;

}


