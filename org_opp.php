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
        $org=$con->myQuery("SELECT id,org_name,phone_num,email,industry,address,org_type,rating,annual_revenue,users,description,date_created,date_modified FROM vw_org WHERE id=?",array($_GET['id']))->fetch(PDO::FETCH_ASSOC);
        if(empty($org)){
            Modal("Invalid Opportunities Selected");
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
                </br>
                <div class='col-md-3'>
                    <!--
                    <?php
                        require_once 'template/account_information.php';
                    ?>
                    -->
                    <div class='row'>
                        <div class="list-group">
                          <a href="organizations.php" class="list-group-item"><span class='fa fa-arrow-left'></span> &nbsp;&nbsp;List of Customers</a>
                          <a href="org_details.php?id=<?php echo $_GET['id'] ?>" class="list-group-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Customer Details</a>
                          <span href="" class="list-group-item active">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Opportunities</span>
                          <a href="org_contact_persons.php?id=<?php echo $_GET['id'] ?>" class="list-group-item"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Contact Persons</a>
                          <!-- <a href="org_roducts.php?id=<?php echo $_GET['id'] ?>" class="list-group-item"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Products</a>
                          <a href="org_documents.php?id=<?php echo $_GET['id'] ?>" class="list-group-item"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Documents</a> -->
                          
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
                                      <?php echo htmlspecialchars($org['org_name']) ?> Opportunities
                                      </h1>
                                    </form>
                                </div>
                                    <br/>

                            <div class='col-md-12'>
                            <br/>
                            <div class="col-sm-12">
                        <div class='col-ms-12 text-right'>
                          <a href='frm_org_opps.php?id=<?php echo $org['id']?>' class='btn btn-success'> Add New Opportunity<span class='fa fa-plus'></span> </a>
                        </div>
                        <br/>
                        <table id='ResultTable' class='table table-bordered table-striped'>
                          <thead>
                            <tr>
                                                <th class='text-center'>Opportunity Name</th>
                                                <th class='text-center'>Customer's Name</th>
                                                <th class='text-center'>Sales Stage</th>
                                                <th class='text-center'>Amount</th>
                                                <th class='text-center'>Creator</th>
                                                <th>Contact Name</th>
                              <th class='text-center' style='min-width:100px'>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                                                $opportunities=$con->myQuery("SELECT opp_name,org_name,sales_stage,tprice,users,cname,id FROM vw_opp where utype=?",array($_SESSION[WEBAPP]['user']['id']))->fetchAll(PDO::FETCH_ASSOC);
                                                foreach ($opportunities as $row):
                                            ?>
                              <tr>
                                                        <!-- <td>
                                                        <input type="checkbox" name="select_org" value="<?php echo $organization["id"];?>" />
                                                        </td> -->
                                                        <?php
                                                            foreach ($row as $key => $value):                                                            
                                                        ?> 
                                                        <?php
                                                            if($key=='opp_name'):
                                                        ?> 
                                                            <td>
                                                                <a href='opp_details.php?id=<?= $row['id']?>'><?php echo htmlspecialchars($value)?></a>
                                                            </td> 
                                                        <?php
                                                            elseif($key=='tprice'):
                                                        ?>  
                                                            <td>
                                                                <?php echo htmlspecialchars(number_format($row['tprice'],2))?></a>
                                                            </td>                                                         
                                                        <?php
                                                            elseif($key=='id'):
                                                        ?>                                                                          
                                                            <td>
                                                                <a class='btn btn-sm btn-warning' href='frm_opportunities.php?id=<?php echo $value;?>'><span class='fa fa-pencil'></span></a>
                                                                <a class='btn btn-sm btn-danger' href='delete.php?id=<?php echo $value?>&t=opp' onclick='return confirm("This opportunity will be deleted.")'><span class='fa fa-trash'></span></a>
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
                    </div><!-- /.col -->   
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