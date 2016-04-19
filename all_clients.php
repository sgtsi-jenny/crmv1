<?php
	require_once 'support/config.php';
	if(!isLoggedIn()){
		toLogin();
		die();
	}
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
                    <h1 class="page-header">Opportunities</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

            <?php
                if(AllowUser(array(1,2))):
            ?>
            <?php
            Alert();
            ?>

            <div class='row'>
                        <div class='col-sm-12'>
                                <a href='frm_accounts.php' class='btn btn-success pull-right'> <span class='fa fa-plus'></span> Create New</a>
                        </div>
                        <br/> <br/> 
                                <div class='col-md-12'>
                                    <table class='table table-bordered table-condensed '>
                                        <thead>

                                            <tr>  
                                                <th></th>  
                                                <th>Name</th>
                                                <th>Industry</th>
                                                <th>Email Address</th>
                                                <th>Phone number</th>
                                                <th>User</th>
                                                <th>Account Status</th>
                                                <th>Date Modified</th>
                                                <th>Date Created</th>
                                                <th>Feed Status</th>
                                                <th>Actions</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $accounts=$con->myQuery("SELECT account_name,industry,email_address,phone,account_handler,account_status,date_modified,date_created,id FROM qry_accounts where is_deleted=0")->fetchAll(PDO::FETCH_ASSOC);
                                                //$account2=$con->myQuery("SELECT id,name,industry,address,email_address,phone,handler_id,account_status_id from accounts where is_deleted=0")->fetchAll(PDO::FETCH_ASSOC);

                                                        foreach ($accounts as $account):
                                            ?>
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" name="select_account" value="<?php echo $account["id"];?>" />
                                                        </td>
                                                        <?php
                                                            foreach ($account as $key => $value):
                                                            if($key=='account_name'):
                                                        ?>
                                                            <td>
                                                                <a href='posts.php?id=<?= $account['id']?>'><?php echo htmlspecialchars($value)?></a>
                                                            </td>
                                                        <?php
                                                            elseif($key=='account_handler'):
                                                        ?>
                                                            <td>
                                                                <a href='view_user.php?id=<?= $accounts['handler_id']?>'><?php echo htmlspecialchars($value)?></a>
                                                            </td> 
                                                        
                                                        <?php
                                                            elseif($key=='id'):
                                                        ?>                   
                                                            <td>
                                                                <span class='badge'>12</span>
                                                                <span class='badge'>5</span>
                                                                <span class='badge'>2</span>
                                                            </td>                                                                               
                                                            <td>
                                                                <a class='btn btn-sm btn-warning' href='frm_accounts.php?id=<?php echo $value;?>'><span class='fa fa-pencil'></span></a>
                                                                <a class='btn btn-sm btn-danger' href='delete.php?id=<?php echo $value?>&t=a' onclick='return confirm("This account will be deleted.")'><span class='fa fa-trash'></span></a>
                                                            </td>
                                                        <?php
                                                            else:
                                                        ?>

                                                            <td>
                                                                <?php
                                                                    echo htmlspecialchars($value);
                                                                ?>
                                                            </td>

                                                        <?php
                                                            endif;
                                                            endforeach;
                                                        ?>
                                                    </tr>
                                            <?php
                                            endforeach;
                                            ?>
                                            
                                        </tbody>
                                    </table>
                                    <?php
                                        else:

                                            createAlert("No Results.");
                                        endif;
                                    ?>
                                </div>
                            </div>

           
            <!-- /.row -->
</div>
<?php
	makeFoot();
?>