<?php
	require_once 'support/config.php';
	if(!isLoggedIn()){
		toLogin();
		die();
	}
    if(empty($_GET['id'])){
        Modal("No Account Selected");
        redirect("all_clients.php");
        die();
    }
    else{
        $org=$con->myQuery("SELECT id,opp_id,opp_name,prod_code,product_name,unit_price,commission_rate,qty_unit,total_price,users,description FROM vw_prod WHERE id=?",array($_GET['id']))->fetch(PDO::FETCH_ASSOC);
        if(empty($org)){
            Modal("Invalid products Selected");
            redirect("products.php");
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
                          <a href="org_events.php?id=<?php echo $_GET['id'] ?>" class="list-group-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Activities</a>
                          <a href="org_opp.php?id=<?php echo $_GET['id'] ?>" class="list-group-item"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Opportunities</a>
                          <a href="org_contact_persons.php?id=<?php echo $_GET['id'] ?>" class="list-group-item"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Contact Persons</a>
                          <span href="" class="list-group-item active"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Products</span>
                          <a href="org_documents.php?id=<?php echo $_GET['id'] ?>" class="list-group-item"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Documents</a>
                          
                        </div>
                    </div>
                    
                </div>
                <div class='col-md-9'>
                    
                    <div class='panel panel-default'>
                        <div class='panel-body'>
                                <div class='col-md-12 text-right'>
                                    <form class="form-inline pull-left">
                                      <h1>
                                      <img src="uploads/summary_organizations.png" width="50" height="50" title="Organization" alt="Organization" />
                                      <?php echo htmlspecialchars($org['org_name']) ?>
                                      </h1>
                                    </form>
                                    <a href='frm_products.php?a_id=<?php echo $account['id']?>'  class='btn btn-success' data-toggle="modal" data-target="#postModal">Select Product <span class='fa fa-plus'></span></a>
                                </div>
                                    <br/>

                            <div class='col-md-12'>
                                <br/>
                                <div class='dataTable_wrapper '>
                                    <table class='table responsive table-bordered table-condensed table-hover ' id='dataTables'>
                                        <thead>
                                            <tr>
                                                <th>Product Name</th>
                                                <th>Unit Price</th>
                                                <th>Commission Rate</th>
                                                <th>Qty/Unit</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $products=$con->myQuery("SELECT product_name,unit_price,commission_rate,qty_unit,id FROM vw_prod WHERE is_deleted=0 AND account_id=? ORDER BY id DESC",array($account['id']))->fetchAll(PDO::FETCH_ASSOC);
                                                foreach ($products as $row):
                                            ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($row['product_name']) ?></td>
                                                    <td class='text-right'><?php echo htmlspecialchars(number_format($row['unit_price'],2)) ?></td>
                                                    <td class='text-right'><?php echo htmlspecialchars(number_format($row['commission_rate'],2)) ?></td>
                                                    <td class='text-right'><?php echo htmlspecialchars(number_format($row['unit_price'],2)) ?></td>
                                                    <td><?php echo htmlspecialchars($row['qty_unit']) ?></td>
                                                    <td>
                                                        <a href='' class='btn btn-sm btn-success'><span class='fa fa-pencil'></span></a>
                                                        <a href='' class='btn btn-sm btn-danger'><span class='fa fa-trash'></span></a>
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