<?php
	require_once 'support/config.php';
	if(!isLoggedIn()){
		toLogin();
		die();
	}
    if(empty($_GET['id'])){
        Modal("No Account Selected");
        redirect("all_clients.php");
        die();
    }
    else{
        $org=$con->myQuery("SELECT id,org_name,phone_num,email,industry,address,org_type,rating,annual_revenue,users,description,date_created,date_modified FROM vw_org WHERE id=?",array($_GET['id']))->fetch(PDO::FETCH_ASSOC);
        if(empty($org)){
            Modal("Invalid Opportunities Selected");
            redirect("opportunities.php");
            die;
        }
    }

    $opp_types=$con->myQuery("SELECT id,name FROM opp_types where is_deleted=0")->fetchAll(PDO::FETCH_ASSOC);
    $opp_statuses=$con->myQuery("SELECT id,name FROM opp_statuses where is_deleted=0")->fetchAll(PDO::FETCH_ASSOC);
    $org_name=$con->myQuery("SELECT id,org_name FROM organizations")->fetchAll(PDO::FETCH_ASSOC);
    $prod=$con->myQuery("SELECT id,product_name,unit_price from products")->fetchAll(PDO::FETCH_ASSOC);
    $contact=$con->myQuery("SELECT id,CONCAT(fname,' ',lname) as name from contacts")->fetchAll(PDO::FETCH_ASSOC);
    $user=$con->myQuery("SELECT id,CONCAT(last_name,' ',first_name,' ',middle_name) as name FROM users")->fetchAll(PDO::FETCH_ASSOC);
	makeHead("Customers");
?>
<div id='wrapper'>
<?php
	 require_once 'template/navbar.php';
?>
</div>

<div id="page-wrapper">
            <div class='row'>
                </br>
                <div class='col-md-3'>
                    <!--
                    <?php
                        require_once 'template/account_information.php';
                    ?>
                    -->
                    <div class='row'>
                        <div class="list-group">
                          <a href="organizations.php" class="list-group-item"><span class='fa fa-arrow-left'></span> &nbsp;&nbsp;List of Customers</a>
                          <a href="org_details.php?id=<?php echo $_GET['id'] ?>" class="list-group-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Customer Details</a>
                          <span href="" class="list-group-item active">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Opportunities</span>
                          <a href="org_contact_persons.php?id=<?php echo $_GET['id'] ?>" class="list-group-item"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Contact Persons</a>
                          <!-- <a href="org_roducts.php?id=<?php echo $_GET['id'] ?>" class="list-group-item"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Products</a>
                          <a href="org_documents.php?id=<?php echo $_GET['id'] ?>" class="list-group-item"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Documents</a> -->
                          
                        </div>
                    </div>
                    
                </div>
                
                <div class='col-md-9'>
                    
                    

                    <div class='panel panel-default'>
                        <div class='panel-body'>
                                <div class='col-md-12 text-right'>
                                    <form class="form-inline pull-left">
                                      <!-- <h1>
                                      <img src="uploads/summary_organizations.png" width="50" height="50" title="Organization" alt="Organization" />
                                      <?php echo htmlspecialchars($org['org_name']) ?>
                                      </h1> -->
                                    <h3 >Creating New Opportunity</h3>
                                    </form>
                                </div>
                                <br/><br/>
                                <hr>
                                <form class='form-horizontal' method='POST' action='save_opp.php'>
                                <input type='hidden' name='id' value='<?php echo !empty($opportunity)?$opportunity['id']:""?>'>

                                <input type='hidden' name='org_id' value='<?php echo $org['id']?>'>
                                
                                <div class='form-group'>
                                    <label class='col-sm-12 col-md-3 control-label'> Opportunity Name *</label>
                                    <div class='col-sm-12 col-md-7'>
                                        <input type='text' class='form-control' name='opp_name' placeholder='Enter Opportunity Name' value='<?php echo !empty($opportunity)?$opportunity['opp_name']:"" ?>' required>
                                    </div>
                                </div>

                                <div class='form-group'>
                                    <label class='col-sm-12 col-md-3 control-label'> Contact Name</label>
                                    <div class='col-sm-12 col-md-7'>
                                        
                                        <div class='row'>
                                            <div class='col-sm-11'>
                                                <select class='form-control' name='contact_id' data-placeholder="Select a Contact name" <?php echo!(empty($opportunity))?"data-selected='".$opportunity['contact_id']."'":NULL ?>>
                                                    <?php
                                                        echo makeOptions($contact);
                                                    ?>
                                                </select>
                                            </div>
                                            <div class='col-ms-1'>
                                                <a href='' class='btn btn-sm btn-success'><span class='fa  fa-plus'></span></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class='form-group'>
                                    <label class='col-sm-12 col-md-3 control-label' > User *</label>
                                    <div class='col-sm-12 col-md-7'>
                                        
                                        <div class='row'>
                                            <div class='col-sm-11'>
                                            <select id="disabledSelect" class='form-control' name='assigned_to' data-placeholder="Select a user" <?php echo!(empty($opportunity))?"data-selected='".$opportunity['assigned_to']."'":"data-selected='".$_SESSION[WEBAPP]['user']['id']."'" ?> required>
                                                <?php
                                                    echo makeOptions($user);
                                                ?>
                                            </select>
                                            </div>
                                            <div class='col-ms-1'>
                                            <a href='frm_users.php' class='btn btn-sm btn-success'><span class='fa fa-plus'></span></a>
                                    </div>
                                        </div>
                                    </div>
                                </div>
                                <div class='form-group'>
                                    <label class='col-sm-12 col-md-3 control-label'> Expected Close Date*</label>
                                    <div class='col-sm-12 col-md-7'>
                                        <?php
                                        $expected_close_date="";
                                         if(!empty($opportunity)){
                                            $expected_close_date=$opportunity['expected_close_date'];
                                            if($expected_close_date=="0000-00-00"){
                                                $expected_close_date="";
                                            }
                                         }
                                        ?>
                                        <?php
                                        $purchase_date="";
                                         if(!empty($asset)){
                                            $purchase_date=$asset['purchase_date'];
                                            if($purchase_date=="0000-00-00"){
                                                $purchase_date="";
                                            }
                                         }
                                        ?>
                                        <input type='date' class='form-control' name='expected_close_date' value='<?php echo $expected_close_date; ?>' required>
                                    </div>
                                </div>
                                <div class='form-group'>
                                    <label class='col-sm-12 col-md-3 control-label'> Sales Stage *</label>
                                    <div class='col-sm-12 col-md-7'>
                                        
                                        <div class='row'>
                                            <div class='col-sm-11'>
                                                <select class='form-control' name='sales_stage' data-placeholder="Select Sales Stage" <?php echo!(empty($opportunity))?"data-selected='".$opportunity['sales_stage']."'":NULL ?> required>
                                                    <?php
                                                        echo makeOptions($opp_statuses);
                                                    ?>
                                                </select>
                                            </div>
                                            <div class='col-ms-1'>
                                                <a href='' class='btn btn-sm btn-success'><span class='fa fa-plus'></span></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class='form-group'>
                                    <label class='col-sm-12 col-md-3 control-label'> Type</label>
                                    <div class='col-sm-12 col-md-7'>
                                        
                                        <div class='row'>
                                            <div class='col-sm-11'>
                                                <select class='form-control' name='opp_type' data-placeholder="Select a Opportunity Type" <?php echo!(empty($opportunity))?"data-selected='".$opportunity['opp_type']."'":NULL ?>>
                                                    <?php
                                                        echo makeOptions($opp_types);
                                                    ?>
                                                </select>

                                            </div>
                                            <div class='col-ms-1'>
                                                <a href='' class='btn btn-sm btn-success'><span class='fa  fa-plus'></span></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class='form-group'>
                                    <label class='col-sm-12 col-md-3 control-label'> Forecast Amount</label>
                                    <div class='col-sm-12 col-md-7'>
                                        <input type='text' class='form-control' placeholder='0.00' name='forecast_amount' value='<?php echo !empty($opportunity)?$opportunity['forecast_amount']:"0" ?>'>
                                    </div>
                                </div>

                                <div class='form-group'>
                                    <label class='col-sm-12 col-md-3 control-label'> Description</label>
                                    <div class='col-sm-12 col-md-7'>
                                        <textarea class='form-control' name='description' value='<?php echo !empty($opportunity)?$opportunity['description']:"" ?>'></textarea>
                                    </div>
                                </div>                             
                                

                                <div class='form-group'>
                                    <div class='col-sm-12 col-md-9 col-md-offset-3 '>
                                        <a href='org_opp.php?id=<?php echo $org['id']?>' class='btn btn-default'>Cancel</a>
                                        <button type='submit' class='btn btn-success'> <span class='fa fa-check'></span> Save</button>
                                    </div>
                                    
                                </div>                          
                            </form>

                            <div class='col-md-12'>
                                <br/>
                                <div class="col-sm-12">
                        <div class='col-ms-12 text-right'>
                        <br/>
                        
                    </div><!-- /.col -->   
                            </div>
                            
                            
                            
                        </div>
                    </div>
                    
                </div>
            </div>
            <!-- /.row -->
</div>
<script type="text/javascript">
    function validatePost(post_form){
        console.log();
        var str_error="";
        $.each($(post_form).serializeArray(),function(index,field){
            console.log(field);
            if(field.value==""){
            
                switch(field.name){
                    case "title":
                        str_error+="Please Enter a Title. \n";
                        break;
                    case "message":
                        str_error+="Please Enter a Message. \n";
                        break;
                }
                
            }

        });
        if(str_error!=""){
            alert("You have the following errors: \n" + str_error );
            return false;
        }
        else{
            return true
        }
    }

    $(document).ready(function() {
        $('#dataTables').DataTable({
                 "scrollY": true,
                "scrollX": true
        });
    });
    
</script>
<?php
	makeFoot();
?>