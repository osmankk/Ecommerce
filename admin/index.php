
<?php 
session_start();
$nonavbar ='';
$pageTitle = 'index';

if(isset($_SESSION['Username'])){
    header('Location:dashboard.php');
}

include 'init.php';


if ($_SERVER['REQUEST_METHOD']=='POST'){
    $username = $_POST['user'];
    $password = $_POST['pass'];
    $hashedpass = sha1($password);
  
    //check if the user is existed
    $stmt = $con->prepare("SELECT UserID,Username ,Password 
                           FROM users 
                           WHERE Username = ? 
                           AND Password = ? 
                           AND GroupID=1
                           Limit 1");
    $stmt->execute(array($username,$hashedpass ));
    $row  = $stmt->fetch();
    $count = $stmt->rowCount();
    if ($count>0) {
        $_SESSION['Username']=$username;
        $_SESSION['ID'] = $row['UserID'];
        header('location:dashboard.php');
        exit();
        
    }

}

?>

<form class='login' action="<?php echo $_SERVER['PHP_SELF'] ?>" method='POST'>
    <h4 class="text-center">Admin Login</h4>
	<input class='form-control input-lg' type='text' name='user' placeholder='Username' autocomplete="off" />
    <input class='form-control input-lg' type="password" name='pass' placeholder='Password' autocomplete="off">
    <input class='btn btn-primary btn-block input-lg' type="submit" value="login" >
</form>
<?php include $tpl . "footer.php"; ?>