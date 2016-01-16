
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


function dbAction(wf, uuid) {
	
				
		$("#"+uuid).addClass( "content-red", 400 );
		
			
		$.ajax({
		    url: "includes/db_action.php",
		    type: "POST",
		    data: 'wf' +'='+ wf + '&uuid='+uuid,
		    success: function(data) {
		    	contentReload();        
		    }
	    });
	
	
}

function contentReload(){		
	
		if($("#audio-filter").is(':checked')) {	var af = "f_audio=on"; } else { af=""; }
		if($("#video-filter").is(':checked')) { var av = "&f_video=on"; } else { av=""; }
		if($("#blender-filter").is(':checked')) {	var ab = "&f_blender=on"; } else { ab=""; }
		
		$("#tbl-content").load('includes/content.php?'+af+av+ab,function() {
			$(".content").mouseover(function() {
				
			});
		
			$(".content").click(function() {
				
			});			
			
		
				
		}); // end content reload
    
	};	
	
$(document).ready( function() {			
 	
 	$(".search-cb").click(function() {
		contentReload();
									
	});
 	
	$("#save").click(function() {
		alert("save");
		window.location.href = "index.php";
									
	});
			
	$(window).resize();
	$("#refresh-btn").click(function() {
		contentReload();
	});
	
		
 				
});



