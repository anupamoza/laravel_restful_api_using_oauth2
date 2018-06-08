<?php

function pr($arr = []) {
	echo "<pre>";
	print_r($arr);
	echo "</pre>";
}

function jsonResponse($status, $data=array()) {
	$response['status'] = $status;
	$response['data'] = $data;
	return json_encode($response);
}
