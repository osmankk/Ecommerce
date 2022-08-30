<?php
ob_start();
session_start();
$pageTitle = 'item';
include "init.php";
$item_id = isset($_GET['item_id']) && is_numeric($_GET['item_id']) ? intval($_GET['item_id']):0;
$stmt = $con->prepare("SELECT items.*,
                              categories.Name AS caterory_name
                               ,users.Username   
                       FROM 
                                items 
                       INNER JOIN 
                                categories
                       ON
                                categories.ID =items.Cat_ID
                       INNER JOIN 
                                users
                       ON
                                 users.UserID= items.Member_ID 
                       WHERE Item_ID  = ? 
                    AND Approve = 1");
$stmt->execute(array($item_id));

$count = $stmt->rowCount();
if ($count>0) {
    $item  = $stmt->fetch();


?>

<h1 class="text-center"><?php echo $item['Name']  ?></h1>
<div class='container'>
    <div class='row'>
        <div class='col-sm-3 item-show-img'>
             
                    <img src='ecom.jpg' class="img-responsive img-thumbnail center-block" >
                
         </div>
          
       <div class='col-sm-8'>
       <ul class='list-unlist'>
       <li><h2><span>Name:</span><?php echo $item['Name']?> </h2></li>
       <li><span>Description:</span> <?php echo $item['Description']?> </li>
       <li> <span>Date:</span> <?php echo $item['Add_Date']?> </li>
       <li><span>Price:</span><?php echo "$".$item['price']?> </li>
       <li><span>Made in:</span> <?php echo $item['Country_Made']?> </li>
       <li><span>Category :</span><a href="categories.php?catpage=<?php echo $item['Cat_ID']?>&catName=<?php echo $item['caterory_name']?>"><?php echo $item['caterory_name']?></a> </li>
       <li><span>Add by :</span> <a href="#"><?php echo $item['Username']?> </a></li>
                
        </ul>                         
        </div>

    </div>
<?php if (isset($_SESSION['user'])) { ?>
<hr>

<div class='row comment'>
    <div class='row col-sm-8 col-sm-offset-3'>
   
       <h3> Add Comment</h3>
       <form  action='<?php echo $_SERVER['PHP_SELF']."?item_id=".$item_id ?>' method='POST'>
           <textarea class='form-control ' name='comment'></textarea>
           <input type='submit' class='btn btn-primary btn-lg' value='Add Comment'>
           
       </form>
       <?php 
                if ($_SERVER['REQUEST_METHOD']=='POST') {
                    $comment=$_POST['comment'];
                    $id_item=$item['Item_ID'];
                    $id_member=$_SESSION['id_user'];
                 
                    echo $comment;
                
                $stmt=$con->prepare("INSERT INTO comments (comment,status,comment_date,item_id,user_id )
                                     VALUES(:zcomment,0,now(),:zitem,:zuser)");
                $stmt->execute(array(
                                'zcomment' =>$comment,
                                'zitem'  =>$id_item,
                                'zuser'  =>$id_member
                 )

            );
            if ($stmt) {
                
               echo"<div class='alert alert-success'>comment waiting admin to APPROVE it </div>";
               echo"<div class='alert alert-success'> your comment is :".$comment."</div>";
            }
        }
               
            ?>
    </div>
    <?php }else {
    echo "<li><i class='glyphicon glyphicon-lock' ></i><a href='login.php'>Login</a> or <a href='login.php'>Registe</a>   to add comment";
       }?>
</div>

<hr>
   <?php
         $stmt = $con->prepare("SELECT comments.* ,users.Username AS UserName
         FROM 
              comments
         INNER JOIN 
              users 
         ON   users.UserID =comments.user_id 
         WHERE 
              item_id =?
        AND   
              status=1

         ORDER BY c_id DESC");
        $stmt->execute(array($item['Item_ID']));
        $comments = $stmt->fetchAll();
        
        
        ?>
<div class='row'>
    <div class='col-sm-3'>
       
    </div>
    <div class='col-sm-9'>
  <?php
  foreach ($comments as $comment) {
    echo "<div class='comment-box'>";
    echo "<div class='row'>";
            echo "<div class='col-sm-2 text-center'>";
                    echo "<img src='user.png' class='img-responsive img-thumbnail img-circle' >";
                        echo "<div class =''><h2>".$comment['UserName']."</h2></div>";
            echo "</div>";              
                            echo "<div class='col-sm-10'>";
                            echo "<p class ='lead'>".$comment['comment']."</p>";
                            echo "</div>";
                            echo "<div class =''>".$comment['comment_date']."</div>";
           
    echo "</div>";
    echo "</div>";
  }
  ?>
    </div>

</div>

</div>
<?php
}else {
    echo"<div class='container'>";
    echo "<div class='alert alert-danger text-center' >item is not exsited or waiting approvment</div>";
    echo"</div>";
}
 include $tpl . "footer.php"; 
 ob_end_flush();
 
 ?>