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
		
		

		if($errors!=""){

			Alert("Please fill in the following fields: <br/>".$errors,"danger");
			if(empty($inputs['id'])){
				redirect("frm_usertypes.php");
			}
			else{
				redirect("frm_usertypes.php?id=".urlencode($inputs['id']));
			}
			die;
		}
		else{
			//IF id exists update ELSE insert
			if(empty($inputs['id'])){
				//Insert
				$inputs=$_POST;
				
				//$inputs['name']=$_POST['name'];
				unset($inputs['id']);
				//$userid=$_SESSION[WEBAPP]['user']['id'];
				
				$con->myQuery("INSERT INTO locations(name) VALUES (:name)", $inputs);	
				
				
				Alert("Save succesful","success");
				

			}
			else{
				//Update
				//date_default_timezone_set('Asia/Manila');
				//$now = new DateTime();
				//$inputs['date_modified']=$now->format('Y-m-d H:i:s a');
				$inputs=$_POST;
				//$userid=$_SESSION[WEBAPP]['user']['id'];
				
				$con->myQuery("UPDATE locations SET name=:name WHERE id=:id",$inputs);
				
				Alert("Update successful","success");
				}
			
			redirect("settings.php");
		}
		die();
		
	}
	else{
		redirect('index.php');
		die();
	}
	redirect('index.php');
?>