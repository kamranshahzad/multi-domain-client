<?php
	require_once("../../devkit/init.php");
	
	
	$pagename 		= $_POST['Pagename'];
	$menuarray 		= $_POST['MenuArray'];
	$menuid 		= $_POST['MenuID'];
	$cid 			= $_POST['CID'];
	
	$outputArray 	= array();
	$contentObject 	= new Contents();
	$contentObject->SaveContentPlacement( $pagename, $menuarray , $menuid , $cid );
	$outputArray['response'] = TRUE;
	
	echo json_encode($outputArray);
	