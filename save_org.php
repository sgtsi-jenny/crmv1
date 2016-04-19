<?php
	require_once 'support/config.php';
	
	if(!isLoggedIn()){
		toLogin();
		die();
	}

	if(!AllowUser(array(1,2))){
		redirect("index.php");
	}

	if(!empty($_POST)){
		//Validate form inputs
		$inputs=$_POST;

		$errors="";
		// if (empty($inputs['org_name'])){
		// 	$errors.="Enter organization name. <br/>";
		// }
		// if (empty($inputs['assigned_to'])){
		// 	$errors.="Select user. <br/>";
		// }

		
		if($errors!=""){

			Alert("You have the following errors: <br/>".$errors,"danger");
			if(empty($inputs['id'])){
				redirect("frm_organizations.php");
			}
			else{
				redirect("frm_organizations.php?id=".urlencode($inputs['id']));
			}
			die;
		}
		else{
			//IF id exists update ELSE insert
			if(empty($inputs['id'])){
				//Insert
				unset($inputs['id']);

				date_default_timezone_set('Asia/Manila');
				$now = new DateTime();
				$inputs['date_modified']=$now->format('Y-m-d H:i:s a');
				$inputs['date_created']=$now->format('Y-m-d H:i:s a');
				// var_dump($inputs);
				var_dump("ADD");
				die;
				$con->myQuery("INSERT INTO organizations (org_name,reg_name,trade_name,tin_num,tel_num,phone_num,email,address,industry,rating,contact_id,org_type,annual_revenue,assigned_to,description,date_created,date_modified) VALUES(:corp_name,:reg_name,:trade_name,:tin_num,:tel_num,:phone_num,:email,:address,:industry,:rating,:contact_id,:org_type,:annual_revenue,:assigned_to,:description,:date_created,:date_modified)",$inputs);				

				Alert("Save successful","success");
				redirect("organizations.php");
			}
			else{
				//Update
				// var_dump($inputs);
				// //var_dump("UPDATE");
				// die;
				date_default_timezone_set('Asia/Manila');
				$now = new DateTime();
				$inputs['date_modified']=$now->format('Y-m-d H:i:s a');
				$con->myQuery("UPDATE organizations SET org_name=:corp_name,reg_name=:reg_name,trade_name=:trade_name,tin_num=:tin_num,tel_num=:tel_num,phone_num=:phone_num,email=:email,address=:address,industry=:industry,rating=:rating,contact_id=:contact_id,org_type=:org_type,annual_revenue=:annual_revenue,assigned_to=:assigned_to,description=:description,date_modified=:date_modified WHERE id=:id",$inputs);
				Alert("Update successful","success");
				redirect("organizations.php");
			}
			
		}
		die;
	}
	else{
		redirect('index.php');
		die();
	}
	redirect('index.php');
?>