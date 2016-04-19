<?php
require_once
'support/config.php';
	if(!isLoggedIn()){
		toLogin();
		die();
	}
	if(!AllowUser(array(1))){
        redirect("index.php");
    }
    if(!empty($_GET['id'])){
        $asset=$con->myQuery("SELECT id,user_type_id,first_name,middle_name,last_name,username,password,email,contact_no,employee_no,location_id,title,department_id from users WHERE id=?",array($_GET['id']))->fetch(PDO::FETCH_ASSOC);
        if(empty($asset)){
            //Alert("Invalid consumables selected.");
            Modal("Invalid user selected");
            redirect("users.php");
            die();
        }
    }
	makeHead("Product statuses");
?>
<div id='wrapper'>
<?php
     require_once 'template/navbar.php';
?>
</div>
<div id="page-wrapper">
	<div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Product Statuses form</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
    </div>
</div>