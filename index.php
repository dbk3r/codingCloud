<?php

	include_once 'includes/config.php';
	
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
    	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
    	<title>CC v-0.1</title>
    	
    	<link rel="stylesheet" href="./includes/css/cc.css" rel="stylesheet" />
    	
	</head>
	<body>
		<script type="text/javascript" src="./includes/js/jquery-2.1.4.min.js"></script>
		<script type="text/javascript" src="./includes/js/jquery-migrate-1.2.1.min.js"></script>
		<script type="text/javascript" src="./includes/js/dmuploader.js"></script>		
		
		<div class=mainDiv id=mainDiv>
			test
			<div class=nav>
				
			</div>
			
		</div>
		
		
		<script type="text/javascript">
			
			$(window).resize(function(){
				$('.mainDiv').css({
				position:'absolute',
					left: ($(window).width() - $('.mainDiv').outerWidth())/2,
					top: ($(window).height() - $('.mainDiv').outerHeight())/2
				});	

			});
			
			$( document ).ready(function() {
 				$(window).resize();
			});
			
			
			
			
		</script>
		
	</body>
	
</html>