<?php
    require_once 'support/config.php';
    if(!isLoggedIn()){
        toLogin();
        die();
    }

    $products=$con->myQuery("SELECT id,product_name,unit_price FROM products")->fetchAll(PDO::FETCH_ASSOC);
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
                          <a href="opp_details.php?id=<?php echo $_GET['id'] ?>" class="list-group-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Opportunity Details</a>
                          <a href="opp_events.php?id=<?php echo $_GET['id'] ?>" class="list-group-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Activities</a>
                          <a href="opp_contact_persons.php?id=<?php echo $_GET['id'] ?>" class="list-group-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Contact Persons</a>
                          <span href="" class="list-group-item active">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Products</span>
                          <a href="opp_documents.php?id=<?php echo $_GET['id'] ?>" class="list-group-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Documents</a>
                          <a href="opp_quotes.php?id=<?php echo $_GET['id'] ?>" class="list-group-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Quotes</a>
                        </div>
                    </div>
                    
                </div>
                <div class='col-md-9'>
                    
                    <div class='panel panel-default'>
                        <div class='panel-body'>
                                <div class='col-md-12 text-right'>
                                    <form class="form-inline pull-left">
                                      <h1>
                                      <img src="uploads/summary_Oppurtunities.png" width="50" height="50" title="Organization" alt="Organization" />
                                      <?php echo htmlspecialchars($opp['opp_name']) ?>
                                      </h1>
                                    </form>
                                    <a href=''  class='btn btn-success' data-toggle="modal" data-target="#productModal">Add New Product <span class='fa fa-plus'></span></a>
                                </div>
                                    <br/>

                            <div class='col-md-12'>
                                <br/>
                                <div class='dataTable_wrapper '>
                                    <table class='table responsive table-bordered table-condensed table-hover ' id='dataTables'>
                                        <thead>
                                            <tr>
                                                <th>Product Name</th>
                                                <th>Based Price</th>
                                                <th>Unit Price</th>
                                                <th>Commission Rate</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $opp=$con->myQuery("SELECT prod_name,prod_based_price,prod_price,commission_rate,id FROM opp_products WHERE is_deleted=0")->fetchAll(PDO::FETCH_ASSOC);
                                                foreach ($opp as $row):
                                            ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($row['prod_name']) ?></td>                                                    
                                                    <td class='text-right'><?php echo htmlspecialchars(number_format($row['prod_based_price'],2)) ?></td>
                                                    <td class='text-right'><?php echo htmlspecialchars(number_format($row['prod_price'],2)) ?></td>
                                                    <td class='text-right'><?php echo htmlspecialchars(number_format($row['commission_rate'],2)) ?></td>
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
<div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="productModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="productModal">Create New Product</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" onsubmit="return validatePost(this)" action='save_opp_prod.php' method='POST'>
            <input type='hidden' name='opp_id' value='<?php echo !empty($data)?$data['id']:""?>'>
          
          <div class='form-group'>
            <label for="" class="col-md-4 control-label">Product Name</label>
            <div class="col-sm-6">
                <select class='form-control' id='prod_name' onchange='get_price()' name='prod_name' data-placeholder="Select a product" <?php echo!(empty($data))?"data-selected='".$data['prod_name']."'":NULL ?>>
                    
                    <?php
                        foreach ($products as $key => $row):
                        //echo makeOptions($products);
                    ?>
                        <option data-price='<?php echo $row['unit_price'] ?>' placeholder="Select product" value='<?php echo $row['id']?>'><?php echo $row['product_name']?></option>
                    <?php
                        endforeach;
                    ?>
                </select>
            </div>  
          </div>
          <div class="form-group">
            <label for="" class="col-sm-4 control-label">Based Price</label>
            <div class="col-sm-6">
                <input class="form-control" id="disabledInput" name='prod_based_price' type="text"  disabled>
            </div>
          </div>
          <div class="form-group">
            <label for="" class="col-md-4 control-label">Product Price</label>
            <div class="col-sm-6">
                <input type='text' name='prod_price' class='form-control' placeholder='0'>
            </div>            
          </div>
          <div class="form-group">
            <label for="" class="col-md-4 control-label">Commission Rate</label>
            <div class="col-sm-6">
                <input type='text' name='commission_rate' class='form-control' placeholder='0'>
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

    function get_price(){
        
        $("#disabledInput").val($("#prod_name option:selected").data("price"));
    }
    
</script>
<?php
    makeFoot();
?>