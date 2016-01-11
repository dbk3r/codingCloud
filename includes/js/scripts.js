
$(document).ready( function() {
 				
 	$(".content").mouseover(function() {
		console.log("id: " + this.id);
	});
		
	$(".content").click(function() {
		alert("id: " + this.id);
	});
		
	$(window).resize();
	
	setInterval(function(){		
	
		$("#tbl-content").load('includes/content.php',function() {
			$(".content").mouseover(function() {
				console.log("id: " + this.id);
			});
		
			$(".content").click(function() {
				alert("id: " + this.id);
			});
				
		});		
    
	}, 2500);		
 				
});



