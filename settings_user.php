<?php
    require_once 'support/config.php';
    if(!isLoggedIn()){
        toLogin();
        die();
    }
    if(!AllowUser(array(1))){
        redirect("index.php");
    }
    makeHead("Settings");
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
                          <a href="settings_user.php" class="list-group-item active"></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;User Levels</a>
                          <a href="settings_oppstat.php" class="list-group-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sales Stages</a>
                          <a href="settings_locations.php" class="list-group-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Locations</a>
                          <a href="settings_ratings.php" class="list-group-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ratings</a>
                          <a href="settings_departments.php" class="list-group-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Departments</a>
                          <a href="settings_orgtypes.php" class="list-group-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Organization Types</a>
                          <a href="settings_opptypes.php" class="list-group-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Opportunity Types</a>
                        </div>
                    </div>
                    
                </div>
                <div class='col-md-9'>
                                <div class='col-md-12 text-right'>
                                    <form class="form-inline pull-left">
                                      <h1>
                                      <!--<img src="uploads/summary_Oppurtunities.png" width="50" height="50" title="Organization" alt="Organization" />-->
                                      Manage Users
                                      </h1>
                                    </form>
                                    <!--<a href=''  class='btn btn-success' data-toggle="modal" data-target="#productModal">Add New Product <span class='fa fa-plus'></span></a>
                                    -->
                                </div>
                                <div class='panel-body'>
                                    <br/>
                                    <div class='col-md-12 text-right'>
                                        <a href='frm_usertypes.php' class='btn btn-success pull-right'> <span class='fa fa-plus'></span> Create New</a>
                                    </div> 
                                </div>

                            <div id='collapseForm' class='collapse'>
                              <form class='form-horizontal' action='save_opp_quote.php' onsubmit="return validatePost(this)" method="POST" >
                                 <input type='hidden' name='opp_quote' value='<?php echo !empty($data)?$data['id']:""?>'>
                                 <input type='hidden' name='opp_id' value='<?php echo $opp['id']?>'>
                                      <div class='form-group'>
                                        <label for="" class="col-md-4 control-label">Quote Name * </label>
                                        <div class="col-sm-5">
                                            <select name='quote_id' class='form-control select2' data-placeholder="Select Quote Name" <?php echo !(empty($record))?"data-selected='".$record['doc_id']."'":NULL ?> style='width:100%' required>
                                                <?php
                                                  echo makeOptions($quote);
                                                ?>
                                            </select>
                                        </div>  
                                      </div>
                                      <!-- <div class="form-group">
                                        <label for="" class="col-sm-4 control-label">Description</label>
                                        <div class="col-sm-6">
                                            <input class="form-control" id="disabledInput" name='desc' type="text"  disabled>
                                        </div>
                                      </div> -->
                                  <div class="form-group">
                                    <div class="col-sm-10 col-md-offset-2 text-center">
                                      <button type='submit' class='btn btn-success'>Save </button>
                                      <a href='opp_quotes.php?id=<?php echo $_GET['id'] ?>' class='btn btn-default'>Cancel</a>
                                    </div>
                                  </div>
                              </form>
                            </div>
                            <br/>

                    <div class='panel panel-default'>
                        <div class='panel-body'>  
                            <div class='col-md-12'>
                                <br/>
                                <div class='dataTable_wrapper '>
                                    <table class='table responsive table-bordered table-condensed table-hover ' id='dataTables'>
                                        <thead>
                                            <tr>
                                                <th>Name</th>   
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                              $users=$con->myQuery("SELECT id, name FROM user_types WHERE is_deleted=0")->fetchAll(PDO::FETCH_ASSOC);
                                              foreach ($users as $user):
                                            ?>
                                                <tr>
                                                <td><?php echo htmlspecialchars($user['name'])?></td>
                                                <td>
                                                    <a class='btn btn-sm btn-warning' href='frm_usertypes.php?id=<?php echo $user['id'];?>'><span class='fa fa-pencil'></span></a>
                                                    <a class='btn btn-sm btn-danger' href='delete.php?id=<?php echo $user['id'];?>&t=ut' onclick='return confirm("This will be deleted.")'><span class='fa fa-trash'></span></a>
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
                    case "prod_name":
                        str_error+="Please select product name. \n";
                        break;
                    case "prod_price":
                        str_error+="Please provide product price. \n";
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

    function get_desc(){
        
        $("#disabledInput").val($("#doc_id option:selected").data("price"));
        
        $("#prod_name2").val($("#doc_id option:selected").html());
    }
    
</script>
<?php
    makeFoot();
?>