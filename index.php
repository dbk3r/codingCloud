<?php

	include_once 'includes/config.php';
	
?>

<!DOCTYPE html>

<html>
	<head>
		<meta charset="utf-8">
    	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
    	<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
    	<title>CC v-0.1</title>    	
    	<link rel="stylesheet" href="./includes/css/cc.css" rel="stylesheet" />
    	<link rel="stylesheet" href="./includes/css/upload.css" rel="stylesheet" />
    	<script type="text/javascript" src="./includes/js/jquery-2.1.4.min.js"></script>
    	<script type="text/javascript" src="./includes/js/jquery.knob.js"></script>
    	<script type="text/javascript" src="./includes/js/jquery.ui.widget.js"></script>
    	<script type="text/javascript" src="./includes/js/jquery.iframe-transport.js"></script> 
    	<script type="text/javascript" src="./includes/js/jquery.fileupload.js"></script>   		
		<script type="text/javascript" src="./includes/js/file-upload.js"></script>		
		
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
    	
	</head>
	<body>
		
		
		<div class=mainDiv id=mainDiv>
			
			<div class=nav-bar id=nav-bar>
				<table width=100%>
					<tr>
						<td align=center>
							<form id="upload" method="post" action="upload.php" enctype="multipart/form-data">
								<div id="drop">
									Datei hier Fallen lassen<br>
					
									<a>Auswahl</a>
									<input type="file" name="upl" multiple />
								</div>
					
								<ul></ul>				
							</form>					      
						</td>					
					</tr>					
				</table>
			</div>
			
			<div id="tbl-content" class="nav-bar">
				<table width=100%>
					<tr>
						<td>Dateiname</td>
						<td>Content</td>
						<td>aktueller Workflow</td>
						<td>Status</td>
						
					</tr>
				</table>				
			</div>
			
		</div> <!-- main-DIV -->
		
		
		
		
	</body>
	
</html>