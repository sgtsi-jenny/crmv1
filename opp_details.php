<?php
    require_once 'support/config.php';
    if(!isLoggedIn()){
        toLogin();
        die();
    }
    if(empty($_GET['id'])){
        Modal("No Account Selected");
        redirect("opportunities.php");
        die();
    }
    else{
        $opp=$con->myQuery("SELECT id,opp_name,org_id,org_name,cname,opp_type,users,sales_stage,forecast_amount,amount,tprice,description,product_set,date_created,date_modified FROM vw_opp WHERE id=?",array($_GET['id']))->fetch(PDO::FETCH_ASSOC);
        if(empty($opp)){
            Modal("Invalid Opportunities Selected");
            redirect("opportunities.php");
            die;
        }
    }
    makeHead("Opportunities");
?>
<div id='wrapper'>
<?php
     require_once 'template/navbar.php';
?>
</div>

<div id="page-wrapper">
            <div class='row'>
                <div class='col-md-12'>
                    <!--
                    <h1 class="page-header">Activities</h1>
                    -->
                </div>
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
                          <a href="org_opp.php?id=<?php echo $_GET['id']?>" class="list-group-item">&nbsp;&nbsp;Back to My Opportunities</a>
                          <span href="" class="list-group-item active">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Opportunity Details</span>
                          <a href="opp_events.php?id=<?php echo $_GET['id'] ?>" class="list-group-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Activities</a>
                          <a href="opp_contact_persons.php?id=<?php echo $_GET['id'] ?>" class="list-group-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Contact Persons</a>
                          <a href="opp_products.php?id=<?php echo $_GET['id'] ?>" class="list-group-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Products</a>
                          <a href="opp_quotes.php?id=<?php echo $_GET['id'] ?>" class="list-group-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Quotations</a>
                          <a href="opp_purchase.php?id=<?php echo $_GET['id'] ?>" class="list-group-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Purchase Orders</a>
                          <a href="opp_invoice.php?id=<?php echo $_GET['id'] ?>" class="list-group-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Invoices</a>
                          <a href="opp_others.php?id=<?php echo $_GET['id'] ?>" class="list-group-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Others</a>
                        </div>
                    </div>
                    
                </div>
                <div class='col-md-9'>
                    
                    <div class='panel panel-default'>
                        <div class='panel-body'>
                            <div class='row'>
                                <div class='col-md-12 '>
                                    <form class="form-inline pull-right">
                                      <div class="form-group">
                                        <label class="sr-only" for="keyword">Search Keyword</label>
                                        <div class="input-group">
                                          <input type="text" class="form-control" id="keyword" placeholder="Search" name='keyword'>
                                        </div>
                                      </div>
                                      <button type="submit" class="btn btn-default">Search</button>
                                    </form>
                                    <form class="form-inline pull-left">
                                      <h1>
                                      <img src="uploads/summary_Oppurtunities.png" width="50" height="50" title="Organization" alt="Organization" />
                                      <?php echo htmlspecialchars($opp['opp_name']) ?>
                                      </h1>
                                    </form>
                                    <!--
                                    <button type='button' class='btn btn-success pull-right' data-toggle="modal" data-target="#postModal">Create New Post <span class='fa fa-plus'></span></button>
                                    -->

                                </div>
                            </div>



                            <?php
                                $oppDetails=$con->myQuery("SELECT id,opp_name,org_id,org_name,cname,opp_type,users,sales_stage,forecast_amount,tprice,description,product_set,date_created,date_modified FROM vw_opp WHERE is_deleted=0 AND id=?",array($opp['id']))->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($oppDetails as $row):

                            ?>



                        <div class='row'>
                        <div class='panel panel-primary'>
                        <div class='panel-heading text-center'>
                            <h4>
                            <b>Project Information</b>
                            </h4>
                        </div>
                        <table class='table table-bordered table-condensed'>
                            <tr>
                                <th>Opportunity Name:</th>
                                <td><?php echo htmlspecialchars($opp['opp_name']) ?></td>
                            </tr>
                            <tr>
                                <th>Customer's Name:</th>
                                <td><?php echo htmlspecialchars($opp['org_name']) ?></td>
                            </tr>
                            <tr>
                                <th>Type:</th>
                                <td><?php echo htmlspecialchars($opp['opp_type']) ?></td>
                            </tr>
                            <tr>
                                <th>Sales Stage:</th>
                                <td><?php echo htmlspecialchars($opp['sales_stage']) ?></td>
                            </tr>
                            <tr>
                                <th>Forecast Amount:</th>
                                <td><?php echo htmlspecialchars(number_format($opp['forecast_amount'],2)) ?></td>
                            </tr>
                            <tr>
                                <th>Amount:</th>
                                <td><?php echo htmlspecialchars(number_format($opp['tprice'],2)) ?></td>
                            </tr>
                            <tr>
                                <th>Assigned To:</th>
                                <td><?php echo htmlspecialchars($opp['users']) ?></td>
                            </tr>
                            <tr>
                                <th>Date Created:</th>
                                <td><?php echo htmlspecialchars($opp['date_created']) ?></td>
                            </tr>
                            <tr>
                                <th>Date Modified:</th>
                                <td><?php echo htmlspecialchars($opp['date_modified']) ?></td>
                            </tr>
                            <tr>
                                <th>Description:</th>
                                <td><?php echo htmlspecialchars($opp['description']) ?></td>
                            </tr>
                        </table>
                        </div>
                    </div>
                            <?php
                                endforeach;
                            ?>
                            
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

    
</script>
<?php
    makeFoot();
?>