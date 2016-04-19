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
		
		if (empty($inputs['description'])){
			
		}


		if($errors!=""){

			Alert("Please fill in the following fields: <br/>".$errors,"danger");
			if(empty($inputs['id'])){
				redirect("frm_documents.php");
			}
			else{
				redirect("frm_documents.php?id=".urlencode($inputs['id']));
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
				$userid=$_SESSION[WEBAPP]['user']['id'];
				

				if(0 == filesize($_FILES['file']['tmp_name'])){
					$name="Default.jpg";
				}
				else{
				$file_id=$_POST['opp_id']. "_" . "Document" . "_" . (new \DateTime())->format('Y-m-d-H-i-s');

				$name=$file_id.getFileExtension($_FILES['file']['name']);
				//$tmp_name = $_FILES['file']['tmp_name'];
				
				move_uploaded_file($_FILES['file']['tmp_name'],"uploads/Documents/".$name);
				}
				// var_dump($inputs);
				// die;

				$con->myQuery("INSERT INTO documents(title,opp_id, user_name, date_uploaded, description, document) VALUES (:title,:opp_id, '$userid', NOW(),:description, '$name')", $inputs);	
				
				//$file_id=$con->lastInsertId();
				//$filename=$file_id.getFileExtension($_FILES['file']);
				//move_uploaded_file($_FILES['file']['tmp_name'],"uploads/".$filename);
				//$con->myQuery("UPDATE contacts SET profile_pic=? WHERE id=?",array($filename,$file_id));
					//$activity_input['admin_id']=$_SESSION[WEBAPP]['user']['id'];
					//$activity_input['user_id']=$_SESSION[WEBAPP]['user']['id'];
					//$activity_input['category_type_id']=2;
					//$activity_input['notes']="Quantity (".$inputs['quantity'].")";
					//$activity_input['item_id']=$con->lastInsertId();
				

				//$con->myQuery("INSERT INTO activities(admin_id,user_id,action,action_date,category_type_id,item_id,notes) VALUES(:admin_id,:user_id,'Consumable Created',NOW(),:category_type_id,:item_id,:notes)",$activity_input);
				
				
				$testing = error_reporting(E_ALL);
				Alert("Save successful","success");
				

			}
			else{
				//Update
				//date_default_timezone_set('Asia/Manila');
				//$now = new DateTime();
				//$inputs['date_modified']=$now->format('Y-m-d H:i:s a');
				$inputs=$_POST;
				$userid=$_SESSION[WEBAPP]['user']['id'];

				date_default_timezone_set('Asia/Manila');
				$now = new DateTime();
				$inputs['date_modified']=$now->format('Y-m-d H:i:s a');

				// var_dump($inputs);
				// die;
				

				if(0 == filesize($_FILES['file']['tmp_name'])){					
					
					$con->myQuery("UPDATE documents SET title=:title, opp_id=:opp_id, description=:description, date_modified=:date_modified WHERE id=:id",$inputs);
				
					Alert("Update successful","success");
				}
				else{
				$file_id=$_POST['opportunity_name']. "_" . "Document" . "_" . (new \DateTime())->format('Y-m-d-H-i-s');

				$name=$file_id.getFileExtension($_FILES['file']['name']);
				//$tmp_name = $_FILES['file']['tmp_name'];
				
				move_uploaded_file($_FILES['file']['tmp_name'],"uploads/Documents/".$name);

				$con->myQuery("UPDATE documents SET title=:title, opp_id=:opp_id, description=:description, date_uploaded=:date_modified, document='$name' WHERE id=:id",$inputs);
				
				Alert("Update successful","success");
				}
					
				
			}

			
			redirect("documents.php");
		}
		die;
	}
	else{
		redirect('index.php');
		die();
	}
	redirect('index.php');
?>