
<?php
session_start();
                          

if (isset($_SESSION['Username'])) {
    $pageTitle = 'Dashboard';
    include 'init.php';
    $count=6;
    $latest_members = GetLatest("*", "users", "UserID", $count);
    $latest_items   = GetLatest("*", "items", "Item_ID", $count);

   
?>
<div class='container home-state text-center'>
    <h1>Dashboard</h1>
    <div class='row'>
           <div class="col-md-3">
                <div class="stat st-members">
                    <i class='glyphicon glyphicon-user'></i>
                    </br>
                    <div class='info'>
                    Total members<br>
                    <span><a href="members.php"><?php echo CounterItems("userID","users") ?></a></span>
                   </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat st-pending">
                <i class='glyphicon glyphicon-plus'></i>
                    </br>
                    <div class='info'>
                    Pending members<br>
                    <span><a href="members.php?do=Manage&page=pending">
                        <?php echo Check_database("RegStatus","users",0)?>
                    </a></span>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat st-items">
                <i class='glyphicon glyphicon-tag'></i>
                    </br>
                    <div class='info'>
                    Total Items<br>
                    <span><a href="items.php?do=Manage">
                        <?php echo CounterItems('Item_ID','items')?>
                    </a></span>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat st-comments">
                <i class='glyphicon glyphicon-comment'></i>
                    </br>
                    <div class='info'>
                    Total Comments<br>
                    <span><a href="comment.php">
                    <?php echo CounterItems('c_id','comments')?>
                    </a></span>
                    </div>
                </div>
            </div>
    </div>

</div> 
<div class='container latest'>
        <div class='row'>
                <div class= 'col-sm-6'>
                    <div class='panel panel-default'>
                        <div class='panel-heading'>
                            <i class='glyphicon glyphicon-user'></i>Latest Registered users
                            <span class='toggle-info pull-right'>
                                <i class='glyphicon glyphicon-plus'></i>
                            </span>
                        </div>

                        <div class='panel-body'>
                                <ul class="list-unstyled latest-users">
                                <?php
                                if (! empty($latest_members)) {
                                    
                               
                                foreach ($latest_members as $user) {
                                    echo "<li>"
                                            .$user["Username"].
                                                "<a href='members.php?do=Edit&user_id=".$user["UserID"]."'>
                                                <span class= 'btn btn-success pull-right'>
                                                <i class='glyphicon glyphicon-edit'></i> 
                                                Edit</a>";
                                                if ($user['RegStatus']== 0) {
                                                    echo '<a href="members.php?do=Activate&user_id='  .$user['UserID'].
                                                    '" class="btn btn-info pull-right"><i class="glyphicon glyphicon-ok"></i>Activate</a>';
                                                
                                                }
                                                echo "</span>
                                                </a>
                                        </li>";
                                }
                            }else {
                                echo"<div class ='alert alert-info '>There is no record </div>";
                            }
                                ?>
                                </ul>
                        </div>
                        
                    
                    </div>
                </div>

                <div class= 'col-sm-6'>
                    <div class='panel panel-default'>
                        <div class='panel-heading'>
                            <i class='glyphicon glyphicon-tag'></i> Latest Items
                            <span class='toggle-info pull-right'>
                                <i class='glyphicon glyphicon-plus'></i>
                            </span>
                        </div>

                        <div class='panel-body'>
                          <ul class="list-unstyled latest-users">
                                <?php
                                if (! empty($latest_items)) {
                                    
                                
                                foreach ($latest_items as $item) {
                                    echo "<li>"
                                            .$item["Name"].
                                                "<a href='Items.php?do=Edit&item_id=".$item["Item_ID"]."'>
                                                <span class= 'btn btn-success pull-right'>
                                                <i class='glyphicon glyphicon-edit'></i> 
                                                Edit</a>";
                                                if ($item['Approve']== 0) {
                                                    echo '<a href="Items.php?do=Approve&item_id='  .$item['Item_ID'].
                                                    '" class="btn btn-info pull-right"><i class="glyphicon glyphicon-ok"></i>Approve</a>';
                                                
                                                }
                                                echo "</span>
                                                </a>
                                        </li>";
                                }
                            }else {
                                    echo"<div class ='alert alert-info '>There is no record </div>";
                                }
                                ?>
                            </ul>
                        </div>
                        
                    
                    </div>
                </div>
        </div>
        <!-- start latest comment  -->
        <div class='row'>
                <div class= 'col-sm-6'>
                    <div class='panel panel-default'>
                        <div class='panel-heading'>
                            <i class='glyphicon glyphicon-comment'></i>
                            Latest Comments
                            <span class='toggle-info pull-right'>
                                <i class='glyphicon glyphicon-plus'></i>
                            </span>
                        </div>

                        <div class='panel-body'>
                          <?php 
                            $stmt = $con->prepare("SELECT comments.* ,users.Username AS UserName
                                FROM 
                                        comments
                                INNER JOIN 
                                        users 
                                ON 
                                        users.UserID =comments.user_id 
                                ORDER BY c_id DESC
                                 ");
                                    $stmt->execute();
                                    $rows = $stmt->fetchAll();
                                    if (! empty($rows)) {
                                        # code...
                                    
                                    foreach ($rows as $row) {
                                        echo"<div class= 'comment-box'>";
                                            echo"<span class= 'member-n'>".$row['UserName'];
                                           
                                            echo"</span>";
                                            
                                            echo"<p class= 'member-c'>".$row['comment'];
                                            echo"</p>";
                                          
                                        echo"</div>";
                                    }
                                }else {
                                    echo"<div class ='alert alert-info '>There is no record </div>";
                                }
                                    
                          ?>
                        </div>
                    </div>
                </div>
          </div>
        <!-- start latest comment  -->
    </div>

</div>
   
<?php

    include $tpl . "footer.php";
}else {
    header('Location:index.php');

}
     
?>



