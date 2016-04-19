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
        <!--
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-barcode fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $con->myQuery("SELECT COUNT(id) FROM assets WHERE is_deleted=0")->fetchColumn();?></div>
                                    <div>Total Assets</div>
                                </div>
                            </div>
                        </div>
                        <a href="assets.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-barcode fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $con->myQuery("SELECT COUNT(id) FROM qry_assets WHERE is_deleted=0 AND asset_status_label='Deployable' AND qry_assets.user_id=0")->fetchColumn();?></div>
                                    <div>Assets Available</div>
                                </div>
                            </div>
                        </div>
                        <a href="assets.php?status=Deployable">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-tint fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $con->myQuery("SELECT COUNT(id) FROM consumables WHERE is_deleted=0")->fetchColumn() ?></div>
                                    <div>Consumables</div>
                                </div>
                            </div>
                        </div>
                        <a href="consumables.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-globe fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $con->myQuery("SELECT COUNT(id) FROM locations WHERE is_deleted=0")->fetchColumn()?></div>
                                    <div>Locations</div>
                                </div>
                            </div>
                        </div>
                        <a href="locations.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        -->
            <div class='row'>
                                <div class='col-md-12'>
                                    <h4>Recent Client Activity <small></small></h4>
                                    <?php
                                    $uid=$_SESSION[WEBAPP]['user']['id'];
                                        $activities=$con->myQuery("SELECT opp_name, opp_statuses.name, date_modified, opportunities.id from opportunities
                                        inner join opp_statuses on opportunities.sales_stage=opp_statuses.id
                                        where opportunities.is_deleted=0 and opportunities.assigned_to='$uid'")->fetchAll(PDO::FETCH_ASSOC);
                                        if(!empty($activities)):

                                    ?>
                                    <table class='table table-bordered table-condensed '>
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
                                    <?php
                                        else:

                                            createAlert("No Results.");
                                        endif;
                                    ?>
                                </div>
                            </div>

                            <div class='row'>
                                <div class='col-md-12'>
                                    <h4>Birthdays<small></small></h4>
                                    <?php
                                    $uid=$_SESSION[WEBAPP]['user']['id'];
                                            $activities=$con->myQuery("SELECT CONCAT(lname, ', ', fname) As uname, organizations.org_name, DATE_FORMAT(dob,'%M %d') AS dob, contacts.email, contacts.mobile_phone FROM contacts 
                                            inner join organizations on contacts.org_id=organizations.id 
                                            WHERE contacts.is_deleted=0 and MONTH(dob) = MONTH(NOW()) Order by dob")->fetchAll(PDO::FETCH_ASSOC);
                                        if(!empty($activities)):

                                    ?>
                                    <table class='table table-bordered table-condensed '>
                                        <thead>
                                            <tr>    
                                                <th >Client</th>
                                                <th>Action</th>
                                                <th class='date-td'>Date</th>
                                                <th>Email</th>
                                                <th>Mobile Phone</th>
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

                                            createAlert("No Results.");
                                        endif;
                                    ?>
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
<?php
	makeFoot();
?>