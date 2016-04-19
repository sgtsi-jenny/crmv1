<?php
	require_once 'support/config.php';
	if(!isLoggedIn()){
		toLogin();
		die();
	}
	makeHead("Documents"); 
?>
<div id='wrapper'>
<?php
	 require_once 'template/navbar.php';
?>
</div>

<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Documents</h1>
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
                        <div class='col-sm-12'>
                                <a href='frm_documents.php' class='btn btn-success pull-right'> <span class='fa fa-plus'></span> Create New</a>
                        </div>
                        <br/> <br/> 
                        <div class='panel panel-default'>
                          <div class='panel-body ' >
                            <div class='dataTable_wrapper '>
                                <div class='col-md-12'>
                                    <table class='table table-bordered table-condensed ' id='dataTables'>
                                        <thead>

                                            <tr>  
                                                <th style="max-width: 5px"></th>  
                                                <th>Title</th>
                                                <th>Description</th>
                                                <th>Opportunity Name</th>
                                                <th>Assigned To</th>
                                                <th>Date Uploaded</th>
                                                <th>Document</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $accounts=$con->myQuery("SELECT title, documents.description,opportunities.opp_name, opp_id, CONCAT(users.last_name, ', ', users.first_name) As uname, user_name, date_uploaded, document, documents.id FROM documents inner join opportunities on documents.opp_id=opportunities.id inner join users on documents.user_name=users.id where documents.is_deleted=0")->fetchAll(PDO::FETCH_ASSOC);

                                                        foreach ($accounts as $account):
                                            ?>
                                                    <tr>
                                                        <td align="center">
                                                            <input type="checkbox" name="select_account" value="<?php echo $account["id"];?>" />
                                                        </td>
                                                        <?php
                                                            foreach ($account as $key => $value):
                                                            if($key=='id'):
                                                        ?>                   
                                                                                                                                         
                                                            <td>
                                                                <a class='btn btn-sm btn-warning' href='frm_documents.php?id=<?php echo $value;?>'><span class='fa fa-pencil'></span></a>
                                                                
                                                                <a class='btn btn-sm btn-danger' href='delete.php?id=<?php echo $value?>&t=do' onclick='return confirm("This record will be deleted.")'><span class='fa fa-trash'></span></a>
                                                            </td>
                                                            <?php
                                                                elseif($key=='opp_id'):
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
                "scrollX": true
        });
    });
    </script>
<?php
	makeFoot();
?>