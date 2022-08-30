<?php 
$pageTitle = $_GET['catName'];
include 'init.php';
echo"<div class='container'>";
echo"<h1>".$_GET['catName']."</h1>";
echo "<div class='row'>";
            foreach (GetItem('Cat_ID' ,$_GET['catpage'],1) as $item) {
                echo "<div class='col-sm-6'>";
                echo "<div class='thumbnail item-box'>";
                    echo "<span class='price-tag'>".$item['price']."</span>";
                    if ($item['Approve']==0) {echo "<div class='cat-Approve pull-right'>NOT APPROVED</div>";}
                    echo "<img src='ecom.jpg' height='300' width='400px'>";
                      echo"<div class='caption'>";
                                 echo '<h2>    <a href="item.php?item_id='.$item['Item_ID'].'">'.$item['Name']."</a> </h2>";
                                 echo '<p>'.$item['Description']." </p>";
                echo"</div>";
                echo"</div>";
                echo"</div>";
              
            }
echo"</div>";
echo"</div>";
 include $tpl . "footer.php"; 
 ?>