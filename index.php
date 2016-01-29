<?php
	include_once './includes/header.php';
	include_once './includes/menu-bar.php';
			
?>
		<div id="leftDiv" class="leftDiv">	
			<div id="splitDiv" class="splitDiv"></div>
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
			
			<div id="search-content" class="tbl-content">
				<?php include 'includes/search-bar.php';	?>	
			</div>
		
			
			<div id="tbl-content" class="tbl-content">
				<?php include 'includes/content.php';	?>	
			</div>
				
		
		</div>
			
		
		<div id="rightDiv" class="rightDiv">
			<div id=vPlayer class=vPlayer></div>
			<div id=vControls class=vControlls></div>
			<div id=jProcess class=jProcess></div>
		</div>


<?php
	include_once './includes/footer.php';

?>	