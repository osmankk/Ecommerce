<?php
ob_start();
session_start();
$pageTitle = 'Login';
include "init.php";
if(isset($_SESSION['user'])){
    header('Location:index.php');
}
// user come during a form 
if ($_SERVER['REQUEST_METHOD']=='POST'){
    

    if (isset($_POST['login'])) {
  

            $user = $_POST['username'];
            $pass = $_POST['password'];
            $shapass = sha1($pass);

        //check if the user is existed
        $stmt = $con->prepare("SELECT 	UserID, Username ,Password 
                        FROM users 
                        WHERE Username = ? 
                        AND Password = ? 
                        ");
        $stmt->execute(array($user, $shapass));
        $row=$stmt->fetch();
        $count = $stmt->rowCount();
            if ($count>0) {
                $_SESSION['user']=$user;
                $_SESSION['id_user']=$row['UserID'];
                print_r($_SESSION['user']);
                header('location:index.php');
                exit();
            
        }
    }else {
     
            $error_form=array();
            $member='';
            if (isset($_POST['username'])) {
                $sant_var =  filter_var($_POST['username'], FILTER_SANITIZE_STRING);

                if (strlen($sant_var)<4) {
                    $error_form[]= "Short Username ";
                }
                if (strlen($sant_var)>20) {
                    $error_form[]= "Long Username ";
                }
                
            }
            if (isset($_POST['password']) && isset($_POST['repassword'])) {
                if (empty($_POST['password'])) {
                    $error_form[]= "Empty password";
                }
                $pass1=sha1($_POST['password']);
                $pass2=sha1($_POST['repassword']);
                if ($pass1 !== $pass2) {
                    $error_form[] = "password does't match";
                }
            }

            if (isset($_POST['email'])) {
                $sant_var_email =  filter_var($_POST['username'], FILTER_SANITIZE_STRING);
                if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) != true) {
                    $error_form[] = "Invalid Email";
                }
            }
            $check = Check_database("Username ","users",$_POST['username']);
                                
            if ( $check == 1) {
                $error_form[] = " USER NAME ALREDY <strong>EXISTED !!!!</strong>";  
                
            } 

            if (empty($error_form)) {
                $stmt = $con->prepare("INSERT INTO 
                                      users(Username,Password,email,RegStatus,Date)
                                      VALUES(:zuser,:zpass,:zemail,0,now())");
                $stmt->execute(array(
                'zuser'=> $_POST['username'], 
                'zpass'=> $pass1, 
                'zemail'=> $_POST['email']
             ));
               
              
              
            }
            $member= "<div class='alert alert-success'>Regist successed</div>";

    }


}
?>
           
            <div class="container login" >
                <!-- start login form -->
            <h1 class='log text-center'>Login</h1>
            
                <form class="log-in" action="<?php echo $_SERVER['PHP_SELF'] ?> " method='post'>
                        <div class ='con-input'>
                        <input class="form-control" type = "text"     name = "username"   required='required' placeholder='Username' autocomplete='off' />
                         </div>
                         <div class ='con-input'>
                        <input class="form-control" type = "password" name = "password"   required='required' autocomplete='new-password' placeholder='Password'/>
                        </div>
                        
                        <input   type = "submit"  name='login'   value='Login'  class="btn btn-primary btn-lg btn-block"/>
                 </form>
</br>
</br>
 <!-- end login form -->
  <!-- start sign form -->
 
                 <h1 class=' text-center'>Signin</h1>
                 <form class="sign-in" action="<?php echo $_SERVER['PHP_SELF'] ?> " method='post' >
                        <div class ='con-input' >
                        <input minlenght="4" class="form-control" type = "text"     name = "username"   required='required' autocomplete='off'placeholder=' Username' />
                        </div>
                        <div class ='con-input'>
                        <input minlenght="4" class="form-control" type = "email"     name = "email"    required='required'  autocomplete='off' placeholder='Email' />
                        </div>
                        <div class ='con-input'>
                        <input minlenght="4" class="form-control" type = "password" name = "password"    required='required'  autocomplete='new-password' placeholder='Password'/>
                        </div>
                        <div class ='con-input'>
                        <input minlenght="4" class="form-control" type = "password" name = "repassword"    required='required'  placeholder='Re-Type Password'/>
                        </div>
                        <input  type = "submit"     name='sign'     class="btn btn-success btn-lg btn-block"/>
                 </form>



                    <div class=' text-center error'>
                    <?php 
                   
                    if (!empty($error_form)) {
                        foreach ($error_form as $error) {
                           echo "<div class='msg'>". $error."</div>";
                        }
                    }
                    if (isset($member)) {
                        echo $member;
                    }
                    ?>
                    </div>
                    
        
        
        
        </div>

<?php
include $tpl. "footer.php";
ob_end_flush();
?>