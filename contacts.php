<?php
	require_once 'support/config.php';
	if(!isLoggedIn()){
		toLogin();
		die();
	}
	makeHead("Contacts");
?>
<div id='wrapper'>
<?php
	 require_once 'template/navbar.php';
?>
</div>

<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Contacts</h1>
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
                                <a href='frm_contacts.php' class='btn btn-success pull-right'> <span class='fa fa-plus'></span> Create New</a>
                        </div>
                        <br/> <br/> 
                        <div class='panel panel-default'>
                          <div class='panel-body ' >
                            <div class='dataTable_wrapper '>
                                <div class='col-md-12'>
                                    <table class='table table-bordered table-condensed ' id='dataTables'>
                                        <thead>

                                            <tr>  
                                                <th></th>  
                                                <th>Photo</th>
                                                <th>Name</th>
                                                <th>Assigned To</th>
                                                <th>Department</th>
                                                <th>Company</th>
                                                <th>Birth date</th>
                                                <th>Email</th>
                                                <th>Home Phone</th>
                                                <th>Mobile Phone</th>
                                                <th>Office Phone</th>
                                                <th>Description</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $uid=$_SESSION[WEBAPP]['user']['id'];
                                            //if ($_SESSION[WEBAPP]['user']['user_type']==1):
                                            
                                               $accounts=$con->myQuery("SELECT profile_pic, CONCAT(lname, ', ', fname) As contact_name, CONCAT(users.last_name, ', ', users.first_name) As assigned_name, contacts.assigned_to, departments.name, department_id, organizations.org_name, contacts.org_id, dob, contacts.email, home_phone, mobile_phone, office_phone, contacts.description, contacts.id FROM contacts left join users on contacts.assigned_to=users.id inner join departments on departments.id=contacts.department_id inner join organizations on organizations.id=contacts.org_id where contacts.is_deleted=0")->fetchAll(PDO::FETCH_ASSOC); 
                                            
                                            //else:
                                            //    $accounts=$con->myQuery("SELECT profile_pic, CONCAT(lname, ', ', fname) As contact_name, CONCAT(users.last_name, ', ', users.first_name) As assigned_name, contacts.assigned_to, departments.name, department_id, organizations.org_name, contacts.org_id, dob, contacts.email, home_phone, mobile_phone, office_phone, contacts.description, contacts.id FROM contacts inner join users on contacts.assigned_to=users.id inner join departments on departments.id=contacts.department_id inner join organizations on organizations.id=contacts.org_id where contacts.is_deleted=0 and contacts.assigned_to='$uid'")->fetchAll(PDO::FETCH_ASSOC); 
                                            //endif;
                                                        foreach ($accounts as $account):
                                            ?>
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" name="select_account" value="<?php echo $account["contact_id"];?>" />
                                                        </td>
                                                        <?php
                                                            foreach ($account as $key => $value):
                                                            if($key=='profile_pic'):
                                                        ?>
                                                            <td><a href='uploads/<?php echo $account['profile_pic'] ?>'>
                                                                <img src='uploads/<?php echo $account['profile_pic'];?>' class='img-responsive' width='40px' height='40px'></a>
                                                            </td>
                                                            <?php
                                                            elseif($key=='id'):
                                                            
                                                        ?>                   
                                                                                                                                         
                                                            <td>
                                                                <a class='btn btn-sm btn-warning' href='frm_contacts.php?id=<?php echo $value;?>'><span class='fa fa-pencil'></span></a>
                                                                <a class='btn btn-sm btn-danger' href='delete.php?id=<?php echo $value?>&t=co' onclick='return confirm("This contact will be deleted.")'><span class='fa fa-trash'></span></a>
                                                            </td>
                                                        <?php
                                                            elseif($key=='assigned_to'):
                                                            elseif($key=='department_id'):
                                                            elseif($key=='org_id'):
                                                        ?>                   
                                                                                 
                                                           
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
                           </div>
                        </div>

           
            <!-- /.row -->
</div>
<script>
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