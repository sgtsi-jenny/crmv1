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
        $event=$con->myQuery("SELECT ev.stat_id,ev.event_stat,ev.atype_id,ev.activity_type,ev.priority_id,ev.priority,ev.location,ev.description,ev.subjects,DATE(ev.start_date) AS start_date,TIME(ev.start_date) AS start_time,DATE(ev.end_date) AS end_date,TIME(ev.start_date) AS end_time,ev.opp_name,ev.assigned_to,ev.id FROM vw_calendar ev WHERE ev.is_deleted=0 AND ev.id=?",array($_GET['id']))->fetch(PDO::FETCH_ASSOC);
        if(empty($event)){
            //Alert("Invalid asset selected.");
            //Modal("Invalid Opportunity Selected");
            redirect("opportunities.php");
            die();
        }
        //var_dump($opportunity);
        //die;
    }

    $event_stat=$con->myQuery("SELECT id,name FROM event_status where type=2 or type=3")->fetchAll(PDO::FETCH_ASSOC);
    $activity_type=$con->myQuery("SELECT id,name FROM act_types where type=0")->fetchAll(PDO::FETCH_ASSOC);
    $org_name=$con->myQuery("SELECT id,org_name FROM organizations")->fetchAll(PDO::FETCH_ASSOC);
    $prod=$con->myQuery("SELECT id,product_name,unit_price from products")->fetchAll(PDO::FETCH_ASSOC);
    $contact=$con->myQuery("SELECT id,CONCAT(fname,' ',lname) as name from contacts")->fetchAll(PDO::FETCH_ASSOC);
    $prior=$con->myQuery("SELECT id,name FROM priorities")->fetchAll(PDO::FETCH_ASSOC);
    $user=$con->myQuery("SELECT id,CONCAT(last_name,' ',first_name,' ',middle_name) as name FROM users")->fetchAll(PDO::FETCH_ASSOC);
                                            
    makeHead("Calendar");

?>
<div id='wrapper'>
<?php
     require_once 'template/navbar.php';
?>
</div>
<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Creating New Event</h1>
                </div>

                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class='col-lg-12'>

                    <div class='row'>
                        <div class='col-sm-12 col-md-8 col-md-offset-2'>
                            <form class='form-horizontal' method='POST' action='save_event.php'>
                                <input type='hidden' name='id' value='<?php echo !empty($event)?$event['id']:""?>'>
                                
                                <div class='form-group'>
                                    <label for="" class="col-sm-4 control-label"> Subject *</label>
                                    <div class='col-sm-6'>
                                        <input type='text' class='form-control' name='subject' placeholder='Enter Subject Name' value='<?php echo !empty($event)?$event['subjects']:"" ?>'>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="" class="col-sm-4 control-label">Start Date*</label>
                                    <div class="col-sm-6">
                                            <?php
                                                $start_date="";
                                                if(!empty($event)){
                                                $start_date=$event['start_date'];
                                                if($start_date=="0000-00-00"){
                                                $start_date="";
                                                }
                                                }
                                            ?>
                                        <input type='date' class='form-control' name='start_date' value='<?php echo $start_date; ?>'>
                                    </div>
                                    <label for="" class="col-sm-4 control-label">Time*</label>
                                    <div class="col-sm-3">
                                    <input type="time" class="form-control" value='<?php echo !empty($event)?$event['start_time']:"" ?>' id="until_t" name="start_time" required/>
                                    </div>
                              </div>

                              <div class="form-group">
                                <label for="" class="col-sm-4 control-label">End Date*</label>
                                <div class="col-sm-6">
                                        <?php
                                            $end_date="";
                                            if(!empty($event)){
                                            $end_date=$event['end_date'];
                                            if($end_date=="0000-00-00"){
                                            $end_date="";
                                            }
                                            }
                                        ?>
                                    <input type='date' class='form-control' name='end_date' value='<?php echo $end_date; ?>'>
                                    </div>
                                    <label for="" class="col-sm-4 control-label">Time*</label>
                                    <div class="col-sm-3">
                                    <input type="time" class="form-control" value='<?php echo !empty($event)?$event['end_time']:"" ?>' id="until_t" name="end_time" required/>
                                </div>
                                </div>

                                <div class='form-group'>
                                    <label for="" class="col-md-4 control-label">Status*</label>
                                    <div class="col-sm-6">
                                        <!-- <select name='event_stat' class='no-search'>
                                        <option value='1'>Planned</option>
                                        <option value='2'>Held</option>
                                        <option value='3'>Not Held</option>
                                        </select> -->
                                        <select class='form-control' name='status' data-placeholder="Select an option" <?php echo!(empty($event))?"data-selected='".$event['stat_id']."'":NULL ?>>
                                                    <?php
                                                        echo makeOptions($event_stat);
                                                    ?>
                                        </select>
                                    </div>  
                                </div>

                              <div class='form-group'>
                                <label class="col-md-4 control-label">Activity Type*</label>
                                    <div class="col-sm-6">
                                        <select class='form-control' name='type' data-placeholder="Select an option" <?php echo!(empty($event))?"data-selected='".$event['atype_id']."'":NULL ?>>
                                                    <?php
                                                        echo makeOptions($activity_type);
                                                    ?>
                                        </select>
                                    </div>  
                              </div>
                              
                              <div class='form-group'>
                                    <label class='col-sm-4 control-label' > User *</label>
                                    <div class='col-sm-6'>
                                        
                                        <div class='row'>
                                            <div class='col-sm-11'>
                                             <select id="disabledSelect" class='form-control' name='assigned_to' data-placeholder="Select a user" <?php echo!(empty($event))?"data-selected='".$event['assigned_to']."'":"data-selected='".$_SESSION[WEBAPP]['user']['id']."'" ?>>
                                                <?php
                                                    echo makeOptions($user);
                                                ?>
                                            </select>
                                            </div>
                                            <?php
                                                if($_SESSION[WEBAPP]['user']['user_type']==1):
                                            ?>
                                            <div class='col-ms-1'>
                                            <a href='frm_users.php' class='btn btn-sm btn-success'><span class='fa fa-plus'></span></a>
                                            </div>
                                            <?php
                                                endif;
                                            ?>
                                        </div>
                                    </div>
                                </div>
                              
                              <div class='form-group'>
                                    <label class='col-sm-4 control-label' > Priority</label>
                                    <div class='col-sm-6'>
                                        
                                                <select class='form-control' name='priority' data-placeholder="Select an option" <?php echo!(empty($event))?"data-selected='".$event['priority_id']."'":NULL ?>>
                                                    <?php
                                                    echo makeOptions($prior);
                                                ?>
                                                </select>
                                    </div>
                                </div>

                                <div class='form-group'>
                                    <label for="" class="col-sm-4 control-label"> Location</label>
                                    <div class='col-sm-6'>
                                        <input type='text' class='form-control' name='location' placeholder='Enter Location' value='<?php echo !empty($event)?$event['location']:"" ?>'>
                                    </div>
                                </div>

                                <div class='form-group'>
                                    <label for="" class="col-sm-4 control-label"> Description</label>
                                    <div class='col-sm-6'>
                                        <textarea class='form-control' name='description' value=''><?php echo !empty($event)?$event['description']:"" ?></textarea>
                                    </div>
                                </div>

                                <div class='form-group'>
                                    <div class='col-sm-12 col-md-9 col-md-offset-3 '>
                                        <a href='events.php' class='btn btn-default'>Cancel</a>
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