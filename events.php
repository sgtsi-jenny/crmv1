        <link type="text/css" rel="stylesheet" href="media/layout.css" />
        <link type="text/css" rel="stylesheet" href="themes/calendar_g.css" />    
        <link type="text/css" rel="stylesheet" href="themes/calendar_green.css" />    
        <link type="text/css" rel="stylesheet" href="themes/calendar_traditional.css" />    
        <link type="text/css" rel="stylesheet" href="themes/calendar_transparent.css" />    
        <link type="text/css" rel="stylesheet" href="themes/calendar_white.css" />
    <!-- helper libraries -->
    <script src="js/jquery-1.9.1.min.js" type="text/javascript"></script>
    <!-- daypilot libraries -->
    <script src="js/daypilot/daypilot-all.min.js" type="text/javascript"></script>
<?php
    require_once 'support/config.php';
    if(!isLoggedIn()){
        toLogin();
        die();
    }
    makeHead("Calendar");
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
                          <a href="my_calendar.php" class="list-group-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;My Calendar</a>
                          <span href="" class="list-group-item active">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Calendar List</span>
                        </div>
                    </div>
                    
                </div>
                <div class='col-md-9'>
                    
                    <div class='panel panel-default'>
                        <div class='panel-body'>
                                    <br/>

                            <div class='col-md-12'>
                                
                    <?php
                        Alert();
                    ?> 
                               <a href='frm_to_do.php' class='btn btn-success pull-right'> <span class='fa fa-plus'></span> Add To Do</a>
                               <a href='frm_event.php' class='btn btn-success pull-right'> <span class='fa fa-plus'></span> Add Event</a>
                               <a class='pull-right'></a>
                                 <br/> <br/> <br/> 
                                <div class='dataTable_wrapper '>
                                    <table class='table responsive table-bordered table-condensed table-hover ' id='dataTables'>
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" name="select_opp" value="<?php echo $opportunity["id"];?>" />
                                                </th>  
                                                <th>Status</th>
                                                <th>Activity Type</th>
                                                <th>Subject</th>
                                                <th>Related To</th>
                                                <th>Start Date & Time</th>
                                                <th>End Date</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $calendars=$con->myQuery("SELECT event_stat,activity_type,subjects,is_related,start_date,end_date,id FROM vw_calendar where activity_type<>5 and assigned_to=?",array($_SESSION[WEBAPP]['user']['id']))->fetchAll(PDO::FETCH_ASSOC);
                                                foreach ($calendars as $row):
                                            ?>
                                                <tr>
                                                        <td>
                                                            <input type="checkbox" name="select_opp" value="<?php echo $row["id"];?>" />
                                                        </td>
                                                        <?php
                                                            foreach ($row as $key => $value):                                                            
                                                        ?>                                                                                                                   
                                                        <?php
                                                            if($key=='users'):
                                                        ?>
                                                            <td>
                                                                <a href='view_user.php?id=<?= $row['assigned_to']?>'><?php echo htmlspecialchars($value)?></a>
                                                            </td> 
                                                        <?php
                                                            elseif($key=='opp_name'):
                                                        ?> 
                                                            <td>
                                                                <a href='opp_details.php?id=<?= $row['id']?>'><?php echo htmlspecialchars($value)?></a>
                                                            </td> 
                                                        <?php
                                                            elseif($key=='id'):
                                                        ?>                                                                          
                                                            <td>
                                                                <?php
                                                                if($row['activity_type']=="To Do"){
                                                                    $parameter_2="frm_to_do.php?id=";
                                                                }
                                                                else{
                                                                    $parameter_2="frm_event.php?id=";
                                                                }
                                                                    $parameter_2.=$row['id'];
                                                                ?>
                                                                <a class='btn btn-sm btn-warning' href='<?php echo $parameter_2?>'><span class='fa fa-pencil'></span></a>
                                                                <a class='btn btn-sm btn-danger' href='delete.php?id=<?php echo $value?>&t=eve' onclick='return confirm("This event will be deleted.")'><span class='fa fa-trash'></span></a>
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
                            </div>
                            
                            
                            
                        </div>
                    </div>
                    
                </div>
            </div>
            <!-- /.row -->
</div>
<!-- Modal -->
<div class="modal fade" id="postModal" tabindex="-1" role="dialog" aria-labelledby="postModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="postModal">Create New Post</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" onsubmit="return validatePost(this)" action='save_post.php' method='POST'>
            <input type='hidden' name='account_id' value='<?php echo htmlspecialchars($_GET['id']) ?>'>
          <div class="form-group">
            <label for="" class="col-md-2 control-label">Post Title</label>
            <div class="col-sm-10">
                <input type='text' name='title' class='form-control'>
            </div>
            
          </div>
          <div class="form-group">
            <label for="" class="col-sm-2 control-label">Message</label>
            <div class="col-sm-10">
              <textarea class='form-control' name='message'></textarea>
            </div>
          </div>
          <div class='form-group'>
            <label for="" class="col-md-2 control-label">Post Type</label>
            <div class="col-sm-10">
                <select name='post_type' class='no-search'>
                <option value='1'>Normal (white)</option>
                <option value='2'>Notice (yellow)</option>
                <option value='3'>Urgent (red)</option>
                </select>
            </div>  
          </div>
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <button type="submit" class="btn btn-success">Save</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
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