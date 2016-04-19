<?php
	require_once 'support/config.php';
	if(!isLoggedIn()){
		toLogin();
		die();
	}
	makeHead();
?>
<div id='wrapper'>
<?php
	 require_once 'template/navbar.php';
?>
</div>

<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Dashboard</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <?php
                if(AllowUser(array(1,2))):
            ?>
            <div class='row'>
                                <div class='col-md-8'>
                                <div class='panel panel-primary'>
                                <div class='panel-heading text-left'>
                                <div class="row">
                                    <h2 class="col-xs-10">Recent Client Activity</h2>
                                    <span class="fa fa-tasks fa-3x col-md-2" style="padding-top: 10px;"></span>
                                    
                                </div>
                                </div>
                                    <?php
                                    $uid=$_SESSION[WEBAPP]['user']['id'];
                                        $activities=$con->myQuery("SELECT opportunities.opp_name, notes, DATE_FORMAT(action_date, '%M %d %h:%i %p') FROM activities
                                        inner join opportunities on activities.opp_id=opportunities.id
                                        inner join users on activities.user_id=users.id
                                        where opportunities.is_deleted=0
                                        and activities.user_id='$uid'
                                        order by action_date desc
                                       ")->fetchAll(PDO::FETCH_ASSOC);
                                        if(!empty($activities)):

                                    ?>
                                    <div style="padding:10px;">
                                    <table class='table table-bordered table-condensed 'id='dataTables'>
                                        <thead>
                                            <tr>    
                                                <th >Client</th>
                                                <th>Action</th>
                                                <th class='date-td'>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                    foreach ($activities as $activity):
                                                    
                                            ?>
                                                    <tr>
                                                <?php
                                                    foreach ($activity as $key => $value):
                                                    if($key=='id'):
                                                    elseif($key=='opp_name'):
                                                ?>
                                                    <td>
                                                        <a href='opp_details.php?id=<?= $activity['id']?>'><?php echo htmlspecialchars($value)?></a>
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
                                    </div>
                                    <?php
                                        else:
                                            ?>

                                        <?php
                                            createAlert("No Results.");
                                        endif;
                                    ?>
                                </div>
                                </div>
                                
                                
                            
                                <div class='col-md-4'>
                                <div class='panel panel-green'>
                                <div class='panel-heading text-left'>
                                <div class="row">
                                    <h4 class="col-xs-9">Birthdays</h4>
                                    <span class="fa fa-gift fa-3x col-md-3"></span>
                                    
                                </div>
                                </div>
                                <?php
                                    $uid=$_SESSION[WEBAPP]['user']['id'];
                                                $activities=$con->myQuery("SELECT DATE_FORMAT(dob,'%M %d') AS dob, CONCAT(lname, ', ', fname) As uname, organizations.org_name
                                                    FROM contacts 
                                                    inner join organizations on contacts.org_id=organizations.id
                                                    WHERE contacts.is_deleted=0 and 
                                                    week(dob) BETWEEN WEEK( CURDATE() )  AND  WEEK( DATE_ADD(CURDATE(), INTERVAL +21 DAY) ) 
                                                    Order by dob")->fetchAll(PDO::FETCH_ASSOC);
                                        if(!empty($activities)):

                                    ?>
                                    <table class='table table-bordered table-condensed '>
                                        <thead>
                                            <tr>    
                                                <th class='date-td'>Date</th>
                                                <th >Client</th>
                                                <th>Organization</th>
                                                
                                               <!-- <th>Email</th>
                                                <th>Mobile Phone</th> -->   
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                    foreach ($activities as $activity):
                                                    
                                            ?>
                                                    <tr>
                                                <?php
                                                    foreach ($activity as $key => $value):
                                                    if($key=='id'):
                                                    elseif($key=='opp_name'):
                                                ?>
                                                    <td>
                                                        <a href='opp_details.php?id=<?= $activity['id']?>'><?php echo htmlspecialchars($value)?></a>
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
                                            
                                            birthdayAlert("No Results.");
                                        endif;
                                    ?>
                                        </div>
                                        
                                </div>
                                </div>
            </div>
            <?php
                else:
                $asset=$con->myQuery("SELECT CONCAT(first_name,' ',middle_name,' ',last_name) as name,username,email,contact_no,id FROM qry_users WHERE id=?",array($_SESSION[WEBAPP]['user']['id']))->fetch(PDO::FETCH_ASSOC);


            ?>
            <div class='row'>
                        <div class='col-md-9'>          
                            <div class='row'>
                                <div class='col-xs-12'>
                                    <strong>Employee Number: </strong>
                                    <em><?php echo htmlspecialchars($asset['employee_no'])?></em>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-xs-12'>
                                    <strong>Email Address: </strong>
                                    <em><?php echo htmlspecialchars($asset['email'])?></em>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-xs-12'>
                                    <strong>Contact Number: </strong>
                                    <em><?php echo htmlspecialchars($asset['contact_no'])?></em>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-xs-12'>
                                    <strong>Department: </strong>
                                    <em><?php echo htmlspecialchars($asset['department'])?></em>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-xs-12'>
                                    <strong>Location: </strong>
                                    <em><?php echo htmlspecialchars($asset['location'])?></em>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-md-12'>
                                    </br></br>
                                    <!--FOR CONSUMABLES-->
                                    <h4>Consumables</h4>
                                    <table class='table table-bordered table-condensed '>
                                        <thead>
                                            <tr>    
                                                <td>Name</td>
                                                <td>Date</td>
                                                <td>Actions</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $consumables=$con->myQuery("SELECT NAME,action_date,ACTION FROM vw_user WHERE category_type_id=2 AND user_id=?",array($_SESSION[WEBAPP]['user']['id']))->fetchAll(PDO::FETCH_ASSOC);
                                               if(!empty($consumables)):

                                                    foreach ($consumables as $consumable):
                                            ?>
                                                    <tr>
                                                        <td><?php echo $consumable['NAME']?></td>
                                                        <td><?php echo $consumable['action_date']?></td>
                                                        <td><?php echo $consumable['ACTION']?></td>
                                                    </tr>
                                            <?php
                                                    endforeach;
                                                else:
                                            ?>
                                                <tr>
                                                    <td colspan='5'>No Results.</td>
                                                </tr>
                                            <?php
                                                endif;
                                            ?>
                                        </tbody>
                                    </table>


                                    </br>
                                    <!--FOR ASSETS-->
                                    <h4>Assets</h4>
                                    <table class='table table-bordered table-condensed '>
                                        <thead>
                                            <tr>    
                                                <td>Name</td>
                                                <td>Date</td>
                                                <td>Actions</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $consumables=$con->myQuery("SELECT NAME,action_date,ACTION FROM vw_asset WHERE category_type_id=1 AND user_id=?",array($_SESSION[WEBAPP]['user']['id']))->fetchAll(PDO::FETCH_ASSOC);
                                               if(!empty($consumables)):

                                                    foreach ($consumables as $consumable):
                                            ?>
                                                    <tr>
                                                        <td><?php echo $consumable['NAME']?></td>
                                                        <td><?php echo $consumable['action_date']?></td>
                                                        <td><?php echo $consumable['ACTION']?></td>
                                                    </tr>
                                            <?php
                                                    endforeach;
                                                else:
                                            ?>
                                                <tr>
                                                    <td colspan='5'>No Results.</td>
                                                </tr>
                                            <?php
                                                endif;
                                            ?>
                                        </tbody>
                                    </table>


                                </div>
                            </div>
                        </div>
                        <div class='col-md-3'></div>
                    </div>
            <?php
                endif;
            ?>
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