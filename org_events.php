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
            Modal("Invalid Opportunities Selected");
            redirect("opportunities.php");
            die;
        }
    }
    makeHead("Organizations");
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
                          <a href="organizations.php" class="list-group-item"><span class='fa fa-arrow-left'></span> &nbsp;&nbsp;List of Organizations</a>
                          <a href="org_details.php?id=<?php echo $_GET['id'] ?>" class="list-group-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Organization Details</a>
                          <span href="" class="list-group-item active"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Activities</span>
                          <a href="org_opp.php?id=<?php echo $_GET['id'] ?>" class="list-group-item"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Opportunities</a>
                          <a href="org_contact_persons.php?id=<?php echo $_GET['id'] ?>" class="list-group-item"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Contact Persons</a>
                          <a href="org_products.php?id=<?php echo $_GET['id'] ?>" class="list-group-item"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Products</a>
                          <a href="org_documents.php?id=<?php echo $_GET['id'] ?>" class="list-group-item"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Documents</a>
                          
                        </div>
                    </div>
                    
                </div>
                <div class='col-md-9'>
                    
                    <div class='panel panel-default'>
                        <div class='panel-body'>
                            <div class='row'>
                                <div class='col-md-12 '>
                                    <div class='col-md-12 '>
                                    <button type='button' class='btn btn-success pull-right' data-toggle="modal" data-target="#postModal">Create Event / To Do <span class='fa fa-plus'></span></button>
                                
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
                                    <form class="form-inline pull-right">
                                      <div class="form-group">
                                        <label class="sr-only" for="keyword">Search Keyword</label>
                                        <div class="input-group">
                                          <input type="text" class="form-control" id="keyword" placeholder="Search" name='keyword'>
                                        </div>
                                      </div>
                                      <button type="submit" class="btn btn-default">Search</button>
                                    </form>
                                    </div>
                            </div>
                            <?php
                                $posts=$con->myQuery("SELECT id,title,message,date_created,user,user_id,post_type,is_deleted FROM qry_posts WHERE is_deleted=0 AND account_id=? ORDER BY id DESC",array($account['id']))->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($posts as $row):

                            ?>
                                <div class='panel <?php echo post_type($row['post_type'])?>'>
                                    <div class="panel-heading">
                                        <?php echo htmlspecialchars($row['title']) ?>
                                        <?php
                                            if($_SESSION[WEBAPP]['user']['id']==$row['user_id']):
                                        ?>
                                            <div class='pull-right'>
                                                <a href='frm_posts.php?a_id=<?php echo $account['id']?>&id=<?php echo $row['id']?>'><button  class='btn btn-sm btn-default'><span class='fa fa-pencil'></span></button></a>
                                                <button class='btn btn-sm btn-default' onclick='return confirm("This item will be deleted?")'><span class='fa fa-trash'></span></button>
                                            </div>
                                        <?php
                                            endif;
                                        ?>
                                    </div>
                                    <div class='panel-body'>
                                        <?php echo htmlspecialchars($row['message']) ?>
                                    </div>
                                    <div class='panel-footer'>
                                        <div class='pull-right'>
                                            <?php echo htmlspecialchars($row['user']) ?>
                                        </div>
                                        <div class='text-left'>                             
                                            <?php echo htmlspecialchars($row['date_created']) ?>
                                        </div>
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