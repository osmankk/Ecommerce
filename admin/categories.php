<?php
ob_start();
session_start();
$pageTitle='Categories';
if (isset($_SESSION['Username'])) { 
    include 'init.php';
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
    if ($do == 'Manage') {
        $array_sort =array('ASC','DESC');
        $sort = isset($_GET['sort'])&& in_array($_GET['sort'],$array_sort)?$_GET['sort']:'ASC';
        

        $stmt = $con->prepare("SELECT * FROM  categories ORDER BY 	Ordering $sort ");
        $stmt->execute();
        $cats = $stmt->fetchAll();
        ?>
        <h1 class="text-center">Manage Categories </h1>
        <div class="container categories" >
            <div class="panel panel-default">
                    <div class="panel-heading"><i class="glyphicon glyphicon-edit"></i>
                                <div class='sort pull-right'><i class="glyphicon glyphicon-sort"></i>
                                   <b><u>Ordering</u>:</b>[
                                    <a class="<?php if ($sort=="ASC") {
                                        echo "active";
                                    } ?>" href="?sort=ASC">Asc</a>
                                    <a class="<?php  if ($sort=="DESC") {
                                        echo "active";
                                    } ?>" href="?sort=DESC">Desc</a>]
                                   <i class="glyphicon glyphicon-resize-vertical"></i>
                                   <b><u>View</u>:</b>[
                                    <span class='active full' >Full</span>
                                    <span>Classic</span>]
                                </div>
                    Manage Categories</div>
                    <div class="panel-body">
                            <?php
                            foreach ($cats as $cat) {
                                echo "<div class='cat'>";
                                        echo "<div class='button-hidden'>";
                                        echo'<a href="categories.php?do=Edit&cat_id='.$cat['ID'].'" class="btn btn-success"><i class="glyphicon glyphicon-edit"></i>Edit</a>';
                                        echo'<a href="categories.php?do=Delete&cat_id='.$cat['ID'].'" class="comfirm btn btn-danger"><i class="glyphicon glyphicon-remove"></i>Delete</a>';
                                                            
                                        echo "</div>";
                                    echo "<h3>".$cat['Name']."</h3>";
                                    echo "<div class='full-view'>";
                                    echo "<p class='Description'>";if ($cat['Description']=="") {echo "this category is empty";}
                                    else { echo $cat['Description'];} 
                                    echo "</p>";
                                    if ($cat['visibility']==1)    { echo "<span class='visibility'><i class='glyphicon glyphicon-eye-close'></i> Hidden</span>";}
                                    if ($cat['Allow_comment']==1) {echo "<span class='Allow_comment'><i class='glyphicon glyphicon-remove'></i>Disable</span>";}
                                    if ($cat['Allow_Ads']==1)            {echo "<span class='Advertisment'><i class='glyphicon glyphicon-remove'></i>No Ads</span>";}
                                     echo "</div>";
                                echo "</div>";
                                echo "<hr>";

                            }
                            ?>
                    </div>
            </div>
        
        <a href="?do=Add" class="btn btn-info"><i class="glyphicon glyphicon-plus"></i>Add Category</a>
        </div>
        <?php }elseif ($do == 'Add') { ?>
            <h1 class='text-center'>Add New Category</h1>
            <div class="container" >
                <form class="form-horizontal" action="?do=Insert" method='POST'>
                    <div class="form-group form-group-lg">
                        <label  class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10">
                        <input type = "text" name = "name"  class="form-control" autocomplete="off" required='required' placeholder='Name of the category'/>

                        </div>
                    </div>
            <div class="form-group form-group-lg">
                <label  class="col-sm-2 control-label">Description</label>
                <div class="col-sm-10">
                <input type = "text" name = "describe"  class=" form-control " placeholder='Describe the category'/>
            
            </div>
            </div>
                <div class="form-group form-group-lg">
                <label  class="col-sm-2 control-label">Ordering</label>
                <div class="col-sm-10">
                <input type = "text" name = "Order"  class="form-control"  placeholder='number to arrange the categories'/>
                </div>
            </div>
            <div class="form-group form-group-lg">
                <label  class="col-sm-2 control-label">Visibility</label>
                <div class="col-sm-10">
                        <div>
                            <input type='radio' id='vis-yes' name='visible' value='0' checked/>
                            <label for='vis-yes' >Yes</label>
                        </div>
                        <div>
                            <input type='radio' id="vis-no" name='visible' value='1'/>
                            <label for='vis-no'>NO</label>
                    
                        </div>
                </div>
            </div>

            <div class="form-group form-group-lg">
                <label  class="col-sm-2 control-label">Allow Commenting</label>
                    <div class="col-sm-10">
                        <div>
                            <input id='com-yes' type='radio' value='0' name='comment' checked />
                            <label for='com-yes'>Yes</label>
                        </div>
                        <div>
                            <input id='com-no' type='radio' value='1' name='comment' />
                            <label for='com-no'>No</label>
                        </div>
                    </div>    
    
            </div>

            <div class="form-group form-group-lg">
                <label  class="col-sm-2 control-label">Allow ads</label>
                    <div class="col-sm-10">
                            <div>
                                <input id='ads-yes' type='radio' value='0' name='ads' checked />
                                <label for='ads-yes'>Yes</label>
                            </div>
                            <div>
                                <input id='ads-no' type='radio' value='1' name='ads' />
                                <label for='ads-no'>No</label>
                            </div>
                     </div>
    
            </div>


         
                    <div class = "form-group form-group-lg">
                                    <div class="col-sm-offset-2 col-sm-10">
                                    <input type = "submit"  value=' Save' name = "Insert" class="btn btn-primary btn-lg"/>
                    </div>
                </div>
            
        </form>
    <div>
            <?php }
                elseif($do == 'Insert') {
                    if ($_SERVER['REQUEST_METHOD']=='POST') {
                            echo"<h1 class='text-center'>Insert Category</h1>";
                            echo "<div class = 'container'>";
                            $Nam     = $_POST['name'];
                            $desc     = $_POST['describe'];
                            $Orders    = $_POST['Order'];
                            $visib    = $_POST['visible'];
                            $comment  = $_POST['comment'];
                            $ads      = $_POST['ads'];
                            $check = Check_database("Name","categories",$Nam );
                            if ($check == 0) {
                                $stmt = $con->prepare("INSERT INTO 
                                categories(Name, Description,Ordering,visibility,Allow_comment,Allow_Ads )
                                VALUES     (:zname, :Desc, :order, :visib, :comment,  :ads)");
                                $stmt->execute(array(
                                'zname'  => $Nam,
                                'Desc'   => $desc,
                                'order'  => $Orders,
                                'visib'  => $visib,
                                'comment'=>$comment,
                                'ads'    => $ads 
                                ));
                                $Msg ="<div class='alert alert-success'>".$stmt->rowCount() . "categories have been added"."</div>";
                                DirectionHome($Msg,'back');
                            }else {
                                $Msg="<div class='alert alert-danger'> YOUR NAME IS EXISTED !!! </div>";
                                DirectionHome($Msg,'back',100);  
                            }
                                
                    }else {
                                $Msg="<div class='alert alert-danger'> SORRY YOU CANOT BROWSE THIS PAGE DIRECTLY </div>";
                                DirectionHome($Msg,'back',100);
                        }
                            
                }

            elseif ($do == 'Edit') {
                // start category page .
                $cat = isset($_GET['cat_id']) && is_numeric($_GET['cat_id']) ? intval($_GET['cat_id']):0;
                $stmt = $con->prepare("SELECT * FROM categories
                WHERE 	ID = ? ");
                $stmt->execute(array($cat));
                $row  = $stmt->fetch();
                $count = $stmt->rowCount();
                if ($count>0) {
                ?>
                <h1 class='text-center'>Edit Category</h1>
                <div class="container" >
                <form class="form-horizontal" action="?do=Update" method='POST'>
                <div class="form-group form-group-lg">
                    <label  class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10">
                    <input type = "text" name = "name"  class="form-control"  required='required' placeholder='Name of the category' value = "<?PHP echo $row['Name'] ?>"/>
                    <input type = "hidden"  name = "usercat" value = "<?PHP echo $cat ?>" />
                    </div>
                </div>
                <div class="form-group form-group-lg">
                    <label  class="col-sm-2 control-label">Description</label>
                    <div class="col-sm-10">
                    <input type = "text" name = "describe"  class=" form-control " placeholder='Describe the category' value = "<?PHP echo $row['Description'] ?>"/>
                
                </div>
                </div>
                    <div class="form-group form-group-lg">
                    <label  class="col-sm-2 control-label">Ordering</label>
                    <div class="col-sm-10">
                    <input type = "text" name = "Order"  class="form-control"  placeholder='number to arrange the categories' value = "<?PHP echo $row['Ordering'] ?>"/>
                    </div>
                </div>
                <div class="form-group form-group-lg">
                <label  class="col-sm-2 control-label">Visibility</label>
                <div class="col-sm-10">
                        <div>
                            <input type='radio' id='vis-yes' name='visible' value='0' <?php if($row['visibility']==0){echo "checked";}?> />
                            <label for='vis-yes' >Yes</label>
                        </div>
                        <div>
                            <input type='radio' id="vis-no" name='visible' value='1'  <?php if($row['visibility']==1){echo "checked";}?> />
                            <label for='vis-no'>NO</label>
                    
                        </div>
                </div>
              </div>

              <div class="form-group form-group-lg">
                <label  class="col-sm-2 control-label">Allow Commenting</label>
                    <div class="col-sm-10">
                        <div>
                            <input id='com-yes' type='radio' value='0' name='comment' <?php if($row['Allow_comment']==0){echo "checked";}?>/>
                            <label for='com-yes'>Yes</label>
                        </div>
                        <div>
                            <input id='com-no' type='radio' value='1' name='comment' <?php if($row['Allow_comment']==1){echo "checked";}?>/>
                            <label for='com-no'>No</label>
                        </div>
                    </div>    
        
                </div>

                <div class="form-group form-group-lg">
                    <label  class="col-sm-2 control-label">Allow ads</label>
                        <div class="col-sm-10">
                            <div>
                                <input id='ads-yes' type='radio' value='0' name='ads' <?php if($row['Allow_Ads']==0){echo "checked";}?> />
                                <label for='ads-yes'>Yes</label>
                            </div>
                            <div>
                                <input id='ads-no' type='radio' value='1' name='ads' <?php if($row['Allow_Ads']==1){echo "checked";}?>/>
                                <label for='ads-no'>No</label>
                            </div>
                     </div>
    
                    </div>

                    <div class = "form-group form-group-lg">
                    <div class="col-sm-offset-2 col-sm-10 ">
                    <input type = "submit" name = "save"  value='Save'   class="btn btn-primary btn-lg"/>
                    </div>
                    </div>
                    <?php 
                        }else {
                                        $Msg="<div class = 'alert alert-danger'>YOU ARE NOT A MEMBER </div>";
                                        DirectionHome($Msg);
                            }

            }  







            elseif($do == 'Update') {
                echo"<h1 class='text-center'>Update Category</h1>";
                echo "<div class = 'container'>";
                if ($_SERVER['REQUEST_METHOD']=='POST') {
                $catid     = $_POST['usercat'];
                $name      = $_POST['name'];
                $desc      = $_POST['describe'];
                $ordering  = $_POST['Order'];
                $visible   = $_POST['visible'];
                $comment   = $_POST['comment'];
                $ads       = $_POST['ads'];

                $stmt = $con->prepare("UPDATE  categories SET
                                    Name = ? ,
                                    Description = ?,
                                    Ordering = ?,
                                    visibility=?,
                                    Allow_comment=?,
                                    Allow_Ads = ?
                                    WHERE ID=?");
                
                $stmt->execute(array($name,$desc,$ordering, $visible,$comment,$ads,$catid ));
                $Msg="<div class='alert alert-success'>YESSSS!!! ".$stmt->rowCount()." category have been updated</div>";
                            DirectionHome($Msg,'back');
                }else {
                    $Msg="<div class='alert alert-danger'>YOU CAN NOT COME DIRECTORY</div> ";
                    DirectionHome($Msg,6);
                }
                echo "</div";

                 }
          


                elseif ($do=='Delete') {
                
                    $cat  = isset($_GET['cat_id'])&& is_numeric($_GET['cat_id'])?intval(($_GET['cat_id'])):0;

                        $stmt  = $con->prepare('DELETE FROM categories WHERE ID = :zuser');
                        $stmt->bindParam('zuser',$cat );
                        $stmt->execute();
                        if ($stmt->rowCount() > 0) {
                        $Msg="<div class='alert alert-success'>".$stmt->rowCount()."category has been deleted</div>";
                        DirectionHome($Msg,'back',);
                        
                        }else {
                            $Msg="<div class='alert alert-danger'>Therer is no such user with this category and  'ID'   !!!</div>";
                            DirectionHome($Msg,'back',);
                                }
                                
                }
                            






























           else {
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