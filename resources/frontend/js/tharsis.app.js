var tharsis = {
	init : function () {

		


	}
}



$(window).load(function () {
	$('.dropdown-button').dropdown({
      inDuration: 500,
      outDuration: 225,// Does not change width of dropdown to that of the activator
      hover: false, // Activate on hover
      gutter: 0, // Spacing from edge
      belowOrigin: true // Displays dropdown below the button
    }
  );

	$('.parallax').parallax();
	 $('ul.tabs').tabs();

	 $('.masonry-container').masonry({
	
      	itemSelector: '.item',
      	"columnWidth" : ".col",
      	percentPosition: true

	});


	 $(".item").hover(function (e) {
	 	$(this).find(".capa").stop().fadeIn();
	 }, function() {
	 	$(this).find(".capa").stop().fadeOut();
	 });
});