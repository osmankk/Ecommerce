<?php
                /*
                manger memebers page 
                you can edit | add | edit | delete from herer 
                */
                
                session_start();
                $pageTitle='Members';
                $nonavbar = "";
                if (isset($_SESSION['Username'])) { 
                    include 'init.php';
                    $pageTitle = 'Members';
                    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
                    if ($do == 'Manage') {

                        $stmt = $con->prepare("SELECT * FROM users WHERE GroupID !=1 ");
                        $stmt->execute();
                        $rows = $stmt->fetchAll();
                        
?>
                         
                        <h1 class='text-center'>Manage Members</h1>
                        <div class='container'>
                            <div class="table-responsive">
                                <table class="table table-bordered main-table text-center">
                                <tr>
                                        <td>#ID</td>
                                        <td>User Name</td>
                                        <td>Email</td>
                                        <td>Full Name</td>
                                        <td>Registered Date</td>
                                        <td>Control</td>
                                </tr>
                            <?php
                                    foreach ($rows as $row) {
                                        
                                        echo"<tr>";
                                        echo "<td>".$row['UserID']."</td>";
                                        echo "<td>".$row['Username']."</td>";
                                        echo "<td>".$row['email']."</td>";
                                        echo "<td>".$row['FullName']."</td>";
                                        echo "<td>"."</td>";
                                        echo "<td>".
                                              '<a href="members.php?do=Edit&user_id='  .$row['UserID'].'" class="btn btn-success"><i class="glyphicon glyphicon-edit"></i>Edit</a>'.
                                              '<a href="members.php?do=Delete&user_id='.$row['UserID'].'" class="comfirm btn btn-danger"><i class="glyphicon glyphicon-remove"></i>Delete</a>'.
                                             "</td>";
                                        echo"</tr>";
                                    }

                            ?>                                  
                                                                
                                
                                </table>
                            </div>
                                    
                                <a href='members.php?do=Add' class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i>New Member</a>
                            </div>
                            <?php }elseif ($do == 'Add') {
                        
                       ?>
                           <h1 class='text-center'>Add New Member</h1>
                            <div class="container" >
                                <form class="form-horizontal" action="?do=Insert" method='POST'>
                                    <div class="form-group form-group-lg">
                                        <label  class="col-sm-2 control-label">Username</label>
                                        <div class="col-sm-10">
                                        <input type = "text" name = "username"  class="form-control" autocomplete="off" required='required' placeholder='write a suitable username'/>

                                        </div>
                                    </div>
                                    <div class="form-group form-group-lg">
                                        <label  class="col-sm-2 control-label">Password</label>
                                        <div class="col-sm-10">
                                        <input type = "password" name = "password"  class="password form-control "autocomplete="new-password" required='required' placeholder='choose astrong password'/>
                                        <i class='show-pass glyphicon glyphicon-eye-open ' ></i>
                                    </div>
                                    </div>
                                        <div class="form-group form-group-lg">
                                        <label  class="col-sm-2 control-label">Email</label>
                                        <div class="col-sm-10">
                                        <input type = "email" name = "email"  class="form-control" required='required' placeholder='write valid email'/>
                                        </div>
                                    </div>
                                       <div class="form-group form-group-lg">
                                        <label  class="col-sm-2 control-label">Full Name</label>
                                        <div class="col-sm-10">
                                        <input type = "text" name = "full" class="form-control " required='required' placeholder='write your full name'/>
                                        </div>
                                    </div>
                                        <div class = "form-group form-group-lg">
                                                        <div class="col-sm-offset-2 col-sm-10">
                                                        <input type = "submit" name = "Insert" class="btn btn-primary btn-lg"/>
                                        </div>
                                    </div>
                                    
                                </form>
                            <div>

                            <?php }
                            elseif($do == 'Insert') {
                                
                                if ($_SERVER['REQUEST_METHOD']=='POST') {
                                echo"<h1 class='text-center'>Update Member</h1>";
                                echo "<div class = 'container'>";
                                $username  = $_POST['username'];
                                $email     = $_POST['email'];
                                $full      = $_POST['full'];
                                $pass       = $_POST['password'];
                                $hashpass  =sha1($pass );
                                $error_form =array();
                                $check = Check_database("Username ","users",$username);
                                
                                if ( $check == 1) {
                                        $error_form[] = " USER NAME ALREDY <strong>EXISTED !!!!</strong>";//div dont work
                                } 
                               
                                
                                if (empty($_POST['username'])) {
                                    $error_form[] = " USER NAME CANNT BE <strong>EMPTY</strong>";//div dont work
                                }
                
                                if (strlen($_POST['username']) < 4) {
                                    $error_form[] = "USER NAME CANNT BE LESS THAN <strong> 4 CHARACTERS </strong>";//div dont work
                                }
                                if (strlen($_POST['username']) > 20) {
                                    $error_form[] = "USER NAME CANNT BE MORE THAN <strong> 20 CHARACTERS </strong>";//div dont work
                                }
                            
                                if (empty($_POST['email'])) {
                                    $error_form[] = "EMAIL CANNT BE <strong>EMPTY</strong>";//div dont work
                                    
                                }
                                if (empty($_POST['password'])) {
                                    $error_form[] = "Password CANNT BE <strong>EMPTY</strong>";//div dont work
                                }
                                if (empty($_POST['full'])) {
                                    $error_form[] = " FULL NAME CANNT BE <strong>EMPTY</strong>";//div dont work
                                }
                                foreach ( $error_form as $error ) {
                                    echo '<div class="alert alert-danger">'.$error.'</div>';
                                }
                                if (empty($error_form)) {
                                    $stmt = $con->prepare("INSERT INTO 
                                                          users(Username,Password,email,FullName)
                                                          VALUES(:zuser,:zpass,:zemail,:zfull)");
                                    $stmt->execute(array(
                                    'zuser'=> $username, 
                                    'zpass'=> $hashpass  , 
                                    'zemail'=> $email , 
                                    'zfull'=> $full 
                                 ));
                                    $Msg ="<div class='alert alert-success'>".$stmt->rowCount() . "records have been added"."</div>";
                                    DirectionHome($Msg,'back');
                                  
                                }
                            
                             
                            }else {
                                $Msg="<div class='alert alert-danger'> SORRY YOU CANOT BROWSE THIS PAGE DIRECTLY </div>";
                                DirectionHome($Msg,'back',100);
                                }
                                echo "</div>";
                                
                                
                                
                               }
                                elseif ($do == 'Edit') {
                                    // start edit page .
                                $user = isset($_GET['user_id']) && is_numeric($_GET['user_id']) ? intval($_GET['user_id']):0;
                                $stmt = $con->prepare("SELECT * FROM users 
                                WHERE UserID = ? Limit 1");
                                $stmt->execute(array($user));
                                $row  = $stmt->fetch();
                                $count = $stmt->rowCount();
                                if ($count>0) {
                                    
                                
                                ?>
                                <h1 class='text-center'>Edit Member</h1>
                                <div class='container'>
                               
                                                    
                                   <form class="form-horizontal" action="?do=Update" method='POST'>               
                                                <!-- strat username feild -->
                                                <div class = "form-group form-group-lg">
                                                        <label class="col-sm-2 control-label">Username</label>
                                                        <div class="col-sm-10">
                                                                <input type = "text" name = "username"  value = "<?PHP echo $row['Username'] ?>"  class="form-control" autocomplete="off" required='required'/>
                                                                <input type = "hidden"  name = "userid" value = "<?PHP echo $user ?>" />
                                                        </div>
                                                </div>
                                                <!-- End username feild -->
                                                <!-- strat Password feild -->
                                                <div class = "form-group form-group-lg">
                                                    <label class="col-sm-2 control-label">Password</label>
                                                    <div class="col-sm-10">
                                                    <input type = "hidden" name = "oldpassword" value = "<?PHP echo $row['Password'] ?>">
                                                    <input type = "password" name = "newpassword"  class="form-control "autocomplete="new-password"/>
                                                    </div>
                                                </div>
                                                <!-- End Password feild -->
                                                <!-- strat Email feild -->
                                                <div class = "form-group form-group-lg">
                                                    <label class=" col-sm-2  control-label">Email</label>
                                                    <div class="col-sm-10">
                                                    <input type = "email" name = "email"  value = "<?PHP echo $row['email'] ?>" class="form-control" required='required'/>
                                                    </div>
                                                </div>
                                                <!-- End Email feild -->
                                                <!-- strat full name feild -->
                                                <div class = "form-group form-group-lg">
                                                    <label class="col-sm-2  control-label">Full NAME</label>
                                                    <div class="col-sm-10" >
                                                    <input type = "text" name = "full" value = "<?PHP echo $row['FullName']?>" class="form-control "required='required'/>
                                                    </div>
                                                </div>
                                                <!-- End full name feild -->
                                                <!-- strat username feild -->
                                                <div class = "form-group form-group-lg">
                                                    <div class="col-sm-offset-2 col-sm-10 ">
                                                    <input type = "submit" name = "save"     class="btn btn-primary btn-lg"/>
                                                    </div>
                                                </div>
                                                <!-- End username feild -->
                                    </form>
                                </div>


                                    
<?php }
            else {
                                $Msg="<div class = 'alert alert-danger'>YOU ARE NOT A MEMBER </div>";
                                DirectionHome($Msg);
                    }
    
      }
            elseif($do == 'Update') {
                echo"<h1 class='text-center'>Update Member</h1>";
                echo "<div class = 'container'>";
                if ($_SERVER['REQUEST_METHOD']=='POST') {
                $username  = $_POST['username'];
                $userid    = $_POST['userid'];
                $email     = $_POST['email'];
                $full      = $_POST['full'];
                $pass      = $_POST['newpassword'] ? sha1($_POST['newpassword']):$_POST['oldpassword'];
                $error_form =array();
                if (empty($_POST['username'])) {
                    $error_form[] = "<div class='alert alert-danger'> USER NAME CANNT BE <strong>EMPTY</strong></div>";//div dont work
                }

                if (strlen($_POST['username']) < 4) {
                    $error_form[] = "<div class='alert alert-danger'>USER NAME CANNT BE LESS THAN 4 CHARACTERS</div>";//div dont work
                }
                if (strlen($_POST['username']) > 20) {
                    $error_form[] = "<div class='alert alert-danger'>USER NAME CANNT BE MORE THAN 20 CHARACTERS</div>";//div dont work
                }
            
                if (empty($_POST['email'])) {
                    $error_form[] = "<div class='alert alert-danger'> EMAIL CANNT BE <strong>EMPTY</strong></div>";//div dont work
                }
                if (empty($_POST['full'])) {
                    $error_form[] = " <div class='alert alert-danger'>FULL NAME CANNT BE <strong>EMPTY</strong></div>";//div dont work
                }
                foreach ( $error_form as $error ) {
                    echo $error;
                }
                if (empty($error_form )) {
                    $stmt = $con->prepare("UPDATE  users  SET
                                    Username = ? ,
                                    Password = ?,
                                    email = ?,
                                    FullName = ? WHERE UserID = ? ");
                
                $stmt->execute(array($username,$pass,$email, $full,$userid ));
                $Msg="<div class='alert alert-success'>YESSSS!!! ".$stmt->rowCount()." records</div>";
                DirectionHome($Msg,'back');
                }
            
                
                }else {
                    $Msg="<div class='alert alert-danger'>YOU CAN NOT COME DIRECTORY</div> ";
                    DirectionHome($Msg,6);
                }
                echo "</div";
                
                
                
            }elseif ($do=='Delete') {
                // echo "helllo from delete";
                $user  = isset($_GET['user_id'])&& is_numeric($_GET['user_id'])?intval(($_GET['user_id'])):0;
                // $stmt  = $con->prepare('SELECT * FROM users WHERE UserID = ? Limit 1');
                // $stmt->execute(array($user ));
                // $stmt->fetch();
                // $count = $stmt->rowCount();
                // if ($stmt->rowCount() > 0) {
                    $stmt  = $con->prepare('DELETE FROM users WHERE UserID = :zuser');
                    $stmt->bindParam('zuser',$user );
                    $stmt->execute();
                    if ($stmt->rowCount() > 0) {
                    echo"<div class='alert alert-success'>".$stmt->rowCount()."member has been deleted</div>";
                     
                    }else {
                      echo"<div class='alert alert-danger'>Therer is no such user with this name!!!</div>";
                            }
                            
            }
    include $tpl . "footer.php";
 }else {
    header('location:index.php');
    exit();
 }