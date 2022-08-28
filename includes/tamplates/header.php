
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php getTitle() ?></title>


    <link rel="stylesheet" href="layout/css/bootstrap.min.css">
    <link rel="stylesheet" href="layout/css/font-awesome.min.css">
	<link rel="stylesheet" href="layout/css/jquery-ui.css">
	<link rel="stylesheet" href="layout/css/jquery.selectBoxIt.css">
	<link rel="stylesheet" href="layout/css/frontend.css">
	
</head>
<body>
	<div class='upper-bar'>
    <div class='container'>
    <a href='login.php'>
        <?php
        if (isset($_SESSION['user'])) {?>
         
          <div class="my-info">
          <img src='user.png'  class='img-responsive img-thumbnail img-circle header-img '>
                  <ul class="nav navbar-nav navbar-right">
                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle btn btn-light" data-toggle="dropdown" role="button" aria-haspopup="false" aria-expanded="false"> <?php echo $_SESSION['user'] ?><span class="caret"></span></a>
                    <ul class="dropdown-menu">
                    <li><a href='profile.php'>My profile</a></li>
                      <li><a href='new_ad.php'>New item</a></li>
                      <li><a href='profile.php#my-ads'>My item</a></li>
                      <li><a href='logout.php'>Logout</a></li>
                    </ul>
                  </li>
                </ul>
                
          </div> 
             <?php
            //   if (User_status($_SESSION['user'])==1) { // user is not active
            //     // echo"You aren't Active";
            // }else {
            //   // echo"Member Active";
            // }
        }else {
         
         
       
        ?>
        <span class='pull-right'>
        Login/Signup
        <?php } ?>
      </span>
    </a>
    </div>
  </div>
<nav class="navbar navbar-inverse">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">HOME PAGE</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="app-nav">
      <ul class="nav navbar-nav navbar-right">
        <?php  
        foreach (GetCats() as $cat) {
          echo"<li ><a href='categories.php?catpage=".$cat['ID']."&catName=".$cat['Name']."'>".$cat['Name']."</a></li>";
      } 
        ?>
       </ul>
      
    </div>
  </div>
</nav>

	