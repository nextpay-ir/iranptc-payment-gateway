<?php session_start();

require_once($_SERVER["DOCUMENT_ROOT"].'/includes/php/funkcje.inc.php');
_DB_CONNECT();

include_once("sender.php");
$api_key = 'Your-api_key';
$trans_id = $_POST['trans_id'];
$order_id = $_POST['order_id'];
$result = get($order_id, $api_key,$trans_id,$amount);

if($result == 0){
	$invon = $_SESSION['invonum'];
	$invod = $_SESSION['invodat'];
	$price = $_SESSION['invoprice'];
	$user = $_SESSION['apuser'];
	$TIME = time();
	if($invon == $trans_id){
		unset($_SESSION['invonum']);
		unset($_SESSION['invodat']);
		unset($_SESSION['invoprice']);
		$state = $array["resultObj"]["result"];
		$act= $array["resultObj"]["action"];
		if($result == 0 && ($_GET['dates'] == $invod)){
			$trans_id = 'Order_id :'.$order_id.'<br>Transaction ID:'.$trans_id;
			mysql_query("UPDATE `xeon_users` SET `b_rent` = `b_rent` + '$price', `s_invest` = `s_invest` + '$price' WHERE `x_username` = '$user';");
			mysql_query("INSERT INTO `xeon_users_history` (`id`,`user`,`date`,`type`,`value`) VALUES (NULL,'$user','$TIME','6','$price');");
			mysql_query("INSERT INTO `xeon_users_transactions` (`id`,`au`,`date`,`username`,`ammount`,`status`) VALUES (NULL,'$trans_id','$TIME','$user','$price','1');");
			Header('Location: http://'.$_SERVER["SERVER_NAME"].'/?v=c&cc=order&status=success');
		}
		else {
			unset($_SESSION['invonum']);
			unset($_SESSION['invodat']);
			unset($_SESSION['invoprice']);
			Header('Location: http://'.$_SERVER["SERVER_NAME"].'/?v=c&cc=order&status=cancel');
		}
	}
	else{
		unset($_SESSION['invonum']);
		unset($_SESSION['invodat']);
		unset($_SESSION['invoprice']);
		Header('Location: http://'.$_SERVER["SERVER_NAME"].'/?v=c&cc=order&status=cancel');
	}

} else {
	unset($_SESSION['invonum']);
	unset($_SESSION['invodat']);
	unset($_SESSION['invoprice']);
	Header('Location: http://'.$_SERVER["SERVER_NAME"].'/?v=c&cc=order&status=cancel');

}

?>

