<?php
	require_once("../../devkit/init.php");
	
	
	$pageheading 		= $_POST['PageHeading'];
	$pagetext 			= $_POST['PageText'];
	$menuid 			= $_POST['MenuID'];
	$cid 				= $_POST['CID'];
	
	
	$outputArray 	= array();
	$contentObject 	= new Contents();
	$contentObject->SaveContentText( $pageheading, $pagetext , $menuid , $cid );
	$outputArray['response'] = TRUE;
	
	echo json_encode($outputArray);
	