<?php
                /*
                manger memebers page 
                you can edit | add | edit | delete from herer 
                */
                ob_start();
                session_start();
                $pageTitle='Comments';
               
                if (isset($_SESSION['Username'])) { 
                    include 'init.php';
                    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
                    if ($do == 'Manage') {
                        $stmt = $con->prepare("SELECT comments.* ,items.Name AS ItemName,users.Username AS UserName
                                                 FROM 
                                                      comments
                                                 INNER JOIN
                                                      items 
                                                 ON  
                                                      items.Item_ID=comments.item_id
                                                 INNER JOIN 
                                                      users 
                                                 ON  users.UserID =comments.user_id 
                                                 ORDER BY c_id DESC");
                        $stmt->execute();
                        $rows = $stmt->fetchAll();
                        
?>
                         
                        <h1 class='text-center'>Manage Comments</h1>
                        <div class='container'>
                            <div class="table-responsive">
                                <table class="table table-bordered main-table text-center">
                                <tr>
                                        <td>#ID</td>
                                        <td>Comment</td>
                               
                                        <td>User Name</td>
                                        <td>Item Name</td>
                                        <td>Registered Date</td>
                                        <td>Control</td>
                                </tr>
                            <?php
                                    foreach ($rows as $row) {
                                        
                                        echo"<tr>";
                                        echo "<td>".$row['c_id']."</td>";
                                        echo "<td>".$row['comment']."</td>";
                                   
                                        echo "<td>".$row['UserName']."</td>";
                                        echo "<td>".$row['ItemName']."</td>";
                                        echo "<td>".$row['comment_date']."</td>";
                                        echo "<td>".
                                              '<a href="comment.php?do=Edit&comid='.$row['c_id'].'" class="btn btn-success"><i class="glyphicon glyphicon-edit"></i>Edit</a>'.
                                              '<a href="comment.php?do=Delete&comid='.$row['c_id'].'" class="comfirm btn btn-danger"><i class="glyphicon glyphicon-remove"></i>Delete</a>';
                                               if ($row['status']== 0) {
                                                echo '<a href="comment.php?do=Approve&comid='.$row['c_id'].'" class="btn btn-info"><i class="glyphicon glyphicon-ok"></i>Approve</a>';
                                              
                                               }
                                              echo "</td>";
                                        echo"</tr>";
                                    }

                            ?>                                  
                                                                
                                
                                </table>
                            </div>
                                    
                            </div>
                            <?php }elseif ($do == 'Edit') {
                                $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']):0;
                                $stmt = $con->prepare("SELECT * FROM comments 
                                WHERE c_id  = ? ");
                                $stmt->execute(array($comid));
                                $row  = $stmt->fetch();
                                $count = $stmt->rowCount();
                                
                                if ($count>0) {
                                    
                                
                                ?>
                                <h1 class='text-center'>Edit Comment</h1>
                                <div class='container'>
                               
                                                    
                                   <form class="form-horizontal" action="?do=Update" method='POST'>               
                                   <input type = "hidden"  name = "comid" value = "<?PHP echo $comid ?>" />
                                                <div class = "form-group form-group-lg">
                                                        <label  class="col-sm-2 control-label "><h2>Comment:</h2></label>
                                                        <div class="col-sm-10">
                                                        <textarea  name="comment" rows="4" cols="100"><?php echo $row['comment']  ?></textarea>
                                                        </div>
                                                </div>
                                                
                                                <div class = "form-group form-group-lg">
                                                    <div class="col-sm-offset-2 col-sm-10 ">
                                                    <input type = "submit" name = "save"     class="btn btn-primary btn-lg"/>
                                                    </div>
                                                </div>
            
                                    </form>
                                </div>


                                    
<?php }
                               else {
                                    $Msg="<div class = 'alert alert-danger'>YOU ARE NOT A MEMBER </div>";
                                    DirectionHome($Msg);
                                   }
                        

                        }elseif ($do == 'Update') {
                            echo"<h1 class='text-center'>Update Comment</h1>";
                            echo "<div class = 'container'>";
                            if ($_SERVER['REQUEST_METHOD']=='POST') {
                            $id         = $_POST['comid'];
                            $comment    = $_POST['comment'];
                        
                                $stmt = $con->prepare("UPDATE  comments  SET
                                                comment = ? 
                                                 WHERE c_id = ? ");
                            
                            $stmt->execute(array( $comment ,$id  ));
                            $msg="<div class='alert alert-success'>YESSSS!!! ".$stmt->rowCount()."comment has been updated</div>";
                            DirectionHome($msg);
                            }
                            else {
                                $Msg="<div class='alert alert-danger'>YOU CAN NOT COME DIRECTORY</div> ";
                                DirectionHome($Msg,6);
                            }
                            echo "</div";
                            
                        }elseif ($do == 'Delete') {
                                $comid  = isset($_GET['comid'])&& is_numeric($_GET['comid'])?intval(($_GET['comid'])):0;
                                $stmt  = $con->prepare('DELETE FROM comments WHERE c_id = :zcom');
                                $stmt->bindParam('zcom',$comid );
                                $stmt->execute();
                                if ($stmt->rowCount() > 0) {
                                $msg="<div class='alert alert-success'>".$stmt->rowCount()."comment has been deleted</div>";
                                DirectionHome($msg,'comment.php');
                                
                                }else {
                                    $msg="<div class='alert alert-danger'>Therer is no such user with this name and  'ID'   !!!</div>";
                                DirectionHome($msg);
                                        }
                            

                        }elseif ($do == 'Approve') {
                            $comid  = isset($_GET['comid'])&& is_numeric($_GET['comid'])?intval(($_GET['comid'])):0;

                            $stmt  = $con->prepare('UPDATE comments SET  status=1 WHERE c_id = ?');
                            $stmt->execute(array($comid ));
                            if ($stmt->rowCount() > 0) {
                            $Msg = "<div class='alert alert-success'>".$stmt->rowCount()."member has been Approved</div>";
                            DirectionHome($Msg,'comment.php',);
                            }else {
                              echo"<div class='alert alert-danger'>Therer is no such user with this name and  'ID'   !!!</div>";
                                    }
                            
                        }
                        else {
                            # code...
                        }
include $tpl . "footer.php";
}else {
    header('location:index.php');
    exit();
}
ob_end_flush();
?>