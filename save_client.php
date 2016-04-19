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
		if (empty($inputs['name'])){
			$errors.="Enter client name. <br/>";
		}
		if (empty($inputs['industry'])){
			$errors.="Enter industry. <br/>";
		}
		if (empty($inputs['address'])){
			$errors.="Enter address. <br/>";
		}
		if (empty($inputs['email_address'])){
			$errors.="Enter email address. <br/>";
		}
		if (empty($inputs['phone'])){
			$errors.="Enter phone number. <br/>";
		}
		if (empty($inputs['user'])){
			$errors.="Select user. <br/>";
		}
		if (empty($inputs['account_stat'])){
			$errors.="Enter account status. <br/>";
		}



		if($errors!=""){

			Alert("You have the following errors: <br/>".$errors,"danger");
			if(empty($inputs['id'])){
				redirect("frm_accounts.php");
			}
			else{
				redirect("frm_accounts.php?id=".urlencode($inputs['id']));
			}
			die;
		}
		else{
			//IF id exists update ELSE insert
			if(empty($inputs['id'])){
				//Insert
				$inputs=$_POST;
				
				$inputs['name']=$_POST['name'];
				unset($inputs['id']);

				date_default_timezone_set('Asia/Manila');
				$now = new DateTime();
				$inputs['date_modified']=$now->format('Y-m-d H:i:s a');
				$inputs['date_created']=$now->format('Y-m-d H:i:s a');
				$con->myQuery("INSERT INTO accounts(name,industry,address,email_address,phone,handler_id,account_status_id,date_modified,date_created) VALUES(:name,:industry,:address,:email_address,:phone,:user,:account_stat,:date_modified,:date_created)",$inputs);
					
					//$activity_input['admin_id']=$_SESSION[WEBAPP]['user']['id'];
					//$activity_input['user_id']=$_SESSION[WEBAPP]['user']['id'];
					//$activity_input['category_type_id']=2;
					//$activity_input['notes']="Quantity (".$inputs['quantity'].")";
					//$activity_input['item_id']=$con->lastInsertId();
				

				//$con->myQuery("INSERT INTO activities(admin_id,user_id,action,action_date,category_type_id,item_id,notes) VALUES(:admin_id,:user_id,'Consumable Created',NOW(),:category_type_id,:item_id,:notes)",$activity_input);
				Alert("Save successful","success");

			}
			else{
				//Update
				date_default_timezone_set('Asia/Manila');
				$now = new DateTime();
				$inputs['date_modified']=$now->format('Y-m-d H:i:s a');
				$con->myQuery("UPDATE accounts SET name=:name,industry=:industry,address=:address,email_address=:email_address,phone=:phone,handler_id=:user,account_status_id=:account_stat,date_modified=:date_modified WHERE id=:id",$inputs);
				Alert("Update successful","success");
			}

			
			redirect("all_clients.php");
		}
		die;
	}
	else{
		redirect('index.php');
		die();
	}
	redirect('index.php');
?>