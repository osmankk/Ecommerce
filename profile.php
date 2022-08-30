
<?php
session_start();
$pageTitle = 'Profile'; 
include 'init.php';
if (isset($_SESSION['user'])) {
$stmt= $con->prepare("SELECT * FROM users where Username=?");
$stmt->execute(array($_SESSION['user']));
$row = $stmt->fetch();


?>
<h1 class='text-center'><?php echo $session_name?> Profile</h1>
<div class='information block profile'>
    <div class='container'>
        <div class='panel panel-primary'>
            <div class=' panel-heading'><h3>My Info</h3> </div>
                <div class='panel-body'>
                    <ul class='list-unlist'>
                    <li><i class="glyphicon glyphicon-lock" ></i><span>Name</span>:<?php echo $row['Username'] ?></li>
                    <li><i class="glyphicon glyphicon-envelope" ></i><span>E-mail</span>:<?php echo $row['email'] ?></li>
                    <li><i class="glyphicon glyphicon-user" ></i><span>Full-Name</span>:<?php echo $row['FullName'] ?></li>
                    <li><i class="glyphicon glyphicon-calendar" ></i><span>Date-Registe</span>:<?php echo $row['Date'] ?></li>
                    <li><i class="glyphicon glyphicon-tag" ></i><span>favorites</span></li>
                    </ul>
                </div> 
        </div>  
    </div>
</div> 

<div class='ads block' id='my-ads'>
    <div class='container'>
        <div class='panel panel-primary'>
            <div class=' panel-heading'><h3>My Items</h3></div>
                <div class='panel-body'>
                    
                    <?php
                   
                    if (!empty(GetItem('Member_ID',$row['UserID']))) {
                    echo "<div class='row'>"; 
                    foreach (GetItem('Member_ID',$row['UserID']) as $Item) { 
                            echo"<div class= 'col-sm-6'>";
                                    echo "<div class='thumbnail item-box'>";
                                       echo "<img src='ecom.jpg' height='300' class='img-responsive img-thumbnail' width='400px'>";
                                            echo "<span class='price-tag'>$". $Item['price']."</span>";
                                                echo"<div class='caption'>";
                                                    echo '<h2><a href="item.php?item_id='.$Item['Item_ID'].'">'.$Item['Name']."</a> </h2>";
                                                    echo '<p class ="Description">'.$Item['Description']." </p>";
                                                    echo '<div class="date">'.$Item['Add_Date']." </div>";
                                                echo "</div>";
                                    
                                echo "</div>";
                            echo "</div>";
                    }
                    echo "</div>";
                }else {
                    echo "<h2>Ads Empty</h2>";
                }
                    ?>
                    <button  class=" btn-lg "><a href="new_ad.php">Add new Item</a></button>
                </div> 
        </div>  
    </div>
</div> 

<div class='comments block'>
    <div class='container'>
        <div class='panel panel-primary'>
            <div class=' panel-heading'><h3>Latest Comments </h3></div>
                <div class='panel-body'>
                    <?php
                    $stmt= $con->prepare("SELECT * FROM comments where user_id=?");
                    $stmt->execute(array($row['UserID']));
                    $coms = $stmt->fetchAll();
                    if (!empty($coms)) {
                    foreach ($coms as $com) {
                        echo '<h3>'.$com['comment_date']." </h3>";
                       echo '<p>'.$com['comment']." </p>";
                    }
                }
                else {
                    echo "<h2>Empty Comments </h2>";
                }
                    
                    ?>
                </div> 
        </div>  
    </div>
</div> 
<?php
}else {
 header('location:index.php');
 exit();
}
 include $tpl . "footer.php"; 
 
 ?>