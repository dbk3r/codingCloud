
var cvideo = null;

function restartJob(jobID) {
	
	$.ajax({
		    url: "includes/db_action.php",
		    type: "POST",
		    data: 'rJob' +'='+ jobID ,
		    success: function(data) {
		    	//contentReload();        
		    }
	    });
	    
}

function reloadJobs(){
	
	$("#Tab-Jobs").load("includes/read_jobs.php");
	$("#Tab-Encoder").load("includes/read_encoder.php");
}

function reloadProc(puuid) {	
	$("#jProcess").load("includes/readProcess.php?uuid='"+puuid+"'");
}

var curFrame;
var ratio;

function cActivate(event,content_type, uuid,AV) {
	curFrame = 1;
	ratio = 1;
	updateSliderPointer(curFrame);
	var cvideo = null;
	$("#cplayer").remove();
	$(".content").removeClass("content-selected");
	$("#"+uuid).addClass( "content-selected", 100 );	
	
	if(content_type == "Video") {		
		$("#vPlayer").html('<video id=cplayer class="vp" preload="auto"><source src="'+ AV +'" type="video/mp4"></video>');
		$("#vPlayer").switchClass("aPlayer","vPlayer");		
	}	
	if(content_type == "Audio") {
		$("#vPlayer").html('<audio id=cplayer class="ap" preload="auto"><source src="'+ AV +'" type="audio/mp3"></video>');
		$("#vPlayer").switchClass("vPlayer","aPlayer");
		
	}
	$("#vControls").show();
	$("#cplaypause").switchClass("cpause","cplay");
	
	$("#procreload").html("<img onClick=\"reloadProc('"+uuid+"');\" valign=middle  class=clRelProc src=img/refresh.png>" );
	reloadProc(uuid);
	
	
 	
	cvideo = VideoFrame({
		    id: 'cplayer',
		    frameRate: FrameRates.PAL,
		    callback: function(response) {
		    	var frame = cvideo.get();
		    	$("#vTC").html(cvideo.toSMPTE(frame));
		    	updateSliderPointer(frame);		        
		    }		    
	});	
	cvideo.listen('frame',1);			
	updateTC(cvideo);		
	
	$("#cforward").click(function(){
		$("#cplayer").get(0).pause();
		cvideo.seekForward(1,updateTC(cvideo));
	});
	$("#cback").click(function(){
		$("#cplayer").get(0).pause();
		cvideo.seekBackward(1,updateTC(cvideo));
	});
		
	
		
	$("#cslider").mousedown(function(e){
		
		e.preventDefault();
		var mouseX;
		var mouseY;
		$(document).mousemove( function(e) {
		e.preventDefault();
		mouseX = e.clientX; 
	   	mouseY = e.clientY;	
	   	var maxPos = $('#cslider').offset().left+$('#cslider').width();
	   	var minPos = $('#cslider').offset().left;
	   	var vFrames = Math.round($("#cplayer").get(0).duration * cvideo.frameRate);
	   	
		if ( mouseX >= minPos  && mouseX <= maxPos) 
		{
			
		    var sliderWidth = $("#cslider").width();		
		    			     
		    var x = mouseX - $('#cslider').offset().left;		 
		    ratio = vFrames/$('#cslider').width();           
        	curFrame= Math.floor(x * ratio);   
		    if (curFrame < 1) {curFrame = 1;}
		    if (curFrame > vFrames) {curFrame = vFrames;}
		    $("#cplayer").get(0).currentTime = curFrame / cvideo.frameRate;
		    updateSliderPointer(curFrame);
		    	
	 	}
	    });
	});
	$("#cslider").mouseup(function(e){
		$(document).unbind('mousemove');	
		
	});
		
		
	
}

function frametoSMPTE(frame){	
	
	var frameNumber = Number(frame);
	var fps = 25;
	function wrap(n) { return ((n < 10) ? '0' + n : n); }
	var _hour = ((fps * 60) * 60), _minute = (fps * 60);
	var _hours = (frameNumber / _hour).toFixed(0);
	var _minutes = (Number((frameNumber / _minute).toString().split('.')[0]) % 60);
	var _seconds = (Number((frameNumber / fps).toString().split('.')[0]) % 60);
	var SMPTE = (wrap(_hours) + ':' + wrap(_minutes) + ':' + wrap(_seconds) + ':' + wrap(frameNumber % fps));
	return SMPTE;

}

function updateSliderPointer(frame) {	
	
	var nPos = $('#cslider').offset().left + (frame/ratio) - 1;
	$("#sliderPointer").offset({left:nPos,top:$("#cslider").offset().top});
	$("#vTC").html(frametoSMPTE(frame));
	
}

function updateTC(vid) {
	var frame = vid.get();
		$("#vTC").html(vid.toSMPTE(frame));	
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
				
		if(wf == "delContent"){
			$("#"+uuid).fadeOut(400, function() {
				
				if($("#cplayer").length > 0)
				{			
					$("#cplayer").get(0).pause();			
					$("#cplayer").empty().remove();
				}				
                $("#"+uuid).remove();
				$("#jProcess").html("");
				$("#vTC").html("");			 
				 
			 });		
		}		
		
		$.ajax({
		    url: "includes/db_action.php",
		    type: "POST",
		    data: 'wf' +'='+ wf + '&uuid='+uuid,
		    success: function(data) {
		    	//contentReload();        
		    }
	    });
	
}

function contentReload(){		
			
	
		if($("#audio-filter").is(':checked')) {	var af = "f_audio=on"; } else { af=""; }
		if($("#video-filter").is(':checked')) { var av = "&f_video=on"; } else { av=""; }
		if($("#blender-filter").is(':checked')) {	var ab = "&f_blender=on"; } else { ab=""; }
		if($("#search-input").val().length != 0) {var si = "&search="+$("#search-input").val();} else { si ="";}
		$("#tbl-content").load('includes/content.php?'+af+av+ab+si,function() {	
		fitCanvas();
			
				
		}); // end content reload	
		
    
};	

function fitCanvas() {
	$("#leftDiv").css("height", $("#tbl-content").height() + $("#nav-bar").height() + $("#search-content").height()+30);	
	$("#splitDiv").css("height", $("#leftDiv").height()- 8);	
	$("#rightDiv").css({"height":$("#leftDiv").height()- 8, "margin-left":$("#leftDiv").width()+4});
	$("#mainDiv").css("height", "auto");
}	
	
$(document).ready( function() {			
 	
  	
 	$("#vControls").hide();	
 		
 	fitCanvas();
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
	      updateSliderPointer(curFrame);
	    }
	  });
	});
	$(document).mouseup(function(e) {
	  $(document).unbind('mousemove');
	});	
	
	
	
	$("#cplaypause").click(function(){
		if($("#cplayer").get(0).paused){
			$("#cplaypause").attr("src","img/pause.png");
			$("#cplaypause").switchClass("cplay","cpause");
			$("#cplayer").get(0).play();					
		}
		else {
			$("#cplaypause").attr("src","img/play.png");
			$("#cplaypause").switchClass("cpause","cplay");
			$("#cplayer").get(0).pause();					
		}
	});			
	
	
	$("#cplayer").bind("ended", function(){
		$("#cplaypause").switchClass("cpause","cplay");
		$("#cplaypause").attr("src","img/play.png");
		
	});
 				
});



