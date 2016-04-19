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
        $org=$con->myQuery("SELECT id,org_name,phone_num,email,industry,address,org_type,rating,annual_revenue,users,description,date_created,date_modified FROM vw_org WHERE id=?",array($_GET['id']))->fetch(PDO::FETCH_ASSOC);
        if(empty($org)){
            Modal("Invalid Organization Selected");
            redirect("opportunities.php");
            die;
        }
    }
    makeHead("Customers");
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
                          <a href="organizations.php" class="list-group-item"> <span class='fa fa-arrow-left'>&nbsp;&nbsp;</span>List of Customers </a>
                          <span href="" class="list-group-item active">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Customer Details</span>
                           <a href="org_opp.php?id=<?php echo $_GET['id'] ?>" class="list-group-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Opportunities</a>
                          <a href="org_contact_persons.php?id=<?php echo $_GET['id'] ?>" class="list-group-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Contact Persons</a>
                          <!--
                          <a href="org_contact_persons.php?id=<?php echo $_GET['id'] ?>" class="list-group-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Contact Persons</a>
                          <a href="org_products.php?id=<?php echo $_GET['id'] ?>" class="list-group-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Products</a>
                          <a href="org_documents.php?id=<?php echo $_GET['id'] ?>" class="list-group-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Documents</a>
                         -->
                        </div>
                    </div>
                    
                </div>
                <div class='col-md-9'>
                    
                    <div class='panel panel-default'>
                        <div class='panel-body'>
                            <div class='row'>
                                <div class='col-md-12 '>
                                    <!-- <form class="form-inline pull-right">
                                      <div class="form-group">
                                        <label class="sr-only" for="keyword">Search Keyword</label>
                                        <div class="input-group">
                                          <input type="text" class="form-control" id="keyword" placeholder="Search" name='keyword'>
                                        </div>
                                      </div>
                                      <button type="submit" class="btn btn-default">Search</button>
                                    </form> -->
                                    <form class="form-inline pull-left">
                                      <h1>
                                      <img src="uploads/summary_organizations.png" width="50" height="50" title="Organization" alt="Organization" />
                                      <?php echo htmlspecialchars($org['org_name']) ?>
                                      </h1>
                                    </form>
                                    <!--
                                    <button type='button' class='btn btn-success pull-right' data-toggle="modal" data-target="#postModal">Create New Post <span class='fa fa-plus'></span></button>
                                    -->

                                </div>
                            </div>



                            <?php
                                $oDetails=$con->myQuery("SELECT id,org_name,phone_num,email,industry,address,org_type,rating,annual_revenue,users,description,date_created,date_modified FROM vw_org WHERE is_deleted=0 AND id=? ORDER BY id DESC",array($org['id']))->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($oDetails as $row):

                            ?>



                        <div class='row'>
                        <div class='panel panel-primary'>
                        <div class='panel-heading text-center'>
                            <h4>
                            <b>Customer's Information</b>
                            </h4>
                        </div>
                        <table class='table table-bordered table-condensed'>
                            <tr>
                                <th>Customer's name:</th>
                                <td><?php echo htmlspecialchars($org['org_name']) ?></td>
                            </tr>
                            <tr>
                                <th>Phone Number:</th>
                                <td><?php echo htmlspecialchars($org['phone_num']) ?></td>
                            </tr>
                            <tr>
                                <th>Address:</th>
                                <td><?php echo htmlspecialchars($org['address']) ?></td>
                            </tr>
                            <tr>
                                <th>Email Address:</th>
                                <td><?php echo htmlspecialchars($org['email']) ?></td>
                            </tr>
                            <tr>
                                <th>Industry:</th>
                                <td><?php echo htmlspecialchars($org['industry']) ?></td>
                            </tr>
                            <tr>
                                <th>Ratings:</th>
                                <td><?php echo htmlspecialchars($org['rating']) ?></td>
                            </tr>
                            <tr>
                                <th>Annual Revenue:</th>
                                <td><?php echo htmlspecialchars(number_format($org['annual_revenue'],2)) ?></td>
                            </tr>
                            <tr>
                                <th>Assigned To:</th>
                                <td><?php echo htmlspecialchars($org['users']) ?></td>
                            </tr>
                            <tr>
                                <th>Date Created:</th>
                                <td><?php echo htmlspecialchars($org['date_created']) ?></td>
                            </tr>
                            <tr>
                                <th>Date Modified:</th>
                                <td><?php echo htmlspecialchars($org['date_modified']) ?></td>
                            </tr>
                            <tr>
                                <th>Description:</th>
                                <td><?php echo htmlspecialchars($org['description']) ?></td>
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