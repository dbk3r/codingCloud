
function contentReload(){		
	
		$("#tbl-content").load('includes/content.php',function() {
			$(".content").mouseover(function() {
				
			});
		
			$(".content").click(function() {
				
			});
			
			$("#"+this.id+" .trash").mouseover(function() {
				$("#"+this.id+" .trash").css({
					border:'1px solid #000'
				});
			});
			$("#"+this.id+" .trash").mouseout(function() {
				$("#"+this.id+" .trash").css({
					border:'0px solid #000'
				});
			});
			
			$("#"+this.id+" .trash").mousedown(function() {
				$("#"+this.id+" .trash").css({
					border:'1px solid #ff0000'
				}),
				
				$(".trash").mouseup(function() {
							
					$("#"+this.id).remove(),
					$.ajax({
					    url: "includes/db_action.php",
					    type: "POST",
					    data: 'del='+this.id,
					    success: function(data) {
					            
					    },  
					});
				
				}); // end trash click
				
			});
			
			
			
				
		}); // end content reload
    
	};	
$(document).ready( function() {			
 	
			
	$(window).resize();
	$("#refresh-btn").click(function() {
		contentReload();
	});
	
		
 				
});



