<?php

	session_start();
	define("WEBAPP", 'Customer Relationship Management');
	//$_SESSION[WEBAPP]=array();
	function __autoload($class)
	{
		require_once 'class.'.$class.'.php';
	}
	function redirect($url)
	{
		header("location:".$url);
	}
	function getFileExtension($filename){
		return substr($filename, strrpos($filename,"."));
	}
// ENCRYPTOR
	function encryptIt( $q ) {
	    $cryptKey  = 'JPB0rGtIn5UB1xG03efyCp';
	    $qEncoded      = base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), $q, MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ) );
	    return( $qEncoded );
	}
	function decryptIt( $q ) {
	    $cryptKey  = 'JPB0rGtIn5UB1xG03efyCp';
	    $qDecoded      = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), base64_decode( $q ), MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ), "\0");
	    return( $qDecoded );
	}
//End Encryptor
/* User FUNCTIONS */
	function isLoggedIn()
	{
		if(empty($_SESSION[WEBAPP]['user']))
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	function toLogin($url=NULL)
	{
		if(empty($url))
		{
			Alert('Please Log in to Continue');
			header("location: frmlogin.php");
		}
		else{
			header("location: ".$url);
		}
	}
	function Login($user)
	{
		$_SESSION[WEBAPP]['user']=$user;
	}
/* End User FUnctions */
//HTML Helpers
	function makeHead($pageTitle=WEBAPP,$level=0)
	{
		require_once str_repeat('../',$level).'template/head.php';
		unset($pageTitle);
	}
	function makeFoot($level=0)
	{
		require_once 'template/foot.php';
	}

	function makeOptions($array,$placeholder="",$checked_value=NULL){
		$options="";
		// if(!empty($placeholder)){
			$options.="<option value=''>{$placeholder}</option>";
		// }
		foreach ($array as $row) {
			list($value,$display) = array_values($row);
				if($checked_value!=NULL && $checked_value==$value){

					$options.="<option value='".htmlspecialchars($value)."' checked>".htmlspecialchars($display)."</option>";
				}
				else
				{
					$options.="<option value='".htmlspecialchars($value)."'>".htmlspecialchars($display)."</option>";
				}
		}
		return $options;
	}
//END HTML Helpers
/* BOOTSTRAP Helpers */
	function Modal($content=NULL,$title="Alert")
	{
		if(!empty($content))
		{
			$_SESSION[WEBAPP]['Modal']=array("Content"=>$content,"Title"=>$title);
		}
		else
		{
			if(!empty($_SESSION[WEBAPP]['Modal']))
			{
				include_once 'template/modal.php';
				unset($_SESSION[WEBAPP]['Modal']);
			}
		}
	}
	function Alert($content=NULL,$type="info")
	{
		if(!empty($content))
		{
			$_SESSION[WEBAPP]['Alert']=array("Content"=>$content,"Type"=>$type);
		}
		else
		{
			if(!empty($_SESSION[WEBAPP]['Alert']))
			{
				include_once 'template/alert.php';
				unset($_SESSION[WEBAPP]['Alert']);
			}
		}
	}
	function createAlert($content='',$type='info')
	{
		echo "<div class='alert alert-{$type}' role='alert'>{$content}</div>";
	}
/* End BOOTSTRAP Helpers */

/* SPECIFIC TO WEBAPP */

function AllowUser($user_type_id){
	if(array_search($_SESSION[WEBAPP]['user']['user_type'], $user_type_id)!==FALSE){
		return true;
	}
	return false;
}

function post_type($type){
	switch ($type) {
		case '1':
			
			return "panel-default";
			break;
		case '2':
			return "panel-yellow";
			break;
		case '3':
			return "panel-red";
			break;
		
		default:
			return "panel-default";
			break;
	}
}

/* END SPECIFIC TO WEBAPP */
	$con=new myPDO('customer_relation_management','root','');
	//$con=new PDO("mysql:host=localhost;dbname=customer_relation_management",'root','')
?>