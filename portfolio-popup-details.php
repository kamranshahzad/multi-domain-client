<?php
	
	require_once("devkit/init.php");
	$boot 		= new bootstrap();
	$asset 		=  $boot->siteimg;
	$baseURL 	=  $boot->basepath;
	$portObject = new Portfolio();
	
	
	$portfolioId = 0;
	$portfolioItem = array();
	if(isset($_GET['pid'])){
		$portfolioId = 	$_GET['pid'];
		$portfolioItem = $portObject->fetchById($portfolioId);
	}
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<body style="width:800px; margin:0 auto; text-align:center;">

<div class="portfolioPopupContainer">
    <img src="media/portfolio/large/<?php  echo ArrayUtil::value('image',$portfolioItem);?>" class="round" alt="" />
    <p>
        <?php echo ArrayUtil::value('full_description',$portfolioItem); ?>
    </p>
</div><!-- $portfolioContainer -->

</body>
</html>