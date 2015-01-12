/*
 * Script fuer den Luna zur Aktivierung verschiedener Hintergruende im 
 * Kopfteil der Seite bei Nutzung eines Screens mit Mindestens 1200 Pixel
 * Breite.
 */


// Variable to store the images we need to set as background
// which also includes some text and url's.
var photos = [ {
		"image" : "01_header_wke_834x200.png",
	}, {
		"image" : "02_header_wke_834x200.png",
	}, {
		"image" : "03_header_wke_834x200.png",
	}, {
		"image" : "04_header_wke_834x200.png",
	}, 
];


 
	   
jQuery(document).ready(function($) {
  if ($(window).width() > minscreenwidth) { 
      $(".btn").html('<a href="#toggle"><img src="'+uripath+'/images/btn_pause.png" alt="Stop Animation"></a>');
    
	var interval;
	$("#control").click(function() {$(".btn").keypress();});	
	$(document).keypress(function(e){
	    if ($(e.target).is('input, textarea')) {
	       return;   
	    }
	    var key = e.which;
	    if (key == 116) {
	    // if the user pressed 't' (for 'toggle'):
	    $('#control').click();
	    }
	});

	$("#control").toggle(function(){
		stopAnimation();
	}, function() {
		$(".btn").html('<a href="#toggle"><img src="'+uripath+'/images/btn_pause.png" alt="Stop Animation"></a>');
		
		// Show the next image
		navigate("next");
		
		// Start playing the animation
		interval = setInterval(function() {
			navigate("next");
		}, slideshowSpeed);
	});
	
	var activeContainer = 1;	
	var currentImg = 0;
	var animating = false;
	var navigate = function(direction) {
		// Check if no animation is running. If it is, prevent the action
		if(animating) {
			return;
		}		
		currentImg++;
		if(currentImg == photos.length + 1) {
			currentImg = 1;
		}
		
		
		// Check which container we need to use
		var currentContainer = activeContainer;
		if(activeContainer == 1) {
			activeContainer = 2;
		} else {
			activeContainer = 1;
		}
		
		showImage(photos[currentImg - 1], currentContainer, activeContainer);
		
	};
	
	var showImage = function(photoObject, currentContainer, activeContainer) {
		animating = true;
		
		// Set the background image of the new active container
		$("#headerimg" + activeContainer).css({
			"background-image" : "url("+uripath+"/images/" + photoObject.image + ")",
			"display" : "block",
			"z-index" : 4
		});
		$("#headerimg" + currentContainer).css({
			"z-index" : 5
		});		
		
		$("#headerimg" + currentContainer).fadeOut(3000,function() {
			setTimeout(function() {	
			   animating = false;
			}, 4000);
		});
		
	};
	
	var stopAnimation = function() {
		// Change the background image to "play"
		$(".btn").html('<a href="#toggle"><img src="'+uripath+'/images/btn_play.png" alt="Starte Animation"></a>');
		
		// Clear the interval
		clearInterval(interval);
	};
	
	
	    // We should statically set the first image
	    navigate("next");
	
	    // Start playing the animation
	    interval = setInterval(function() {
		navigate("next");
	    }, slideshowSpeed);
	}	
});

