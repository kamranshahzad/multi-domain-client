<?php
	require_once("../../devkit/init.php");
	
	
	$pageTitle  = $_POST['PageTitle'];
	$pageText 	= $_POST['ContentText'];
	
	$response = array();
	
	$tmpObject = new ContentsTmp();
	$tmpObject->setTmpContentText( $pageTitle, $pageText );
	$response['response'] = true;
	echo json_encode($response);