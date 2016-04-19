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
		if (empty($inputs['product_name'])){
			$errors.="Enter product name. <br/>";
		}
		//if (empty($inputs['assigned_to'])){
		//	$errors.="Select user. <br/>";
		//}
		if (empty($inputs['unit_price'])){
			$errors.="Enter unit price. <br/>";
		}

		//var_dump($inputs);
		//die;

		if($errors!=""){

			Alert("You have the following errors: <br/>".$errors,"danger");
			if(empty($inputs['id'])){
				redirect("frm_products.php");
			}
			else{
				redirect("frm_products.php?id=".urlencode($inputs['id']));
			}
			die;
		}
		else{
			//IF id exists update ELSE insert
			if(empty($inputs['id'])){
				//Insert
				unset($inputs['id']);
				$prod_inputs['amount']=$inputs['unit_price'];
				$prod_inputs['qty']=$inputs['qty_unit'];
				$inputs['total_price']=$prod_inputs['amount'] * $prod_inputs['qty'];
				//var_dump($inputs);
				//die;
				$con->myQuery("INSERT INTO products(product_name,prod_code,assigned_to,unit_price,commission_rate,qty_unit,description,total_price) VALUES(:product_name,:prod_code,:assigned_to,:unit_price,:commission_rate,:qty_unit,:description,:total_price)",$inputs);
				//var_dump($inputs);
				//die;	


				Alert("Save successful","success");
				redirect("products.php");
			}
			else{
				//Update
				$prod_inputs['amount']=$inputs['unit_price'];
				$prod_inputs['qty']=$inputs['qty_unit'];
				$inputs['total_price']=$prod_inputs['amount'] * $prod_inputs['qty'];
				//var_dump($inputs);
				//die;
				$con->myQuery("UPDATE products SET product_name=:product_name,prod_code=:prod_code,assigned_to=:assigned_to,unit_price=:unit_price,commission_rate=:commission_rate,qty_unit=:qty_unit,description=:description,total_price=:total_price WHERE id=:id",$inputs);
				Alert("Update successful","success");
				redirect("products.php");
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