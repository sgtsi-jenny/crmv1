<?php
    require_once 'support/config.php';
    if(!isLoggedIn()){
        toLogin();
        die();
    }
    if(!empty($_POST['ddlMonth'])){
        $monthValue=$_POST;
        $monthValue['validDate']=$_POST['ddlMonth']."-01";
        $accounts=$con->myQuery("SELECT subject, event_status.name, priority, CONCAT(users.last_name, ', ', first_name) As uname, DATE_FORMAT(start_date,'%M %d') AS start_date, DATE_FORMAT(end_date,'%M %d') AS end_date, DATE_FORMAT(date_created,'%M %d') AS date_created 
            FROM events 
            inner join users on events.assigned_to=users.id 
            inner join event_status on events.event_stat=event_status.id
            WHERE MONTH(date_created) = MONTH(:validDate) 
            and YEAR(date_created) = YEAR(:validDate)
            and events.is_deleted=0
            Order by date_created", $monthValue)->fetchAll(PDO::FETCH_ASSOC);
        
    }
    else
    {
        $accounts=$con->myQuery("SELECT subject, event_status.name, priority, CONCAT(users.last_name, ', ', first_name) As uname, DATE_FORMAT(start_date,'%M %d') AS start_date, DATE_FORMAT(end_date,'%M %d') AS end_date, DATE_FORMAT(date_created,'%M %d') AS date_created 
                                                FROM events 
                                                inner join users on events.assigned_to=users.id 
                                                inner join event_status on events.event_stat=event_status.id
                                                WHERE MONTH(date_created) = MONTH(NOW()) 
                                                and events.is_deleted=0
                                                Order by date_created")->fetchAll(PDO::FETCH_ASSOC);
    }
    makeHead("Event Reports");
?>
<div id='wrapper'>
<?php
     require_once 'template/navbar.php';
?>
</div>

<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Event Reports</h1>
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
                <form class='form-horizontal' method='POST' enctype="multipart/form-data" action='reports_activities_currentmonth.php'>
                    <div class='form-group'>
                        <div class='col-sm-12 col-md-2' align="center">
                                <h4>Select Month/Year</h4>
                        </div>
                        <div class='col-md-2'>
                                 <?php
                                        $start_date="";
                                         if(!empty($maintenance)){
                                            $start_date=$maintenance['start_date'];
                                            if($start_date=="0000-00-00"){
                                                $start_date="";
                                            }
                                         }
                                        ?>
                                <input type='month' class='form-control' name='ddlMonth' value='<?php echo !empty($account)?$account['dob']:"" ?>' required>
                        </div>
                        <div class='col-md-7'>
                                <button type='submit' class='btn btn-success'> <span class='fa fa-check'></span>Go</button>
                        </div>
                        <div class='col-md-1 hidden'>
                                <a href='frm_quotes.php' class='btn btn-success pull-right'> <span class='fa fa-plus'></span> Create New</a>
                        </div>
                    </div>
                        <br/> <br/> 
                        <div class='panel panel-default'>
                          <div class='panel-body ' >
                            <div class='dataTable_wrapper '>
                                <div class='col-md-12'>
                                    <table class='table table-bordered table-condensed ' id='dataTables'>
                                        <thead>

                                            <tr>  
                                                
                                                <th >Subject</th>
                                                <th>Status</th>
                                                <th>Priority</th>
                                                <th>Assigned To</th>
                                                <th class='date-td'>Start Date</th>
                                                <th class='date-td'>End Date</th>
                                                <th class='date-td'>Date Created</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                
                                                //$account2=$con->myQuery("SELECT id,name,industry,address,email_address,phone,handler_id,account_status_id from accounts where is_deleted=0")->fetchAll(PDO::FETCH_ASSOC);

                                                        foreach ($accounts as $account):
                                            ?>
                                                    <tr>
                                                        
                                                        <?php
                                                            foreach ($account as $key => $value):
                                                            if($key=='id'):
                                                        ?>                   
                                                                                                                                         
                                                            
                                                            <?php
                                                                elseif($key=='opportunity_name'):
                                                                elseif($key=='user_name'):
                                                                elseif($key=='document'):
                                                            ?>                   
                                                                                                                                         
                                                            <td>
                                                                <a download='<?php echo $account["document"];?>' href='uploads/Documents/<?php echo $account['document'] ?>'>
                                                                Download
                                                                </a>
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
                           </div>
                        </div>
                </form>
           
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