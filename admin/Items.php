<?php
ob_start();
session_start();
$pageTitle='Items';
if (isset($_SESSION['Username'])) { 
        include 'init.php';
        $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
        if ($do == 'Manage') {
        $stmt = $con->prepare("SELECT items.*,categories.Name AS category_name ,users.Username AS member_name FROM items
                              INNER JOIN categories ON categories.ID = items.Cat_ID 
                              INNER JOIN users      ON  users.UserID = items.Member_ID
                              ORDER BY Item_ID  DESC");



        $stmt->execute();
        $rows = $stmt->fetchAll(); ?>
        <h1 class='text-center'>Manage Items</h1>
        <div class='container'>
        <div class="table-responsive">
            <table class="table table-bordered main-table text-center">
                <tr>
                    <td>#ID</td>
                    <td>Item Name</td>
                    <td>Description</td>
                    <td>Orgin Country</td>
                    <td>price</td>
                   
                    <td>Category Name</td>
                    <td>UserName</td>
                    <td>Registered Date</td>
                    <td>Control</td>
                </tr>
                <?php
                    foreach ($rows as $row) {
                        
                        echo"<tr>";
                        echo "<td>".$row['Item_ID']."</td>";
                        echo "<td>".$row['Name']."</td>";
                        echo "<td>".$row['Description']."</td>";
                        echo "<td>".$row['Country_Made']."</td>";
                        echo "<td>".$row['price']."</td>";
                    
                        echo "<td>".$row['category_name']."</td>";
                        echo "<td>".$row['member_name']."</td>";
                        echo "<td>".$row['Add_Date']."</td>";
                      
                        echo "<td>".
                                '<a href="Items.php?do=Edit&item_id='  .$row['Item_ID'].'" class="btn btn-success"><i class="glyphicon glyphicon-edit"></i>   Edit</a>'.
                                '<a href="Items.php?do=Delete&item_id='.$row['Item_ID'].'" class="comfirm btn btn-danger"><i class="glyphicon glyphicon-remove"></i>   Delete</a>';
                                if ($row['Approve']== 0) {
                                    echo '<a href="Items.php?do=Approve&item_id='.$row['Item_ID'].'" class="btn btn-info"><i class="glyphicon glyphicon-ok"></i>Approve</a>';
                                  
                                   }
                                echo "</td>";
                        echo"</tr>";
                    }?>  

                                            
                                                
                
                </table>
            </div>
                            
                        <a href='Items.php?do=Add' class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> New Item</a>
                    </div>
           <?php }elseif ($do == 'Add') {?>
           
                <h1 class='text-center'>Add New Item</h1>
                <div class="container" >
                    <form class="form-horizontal" action="?do=Insert" method='POST'>
                        <div class="form-group form-group-lg">
                                <label  class="col-sm-2 control-label">Name</label>
                                <div class="col-sm-10">
                                <input type = "text" name = "name"  class="form-control"  required='required' placeholder='Name of the Item'/>
                                </div>
                        </div>

                        <div class="form-group form-group-lg">
                                <label  class="col-sm-2 control-label">Description</label>
                                <div class="col-sm-10">
                                <textarea type = "text" name = "describe"  class=" form-control " required='required' placeholder='Describe the item' ></textarea>
                                </div>
                        </div>

                        <div class="form-group form-group-lg">
                                <label  class="col-sm-2 control-label">Price</label>
                                <div class="col-sm-10">
                                <input type = "text" name = "price"  class=" form-control " required='required' placeholder='price of the item'/>
                                </div>
                        </div>

                        <div class="form-group form-group-lg">
                                <label  class="col-sm-2 control-label">Country</label>
                                <div class="col-sm-10">
                                <input type = "text" name = "country"  class=" form-control " required='required' placeholder='country of orgin'/>
                                </div>
                        </div>


                        <div class="form-group form-group-lg">
                                <label  class="col-sm-2 control-label">Status</label>
                                <div class="col-sm-10">
                                    <select name='status' class=' '>
                                    <option value="0">.....</option>
                                    <option value="1">New</option>
                                    <option value="2">Almost New</option>
                                    <option value="3">Used</option>
                                    <option value="4">Old</option>
                                    </select>  
                                </div>
                        </div>


                        <div class="form-group form-group-lg">
                                <label  class="col-sm-2 control-label">Member</label>
                                <div class="col-sm-10">
                                    <select name='member' class=' '>
                                    <option value="0">.....</option>
                                    <?php
                                    $stmt = $con->prepare("SELECT * FROM users ");
                                    $stmt->execute();
                                    $rows = $stmt->fetchAll();
                                    foreach ($rows as $row) {
                                        echo '<option value="'.$row['UserID'].'">'.$row['Username'].'</option>';
                                    }
                                    ?>
                                    </select>  
                                </div>
                        </div>



                        <div class="form-group form-group-lg">
                                <label  class="col-sm-2 control-label">Category</label>
                                <div class="col-sm-10">
                                    <select name='category' class=' '>
                                    <option value="0">.....</option>
                                    <?php
                                    $stmt = $con->prepare("SELECT * FROM categories ");
                                    $stmt->execute();
                                    $rows = $stmt->fetchAll();
                                    foreach ($rows as $row) {
                                        echo '<option value="'.$row['ID'].'">'.$row['Name'].'</option>';
                                    }
                                    ?>
                                    </select>  
                                </div>
                        </div>


                        <div class = "form-group form-group-lg">
                                    <div class="col-sm-offset-2 col-sm-10">
                                    <input type = "submit"  value=' Save' name = "Insert" class="btn btn-primary btn-lg"/>
                                   </div>
                        </div>
            
                     </form>
                 <div>
            <?php }elseif ($do == 'Insert') {
                 if ($_SERVER['REQUEST_METHOD']=='POST') {
                    echo"<h1 class='text-center'>Insert Item</h1>";
                    echo "<div class = 'container'>";
                    $name      = $_POST['name'];
                    $desc      = $_POST['describe'];
                    $price     = $_POST['price'];
                    $country   = $_POST['country'];
                    $status    = $_POST['status'];
                    $member    = $_POST['member'];
                    $cat       = $_POST['category'];
                    $error_form =array();
                    if (empty($_POST['name'])) {
                        $error_form[] = " Items NAME CANNT BE <strong>EMPTY</strong>";//div dont work
                    }
    
                    if (empty($_POST['describe'])) {
                        $error_form[] = "DESCRIPTION CANNT BE <strong>EMPTY</strong>";//div dont work
                        
                    }
                    if (empty($_POST['price'])) {
                        $error_form[] = "PRICE CANNT BE <strong>EMPTY</strong>";//div dont work
                    }
                    if (empty($_POST['country'])) {
                        $error_form[] = " COUNTRY CANNT BE <strong>EMPTY</strong>";//div dont work
                    }
                    if ($_POST['status']==0) {
                        $error_form[] = " STATUS CANNT BE <strong>EMPTY</strong>";//div dont work
                    }
                    if ($_POST['member']==0) {
                        $error_form[] = " Member CANNT BE <strong>EMPTY</strong>";//div dont work
                    }
                    if ($_POST['category']==0) {
                        $error_form[] = " Category CANNT BE <strong>EMPTY</strong>";//div dont work
                    }
                    foreach ( $error_form as $error ) {
                        echo '<div class="alert alert-danger">'.$error.'</div>';
                    }
                    if (empty($error_form)) {
                        $stmt = $con->prepare("INSERT INTO 
                                    Items(Name,Description,price,Country_Made,status,Cat_ID,Member_ID,Add_Date)
                                    VALUES(:zname,:zdesc,:zprice,:zcountry,:zstatus,:zcat,:zmember,now())");
                        $stmt->execute(array(
                        'zname'   => $name , 
                        'zdesc'   => $desc  , 
                        'zprice'  => $price , 
                        'zcountry'=> $country ,
                        'zstatus' => $status,
                        'zcat'    => $cat,
                        'zmember' => $member
                     ));
                        $Msg ="<div class='alert alert-success'>".$stmt->rowCount() . "item have been added"."</div>";
                        DirectionHome($Msg,'back');
                      
                    }
                
                 
                    }else {
                        $Msg="<div class='alert alert-danger'> SORRY YOU CANOT BROWSE THIS PAGE DIRECTLY </div>";
                        DirectionHome($Msg);
                        }
                        echo "</div>";
    }elseif ($do=='Edit') {
    $item = isset($_GET['item_id']) && is_numeric($_GET['item_id']) ? intval($_GET['item_id']):0;
            $stmt = $con->prepare("SELECT * FROM items 
            WHERE Item_ID  = ? ");
            $stmt->execute(array($item));
            $row  = $stmt->fetch();
            $count = $stmt->rowCount();
            
            if ($count>0) { ?>
                    <h1 class='text-center'>Edit Item</h1>
                    <div class="container" >
                    <form class="form-horizontal" action="?do=Update" method='POST'>
                    <input type = "hidden" name = "item_ID" value = "<?PHP echo $item ?>" />
                        <div class="form-group form-group-lg">
                                <label  class="col-sm-2 control-label">Name</label>
                                <div class="col-sm-10">
                                <input type = "text" name = "name"  class="form-control"  required='required' placeholder='Name of the Item' value='<?php echo $row['Name'] ?>'/>
                                
                                </div>
                        </div>

                        <div class="form-group form-group-lg">
                        <label  class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-10">
                        <input type = "text" name = "describe"  class=" form-control " required='required' placeholder='Describe the item' value='<?php echo $row['Description'] ?>'/>
                        </div>
                        </div>

                        <div class="form-group form-group-lg">
                                <label  class="col-sm-2 control-label">Price</label>
                                <div class="col-sm-10">
                                <input type = "text" name = "price"  class=" form-control " required='required' placeholder='price of the item' value='<?php echo $row['price'] ?>'/>
                                </div>
                        </div>

                        <div class="form-group form-group-lg">
                                <label  class="col-sm-2 control-label">Country</label>
                                <div class="col-sm-10">
                                <input type = "text" name = "country"  class=" form-control " required='required' placeholder='Country of orgin' value='<?php echo $row['Country_Made'] ?>'/>
                                </div>
                        </div>


                        <div class="form-group form-group-lg">
                                <label  class="col-sm-2 control-label">Status</label>
                                <div class="col-sm-10">
                                    <select name='status' class=' '>
                                
                                    <option value="1"<?php if ($row['status']==1) { echo "selected";}?>>New</option>
                                    <option value="2"<?php if ($row['status']==2) { echo "selected";}?>>Almost New</option>
                                    <option value="3"<?php if ($row['status']==3) { echo "selected";}?>>Used</option>
                                    <option value="4"<?php if ($row['status']==4) { echo "selected";}?>>Old</option>
                                    </select>  
                                </div>
                        </div>


                        <div class="form-group form-group-lg">
                                <label  class="col-sm-2 control-label">Member</label>
                                <div class="col-sm-10">
                                    <select name='member1' >
                                    <option value ='0'>.....</option>
                                    <?php
                                    $stmt1 = $con->prepare("SELECT * FROM users ");
                                    $stmt1->execute();
                                    $users = $stmt1->fetchAll();

                                    foreach ($users as $user) {
                                        echo $user['UserID '];
                                        echo'<option value="'.$user['UserID'].'"';
                                        if ($row['Member_ID']==$user['UserID']) {
                                        echo'selected';
                                        }
                                        echo '>'.$user['Username'].'</option>';
                                    }

                                    ?>
                                    </select>  
                                </div>
                        </div>

                        <div class="form-group form-group-lg">
                                <label  class="col-sm-2 control-label">Category</label>
                                <div class="col-sm-10">
                                    <select name='category' class=' '>
                                    
                                    <?php
                                    $stmt2 = $con->prepare("SELECT * FROM categories ");
                                    $stmt2->execute();
                                    $cats = $stmt2->fetchAll();
                                    foreach ($cats as $cat) {
                                        echo'<option value="'.$cat['ID'].'"';
                                        if ($cat['ID']==$item['Cat_ID']) {
                                        echo'selected';
                                        }
                                        echo '>'.$cat['Name'].'</option>';
                                    }
                                    ?>
                                    </select>  
                                </div>
                        </div>


                                        <div class = "form-group form-group-lg">
                                                <div class="col-sm-offset-2 col-sm-10 ">
                                                <input type = "submit" name = "save" class="btn btn-primary btn-lg"/>
                                                </div>
                                        </div>
                                    </form>







                                   

                         <?php 
                         $stmt = $con->prepare("SELECT comments.* ,users.Username AS UserName
                                                 FROM 
                                                      comments
                                                 INNER JOIN 
                                                      users 
                                                 ON 
                                                      users.UserID =comments.user_id 
                                                 WHERE 
                                                 item_id  =? ");
                        $stmt->execute(array($item));
                        $rows = $stmt->fetchAll();
                        if (!empty($rows)) {
                         
?>
                         
                        <h1 class='text-center'><?php echo $row['Name'] ?> Comments</h1>
                      
                            <div class="table-responsive">
                                <table class="table table-bordered main-table text-center">
                                <tr>
    
                                        <td>Comment</td>
                                        <td>Status</td>
                                        <td>User Name</td>
                                        <td>Registered Date</td>
                                        <td>Control</td>
                                </tr>
                                 <?php
                                    foreach ($rows as $row) {
                                        
                                        echo"<tr>";
                                        echo "<td>".$row['comment']."</td>";
                                        echo "<td>".$row['status']."</td>";
                                        echo "<td>".$row['UserName']."</td>";
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
                            <?php } ?>
            </div> 
                           
                             
                            <?php }else {
                                                $Msg="<div class = 'alert alert-danger'>YOU ARE NOT A MEMBER </div>";
                                                DirectionHome($Msg);
                                    }
                    
            }elseif ($do=='Update') {
                echo"<h1 class='text-center'>Update Item</h1>";
                echo "<div class = 'container'>";
                if ($_SERVER['REQUEST_METHOD']=='POST') {
                    $id        = $_POST['item_ID'];
                    $name      = $_POST['name'];
                    $desc      = $_POST['describe'];
                    $price     = $_POST['price'];
                    $country   = $_POST['country'];
                    $status    = $_POST['status'];
                    $member    = $_POST['member1'];
                    $cat       = $_POST['category'];
                   
                  
                
                    $error_form =array();
                    if (empty($name )) {
                        $error_form[] = " Items NAME CANNT BE <strong>EMPTY</strong>";//div dont work
                    }
                    
                    if (empty($desc)) {
                        $error_form[] = "DESCRIPTION CANNT BE <strong>EMPTY</strong>";//div dont work
                        
                    }
                    if (empty( $price)) {
                        $error_form[] = "PRICE CANNT BE <strong>EMPTY</strong>";//div dont work
                    }
                    if (empty($country)) {
                        $error_form[] = " COUNTRY CANNT BE <strong>EMPTY</strong>";//div dont work
                    }
                    if ($status ==0) {
                        $error_form[] = " STATUS CANNT BE <strong>EMPTY</strong>";//div dont work
                    }
                    if ($member==0) {
                        $error_form[] = " Member CANNT BE <strong>EMPTY</strong>";//div dont work
                    }
                    if ($cat==0) {
                        $error_form[] = " Category CANNT BE <strong>EMPTY</strong>";//div dont work
                    }
                    foreach ( $error_form as $error ) {
                        echo '<div class="alert alert-danger">'.$error.'</div>';
                    }
                    if (empty($error_form)) {
                            $stmt = $con->prepare("UPDATE  items  SET
                                            Name = ?,
                                            Description = ?,
                                            price = ?,
                                            Country_Made = ?,
                                            status = ?,
                                            Member_ID=?,
                                            Cat_ID =?
                                     WHERE Item_ID = ? ");
                        
                        $stmt->execute(array($name ,$desc,$price,$country ,$status,$member, $cat ,$id));
                        $Msg="<div class='alert alert-success'>YESSSS!!! ".$stmt->rowCount()." records</div>";
                        DirectionHome($Msg,'back');
                        }
                    
                        
                }else {
                    $Msg="<div class='alert alert-danger'>YOU CAN NOT COME DIRECTORY</div> ";
                    DirectionHome($Msg,6);
                }
                echo "</div";
                
                
            }elseif ($do=='Delete') {
                $item  = isset($_GET['item_id'])&& is_numeric($_GET['item_id'])?intval(($_GET['item_id'])):0;

                $stmt  = $con->prepare('DELETE FROM items WHERE item_ID = :zuser');
                $stmt->bindParam('zuser',$item );
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $msg="<div class='alert alert-success'>".$stmt->rowCount()."member has been deleted</div>";
                    DirectionHome($msg,'back');
                     
                }else {
                    $msg="<div class='alert alert-danger'>Therer is no such user with this name and  'ID'   !!!</div>";
                    DirectionHome($msg);
                     }
            }elseif ($do=='Approve') {
                $item  = isset($_GET['item_id'])&& is_numeric($_GET['item_id'])?intval(($_GET['item_id'])):0;

                    $stmt  = $con->prepare('UPDATE items SET  Approve=1 WHERE Item_ID = ?');
                    $stmt->execute(array($item ));
                    if ($stmt->rowCount() > 0) {
                    $Msg = "<div class='alert alert-success'>".$stmt->rowCount()."Item has been Activated</div>";
                    DirectionHome($Msg);
                    }else {
                      echo"<div class='alert alert-danger'>Therer is no such user with this name and  'ID'   !!!</div>";
                            }
            }else {
                # code...
            }
//now this is not related
include $tpl.'footer.php';
}else {
    header('location:index.php');
    exit();
}
ob_end_flush();
?>