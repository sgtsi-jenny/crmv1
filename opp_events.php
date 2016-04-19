<?php
	require_once 'support/config.php';
	if(!isLoggedIn()){
		toLogin();
		die();
	}
    //$prods=$con->myQuery("SELECT id,prod_name FROM opp_products WHERE is_deleted=0 AND id=? LIMIT 1",array($_GET['opp_id']))->fetch(PDO::FETCH_ASSOC);

    if(empty($_GET['id'])){
        Modal("No Account Selected");
        redirect("opportunities.php");
        die();
    }
    else{
        $opp=$con->myQuery("SELECT id,opp_id,opp_name,prod_code,product_name,unit_price,commission_rate,qty_unit,total_price,users,description FROM vw_prod WHERE id=?",array($_GET['id']))->fetch(PDO::FETCH_ASSOC);
        if(empty($opp)){
            Modal("Invalid Opportunities Selected");
            redirect("opportunities.php");
            die;
        }
    }

    $data=$con->myQuery("SELECT ev.event_stat,ev.activity_type,ev.subjects,ev.start_date,ev.opp_name,ev.id FROM vw_calendar ev INNER JOIN opportunities ON ev.opp_id=opportunities.id INNER JOIN users ON ev.assigned_to=users.id WHERE ev.is_deleted=0 AND ev.opp_id=? AND ev.assigned_to=?",array($opp['id'],$_SESSION[WEBAPP]['user']['id']))->fetchAll(PDO::FETCH_ASSOC);

    if(!empty($_GET['event_id'])){
        $eve=$con->myQuery("SELECT ev.stat_id,ev.event_stat,ev.atype_id,ev.activity_type,ev.subjects,DATE(ev.start_date) AS start_date,TIME(ev.start_date) AS start_time,DATE(ev.end_date) AS end_date,TIME(ev.start_date) AS end_time,ev.opp_name,ev.assigned_to,ev.id FROM vw_calendar ev INNER JOIN opportunities ON ev.opp_id=opportunities.id INNER JOIN users ON ev.assigned_to=users.id WHERE ev.is_deleted=0 AND ev.id=? LIMIT 1",array($_GET['event_id']))->fetch(PDO::FETCH_ASSOC);
        if(empty($eve)){
            Modal("Invalid event selected");
            redirect("opp_events.php?id={$_GET['opp_id']}");
            die;
        }

    }

    if(!empty($_GET['to_do_id'])){
        $to_do=$con->myQuery("SELECT ev.stat_id,ev.event_stat,ev.atype_id,ev.activity_type,ev.subjects,ev.due_date,DATE(ev.start_date) AS start_date,TIME(ev.start_date) AS start_time,DATE(ev.end_date) AS end_date,TIME(ev.start_date) AS end_time,ev.opp_name,ev.assigned_to,ev.id FROM vw_calendar ev INNER JOIN opportunities ON ev.opp_id=opportunities.id INNER JOIN users ON ev.assigned_to=users.id WHERE ev.is_deleted=0 AND ev.id=? LIMIT 1",array($_GET['to_do_id']))->fetch(PDO::FETCH_ASSOC);
        if(empty($to_do)){
            Modal("Invalid event selected");
            redirect("opp_events.php?id={$_GET['opp_id']}");
            die;
        }

    }

    $event_stat=$con->myQuery("SELECT id,name FROM event_status where type=2 or type=3")->fetchAll(PDO::FETCH_ASSOC);
    $to_do_stat=$con->myQuery("SELECT id,name FROM event_status where type=1 or type=3")->fetchAll(PDO::FETCH_ASSOC);
    $activity_type=$con->myQuery("SELECT id,name FROM act_types where type=0")->fetchAll(PDO::FETCH_ASSOC);
    $products=$con->myQuery("SELECT id,product_name,unit_price FROM products WHERE id NOT IN (SELECT prod_id FROM opp_products WHERE opp_id=? and is_deleted=0)AND is_deleted=0",array($opp['id']))->fetchAll(PDO::FETCH_ASSOC);
    //$products=$con->myQuery("SELECT id,product_name,unit_price,opp_id FROM products")->fetchAll(PDO::FETCH_ASSOC);
	$user=$con->myQuery("SELECT id,CONCAT(last_name,' ',first_name,' ',middle_name) as name FROM users")->fetchAll(PDO::FETCH_ASSOC);
    

    makeHead("Opportunities");
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
                          <a href="opportunities.php" class="list-group-item"><span class='fa fa-arrow-left'></span>&nbsp;&nbsp;List of Opportunities</a>
                          <a href="org_opp.php?id=<?php echo $_GET['id']?>" class="list-group-item"><span class='fa fa-arrow-left'></span>&nbsp;&nbsp;Back to My Opportunities</a>
                          <a href="opp_details.php?id=<?php echo $_GET['id'] ?>" class="list-group-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Opportunity Details</a>
                          <span href="" class="list-group-item active">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Activities</span>
                          <a href="opp_contact_persons.php?id=<?php echo $_GET['id'] ?>" class="list-group-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Contact Persons</a>
                          <a href="opp_products.php?id=<?php echo $_GET['id'] ?>" class="list-group-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Products</span>
                          <a href="opp_quotes.php?id=<?php echo $_GET['id'] ?>" class="list-group-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Quotations</a>
                          <a href="opp_purchase.php?id=<?php echo $_GET['id'] ?>" class="list-group-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Purchase Orders</a>
                          <a href="opp_invoice.php?id=<?php echo $_GET['id'] ?>" class="list-group-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Invoices</a>
                          <a href="opp_others.php?id=<?php echo $_GET['id'] ?>" class="list-group-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Others</a>
                        </div>
                    </div>
                    
                </div>
                <div class='col-md-9'>
                                <div class='col-md-12 text-right'>
                                    <form class="form-inline pull-left">
                                      <h1>
                                      <img src="uploads/summary_Oppurtunities.png" width="50" height="50" title="Organization" alt="Organization" />
                                      <?php echo htmlspecialchars($opp['opp_name']) ?>
                                      </h1>
                                    </form>
                                    <!--<a href=''  class='btn btn-success' data-toggle="modal" data-target="#productModal">Add New Product <span class='fa fa-plus'></span></a>
                                    -->
                                </div>
                                <div class='panel-body'>
                                    <div class='col-md-12 text-right'>
                                        <div class='col-md-12 text-right'>
                                        <button class='btn btn-success' data-toggle="collapse" data-target="#collapseForm" aria-expanded="false" aria-controls="collapseForm">Add New Event <span class='fa fa-plus'></span> </button>

                                        <button class='btn btn-success' data-toggle="collapse" data-target="#collapseForm2" aria-expanded="false" aria-controls="collapseForm2">Add New To Do <span class='fa fa-plus'></span> </button>
                                        </div>                                
                                    </div> 
                                </div>
                                <?php
                                Alert();
                                ?>


                            <!--Event Collapse Form-->
                            <div id='collapseForm' class='collapse'>
                            <h3 >Creating New To Event</h3>
                            <hr>
                                <!-- <h3 class="page-header">Creating New To Event</h3> -->
                                <form class='form-horizontal' method='POST' action='save_opp_event.php'>
                                <!-- <input type='hidden' name='id' value='<?php echo !empty($opp)?$opp['id']:""?>'> -->
                                <input type='hidden' name='opp_event' value='<?php echo !empty($eve)?$eve['id']:""?>'>
                                <input type='hidden' name='event_id' value='<?php echo $opp['id']?>'>
                                
                                <div class='form-group'>
                                    <label for="" class="col-sm-4 control-label"> Subject *</label>
                                    <div class='col-sm-6'>
                                        <input type='text' class='form-control' name='subject' placeholder='Enter Subject Name' value='<?php echo !empty($eve)?$eve['subjects']:"" ?>' required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="" class="col-sm-4 control-label">Start Date*</label>
                                    <div class="col-sm-6">
                                            <?php
                                                $start_date="";
                                                if(!empty($eve)){
                                                $start_date=$eve['start_date'];
                                                if($start_date=="0000-00-00"){
                                                $start_date="";
                                                }
                                                }
                                            ?>

                                        <input type='date' class='form-control' name='start_date' value='<?php echo $start_date; ?>' required>
                                    </div>
                                    <label for="" class="col-sm-4 control-label">Time*</label>
                                    <div class="col-sm-3">
                                    <input type="time" class="form-control" value='<?php echo !empty($eve)?$eve['start_time']:"" ?>' id="until_t" name="start_time" required/>
                                </div>
                              </div>

                              <div class="form-group">
                                <label for="" class="col-sm-4 control-label">End Date*</label>
                                <div class="col-sm-6">
                                        <?php
                                            $end_date="";
                                            if(!empty($eve)){
                                            $end_date=$eve['end_date'];
                                            if($end_date=="0000-00-00"){
                                            $end_date="";
                                            }
                                            }
                                        ?>
                                    <input type='date' class='form-control' name='end_date' value='<?php echo $end_date; ?>' required>
                                    </div>
                                    <label for="" class="col-sm-4 control-label">Time*</label>
                                    <div class="col-sm-3">
                                    <input type="time" class="form-control" value='<?php echo !empty($eve)?$eve['end_time']:"" ?>' id="end_time" name="end_time" required/>
                                </div>
                                </div>

                                <div class='form-group'>
                                    <label for="" class="col-md-4 control-label">Status*</label>
                                    <div class="col-sm-6">
                                        <select class='form-control' name='status' data-placeholder="Select an option" <?php echo!(empty($eve))?"data-selected='".$eve['stat_id']."'":NULL ?> required>
                                                    <?php
                                                        echo makeOptions($event_stat);
                                                    ?>
                                        </select>
                                    </div>  
                                </div>

                              <div class='form-group'>
                                <label class="col-md-4 control-label">Activity Type*</label>
                                    <div class="col-sm-6">
                                        <select class='form-control' name='type' data-placeholder="Select an option" <?php echo!(empty($eve))?"data-selected='".$eve['atype_id']."'":NULL ?> required>
                                                    <?php
                                                        echo makeOptions($activity_type);
                                                    ?>
                                        </select>
                                    </div>  
                              </div>
                              
                              <div class='form-group'>
                                    <label class='col-sm-4 control-label' > User *</label>
                                    <div class='col-sm-6'>
                                             <select id="disabledSelect" class='form-control' name='assigned_to' data-placeholder="Select a user" <?php echo!(empty($eve))?"data-selected='".$eve['assigned_to']."'":"data-selected='".$_SESSION[WEBAPP]['user']['id']."'" ?> required>
                                                <?php
                                                    echo makeOptions($user);
                                                ?>
                                            </select>
                                            <!-- <div class='col-ms-1'>
                                            <a href='frm_users.php' class='btn btn-sm btn-success'><span class='fa fa-plus'></span></a>
                                            </div> -->
                                    </div>
                                </div>
                                <div class='form-group'>
                                    <div class='col-sm-12 col-md-9 col-md-offset-3 '>
                                        <button type='submit' class='btn btn-success'> <span class='fa fa-check'></span> Save</button>
                                        <a href='opp_events.php?id=<?php echo $_GET['id'] ?>' class='btn btn-default'>Cancel</a>
                                    </div>
                                    
                                </div>                          
                            </form>
                            </div>




                            <!--To Do Collapse Form-->
                            <div id='collapseForm2' class='collapse'>
                            <h3>Creating New To Do</h3>
                            <hr>
                                <form class='form-horizontal' method='POST' action='save_opp_to_do.php'>
                                <!-- <input type='hidden' name='id' value='<?php echo !empty($opportunity)?$opportunity['id']:""?>'> -->
                                
                                <input type='hidden' name='opp_to_do' value='<?php echo !empty($to_do)?$to_do['id']:""?>'>
                                <input type='hidden' name='to_do_id' value='<?php echo $opp['id']?>'>


                                <div class='form-group'>
                                    <label for="" class="col-sm-4 control-label"> Subject *</label>
                                    <div class='col-sm-6'>
                                        <input type='text' class='form-control' name='subject' placeholder='Enter Subject Name' value='<?php echo !empty($to_do)?$to_do['subjects']:"" ?>' required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="" class="col-sm-4 control-label">Start Date*</label>
                                    <div class="col-sm-6">
                                            <?php
                                                $start_date="";
                                                if(!empty($to_do)){
                                                $start_date=$to_do['start_date'];
                                                if($start_date=="0000-00-00"){
                                                $start_date="";
                                                }
                                                }
                                            ?>

                                        <input type='date' class='form-control' name='start_date' value='<?php echo $start_date; ?>' required>
                                    </div>
                                    <label for="" class="col-sm-4 control-label">Time*</label>
                                    <div class="col-sm-3">
                                    <input type="time" class="form-control" value='<?php echo !empty($to_do)?$to_do['end_time']:"" ?>' id="until_t" name="start_time"  required/>
                                </div>
                              </div>

                              <div class="form-group">
                                <label for="" class="col-sm-4 control-label">Due Date*</label>
                                <div class="col-sm-6">
                                        <?php
                                            $due_date="";
                                            if(!empty($to_do)){
                                            $due_date=$to_do['due_date'];
                                            if($due_date=="0000-00-00"){
                                            $due_date="";
                                            }
                                            }
                                        ?>
                                    <input type='date' class='form-control' name='due_date' value='<?php echo $due_date; ?>' required>
                                    </div>
                                </div>

                                <div class='form-group'>
                                    <label for="" class="col-md-4 control-label">Status*</label>
                                    <div class="col-sm-6">
                                        <select class='form-control' name='status' data-placeholder="Select an option" <?php echo!(empty($to_do))?"data-selected='".$to_do['stat_id']."'":NULL ?> required>
                                                    <?php
                                                        echo makeOptions($to_do_stat);
                                                    ?>
                                        </select>
                                    </div>  
                                </div>

                              <!-- <div class='form-group'>
                                <label class="col-md-4 control-label">Activity Type*</label>
                                    <div class="col-sm-6">
                                        <select class='form-control' name='type' data-placeholder="Select an option" <?php echo!(empty($opportunity))?"data-selected='".$opportunity['org_id']."'":NULL ?>>
                                                    <?php
                                                        echo makeOptions($activity_type);
                                                    ?>
                                        </select>
                                    </div>  
                              </div> -->
                                
                              <div class='form-group'>
                                    <label class='col-sm-4 control-label' > User *</label>
                                    <div class='col-sm-6'>
                                        
                                        <div class='row'>
                                            <div class='col-sm-11'>
                                             <select id="disabledSelect" class='form-control' name='assigned_to' data-placeholder="Select a user" <?php echo!(empty($to_do))?"data-selected='".$to_do['assigned_to']."'":"data-selected='".$_SESSION[WEBAPP]['user']['id']."'" ?> required>
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
                                    <div class='col-sm-12 col-md-9 col-md-offset-3 '>
                                        <button type='submit' class='btn btn-success'> <span class='fa fa-check'></span> Save</button>
                                        <a href='opp_events.php?id=<?php echo $_GET['id'] ?>' class='btn btn-default'>Cancel</a>
                                    </div>
                                    
                                </div>                          
                            </form>
                            </div>
                            <br/>

                    <div class='panel panel-default'>
                        <div class='panel-body'>  
                            <div class='col-md-12'>
                                <div class='dataTable_wrapper '>
                                <h2>List of Activities</h2>
                                <br>
                                    <table class='table responsive table-bordered table-condensed table-hover ' id='dataTables'>
                                        <thead>
                                            <tr>
                                                <th>Status</th>
                                                <th>Activity Type</th>
                                                <th>Subject</th>
                                                <th>Start Date & Time</th>
                                                <th>Related to</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                //$calendars=$con->myQuery("SELECT event_stat,activity_type,subjects,start_date,opp_name,id FROM vw_calendar where opp_id=?",array($_GET['id']))->fetchAll(PDO::FETCH_ASSOC);
                                                foreach ($data as $row):
                                            ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($row['event_stat']) ?></td>
                                                    <td><?php echo htmlspecialchars($row['activity_type']) ?></td>
                                                    <td><?php echo htmlspecialchars($row['subjects']) ?></td>
                                                    <td><?php echo htmlspecialchars($row['start_date']) ?></td>
                                                    <td><?php echo htmlspecialchars($row['opp_name']) ?></td>     
                                                    <td>
                                                        <?php
                                                            if($row['activity_type']=="To Do"){
                                                                $parameter_2="&to_do_id=";
                                                            }
                                                            else{
                                                                $parameter_2="&event_id=";
                                                            }
                                                                $parameter_2.=$row['id'];
                                                        ?>
                                                        <a href='opp_events.php?id=<?php echo $opp['id']?><?php echo $parameter_2?>' class='btn btn-sm btn-success'><span class='fa fa-pencil'></span></a>

                                                        <a class='btn btn-sm btn-danger' href='delete_prod.php?id=<?php echo $row['id']?>&t=oprod&opp_id=<?php echo $opp['opp_id']?>' onclick='return confirm("This product will be deleted.")'><span class='fa fa-trash'></span></a>
                                                    </td>
                                                </tr>
                                            <?php
                                                endforeach;
                                            ?>
                                        </tbody>
                                    </table>
                                </div>    
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
                    case "subject":
                        str_error+="Please Enter Subject. \n";
                        break;
                    case "start_date":
                        str_error+="Please provide starting date. \n";
                        break;
                    case "start_time":
                        str_error+="Please provide starting time. \n";
                        break;
                    case "end_date":
                        str_error+="Please provide ending date. \n";
                        break;
                    case "end_time":
                        str_error+="Please provide ending time. \n";
                        break;
                    case "event_stat":
                        str_error+="Please select event status. \n";
                        break;
                    case "activity_type":
                        str_error+="Please select activity type. \n";
                        break;
                    case "assigned_to":
                        str_error+="Please select user. \n";
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
  if(!empty($eve)):
?>
<script type="text/javascript">
  $(function(){
    $('#collapseForm').collapse({
      toggle: true
    })    
  });
</script>
<?php
  endif;
?>
<?php 
  if(!empty($to_do)):
?>
<script type="text/javascript">
  $(function(){
    $('#collapseForm2').collapse({
      toggle: true
    })    
  });
</script>
<?php
  endif;
?>
<script type="text/javascript">
  $(function(){
   $('#collapseForm').on('show.bs.collapse', function () {
    $('#collapseForm2').collapse('hide')
    });

   $('#collapseForm2').on('show.bs.collapse', function () {
      $('#collapseForm').collapse('hide')
    });

  });
</script>

<?php
	makeFoot();
?>