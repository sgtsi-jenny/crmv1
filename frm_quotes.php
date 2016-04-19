<?php
	require_once 'support/config.php';
	if(!isLoggedIn()){
		toLogin();
		die();
	}

    if(!AllowUser(array(1,2))){
        redirect("index.php");
    }
    if(!empty($_GET['id'])){
        $account=$con->myQuery("SELECT document, opportunity_name, description, title, id FROM quotes WHERE id=?",array($_GET['id']))->fetch(PDO::FETCH_ASSOC);
        $opp_value=$con->myQuery("SELECT id, opp_name FROM opportunities WHERE id=?",array($account['opportunity_name']))->fetch(PDO::FETCH_ASSOC);
        if(empty($account)){
            //Alert("Invalid asset selected.");
            Modal("Invalid Account Selected");
            redirect("quotes.php");
            die();
        }
    }

    $opp=$con->myQuery("SELECT id,opp_name FROM opportunities where is_deleted=0")->fetchAll(PDO::FETCH_ASSOC);
                    						
	makeHead("Quotes");
?>
<div id='wrapper'>
<?php
	 require_once 'template/navbar.php';
?>
</div>
<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Quotes Form</h1>
                </div>

                <!-- /.col-lg-12 -->;
            </div>
            <!-- /.row -->
            <div class="row">
                <div class='col-lg-12'>
                    <?php
                        Alert();
                    ?>    
                    <div class='row'>
                    	<div class='col-sm-12 col-md-8 col-md-offset-2'>
                    		<form class='form-horizontal' method='POST' enctype="multipart/form-data" action='save_quotes.php'>
                                <input type='hidden' name='id' value='<?php echo !empty($account)?$account['id']:""?>'>
                    			
                                <div class='form-group'>
                                    <label class='col-sm-12 col-md-3 control-label'> Document Upload</label>
                                    <div class='col-sm-12 col-md-9'>
                                        <a download='<?php echo $account["document"];?>' href='uploads/Documents/<?php echo $account['document'] ?>'>
                                                                <?php echo !empty($account)?$account['document']:"" ?>
                                                                </a>
                                       
                                    </div>
                                </div>

                               <div class='form-group'>
                                    <!-- <label class='col-sm-12 col-md-3 control-label'> Title *</label> -->
                                    <div class='col-sm-12 col-md-9  col-md-offset-3'>
                                         <input type='file' class='form-control' name='file' <?php echo !empty($account['id'])?"":'required=""'?>>
                                    </div>
                                </div>

                                <div class='form-group'>
                                    <label class='col-sm-12 col-md-3 control-label'> Title*</label>
                                    <div class='col-sm-12 col-md-9'>
                                        <input type='text' class='form-control' placeholder='Enter Middle Name' name='title' value='<?php echo !empty($account)?$account['title']:"" ?>'>
                                    </div>
                                </div>

                                <div class='form-group'>
                                    <label class='col-sm-12 col-md-3 control-label'> Opportunity Name</label>
                                    <div class='col-sm-12 col-md-9'>
                                        
                                        <select class='form-control' name='opportunity_name' data-placeholder="Select opportunity" <?php echo!(empty($opp))?"data-selected='".$opp['id']."'":NULL ?>>
                                                    <option value='<?php echo !empty($account)?$account['opportunity_name']:""?>'><?php echo !empty($opp_value)?$opp_value['opp_name']:""?></option>
                                                    <?php
                                                        echo makeOptions($opp);
                                                    ?>
                                        </select>
                                    </div>
                                </div>

                               <div class='form-group'>
                                    <label class='col-sm-12 col-md-3 control-label'> Description</label>
                                    <div class='col-sm-12 col-md-9'>
                                        <textarea class='form-control' name='description' placeholder="Write a short description."><?php echo !empty($account)?$account['description']:"" ?></textarea>
                                    </div>
                                </div>

                                <div class='form-group'>
                                    <div class='col-sm-12 col-md-9 col-md-offset-3 '>
                                        <a href='quotes.php' class='btn btn-default'>Cancel</a>
                                        <button type='submit' class='btn btn-success'> <span class='fa fa-check'></span> Save</button>
                                    </div>
                                    
                                </div>                    		
                    		</form>
                    	</div>
                    </div>

                </div>
            </div>
            <!-- /.row -->
</div>
<?php
Modal();
?>
<?php
	makeFoot();
?>