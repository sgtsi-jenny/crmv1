<?php
    require_once 'support/config.php';
    if(!isLoggedIn()){
        toLogin();
        die();
    }
    if(!AllowUser(array(1))){
        redirect("index.php");
    }
    makeHead("Settings");
?>
<div id='wrapper'>
<?php
     require_once 'template/navbar.php';
?>
</div>

<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Settings</h1>
                </div>

                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
             <?php
                        Alert();
                    ?>
                <div class="col-lg-3 col-md-6">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <i class="fa fa-barcode fa-5x"></i>
                                            </div>
                                            <div class="col-xs-9 text-right">
                                                <div class="huge"><?php echo $con->myQuery("SELECT COUNT(id) FROM user_types where is_deleted=0")->fetchColumn();?></div>
                                                <div>User Types</div>
                                            </div>
                                        </div>
                                    </div>
                                            <a href="#">
                                            <div class="panel-footer" href="#managerUsers" data-toggle="collapse">
                                            <span class="pull-left">View Details</span>
                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                <div class="col-lg-3 col-md-6">
                                <div class="panel panel-green">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <i class="fa fa-barcode fa-5x"></i>
                                            </div>
                                            <div class="col-xs-9 text-right">
                                                <div class="huge"><?php echo $con->myQuery("SELECT COUNT(id) FROM opp_statuses where is_deleted=0")->fetchColumn();?></div>
                                                <div>Sales Stages</div>
                                            </div>
                                        </div>
                                    </div>
                                            <a href="#">
                                            <div class="panel-footer" href="#accountStatus" data-toggle="collapse">
                                            <span class="pull-left" >View Details</span>
                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                <div class="col-lg-3 col-md-6">
                                <div class="panel panel-yellow">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <i class="fa fa-barcode fa-5x"></i>
                                            </div>
                                            <div class="col-xs-9 text-right">
                                                <div class="huge"><?php echo $con->myQuery("SELECT COUNT(id) FROM locations where is_deleted=0")->fetchColumn();?></div>
                                                <div>Locations</div>
                                            </div>
                                        </div>
                                    </div>
                                            <a href="#">
                                            <div class="panel-footer" href="#locations" data-toggle="collapse">
                                            <span class="pull-left">View Details</span>
                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                <div class="col-lg-3 col-md-6">
                                <div class="panel panel-red ">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <i class="fa fa-barcode fa-5x"></i>
                                            </div>
                                            <div class="col-xs-9 text-right">
                                                <div class="huge"><?php echo $con->myQuery("SELECT COUNT(id) FROM org_ratings where is_deleted=0")->fetchColumn();?></div>
                                                <div>Ratings</div>
                                            </div>
                                        </div>
                                    </div>
                                            <a href="#">
                                            <div class="panel-footer" href="#ratings" data-toggle="collapse">
                                            <span class="pull-left" >View Details</span>
                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                <div class="col-lg-3 col-md-6">
                                <div class="panel panel-primary ">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <i class="fa fa-barcode fa-5x"></i>
                                            </div>
                                            <div class="col-xs-9 text-right">
                                                <div class="huge"><?php echo $con->myQuery("SELECT COUNT(id) FROM departments where is_deleted=0")->fetchColumn();?></div>
                                                <div>Departments</div>
                                            </div>
                                        </div>
                                    </div>
                                            <a href="#">
                                            <div class="panel-footer" href="#departments" data-toggle="collapse">
                                            <span class="pull-left" >View Details</span>
                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                <div class="col-lg-3 col-md-6">
                                <div class="panel panel-green">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <i class="fa fa-barcode fa-5x"></i>
                                            </div>
                                            <div class="col-xs-9 text-right">
                                                <div class="huge"><?php echo $con->myQuery("SELECT COUNT(id) FROM org_types where is_deleted=0")->fetchColumn();?></div>
                                                <div>Organization Types</div>
                                            </div>
                                        </div>
                                    </div>
                                            <a href="#">
                                            <div class="panel-footer" href="#orgtypes" data-toggle="collapse">
                                            <span class="pull-left" >View Details</span>
                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                <div class="col-lg-3 col-md-6">
                                <div class="panel panel-yellow">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <i class="fa fa-barcode fa-5x"></i>
                                            </div>
                                            <div class="col-xs-9 text-right">
                                                <div class="huge"><?php echo $con->myQuery("SELECT COUNT(id) FROM opp_types where is_deleted=0")->fetchColumn();?></div>
                                                <div>Opportunity Types</div>
                                            </div>
                                        </div>
                                    </div>
                                            <a href="#">
                                            <div class="panel-footer" href="#opptypes" data-toggle="collapse">
                                            <span class="pull-left" >View Details</span>
                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                <div id='managerUsers' class="collapse">
                <div class='col-lg-12'>
                    
                    <div class='row'>
                        <div class='col-sm-12'>
                                <a href='frm_usertypes.php' class='btn btn-success pull-right'> <span class='fa fa-plus'></span> Create New</a>
                        </div>
                    </div>
                    <br/>    

                    <div class='panel panel-default'>
                        <div class='panel-body ' >
                            <div class='dataTable_wrapper'>
                                <table class='table responsive table-striped table-bordered table-condensed table-hover ' id='dataTables' width="100%">
                                <caption style="font-size: 25px">User Types</caption>
                                    <thead>
                                        <tr id='tableHeader1'>
                                            <th>Name</th>   
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $users=$con->myQuery("SELECT id, name FROM user_types WHERE is_deleted=0")->fetchAll(PDO::FETCH_ASSOC);

                                            foreach ($users as $user):
                                        ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($user['name'])?></td>
                                                <td>
                                                    <a class='btn btn-sm btn-warning' href='frm_usertypes.php?id=<?php echo $user['id'];?>'><span class='fa fa-pencil'></span></a>
                                                    <a class='btn btn-sm btn-danger' href='delete.php?id=<?php echo $user['id'];?>&t=ut' onclick='return confirm("This will be deleted.")'><span class='fa fa-trash'></span></a>
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
                <div id='accountStatus' class="collapse">
                <div class='col-lg-12'>
                   
                    <div class='row'>
                        <div class='col-sm-12'>
                                <a href='frm_oppstat.php' class='btn btn-success pull-right'> <span class='fa fa-plus'></span> Create New</a>
                        </div>
                    </div>
                    <br/>    

                    <div class='panel panel-default'>
                        
                        <div class='panel-body ' >
                            <div class='dataTable_wrapper '>
                                <table class='table responsive table-bordered table-condensed table-hover ' id='dataTables1'>
                                    <caption style="font-size: 25px">Sales Stages</caption>
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $users=$con->myQuery("SELECT name, id FROM opp_statuses WHERE is_deleted=0")->fetchAll(PDO::FETCH_ASSOC);

                                            foreach ($users as $user):
                                        ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($user['name'])?></td>
                                                <td>
                                                    <a class='btn btn-sm btn-warning' href='frm_oppstat.php?id=<?php echo $user['id'];?>'><span class='fa fa-pencil'></span></a>
                                                    <a class='btn btn-sm btn-danger' href='delete.php?id=<?php echo $user['id'];?>&t=os' onclick='return confirm("This will be deleted.")'><span class='fa fa-trash'></span></a>
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
                <div id='locations' class="collapse">
                <div class='col-lg-12'>
                   
                    <div class='row'>
                        <div class='col-sm-12'>
                                <a href='frm_locations.php' class='btn btn-success pull-right'> <span class='fa fa-plus'></span> Create New</a>
                        </div>
                    </div>
                    <br/>    

                    <div class='panel panel-default'>
                        
                        <div class='panel-body ' >
                            <div class='dataTable_wrapper '>
                                <table class='table responsive table-bordered table-condensed table-hover ' id='dataTables1'>
                                    <caption style="font-size: 25px">Locations</caption>
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $users=$con->myQuery("SELECT name, id FROM locations WHERE is_deleted=0")->fetchAll(PDO::FETCH_ASSOC);

                                            foreach ($users as $user):
                                        ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($user['name'])?></td>
                                                <td>
                                                    <a class='btn btn-sm btn-warning' href='frm_locations.php?id=<?php echo $user['id'];?>'><span class='fa fa-pencil'></span></a>
                                                    <a class='btn btn-sm btn-danger' href='delete.php?id=<?php echo $user['id'];?>&t=lo' onclick='return confirm("This will be deleted.")'><span class='fa fa-trash'></span></a>
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
                <div id='ratings' class="collapse">
                <div class='col-lg-12'>
                   
                    <div class='row'>
                        <div class='col-sm-12'>
                                <a href='frm_ratings.php' class='btn btn-success pull-right'> <span class='fa fa-plus'></span> Create New</a>
                        </div>
                    </div>
                    <br/>    

                    <div class='panel panel-default'>
                        
                        <div class='panel-body ' >
                            <div class='dataTable_wrapper '>
                                <table class='table responsive table-bordered table-condensed table-hover ' id='dataTables1'>
                                    <caption style="font-size: 25px">Ratings</caption>
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $users=$con->myQuery("SELECT name, id FROM org_ratings WHERE is_deleted=0")->fetchAll(PDO::FETCH_ASSOC);

                                            foreach ($users as $user):
                                        ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($user['name'])?></td>
                                                <td>
                                                    <a class='btn btn-sm btn-warning' href='frm_ratings.php?id=<?php echo $user['id'];?>'><span class='fa fa-pencil'></span></a>
                                                    <a class='btn btn-sm btn-danger' href='delete.php?id=<?php echo $user['id'];?>&t=ra' onclick='return confirm("This will be deleted.")'><span class='fa fa-trash'></span></a>
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
                <div id='departments' class="collapse">
                <div class='col-lg-12'>
                   
                    <div class='row'>
                        <div class='col-sm-12'>
                                <a href='frm_departments.php' class='btn btn-success pull-right'> <span class='fa fa-plus'></span> Create New</a>
                        </div>
                    </div>
                    <br/>    

                    <div class='panel panel-default'>
                        
                        <div class='panel-body ' >
                            <div class='dataTable_wrapper '>
                                <table class='table responsive table-bordered table-condensed table-hover ' id='dataTables1'>
                                    <caption style="font-size: 25px">Departments</caption>
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $users=$con->myQuery("SELECT name, id FROM departments WHERE is_deleted=0")->fetchAll(PDO::FETCH_ASSOC);

                                            foreach ($users as $user):
                                        ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($user['name'])?></td>
                                                <td>
                                                    <a class='btn btn-sm btn-warning' href='frm_departments.php?id=<?php echo $user['id'];?>'><span class='fa fa-pencil'></span></a>
                                                    <a class='btn btn-sm btn-danger' href='delete.php?id=<?php echo $user['id'];?>&t=dpmt' onclick='return confirm("This will be deleted.")'><span class='fa fa-trash'></span></a>
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
                <div id='orgtypes' class="collapse">
                <div class='col-lg-12'>
                   
                    <div class='row'>
                        <div class='col-sm-12'>
                                <a href='frm_orgtypes.php' class='btn btn-success pull-right'> <span class='fa fa-plus'></span> Create New</a>
                        </div>
                    </div>
                    <br/>    

                    <div class='panel panel-default'>
                        
                        <div class='panel-body ' >
                            <div class='dataTable_wrapper '>
                                <table class='table responsive table-bordered table-condensed table-hover ' id='dataTables1'>
                                    <caption style="font-size: 25px">Organization Types</caption>
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $users=$con->myQuery("SELECT name, id FROM org_types WHERE is_deleted=0")->fetchAll(PDO::FETCH_ASSOC);

                                            foreach ($users as $user):
                                        ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($user['name'])?></td>
                                                <td>
                                                    <a class='btn btn-sm btn-warning' href='frm_orgtypes.php?id=<?php echo $user['id'];?>'><span class='fa fa-pencil'></span></a>
                                                    <a class='btn btn-sm btn-danger' href='delete.php?id=<?php echo $user['id'];?>&t=orgt' onclick='return confirm("This will be deleted.")'><span class='fa fa-trash'></span></a>
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
                <div id='opptypes' class="collapse">
                <div class='col-lg-12'>
                   
                    <div class='row'>
                        <div class='col-sm-12'>
                                <a href='frm_opptypes.php' class='btn btn-success pull-right'> <span class='fa fa-plus'></span> Create New</a>
                        </div>
                    </div>
                    <br/>    

                    <div class='panel panel-default'>
                        
                        <div class='panel-body ' >
                            <div class='dataTable_wrapper '>
                                <table class='table responsive table-bordered table-condensed table-hover ' id='dataTables1'>
                                    <caption style="font-size: 25px">Opportunity Types</caption>
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $users=$con->myQuery("SELECT name, id FROM opp_types WHERE is_deleted=0")->fetchAll(PDO::FETCH_ASSOC);

                                            foreach ($users as $user):
                                        ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($user['name'])?></td>
                                                <td>
                                                    <a class='btn btn-sm btn-warning' href='frm_opptypes.php?id=<?php echo $user['id'];?>'><span class='fa fa-pencil'></span></a>
                                                    <a class='btn btn-sm btn-danger' href='delete.php?id=<?php echo $user['id'];?>&t=oppt' onclick='return confirm("This will be deleted.")'><span class='fa fa-trash'></span></a>
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
            </div>
            <!-- /.row -->
</div>
<script>
    $(document).ready(function() {
        $('#dataTables').DataTable({
            columns.adjust();
                 "scrollY": true,
                "scrollX": true,
        });
    });
    
    
    //$(document).ready(function() {
    //    $('#dataTables').DataTable().columns.adjust().draw();;
    //});
    $(document).ready(function() {
        $('#dataTables1').DataTable({
                 "scrollY": true,
                "scrollX": true
        });
    });
    //function resizeTable() 
    //{
    //    Alert("akjshdkjas", "danger");
    //document.getElementsByTagName('tableHeader1')[0].click();
    //}
    
    //jQuery('#dataTables').dataTable({  
    //    "bAutoWidth": false
    //});
    </script>
<?php
    makeFoot();
?>