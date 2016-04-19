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
                          <a href="org_contact_persons.php?id=<?php echo $_GET['id'] ?>" class="list-group-item"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Opportunities</a>
                          <span href="" class="list-group-item active">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Contact Persons</span>
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
                                    <h3 >Creating New Contact</h3>
                                    </form>
                                </div>
                                <br/><br/>
                                <hr>
                                <form class='form-horizontal' method='POST' action='save_opp.php'>
                                <input type='hidden' name='id' value='<?php echo !empty($opportunity)?$opportunity['id']:""?>'>

                                <input type='hidden' name='org_id' value='<?php echo $org['id']?>'>
                                
                                <div class='form-group'>
                                    <label class='col-sm-12 col-md-3 control-label'> </label>
                                    <div class='col-sm-12 col-md-7'>
                                        <img src='uploads/<?php echo !empty($account['profile_pic'])?$account['profile_pic']:"Default.jpg"?>' class='img-responsive' width='100px' height='100px'>
                                    </div>
                                </div>

                                <div class='form-group'>
                                    <label class='col-sm-12 col-md-3 control-label'> Photo Upload</label>
                                    <div class='col-sm-12 col-md-7'>
                                        <input type='file' class='form-control' name='file' >
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
                                    <label class='col-sm-12 col-md-3 control-label'> First Name*</label>
                                    <div class='col-sm-12 col-md-7'>
                                        <input type='text' class='form-control' name='fname' placeholder='Enter First Name' value='<?php echo !empty($account)?$account['fname']:"" ?>' required>
                                    </div>
                                </div>

                                <div class='form-group'>
                                    <label class='col-sm-12 col-md-3 control-label'> Last Name*</label>
                                    <div class='col-sm-12 col-md-7'>
                                        <input type='text' class='form-control' name='lname' placeholder='Enter Last Name' value='<?php echo !empty($account)?$account['lname']:"" ?>' required>
                                    </div>
                                </div>

                                <div class='form-group'>
                                    <label class='col-sm-12 col-md-3 control-label'> Department*</label>
                                    <div class='col-sm-12 col-md-7'>
                                        
                                        <select class='form-control' name='department_id' data-placeholder="Select department" <?php echo!(empty($dep))?"data-selected='".$dep['id']."'":NULL ?> required>
                                                    <option value='<?php echo !empty($account)?$account['department_id']:""?>'><?php echo !empty($dept_value)?$dept_value['name']:""?></option>
                                                    <?php
                                                        echo makeOptions($dep);
                                                    ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- <div class='form-group'>
                                    <label class='col-sm-12 col-md-3 control-label'> Customer*</label>
                                    <div class='col-sm-12 col-md-7'>
                                       
                                        <select class='form-control' name='org_id' data-placeholder="Select customer" <?php echo!(empty($org))?"data-selected='".$org['org_id']."'":NULL ?>>
                                                    <option value='<?php echo !empty($account)?$account['org_id']:""?>'><?php echo !empty($dept_value)?$org_value['org_name']:""?></option required>
                                                    <?php
                                                        echo makeOptions($org);
                                                    ?>
                                        </select>
                                    </div>
                                </div> -->

                                <div class='form-group'>
                                    <label class='col-sm-12 col-md-3 control-label'> Home Phone</label>
                                    <div class='col-sm-12 col-md-7'>
                                        <input type='text' class='form-control' name='home_phone' placeholder='Enter Home Phone' value='<?php echo !empty($account)?$account['home_phone']:"" ?>'>
                                    </div>
                                </div>

                                <div class='form-group'>
                                    <label class='col-sm-12 col-md-3 control-label'> Mobile Phone*</label>
                                    <div class='col-sm-12 col-md-7'>
                                        <input type='text' class='form-control' name='mobile_phone' placeholder='Enter Mobile Phone' value='<?php echo !empty($account)?$account['mobile_phone']:"" ?>' required>
                                    </div>
                                </div>

                                <div class='form-group'>
                                    <label class='col-sm-12 col-md-3 control-label'> Office Phone</label>
                                    <div class='col-sm-12 col-md-7'>
                                        <input type='text' class='form-control' name='office_phone' placeholder='Enter Office Phone' value='<?php echo !empty($account)?$account['office_phone']:"" ?>' >
                                    </div>
                                </div>

                                <div class='form-group'>
                                    <label class='col-sm-12 col-md-3 control-label'> Email*</label>
                                    <div class='col-sm-12 col-md-7'>
                                        <input type='text' class='form-control' name='email' placeholder='Enter Email Address' value='<?php echo !empty($account)?$account['email']:"" ?>' required>
                                    </div>
                                </div>

                                <div class='form-group'>
                                    <label class='col-sm-12 col-md-3 control-label'> Date of Birth*</label>
                                    <div class='col-sm-12 col-md-7'>
                                        <?php
                                        $start_date="";
                                         if(!empty($maintenance)){
                                            $start_date=$maintenance['start_date'];
                                            if($start_date=="0000-00-00"){
                                                $start_date="";
                                            }
                                         }
                                        ?>
                                        <input type='date' class='form-control' name='dob'  value='<?php echo !empty($account)?$account['dob']:"" ?>' required>
                                    </div>
                                </div>

                               <div class='form-group'>
                                    <label class='col-sm-12 col-md-3 control-label'> Description</label>
                                    <div class='col-sm-12 col-md-7'>
                                        <textarea class='form-control' name='description' placeholder="Write a short description."><?php echo !empty($account)?$account['description']:"" ?></textarea>
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