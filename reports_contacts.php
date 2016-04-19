<?php
	require_once 'support/config.php';
	if(!isLoggedIn()){
		toLogin();
		die();
	}
	makeHead("Contacts Report");
?>
<div id='wrapper'>
<?php
	 require_once 'template/navbar.php';
?>
</div>

<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Contacts Report</h1>
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
                        <div class='col-sm-12 hidden'>
                                <a href='frm_quotes.php' class='btn btn-success pull-right'> <span class='fa fa-plus'></span> Create New</a>
                        </div>
                        <br/> <br/> 
                        <div class='panel panel-default'>
                          <div class='panel-body ' >
                            <div class='dataTable_wrapper '>
                                <div class='col-md-12'>
                                    <table class='table table-bordered table-condensed ' id='dataTables'>
                                        <thead>

                                            <tr>  
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
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $accounts=$con->myQuery("SELECT CONCAT(lname, ', ', fname) As contact_name, CONCAT(users.last_name, ', ', users.first_name) As assigned_name, contacts.assigned_to, departments.name, department_id, organizations.org_name, contacts.org_id, dob, contacts.email, home_phone, mobile_phone, office_phone, contacts.description, contacts.id FROM contacts left join users on contacts.assigned_to=users.id inner join departments on departments.id=contacts.department_id inner join organizations on organizations.id=contacts.org_id where contacts.is_deleted=0")->fetchAll(PDO::FETCH_ASSOC);
                                                //$account2=$con->myQuery("SELECT id,name,industry,address,email_address,phone,handler_id,account_status_id from accounts where is_deleted=0")->fetchAll(PDO::FETCH_ASSOC);

                                                        foreach ($accounts as $account):
                                            ?>
                                                    <tr>
                                                        
                                                        <?php
                                                            foreach ($account as $key => $value):
                                                            if($key=='id'):
                                                        ?>                   
                                                                                                                                         
                                                            
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
                "scrollX": true,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend:"csv",
                        text:"<span class='fa fa-download'></span> Download CSV "
                    }
                    ]
        });
    });
    </script>
<?php
	makeFoot();
?>