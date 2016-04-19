<?php
	require_once 'support/config.php';
	if(!isLoggedIn()){
		toLogin();
		die();
	}
    //$prods=$con->myQuery("SELECT id,prod_name FROM opp_products WHERE is_deleted=0 AND id=? LIMIT 1",array($_GET['opp_id']))->fetch(PDO::FETCH_ASSOC);

    if(empty($_GET['id'])){
        //Modal("No Account Selected");
        redirect("opportunities.php");
        die();
    }
    else{
        $opp=$con->myQuery("SELECT id,opp_id,opp_name,prod_code,product_name,unit_price,commission_rate,qty_unit,total_price,users,description,uid,users FROM vw_prod WHERE id=?",array($_GET['id']))->fetch(PDO::FETCH_ASSOC);
        if(empty($opp)){
            Modal("Invalid Opportunities Selected");
            redirect("opportunities.php");
            die;
        }
    }

    $data="";
    if(!empty($_GET['prod_id'])){
        $data=$con->myQuery("SELECT id,prod_name,prod_id,prod_based_price,prod_price,commission_rate,expected_close_date FROM opp_products WHERE is_deleted=0 AND id=? LIMIT 1",array($_GET['prod_id']))->fetch(PDO::FETCH_ASSOC);
        if(empty($data)){
            Modal("Invalid product selected");
            redirect("opp_products.php");
            die;
        }
    }

    $products=$con->myQuery("SELECT id,product_name,unit_price FROM products WHERE is_deleted=0",array($opp['id']))->fetchAll(PDO::FETCH_ASSOC);
    // $products=$con->myQuery("SELECT id,product_name,unit_price FROM products WHERE id NOT IN (SELECT prod_id FROM opp_products WHERE opp_id=? and is_deleted=0)AND is_deleted=0",array($opp['id']))->fetchAll(PDO::FETCH_ASSOC);
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
                          <a href="opp_events.php?id=<?php echo $_GET['id'] ?>" class="list-group-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Activities</a>
                          <a href="opp_contact_persons.php?id=<?php echo $_GET['id'] ?>" class="list-group-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Contact Persons</a>
                          <span href="" class="list-group-item active">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Products</span>
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
                                    <br/>
                                    <div class='col-md-12 text-right'>
                                        <button class='btn btn-success' data-toggle="collapse" data-target="#collapseForm" aria-expanded="true" aria-controls="collapseForm">Add New Product <span class='fa fa-plus'></span> </button>
                                    </div> 
                                </div>

                                <?php
                                Alert();
                                ?>

                            <div id='collapseForm' class='collapse'>
                              <form class='form-horizontal' action='save_opp_prod.php' onsubmit="return validatePost(this)" method="POST" >
                                 <input type='hidden' name='opp_prod' value='<?php echo !empty($data)?$data['id']:""?>'>
                                 <input type='hidden' name='opp_id' value='<?php echo $opp['id']?>'>
                                      
                                      <div class='form-group'>
                                        <label for="" class="col-md-4 control-label">Product Name *</label>
                                        <div class="col-sm-6">
                                            <select class='form-control' id='prod_id' onchange='get_price()' name='prod_id' data-placeholder="Select a product" <?php echo!(empty($data))?"data-selected='".$data['prod_id']."'":NULL ?>style='width:100%' required>
                                            
                                                <?php
                                                    foreach ($products as $key => $row):
                                                ?>
                                                    <option data-price='<?php echo $row['unit_price'] ?>' placeholder="Select product" value='<?php echo $row['id']?>'><?php echo $row['product_name']?></option>
                                                    
                                                <?php
                                                    endforeach;
                                                ?>
                                                <input type='hidden' id='prod_name2' name='prod_name' value=''>
                                            </select>
                                        </div>  
                                      </div>
                                      <div class="form-group">
                                        <label for="" class="col-sm-4 control-label">Base Price</label>
                                        <div class="col-sm-6">
                                            <input class="form-control" name='prod_based_price' id="prod_based_price"  type="text" required>
                                        </div>
                                      </div>
                                      <div class="form-group">
                                        <label for="" class="col-md-4 control-label">Product Price *</label>
                                        <div class="col-sm-6">
                                            <input type='text' name='prod_price' id='prod_price' class='form-control' placeholder='0' value='<?php echo !empty($data)?$data['prod_price']:"" ?>'  required>
                                        </div>            
                                      </div>
                                      <div class="form-group">
                                        <label for="" class="col-md-4 control-label">Commission Rate</label>
                                        <div class="col-sm-6">
                                            <input type='text' name='commission_rate' id='commission_rate' class='form-control' placeholder='0' value='<?php echo !empty($data)?$data['commission_rate']:"" ?>'>
                                        </div>            
                                      </div>

                                    <div class='form-group'>
                                    <label class="col-md-4 control-label"> Expected Close Date*</label>
                                    <div class='col-sm-12 col-md-6'>
                                        <?php
                                        $expected_close_date="";
                                         if(!empty($opportunity)){
                                            $expected_close_date=$opportunity['expected_close_date'];
                                            if($expected_close_date=="0000-00-00"){
                                                $expected_close_date="";
                                            }
                                         }
                                        ?>
                                        <?php
                                        $purchase_date="";
                                         if(!empty($asset)){
                                            $purchase_date=$asset['purchase_date'];
                                            if($purchase_date=="0000-00-00"){
                                                $purchase_date="";
                                            }
                                         }
                                        ?>
                                        <input type='date' class='form-control' name='expected_close_date' value='<?php echo !empty($data)?$data['expected_close_date']:"" ?>' required>
                                    </div>

                                    <div class='form-group'>
                                    <label class="col-md-4 control-label"> Users*</label>
                                    <div class="col-sm-6">
                                            <select id="disabledSelect" class='form-control' name='assigned_to' data-placeholder="Select a user" <?php echo!(empty($opportunity))?"data-selected='".$opportunity['assigned_to']."'":"data-selected='".$_SESSION[WEBAPP]['user']['id']."'" ?> required>
                                                <?php
                                                    echo makeOptions($user);
                                                ?>
                                            </select>
                                    </div>
                                </div>

                                </div>
                                  <div class="form-group">
                                    <div class="col-sm-10 col-md-offset-2 text-center">
                                      <button type='submit' class='btn btn-success'>Save </button>
                                      <a href='opp_products.php?id=<?php echo $_GET['id'] ?>' class='btn btn-default'>Cancel</a>
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
                                                <th>Product Name</th>
                                                <th>Based Price</th>
                                                <th>Unit Price</th>
                                                <th>Commission Rate</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $opp2=$con->myQuery("SELECT prod_name,prod_based_price,prod_price,commission_rate,id FROM opp_products WHERE is_deleted=0 and opp_id=?",array($_GET['id']))->fetchAll(PDO::FETCH_ASSOC);
                                                foreach ($opp2 as $row):
                                            ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($row['prod_name']) ?></td>                                                    
                                                    <td class='text-right'><?php echo htmlspecialchars(number_format($row['prod_based_price'],2)) ?></td>
                                                    <td class='text-right'><?php echo htmlspecialchars(number_format($row['prod_price'],2)) ?></td>
                                                    <td class='text-right'><?php echo htmlspecialchars(number_format($row['commission_rate'],2)) ?></td>
                                                    <td>
                                                        <a href='opp_products.php?id=<?php echo $opp['id']?>&prod_id=<?php echo $row['id']?>' class='btn btn-sm btn-success'><span class='fa fa-pencil'></span></a>
                                                        <!--<a href='' class='btn btn-sm btn-danger'><span class='fa fa-trash'></span></a>-->
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
        
        $("#prod_based_price").val($("#prod_id option:selected").data("price"));
        
        $("#prod_name2").val($("#prod_id option:selected").html());
    }
    
</script>
<?php 
  if(!empty($data)):
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
	makeFoot();
?>