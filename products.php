<?php
    require_once 'support/config.php';
    if(!isLoggedIn()){
        toLogin();
        die();
    }
    
    makeHead("Products");
?>
<div id='wrapper'>
<?php
     require_once 'template/navbar.php';
?>
</div>

<div id="page-wrapper">
            <div class='row'>
                <div class="col-lg-12">
                    <h1 class="page-header">List of Products</h1>
                </div>
                </br>                
                <div class='col-md-12'>
                    <div class='panel panel-default'>
                        <div class='panel-body'>
                            <div class='col-md-12'>
                                <?php
                                    if(AllowUser(array(1,2))):
                                ?>
                                <?php
                                Alert();
                                ?>
                                <a href='frm_products.php' class='btn btn-success pull-right'> <span class='fa fa-plus'></span> Create New</a>
                                <br/> <br/> <br/> 
                                <div class='dataTable_wrapper '>
                                    <table class='table responsive table-bordered table-condensed table-hover ' id='dataTables'>
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" name="select_prod" />
                                                </th>  
                                                <th>Product Name</th>
                                                <th>Unit Price</th>
                                                <th>Commission Rate</th>
                                                <th>Quantity</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $products=$con->myQuery("SELECT product_name,unit_price,commission_rate,qty_unit,id FROM vw_prod")->fetchAll(PDO::FETCH_ASSOC);
                                                foreach ($products as $row):
                                            ?>
                                                <tr>
                                                        <td>
                                                            <input type="checkbox" name="select_opp" value="<?php echo $opportunity["id"];?>" />
                                                        </td>
                                                        <?php
                                                            foreach ($row as $key => $value):                                                            
                                                        ?>                                                    
                                                        <?php
                                                            if($key=='id'):
                                                        ?>                                                                          
                                                            <td>
                                                                <a class='btn btn-sm btn-warning' href='frm_products.php?id=<?php echo $value;?>'><span class='fa fa-pencil'></span></a>
                                                                <a class='btn btn-sm btn-danger' href='delete.php?id=<?php echo $value?>&t=prod' onclick='return confirm("This product will be deleted.")'><span class='fa fa-trash'></span></a>
                                                            </td>
                                                        <?php
                                                            elseif($key=='product_name'):
                                                        ?> 
                                                            <td>
                                                                <a href='prod_details.php?id=<?= $row['id']?>'><?php echo htmlspecialchars($value)?></a>
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