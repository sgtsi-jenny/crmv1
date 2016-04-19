<?php
	require_once 'support/config.php';
	
	if(!isLoggedIn()){
		toLogin();
		die();
	}
	if(!AllowUser(array(1,2))){
        redirect("index.php");
    }
	if(empty($_GET['id']) || empty($_GET['t'])){
		redirect('index.php');
		die;
	}
	else
	{
		//var_dump($_GET['opp_id']);
		//die;
		$table="";
		switch ($_GET['t']) {
			case 'oprod':
				$table="opp_products";
				$page="opp_products.php?id={$_GET['opp_id']}";
				break;
			default:
				# code...
				break;
		}
		$con->myQuery("UPDATE {$table} SET is_deleted=1 WHERE id=?",array($_GET['id']));
		Alert("Delete Successful.","success");
		redirect($page);

		die();

	}
?>