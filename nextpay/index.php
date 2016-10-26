<?php session_start();

	require_once($_SERVER["DOCUMENT_ROOT"].'/includes/php/funkcje.inc.php');
	_DB_CONNECT();

 ?>
<?php
if($_SERVER['REQUEST_METHOD']=="POST"){
	if($_POST['apx_amount'] >= 1000){
		require_once("sender.php");
		
        $api_key = 'Your-Api_key';
		$amount = $_POST['apx_amount'];
		$order_id = time();
		$invoiceDate = date("Y/m/d H:i:s");
        $redirect = urlencode("http://".$_SERVER["SERVER_NAME"]."/nextpay/getresult.php?dates=".$invoiceDate);
		$_SESSION['invodat'] = $invoiceDate;
		$_SESSION['invoprice'] = $_POST['apx_amount']/10;
		$_SESSION['apuser'] = $_POST['apx_user'];
        $result = send($order_id, $api_key,$amount,$redirect);
        if(intval($result->code) == -1 ){
            $go = "http://api.nextpay.org/gateway/payment/" . $result->trans_id;
            $_SESSION['invonum'] = $result->trans_id;
            header("Location: $go");
        }else{
        	echo'ERR: '.$result->code;
            die();
        }

	?>
		<?php }}
	else die(); ?>
