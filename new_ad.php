
<?php
session_start();
$pageTitle = 'Add Item'; 
include 'init.php';
if (isset($_SESSION['user'])) {
   if ($_SERVER['REQUEST_METHOD']=='POST') {
       
       $error_form = [];
       $name=filter_var($_POST['name'],FILTER_SANITIZE_STRING);
       $desc=filter_var($_POST['describe'],FILTER_SANITIZE_STRING);
       $price=filter_var($_POST['price'],FILTER_SANITIZE_NUMBER_INT);
       $country=filter_var($_POST['country'],FILTER_SANITIZE_STRING);
       $status=$_POST['status'];
       $cat=$_POST['category'];
       if (strlen($name)<4) {
        $error_form[]= "SHORT NAME";
       }
       if (strlen($desc)<10) {
        $error_form[]= "SHORT DESCRIPTION";
       }
       if (strlen($country)<3) {
        $error_form[]= "INVALIDE COUNTRY";
       }
       if (empty($price)) {
        $error_form[]="EMPTY PRICE";
       }
       if (empty($status)) {
        $error_form[]="EMPTY STATUS ";
       }
       if (empty($cat)) {
        $error_form[]=" EMPTY GATEGORY";
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
        'zmember' => $_SESSION['id_user']
         ));
         if ($stmt) {
            echo"<div class='alert alert-success'>".$stmt->rowCount() . "item have been added"."</div>";
         }
        
       
      
    }
   }

?>
<h1 class='text-center'>Add Item </h1>
<div class='add-ads '>
    <div class='container'>
        <div class='panel panel-primary'>
            <div class=' panel-heading'><h3>Add Item</h3> </div>
                <div class='panel-body'>
                    <div class='row'>



                                <div class='col-sm-8'>
                                    <form class="form-horizontal form-add" action="<?php echo $_SERVER['PHP_SELF'] ?>" method='POST'>
                                            <div class="form-group form-group-lg">
                                                    <label  class="col-sm-2 control-label">Name</label>
                                                    <div class="col-sm-10">
                                                    <input type = "text" name = "name"  class="form-control name-live" required='required'  placeholder='Name of the Item'/>
                                                    </div>
                                            </div>

                                            <div class="form-group form-group-lg">
                                                    <label  class="col-sm-2 control-label">Description</label>
                                                    <div class="col-sm-10">
                                                    <textarea type = "text" name = "describe"  class=" form-control Description-live " required='required'   placeholder='Describe the item' ></textarea>
                                                    </div>
                                            </div>

                                            <div class="form-group form-group-lg">
                                                    <label  class="col-sm-2 control-label">Price</label>
                                                    <div class="col-sm-10">
                                                    <input type = "text" name = "price"  class="Price-live form-control "  required='required' placeholder='price of the item'/>
                                                    </div>
                                            </div>

                                            <div class="form-group form-group-lg">
                                                    <label  class="col-sm-2 control-label">Country</label>
                                                    <div class="col-sm-10">
                                                    <input type = "text" name = "country"  class=" form-control " required='required'  placeholder='country of orgin'/>
                                                    </div>
                                            </div>


                                            <div class="form-group form-group-lg">
                                                    <label  class="col-sm-2 control-label">Status</label>
                                                    <div class="col-sm-10">
                                                        <select name='status' class=' '>
                                                        <option value="">.....</option>
                                                        <option value="1">New</option>
                                                        <option value="2">Almost New</option>
                                                        <option value="3">Used</option>
                                                        <option value="4">Old</option>
                                                        </select>  
                                                    </div>
                                            </div>


                                            <div class="form-group form-group-lg">
                                                    <label  class="col-sm-2 control-label">Category</label>
                                                    <div class="col-sm-10">
                                                        <select name='category' class=' '>
                                                        <option value="">.....</option>
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
                                                        <input type = "submit"  value='Add Item'  class="btn btn-primary btn-lg"/>
                                                    </div>
                                            </div>
                                
                                        </form>
                                </div>





                                <div class='col-sm-4'>
                                        <div class='thumbnail live-preview'>
                                            <span class='price-tag'>price</span>
                                            <img src='ecom.jpg' height='300' width='400px'>
                                            <div class='caption'>
                                                        <h2>Name</h2>
                                                        <p>Description</p>
                                            </div>
                                        </div>
                                </div>
                    </div>

                    <!-- START ERROR ARRAY-->
                    <?php
                    if (!empty($error_form)) {
                       foreach ($error_form as $error) {
                           echo"<div class='alert alert-danger'>". $error.'</div>';
                       }
                    }
                    ?>
                    <!-- END ERROR ARRAY -->
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