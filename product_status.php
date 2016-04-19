<?php
require_once 'support/config.php';
	if(!isLoggedIn()){
		toLogin();
		die();
	}
	if(!AllowUser(array(1))){
        redirect("index.php");
    }
	makeHead("Product statuses");
?>

<div id='wrapper'>
<?php
	 require_once 'template/navbar.php';
?>
</div>
<div id='page-wrapper'>
	<div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Product statuses</h1>
        </div>
                <!-- /.col-lg-12 -->
    </div>
    <div class='row'>
    	<div class = 'row-lg-12'>
    		<?php
                Alert();
            ?>
            <div class='row'>
                <div class='col-sm-12'>
                        <a href='frm_product_status.php' class='btn btn-success pull-right'> <span class='fa fa-plus'></span> Create New</a>
                </div>
            </div>
            <br/>
            <div class='panel panel-default'>
            	<div class='panel-body'>
            		<div class='dataTable_wrapper'>
            			<table class='table responsive table-bordered table-condensed table-hover ' id='dataTables'>
            				<thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            	$prodStatuses = $con->myQuery("SELECT id,name FROM product_statuses WHERE is_deleted = 0")->fetchAll(PDO::FETCH_ASSOC);
                            	foreach ($prodStatuses as $product_status):
                            ?>
                        		<tr>
                        			<td><?php echo htmlspecialchars($product_status['id'])?></td>
                                    <td><?php echo htmlspecialchars($product_status['name'])?></td>
                                    <td>
                                    	<a class='btn btn-sm btn-warning' href='frm_product_status.php'><span class='fa fa-pencil'></span></a>
                                        <a class='btn btn-sm btn-danger' href='delete.php?id=<?php echo $product_status['id'];?>&t=ps' onclick='return confirm("This status will be deleted.")'><span class='fa fa-trash'></span></a>	
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
<script>
    $(document).ready(function() {
        $('#dataTables').DataTable({
                 "scrollY": true,
                "scrollX": true
        });
    });
    </script>
<?php
    Modal();
	makeFoot();
?>