<?php
	require_once 'support/config.php';
	
	if(!isLoggedIn()){
		toLogin();
		die();
	}


	if(!empty($_POST)){
		//Validate form inputs
		$inputs=$_POST;

		if(empty($_POST['account_id']) || !is_numeric($_POST['account_id'])){
			Modal("Invalid Account Selected");
			redirect("all_clients.php");
			die;
		}
		$errors="";
		if (empty($_POST['title'])){
			$errors.="Enter a title. <br/>";
		}
		if (empty($_POST['message'])){
			$errors.="Enter a message. <br/>";
		}


		if($errors!=""){

			Alert("You have the following errors: <br/>".$errors,"danger");
			if(!empty($inputs['id'])){
				redirect("frm_posts.php?a_id={$inputs['account_id']}&id={$inputs['id']}");
			}
			else{
				redirect("posts.php?id={$inputs['account_id']}");
			}
			die;
		}
		else{
			// echo "<pre>";
			// print_r($_POST);
			// echo "</pre>";
			// die;
			//IF id exists update ELSE insert
			if(empty($inputs['id'])){
				//Insert
				$inputs=$_POST;
				unset($inputs['id']);
				$inputs['user_id']=$_SESSION[WEBAPP]['user']['id'];
				var_dump($inputs);
				//$inputs['name']=$_POST['name'];
				$con->myQuery("INSERT INTO posts(title,message,user_id,post_type,date_created,account_id) VALUES(:title,:message,:user_id,:post_type,NOW(),:account_id)",$inputs);
				Alert("Save successful","success");
			}
			else{				
				//Update
				$con->myQuery("UPDATE users SET user_type_id=:user_type_id,first_name=:name,middle_name=:middle_name,last_name=:last_name,username=:username,password=:password,email=:email,contact_no=:contact_no WHERE id=:id",$inputs);
				Alert("Update successful","success");
			}
			redirect("posts.php?id={$inputs['account_id']}");
		}
		die;
	}
	else{
		redirect('index.php');
		die();
	}
	redirect('index.php');
?>