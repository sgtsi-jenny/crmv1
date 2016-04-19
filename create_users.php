<?php
	require_once 'support/config.php';
	
	if(!isLoggedIn()){
		toLogin();
		die();
	}
if(!AllowUser(array(1))){
        redirect("index.php");
    }
	if(!empty($_POST)){
		//Validate form inputs
		$inputs=$_POST;

		$errors="";
		if (empty($_POST['user_type_id'])){
			$errors.="Select user type. <br/>";
		}
		if (empty($_POST['first_name'])){
			$errors.="Enter first name. <br/>";
		}
		if (empty($_POST['middle_name'])){
			$errors.="Enter middle name. <br/>";
		}
		if (empty($_POST['last_name'])){
			$errors.="Enter last name. <br/>";
		}
		if (empty($_POST['username'])){
			$errors.="Enter username. <br/>";
		}
		if (empty($_POST['password'])){
			$errors.="Enter password. <br/>";	
		}
		if (empty($_POST['email'])){
			$errors.="Enter email address. <br/>";
		}
		if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
     		$errors.="Enter a valid email address. <br/>";
		}

		if($errors!=""){

			Alert("You have the following errors: <br/>".$errors,"danger");
			redirect("frm_users.php");
			die;
		}
		else{
			//IF id exists update ELSE insert
			if(empty($inputs['id'])){
				//Insert
				$inputs=$_POST;
				unset($inputs['id']);
				//$inputs['name']=$_POST['name'];
				$uname=$inputs['username'];
				$results=$con->myQuery("if EXISTS(select username from users where username='$uname') THEN
				select false as result;
				else
				INSERT INTO users(user_type_id,first_name,middle_name,last_name,username, password,email,contact_no) VALUES(:user_type_id,:first_name,:middle_name,:last_name,:username,:password, :email,:contact_no);
				select true as result;
				end IF;",$inputs)->fetch(PDO::FETCH_ASSOC);
				$resultString=$results['result'];

				if($resultString==1){
				Alert("Save succesful","success");
				//die($resultString);
				}
				else
				{
					Alert("Username already exists.","danger");
				}
			}
			else{				
				//Update
				// var_dump($inputs['id']);
				// die;
				//$con->myQuery("UPDATE users SET user_type_id=:user_type_id,first_name=:first_name,middle_name=:middle_name,last_name=:last_name,username=:username,password=:password,email=:email,contact_no=:contact_no WHERE id=:id",$inputs);
				$uname=$inputs['username'];
				$results=$con->myQuery("if EXISTS(select username from users where username='$uname') THEN
				select false as result;
				else
					UPDATE users SET user_type_id=:user_type_id,first_name=:first_name,middle_name=:middle_name,last_name=:last_name,username=:username,password=:password,email=:email,contact_no=:contact_no WHERE id=:id;
				select true as result;
				end IF;",$inputs)->fetch(PDO::FETCH_ASSOC);
				if($resultString==1){
				Alert("Update succesful","success");
				//die($resultString);
				}
				else
				{
					Alert("Username already exists.","danger");
				}


				//Alert("Update successful","success");
			}

			redirect("frm_users.php"."?id={$inputs['id']}");
		}
		die;
	}
	else{
		redirect('index.php');
		die();
	}
	redirect('index.php');
?>