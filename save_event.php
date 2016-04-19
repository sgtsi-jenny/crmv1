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
		if (empty($inputs['subject'])){
			$errors.="Enter opportunity name. <br/>";
		}
		if (empty($inputs['start_date'])){
			$errors.="Provide starting date. <br/>";
		}
		if (empty($inputs['end_date'])){
			$errors.="Provide ending date. <br/>";
		}
		if (empty($inputs['start_time'])){
			$errors.="Provide starting time. <br/>";
		}
		if (empty($inputs['end_time'])){
			$errors.="Provide ending time. <br/>";
		}

		if (empty($inputs['status'])){
			$errors.="Select Status. <br/>";
		}
		if (empty($inputs['type'])){
			$errors.="Select activity type. <br/>";
		}


		//var_dump($inputs);
		//die;

		if($errors!=""){

			Alert("You have the following errors: <br/>".$errors,"danger");
			if(empty($inputs['id'])){
				redirect("frm_event.php");
			}
			else{
				redirect("frm_event.php?id=".urlencode($inputs['id']));
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

				//$inputs['date_modified']=$now->format('Y-m-d H:i:s a');
				$inputs['date_created']=$now->format('Y-m-d H:i:s a');
				$inputs['sdate']=$inputs['start_date'].' '.$inputs['start_time'].':00';
				$inputs['edate']=$inputs['end_date'].' '.$inputs['end_time'].':00';
				$inputs['allDay']='false';
				// var_dump($inputs);
				// die;
				unset($inputs['start_date']);
				unset($inputs['start_time']);
				unset($inputs['end_date']);
				unset($inputs['end_time']);
				//var_dump($inputs['sdate']);
				//var_dump($inputs['edate']);
				var_dump($inputs);
				//die;
				$con->myQuery("INSERT INTO events(subject,assigned_to,start_date,end_date,event_stat,activity_type,location_id,priority,description,date_created,allDay) VALUES(:subject,:assigned_to,:sdate,:edate,:status,:type,:location,:priority,:description,:date_created,:allDay)",$inputs);								

				Alert("Save successful","success");
				redirect("events.php");
			}
			else{
				//Update
				date_default_timezone_set('Asia/Manila');
				$now = new DateTime();
				$inputs['date_modified']=$now->format('Y-m-d H:i:s a');
				$inputs['sdate']=$inputs['start_date'].' '.$inputs['start_time'].':00';
				$inputs['edate']=$inputs['end_date'].' '.$inputs['end_time'].':00';
				unset($inputs['start_date']);
				unset($inputs['start_time']);
				unset($inputs['end_date']);
				unset($inputs['end_time']);
				// var_dump($inputs);
				// die;

				$con->myQuery("UPDATE events SET subject=:subject,assigned_to=:assigned_to,start_date=:sdate,end_date=:edate,event_stat=:status,activity_type=:type,location_id=:location,priority=:priority,description=:description,date_modified=:date_modified WHERE id=:id",$inputs);
				Alert("Update successful","success");
				redirect("events.php");
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