<?php
    require_once 'support/config.php';
    if(!isLoggedIn()){
        toLogin();
        die();
    }
    if(empty($_GET['id'])){
        Modal("No Opportunities Selected");
        redirect("opportunities.php");
        die();
    }
    else{
        $opp=$con->myQuery("SELECT id,opp_id,opp_name,prod_code,product_name,unit_price,commission_rate,qty_unit,total_price,users,description FROM vw_prod WHERE id=?",array($_GET['id']))->fetch(PDO::FETCH_ASSOC);
        if(empty($opp)){
            Modal("Invalid Opportunities Selected");
            redirect("opportunities.php");
            die;
        }
    }

    // $data="";
    // if(!empty($_GET['c_id'])){
    //     $data=$con->myQuery("SELECT id,name FROM opp_contacts WHERE is_deleted=0 AND id=? LIMIT 1",array($_GET['opp_id']))->fetch(PDO::FETCH_ASSOC);
    //     if(empty($data)){
    //         Modal("Invalid product selected");
    //         redirect("opp_contacts.php");
    //         die;
    //     }
    // }

  $data=$con->myQuery("SELECT oc.id,CONCAT(c.fname,' ', c.lname) AS name,c.office_phone,c.email,c.description FROM opp_contacts oc JOIN contacts c ON oc.c_id=c.id WHERE oc.is_deleted=0  AND oc.opp_id=?",array($opp['id']))->fetchAll(PDO::FETCH_ASSOC);
          if(!empty($_GET['c_id'])){
    $record=$con->myQuery("SELECT id,c_id FROM opp_contacts oc WHERE opp_id=? AND id=? LIMIT 1",array($opp['opp_id'],$_GET['c_id']))->fetch(PDO::FETCH_ASSOC);
  }
    $contacts=$con->myQuery("SELECT id,concat(fname,' ', lname) as name,office_phone,home_phone,mobile_phone,email,dob,assigned_to,description FROM contacts WHERE id NOT IN (SELECT c_id FROM opp_contacts WHERE opp_id=? and is_deleted=0)AND is_deleted=0",array($opp['id']))->fetchAll(PDO::FETCH_ASSOC);
  //$products=$con->myQuery("SELECT id,product_name,unit_price FROM products WHERE id NOT IN (SELECT prod_id FROM opp_contacts WHERE opp_id=? and is_deleted=0)AND is_deleted=0",array($opp['id']))->fetchAll(PDO::FETCH_ASSOC);
    
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
                          <span href="" class="list-group-item active">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Contact Persons</span>
                          <a href="opp_products.php?id=<?php echo $_GET['id'] ?>" class="list-group-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Products</a>
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
                                        <button class='btn btn-success' data-toggle="collapse" data-target="#collapseForm" aria-expanded="false" aria-controls="collapseForm">Add New Contact <span class='fa fa-plus'></span> </button>
                                    </div> 
                                </div>
                                <?php
                                  $has_error=FALSE;
                                  if(!empty($_SESSION[WEBAPP]['Alert']) && $_SESSION[WEBAPP]['Alert']['Type']=="danger"){
                                    $has_error=TRUE;
                                  }
                                  Alert();
                                ?>                               


                <div id='collapseForm' class='collapse'>
                  <form class='form-horizontal' action='save_opp_contact.php' method="POST" >
                    <input type='hidden' name='opp_con' value='<?php echo !empty($opp)?$opp['id']:""?>'>
                    <input type='hidden' name='opp_id' value='<?php echo $opp['id']?>'>
                                    <div class='form-group'>
                                        <label for="" class="col-md-4 control-label">Contact Name * </label>
                                        <div class="col-sm-5">
                                            <!--<select class='form-control' id='c_id' onchange='get_con()' name='c_id' data-placeholder="Select a contact" <?php echo!(empty($data))?"data-selected='".$data['name']."'":NULL ?>>
                                            <?php
                                                foreach ($contacts as $key => $row):
                                                    ?>
                                                    <option data-phone='' placeholder="Select contact" value='<?php echo $row['id']?>'><?php echo $row['name']?></option>
                                                <?php
                                                    endforeach;
                                                ?>
                                                <input type='hidden' id='name' name='name' value=''>
                                            -->
                                            <select name='c_id' class='form-control select2' data-placeholder="Select Contact Name" <?php echo !(empty($record))?"data-selected='".$record['c_id']."'":NULL ?> style='width:100%' required>
                                                <?php
                                                  echo makeOptions($contacts);
                                                ?>
                                            </select>
                                        </div>  
                                      </div>
                          <div class="form-group">
                            <div class="col-sm-10 col-md-offset-2 text-center">
                              <button type='submit' class='btn btn-success'>Add </button>
                            <a href='opp_contact_persons.php?id=<?php echo $opp['id'] ?>' class='btn btn-default'>Cancel</a>
                              </div>
                          </div>    
                  </form>
                </div>
                <br/> 
                    <div class='panel panel-default'>
                        <div class='panel-body'>
                            <div class='col-md-12'>
                                <div class='dataTable_wrapper '>
                                <h2>List of Contact Persons</h2>
                                <br>
                                    <table class='table responsive table-bordered table-condensed table-hover ' id='dataTables'>
                                        <thead>
                                            <tr>
                                                <th>Contact Name</th>
                                                <th>Office Number</th>
                                                <th>Email</th>
                                                <th>Description</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                              foreach($data as $row):
                                            ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($row['name']) ?></td>
                                                    <td><?php echo htmlspecialchars($row['office_phone']) ?></td>
                                                    <td><?php echo htmlspecialchars($row['email']) ?></td>
                                                    <td><?php echo htmlspecialchars($row['description']) ?></td>
                                                    <td align="center">
                                                        <!--<a href='' class='btn btn-sm btn-success'><span class='fa fa-pencil'></span></a>
                                                        -->
                                                        <a href='delete.php?id=<?php echo $row['id']?>&t=ocon&opp_id=<?php echo $opp['id']?>' class='btn btn-sm btn-danger' onclick='return confirm("This contact will be deleted.")'><span class='fa fa-trash'></span></a>
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
                    case "c_id":
                        str_error+="Please Select contact name. \n";
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
    function get_con(){
        
        $("#disabledInput").val($("#c_id option:selected").data("phone"));
        $("#name").val($("#c_id option:selected").html());
        // $("#office_phone").val($("#c_id option:selected").html());
        // $("#email").val($("#c_id option:selected").html());
        // $("#assigned_to").val($("#c_id option:selected").html());
        // $("#description").val($("#c_id option:selected").html());
    }
    
</script>
<?php
    makeFoot();
?>