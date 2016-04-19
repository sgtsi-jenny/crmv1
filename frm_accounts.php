<?php
	require_once 'support/config.php';
	if(!isLoggedIn()){
		toLogin();
		die();
	}

    if(!AllowUser(array(1,2))){
        redirect("index.php");
    }
    if(!empty($_GET['id'])){
        $account=$con->myQuery("SELECT id,name,industry,address,email_address,phone,handler_id,account_status_id FROM accounts WHERE id=?",array($_GET['id']))->fetch(PDO::FETCH_ASSOC);
        if(empty($account)){
            //Alert("Invalid asset selected.");
            Modal("Invalid Account Selected");
            redirect("all_clients.php");
            die();
        }
    }

    $account_stat=$con->myQuery("SELECT id,name FROM account_statuses")->fetchAll(PDO::FETCH_ASSOC);
    $user=$con->myQuery("SELECT id, CONCAT(last_name,' ',first_name,' ',middle_name) as name FROM users")->fetchAll(PDO::FETCH_ASSOC);
                    						
	makeHead("Clients");
?>
<div id='wrapper'>
<?php
	 require_once 'template/navbar.php';
?>
</div>
<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Clients Form</h1>
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
                    		<form class='form-horizontal' method='POST' action='save_client.php'>
                                <input type='hidden' name='id' value='<?php echo !empty($account)?$account['id']:""?>'>
                    			
                                <div class='form-group'>
                                    <label class='col-sm-12 col-md-3 control-label'> Client Name*</label>
                                    <div class='col-sm-12 col-md-9'>
                                        <input type='text' class='form-control' name='name' placeholder='Enter Client Name' value='<?php echo !empty($account)?$account['name']:"" ?>'>
                                    </div>
                                </div>

                                <div class='form-group'>
                                    <label class='col-sm-12 col-md-3 control-label'> Industry*</label>
                                    <div class='col-sm-12 col-md-9'>
                                        <input type='text' class='form-control' name='industry' placeholder='Enter Industry' value='<?php echo !empty($account)?$account['industry']:"" ?>'>
                                    </div>
                                </div>

                                <div class='form-group'>
                                    <label class='col-sm-12 col-md-3 control-label'> Address*</label>
                                    <div class='col-sm-12 col-md-9'>
                                        <input type='text' class='form-control' name='address' placeholder='Enter Address' value='<?php echo !empty($account)?$account['address']:"" ?>'>
                                    </div>
                                </div>

                                <div class='form-group'>
                                    <label class='col-sm-12 col-md-3 control-label'> Email Address*</label>
                                    <div class='col-sm-12 col-md-9'>
                                        <input type='text' class='form-control' name='email_address' placeholder='Enter Email Address' value='<?php echo !empty($account)?$account['email_address']:"" ?>'>
                                    </div>
                                </div>

                                <div class='form-group'>
                                    <label class='col-sm-12 col-md-3 control-label'> Phone*</label>
                                    <div class='col-sm-12 col-md-9'>
                                        <input type='text' class='form-control' name='phone' placeholder='Enter phone number' value='<?php echo !empty($account)?$account['phone']:"" ?>'>
                                    </div>
                                </div>

                                <div class='form-group'>
                                    <label class='col-sm-12 col-md-3 control-label'> User*</label>
                                    <div class='col-sm-12 col-md-9'>
                                        
                                        <div class='row'>
                                            <div class='col-sm-11'>
                                             <select class='form-control' name='user' data-placeholder="Select a user" <?php echo!(empty($account))?"data-selected='".$account['handler_id']."'":NULL ?>>
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
                                    <label class='col-sm-12 col-md-3 control-label'> Account Status*</label>
                                    <div class='col-sm-12 col-md-9'>
                                        
                                        <div class='row'>
                                            <div class='col-sm-11'>
                                                <select class='form-control' name='account_stat' data-placeholder="Select account status" <?php echo!(empty($account))?"data-selected='".$account['account_status_id']."'":NULL ?>>
                                            <?php
                                                echo makeOptions($account_stat);
                                            ?>
                                        </select> 
                                            </div>
                                            <div class='col-ms-1'>
                                                <a href='frm_account_stat.php' class='btn btn-sm btn-success'><span class='fa fa-plus'></span></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                

                                <div class='form-group'>
                                    <div class='col-sm-12 col-md-9 col-md-offset-3 '>
                                        <a href='all_clients.php' class='btn btn-default'>Cancel</a>
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