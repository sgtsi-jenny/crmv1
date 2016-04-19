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
		
				// var_dump($inputs);
				// die;
		$errors="";
		
		if (empty($inputs['description'])){
			
		}


		if($errors!=""){

			Alert("Please fill in the following fields: <br/>".$errors,"danger");
			if(empty($inputs['id'])){
				redirect("frm_quotes.php");
			}
			else{
				redirect("frm_quotes.php?id=".urlencode($inputs['id']));
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
				$opp_id=$_POST['opportunity_name'];
				$item=$_POST['id'];
				$page="quotes";

				if(0 == filesize($_FILES['file']['tmp_name'])){
					$name="Default.jpg";
				}
				else
				{
					$allowed =  array('doc', 'docx', 'xls', 'xlsx', 'xlsx');
					$filename = $_FILES['file']['name'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);
					if(!in_array($ext,$allowed) ) 
					{
    					Alert("Invalid file type.","danger");
    					redirect("frm_quotes.php");
    					die();
					}

					$file_id=$_POST['opportunity_name']. "_" . "Quotation" . "_" . (new \DateTime())->format('Y-m-d-H-i-s');

					$name=$file_id.getFileExtension($_FILES['file']['name']);
					//$tmp_name = $_FILES['file']['tmp_name'];
				
					move_uploaded_file($_FILES['file']['tmp_name'],"uploads/Documents/".$name);
				}
				
				$con->myQuery("INSERT INTO quotes(title,opportunity_name, user_name, date_uploaded, description, document) VALUES (:title,:opportunity_name, '$userid', NOW(),:description, '$name')", $inputs);	
				$notes="Updated quote id ".$item." details."; 
					$con->myQuery("INSERT INTO activities(opp_id, user_id, notes, page, item, action_date) VALUES ('$opp_id', '$userid', '$notes', '$page', '$item', NOW())", $inputs);
				//die();
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
				$opp_id=$_POST['opportunity_name'];
				$item=$_POST['id'];
				$page="quotes";

				if(0 == filesize($_FILES['file']['tmp_name'])){
					
					
					$con->myQuery("UPDATE quotes SET opportunity_name=:opportunity_name, description=:description, title=:title, date_uploaded=NOW()WHERE id=:id",$inputs);
					$notes="Updated quote id ".$item." details."; 
					$con->myQuery("INSERT INTO activities(opp_id, user_id, notes, page, item, action_date) VALUES ('$opp_id', '$userid', '$notes', '$page', '$item', NOW())", $inputs);
					
					Alert("Update successful","success");
				}
				else{

					$allowed =  array('doc', 'docx', 'xls', 'xlsx', 'xlsx');
					$filename = $_FILES['file']['name'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);
					if(!in_array($ext,$allowed) ) 
					{
    					Alert("Invalid file type.","danger");
    					redirect("quotes.php");
    					die();
					}

				$file_id=$_POST['opportunity_name']. "_" . "Quotation" . "_" . (new \DateTime())->format('Y-m-d-H-i-s');

				$name=$file_id.getFileExtension($_FILES['file']['name']);
				//$tmp_name = $_FILES['file']['tmp_name'];
				
				move_uploaded_file($_FILES['file']['tmp_name'],"uploads/Documents/".$name);

				$con->myQuery("UPDATE quotes SET opportunity_name=:opportunity_name, description=:description, title=:title, date_uploaded=NOW(), document='$name' WHERE id=:id",$inputs);
				$notes="Updated quote id ".$_POST['id']." file."; 
				$con->myQuery("INSERT INTO activities(opp_id, user_id, notes, action_date) VALUES ('$opp_id', '$userid', '$notes', NOW())", $inputs);
				Alert("Update successful","success");
				}
					
				
			}

			
			redirect("quotes.php");
		}
		die;
	}
	else{
		redirect('index.php');
		die();
	}
	redirect('index.php');
?>