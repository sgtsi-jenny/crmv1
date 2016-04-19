<?php
	require_once 'support/config.php';
	if(!isLoggedIn()){
		toLogin();
		die();
	}
	makeHead("Status Reports");
?>
<div id='wrapper'>
<?php
	 require_once 'template/navbar.php';
?>
</div>

<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Status Reports</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

            <?php
                if(AllowUser(array(1,2))):
            ?>
            <?php
            Alert();
            ?>

            <div class='row'>
                        
                        <br/> <br/> 
                        <div class='panel panel-default'>
                          <div class='panel-body ' >
                            <div class='dataTable_wrapper '>
                                <div class='col-md-12'>
                                    <table class='table table-bordered table-condensed ' id='dataTables'>
                                        <thead>

                                            <tr>  
                                                
                                                <th>Opportunity Name</th>
                                                <th>Organization</th>
                                                <th>Status</th>
                                                <th>Sales Officer</th>
                                                <th>Amount</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $accounts=$con->myQuery("SELECT opp_name, organizations.org_name, opp_statuses.name, CONCAT(users.last_name, ', ', users.first_name) As uname , (select SUM(opp_products.prod_price) from opp_products where is_deleted=0 and opportunities.id=opp_products.opp_id) 
                                                    FROM opportunities 
                                                    inner join organizations on opportunities.org_id=organizations.id 
                                                    inner join opp_statuses on opportunities.sales_stage=opp_statuses.id 
                                                    inner join users on opportunities.assigned_to=users.id 
                                                    where opportunities.is_deleted=0 
                                                    group by opp_statuses.name, uname, organizations.org_name, opp_name, amount")->fetchAll(PDO::FETCH_ASSOC);
                                                //$account2=$con->myQuery("SELECT id,name,industry,address,email_address,phone,handler_id,account_status_id from accounts where is_deleted=0")->fetchAll(PDO::FETCH_ASSOC);

                                                        foreach ($accounts as $account):
                                            ?>
                                                    <tr>
                                                        
                                                        <?php
                                                            foreach ($account as $key => $value):
                                                            if($key=='id'):
                                                        ?>                   
                                                                                                                                         
                                                            
                                                            <?php
                                                                elseif($key=='opportunity_name'):
                                                                elseif($key=='user_name'):
                                                                elseif($key=='document'):
                                                            ?>                   
                                                                                                                                         
                                                            <td>
                                                                <a download='<?php echo $account["document"];?>' href='uploads/Documents/<?php echo $account['document'] ?>'>
                                                                Download
                                                                </a>
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
                                    <?php
                                        else:

                                            createAlert("No Results.");
                                        endif;
                                    ?>
                                </div>
                            </div>
                           </div>
                        </div>

           
            <!-- /.row -->
</div>
<script>
     $(document).ready(function() {
        $('#dataTables').DataTable({
                 "scrollY": true,
                "scrollX": true,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend:"csv",
                        text:"<span class='fa fa-download'></span> Download CSV "
                    }
                    ]
        });
    });
    </script>
<?php
	makeFoot();
?>