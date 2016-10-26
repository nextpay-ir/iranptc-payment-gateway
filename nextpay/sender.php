<?php
	function send($order_id,$api,$amount,$redirect){
		$parameters = array
		(
			"api_key"=>$api,
			"order_id"=> $order_id,
			"amount"=> $amount,
			"callback_uri"=> $redirect,
		);

		$soap_client = new SoapClient("http://api.nextpay.org/gateway/token.wsdl", array('encoding' => 'UTF-8'));
		$result = $soap_client->TokenGenerator($parameters);
		$result = $result->TokenGeneratorResult;

		return $result;
	}
	function get($order_id, $api,$trans_id,$amount){
		$parameters = array
		(
			'api_key'   => $api,
			'order_id'  => $order_id,
			'trans_id'  => $trans_id,
			'amount'    => $amount
		);

		$soap_client = new SoapClient('http://api.nextpay.org/gateway/verify.wsdl', array('encoding' => 'UTF-8'));
		$res = $soap_client->PaymentVerification($parameters);
		$res = $res->PaymentVerificationResult;

		return $res;
	}
?>
