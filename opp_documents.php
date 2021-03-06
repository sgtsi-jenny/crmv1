<?php
	require_once 'support/config.php';
	if(!isLoggedIn()){
		toLogin();
		die();
	}
    //$prods=$con->myQuery("SELECT id,prod_name FROM opp_products WHERE is_deleted=0 AND id=? LIMIT 1",array($_GET['opp_id']))->fetch(PDO::FETCH_ASSOC);

    if(empty($_GET['id'])){
        Modal("No Document Selected");
        redirect("opportunities.php");
        die();
    }
    else{
        $opp=$con->myQuery("SELECT id,opp_id,opp_name,prod_code,product_name,unit_price,commission_rate,qty_unit,total_price,users,description FROM vw_prod WHERE id=?",array($_GET['id']))->fetch(PDO::FETCH_ASSOC);
        if(empty($opp)){
            Modal("Invalid Document Selected");
            redirect("opportunities.php");
            die;
        }
    }
    
    $data=$con->myQuery("SELECT title, documents.description,opportunities.opp_name, opp_id, CONCAT(users.last_name, ', ', users.first_name) AS uname, user_name, date_uploaded, document, documents.id FROM documents INNER JOIN opportunities ON documents.opp_id=opportunities.id INNER JOIN users ON documents.user_name=users.id WHERE documents.is_deleted=0 AND documents.opp_id=? AND users.user_type_id=?",array($opp['id'],$_SESSION[WEBAPP]['user']['id']))->fetchAll(PDO::FETCH_ASSOC);

    
    if(!empty($_GET['doc_id'])){
        $docs=$con->myQuery("SELECT title, documents.description,opportunities.opp_name, opp_id, CONCAT(users.last_name, ', ', users.first_name) AS uname, user_name, date_uploaded, document, documents.id FROM documents INNER JOIN opportunities ON documents.opp_id=opportunities.id INNER JOIN users ON documents.user_name=users.id WHERE documents.is_deleted=0 AND documents.id=? LIMIT 1",array($_GET['doc_id']))->fetch(PDO::FETCH_ASSOC);
        if(empty($docs)){
            Modal("Invalid product selected");
            redirect("opp_documents.php");
            die;
        }

    }  
    
    $opps=$con->myQuery("SELECT id,opp_name FROM opportunities where is_deleted=0")->fetchAll(PDO::FETCH_ASSOC);
    // $doc=$con->myQuery("SELECT id,title,opportunity_name,document,description,user_name,date_uploaded FROM documents WHERE id NOT IN (SELECT doc_id FROM opp_docs WHERE opp_id=? AND is_deleted=0)AND is_deleted=0",array($opp['id']))->fetchAll(PDO::FETCH_ASSOC);
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
                                        <button class='btn btn-success' data-toggle="collapse" data-target="#collapseForm" aria-expanded="false" aria-controls="collapseForm">Add New Document <span class='fa fa-plus'></span> </button>
                                    </div> 

                                </div>
                                <?php
                                Alert();
                                ?>


                            <div id='collapseForm' class='collapse'>
                              <form class='form-horizontal' action='save_opp_doc.php' onsubmit="return validatePost(this)" method="POST" >
                                 <input type='hidden' name='opp_doc' value='<?php echo !empty($docs)?$docs['id']:""?>'>

                                 <input type='hidden' name='doc_id' value='<?php echo $opp['id']?>'>
                                
                                <div class='form-group'>
                                    <label for="" class="col-md-4 control-label">Document Upload *</label>
                                    <div class="col-sm-5">
                                    <a download='<?php echo $account["document"];?>' href='uploads/Documents/<?php echo $account['document'] ?>'>
                                        <?php echo !empty($docs)?$docs['document']:"" ?>
                                    </a>
                                        <input type='file' class='form-control' name='file' <?php echo !empty($data['id'])?"":''?>>
                                    </div>
                                </div>

                                <div class='form-group'>
                                    <label for="" class="col-md-4 control-label"> Title *</label>
                                    <div class="col-sm-5">

                                        <input type='text' class='form-control' name='title' placeholder='Enter Title' value='<?php echo !empty($docs)?$docs['title']:"" ?>'  required>
                                    </div>
                                </div>

                                <div class='form-group'>
                                    <label for="" class="col-md-4 control-label">Opportunity Name</label>
                                    <div class="col-sm-5">
                                        
                                        <select class='form-control' name='opp_id' data-placeholder="Select opportunity" <?php echo!(empty($opp))?"data-selected='".$opp['id']."'":NULL ?> required>
                                                    <option value='<?php echo !empty($account)?$account['opportunity_name']:""?>'><?php echo !empty($opp_value)?$opp_value['opp_name']:""?></option>
                                                    <?php
                                                        echo makeOptions($opps);
                                                    ?>
                                        </select>
                                    </div>
                                </div>

                               <div class='form-group'>
                                    <label for="" class="col-md-4 control-label">Description</label>
                                    <div class="col-sm-5">
                                        <textarea class='form-control' name='description' placeholder="Write a short description."><?php echo !empty($docs)?$docs['description']:"" ?></textarea>
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
                                      <a href='opp_documents.php?id=<?php echo $_GET['id'] ?>' class='btn btn-default'>Cancel</a>
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
                                                <th>Document Name</th>
                                                <th>Description</th>
                                                <th>Date Uploaded</th>
                                                <th>Assigned To</th>
                                                <th>Document</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                              foreach($data as $row):
                                            ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($row['title']) ?></td>
                                                    <td><?php echo htmlspecialchars($row['description']) ?></td>
                                                    <td><?php echo htmlspecialchars($row['date_uploaded']) ?></td>
                                                    <td><?php echo htmlspecialchars($row['uname']) ?></td>
                                                    <?php
                                                            foreach ($row as $key => $value):
                                                            if($key=='document'):
                                                        ?> 
                                                    <td>
                                                                <a download='<?php echo $row["document"];?>' href='uploads/Documents/<?php echo $row['document'] ?>'>
                                                                Download
                                                                </a>
                                                    </td>
                                                    <?php
                                                            elseif($key=='id'):
                                                    ?>
                                                    <td align="center">
                                                        <a href='opp_documents.php?id=<?php echo $opp['id']?>&doc_id=<?php echo $row['id']?>' class='btn btn-sm btn-success'><span class='fa fa-pencil'></span></a>
                                                        
                                                        <a href='delete.php?id=<?php echo $row['id']?>&t=odocs&opp_id=<?php echo $opp['id']?>' class='btn btn-sm btn-danger' onclick='return confirm("This document will be deleted.")'><span class='fa fa-trash'></span></a>
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
  if(!empty($docs)):
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