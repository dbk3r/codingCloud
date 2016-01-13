
function ccAlert(text){
	
	var ccAlertDiv = $('<div id=ccAlertBox class=ccAlertBox><table width=100%></tr><td class=alertTH align=center>Fehler</td></tr><tr><td class=alertTD align=center>'+text+'</td></tr></table></div>', { css: { 'display': 'none' }});
	$('body').append(ccAlertDiv);
	$('.ccAlertBox').css({
					position:'absolute',
					left: ($(window).width() /2 ) - ($("#ccAlertBox").width() / 2),
					top: ($(window).height() / 2 )- ($("#ccAlertBox").height() / 2),
					height:'auto'
	});
}



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



