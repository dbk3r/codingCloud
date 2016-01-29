
function cActivate(event, uuid,loresVideo) {
	
	$(".content").removeClass("content-selected");
	$("#"+uuid).addClass( "content-selected", 400 );
	$('#vPlayer video').html('<source src="'+ loresVideo +'" type="video/mp4"></source>').load();
	var pr = "";	
	$.getJSON("includes/readProcess.php?uuid='"+uuid+"'", function(data) {
		        pr = "<table border=0 cellpadding=4 cellspacing=5>";
				
				$.each(data.ps, function(i,ps){																		
					pr = pr + "<tr class=proc><td>"+ps.job_type+"</td></tr>" ;				
				});
				pr = pr + "</table>"; 
				$("#jProcess").html(pr);
	});
	
}

function wfAction(event,uuid) {	
		
		$("#cMenu").remove();
		var wf="";
		$.getJSON("includes/db_action.php?getWF='a'", function(data) {
		        wf = "<table border=0 cellpadding=4 cellspacing=0>";
				
				$.each(data.workflow, function(i,workflow){	
					var action = "onClick=\"dbAction('"+workflow.wf_short+"','"+uuid+"')\";";													
					wf = wf + "<tr " + action +" class=menutr><td><img src="+workflow.wf_icon+"></td><td>"+workflow.wf_description+"</td></tr>" ;				
				});
				wf = wf + "</table>"; 
				var cmenu = $(
					'<div id=cMenu class=cmenu>'+
						wf +				
					'</div>'
				
				);
				$(cmenu).hide().appendTo('body').fadeIn(300);		
				$("#cMenu").offset({left:event.pageX,top:event.pageY})	;
				
		});
		
		$(document).click(function() {
			$("#cMenu").remove();
		});
			
	
}

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
		if($("#search-input").val().length != 0) {var si = "&search="+$("#search-input").val();} else { si ="";}
		$("#tbl-content").load('includes/content.php?'+af+av+ab+si,function() {	
		$("#leftDiv").css("height", $("#tbl-content").height() + $("#nav-bar").height() + $("#search-content").height()+30);	
		$("#splitDiv").css("height", $("#leftDiv").height()- 8);	
		$("#rightDiv").css({"height":$("#leftDiv").height()- 8, "margin-left":$("#leftDiv").width()+4});
		$("#mainDiv").css("height", "auto");
			
				
		}); // end content reload
    
	};	
	
$(document).ready( function() {			
 	
 	
 	contentReload();
 	
 	$(".search-cb").click(function() {
		contentReload();
									
	});
 	$("#search-input").on('input',function () { 
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
	
		
	var min = 600;
	var max = 3600;
	var mainmin = 250;
	
	$('#splitDiv').mousedown(function(e) {
	  e.preventDefault();
	  $(document).mousemove(function(e) {
	    e.preventDefault();
	    var x = e.pageX - $('#leftDiv').offset().left;
	    if (x > min && x < max && e.pageX < ($(window).width() - mainmin)) {
	      $('#leftDiv').css("width", x);
	      $('#rightDiv').css("margin-left", x + 4);
	      $("#splitDiv").css("height", $("#leftDiv").height()- 10);	
		  $("#rightDiv").css({"height":$("#leftDiv").height()- 10, "margin-left":$("#leftDiv").width()+4});
		  $("#mainDiv").css("height", "auto");
	      
	    }
	  });
	});
	$(document).mouseup(function(e) {
	  $(document).unbind('mousemove');
	});	
 				
});



