<?php
    require_once 'support/config.php';
    if(!isLoggedIn()){
        toLogin();
        die();
    }

    if(!AllowUser(array(1,2))){
        redirect("index.php");
    }

   // var_dump($_SESSION[WEBAPP]['user']['id']
    if(!empty($_GET['id'])){
        $prod=$con->myQuery("SELECT id,opp_id,prod_code,product_name,unit_price,commission_rate,qty_unit,total_price,assigned_to,description FROM products WHERE id=?",array($_GET['id']))->fetch(PDO::FETCH_ASSOC);
        if(empty($prod)){
            //Alert("Invalid asset selected.");
            Modal("Invalid Product Selected");
            redirect("products.php");
            die();
        }
        //var_dump($prod);
        //die;
    }

    $user=$con->myQuery("SELECT id,CONCAT(last_name,' ',first_name,' ',middle_name) as name FROM users")->fetchAll(PDO::FETCH_ASSOC);
                                            
    makeHead("Products");

?>
<div id='wrapper'>
<?php
     require_once 'template/navbar.php';
?>
</div>
<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Product Form</h1>
                </div>

                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class='col-lg-12'>
                    <?php
                        Alert();
                    ?> 

                    <div class='row'>
                        <div class='col-sm-12 col-md-8 col-md-offset-2'>
                            <form class='form-horizontal' method='POST' action='save_prod.php'>
                                <input type='hidden' name='id' value='<?php echo !empty($prod)?$prod['id']:""?>'>
                                
                                <div class='form-group'>
                                    <label class='col-sm-12 col-md-3 control-label'> Product Name *</label>
                                    <div class='col-sm-12 col-md-9'>
                                        <input type='text' class='form-control' name='product_name' placeholder='Enter Product Name' value='<?php echo !empty($prod)?$prod['product_name']:"" ?>'>
                                    </div>
                                </div>

                                <div class='form-group'>
                                    <label class='col-sm-12 col-md-3 control-label'> Product Code</label>
                                    <div class='col-sm-12 col-md-9'>
                                        <input type='text' class='form-control' name='prod_code' placeholder='' value='<?php echo !empty($prod)?$prod['prod_code']:"" ?>'>
                                    </div>
                                </div>

                                <div class='form-group'>
                                    <label class='col-sm-12 col-md-3 control-label' > User *</label>
                                    <div class='col-sm-12 col-md-9'>
                                             <select class='form-control' name='assigned_to' data-placeholder="Select a user" <?php echo!(empty($prod))?"data-selected='".$prod['assigned_to']."'":"data-selected='".$_SESSION[WEBAPP]['user']['id']."'" ?>>
                                                <?php
                                                    echo makeOptions($user);
                                                ?>
                                            </select>
                                    </div>
                                </div>

                                <div class='form-group'>
                                    <label class='col-sm-12 col-md-3 control-label'> Price *</label>
                                    <div class='col-sm-12 col-md-9'>
                                        <input type='text' class='form-control' placeholder='0.00' name='unit_price' value='<?php echo !empty($prod)?$prod['unit_price']:"0" ?>'>
                                    </div>
                                </div>

                                <div class='form-group'>
                                    <label class='col-sm-12 col-md-3 control-label'> Commission Rate</label>
                                    <div class='col-sm-12 col-md-9'>
                                        <input type='text' class='form-control' placeholder='0.00' name='commission_rate' value='<?php echo !empty($prod)?$prod['commission_rate']:"0" ?>'>
                                    </div>
                                </div>

                                <div class='form-group'>
                                    <label class='col-sm-12 col-md-3 control-label'> Quantity</label>
                                    <div class='col-sm-12 col-md-9'>
                                        <input type='text' class='form-control' placeholder='1' name='qty_unit' value='<?php echo !empty($prod)?$prod['qty_unit']:"1" ?>'>
                                    </div>
                                </div>

                                <div class='form-group'>
                                    <label class='col-sm-12 col-md-3 control-label'> Description</label>
                                    <div class='col-sm-12 col-md-9'>
                                        <textarea class='form-control' name='description' value='<?php echo !empty($prod)?$prod['description']:"" ?>'></textarea>
                                    </div>
                                </div>                             
                                

                                <div class='form-group'>
                                    <div class='col-sm-12 col-md-9 col-md-offset-3 '>
                                        <a href='products.php' class='btn btn-default'>Cancel</a>
                                        <button type='submit' class='btn btn-success'> <span class='fa fa-check'></span> Save</button>
                                    </div>
                                    
                                </div>                          
                            </form>
                        </div>
                    </div>

                </div>
            </div>
            <!-- /.row -->
</div>
<?php
Modal();
?>
<?php
    makeFoot();
?>