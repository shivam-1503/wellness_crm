(function($) {
	"use strict";
	
	//Color-Theme
	$(document).on("click", "a[data-theme]", function() {
		$("head link#theme").attr("href", $(this).data("theme"));
		$(this).toggleClass('active').siblings().removeClass('active');
	});

	
	// FAQ Accordion
	$(document).on("click", '[data-bs-toggle="collapse"]', function() {
		$(this).toggleClass('active').siblings().removeClass('active');
	});
	
	
	// ______________Full screen
	$(document).on("click", ".fullscreen-button", function toggleFullScreen() {
	  $('html').addClass('fullscreen-button');
		if ((document.fullScreenElement !== undefined && document.fullScreenElement === null) || (document.msFullscreenElement !== undefined && document.msFullscreenElement === null) || (document.mozFullScreen !== undefined && !document.mozFullScreen) || (document.webkitIsFullScreen !== undefined && !document.webkitIsFullScreen)) {
			if (document.documentElement.requestFullScreen) {
				document.documentElement.requestFullScreen();
			} else if (document.documentElement.mozRequestFullScreen) {
				document.documentElement.mozRequestFullScreen();
			} else if (document.documentElement.webkitRequestFullScreen) {
				document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
			} else if (document.documentElement.msRequestFullscreen) {
				document.documentElement.msRequestFullscreen();
			}
		} else {
		 $('html').removeClass('fullscreen-button');
			if (document.cancelFullScreen) {
				document.cancelFullScreen();
			} else if (document.mozCancelFullScreen) {
				document.mozCancelFullScreen();
			} else if (document.webkitCancelFullScreen) {
				document.webkitCancelFullScreen();
			} else if (document.msExitFullscreen) {
				document.msExitFullscreen();
			}
		}
	})
	
	// ______________ PAGE LOADING
	$(window).on("load", function(e) {
		$("#global-loader").fadeOut("slow");
	})
	
	// ______________ BACK TO TOP BUTTON
	$(window).on("scroll", function(e) {
		if ($(this).scrollTop() > 0) {
			$('#back-to-top').fadeIn('slow');
		} else {
			$('#back-to-top').fadeOut('slow');
		}
	});
	$(document).on("click", "#back-to-top", function(e) {
		$("html").animate({
			scrollTop: 0
		}, 0);
		return false;
	});
	
	
	// ______________ COVER IMAGE
	$(".cover-image").each(function() {
		var attr = $(this).attr('data-bs-image-src');
		if (typeof attr !== typeof undefined && attr !== false) {
			$(this).css('background', 'url(' + attr + ') center center');
		}
	});

	// ______________Quantity Cart Increase & Descrease
	$(function () {
		$('.add').on('click',function(){
			var $qty=$(this).closest('div').find('.qty');
			var currentVal = parseInt($qty.val());
			if (!isNaN(currentVal)) {
				$qty.val(currentVal + 1);
			}
		});
		$('.minus').on('click',function(){
			var $qty=$(this).closest('div').find('.qty');
			var currentVal = parseInt($qty.val());
			if (!isNaN(currentVal) && currentVal > 0) {
				$qty.val(currentVal - 1);
			}
		});
	});
	
	// ______________Chart-circle
	if ($('.chart-circle').length) {
		$('.chart-circle').each(function() {
			let $this = $(this);
			$this.circleProgress({
				fill: {
					color: $this.attr('data-bs-color')
				},
				size: $this.height(),
				startAngle: -Math.PI / 4 * 2,
				emptyFill: 'rgba(119, 119, 142, 0.2)',
				lineCap: 'round'
			});
		});
	}

	// __________MODAL
	// showing modal with effect
	$('.modal-effect').on('click', function(e) {
		e.preventDefault();
		var effect = $(this).attr('data-bs-effect');
		$('#modaldemo8').addClass(effect);
	});
	// hide modal with effect
	$('#modaldemo8').on('hidden.bs.modal', function(e) {
		$(this).removeClass(function(index, className) {
			return (className.match(/(^|\s)effect-\S+/g) || []).join(' ');
		});
	}); 
	
	// ______________ CARD
	const DIV_CARD = 'div.card';
	
	// ___________TOOLTIP
	var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
	var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
		return new bootstrap.Tooltip(tooltipTriggerEl)
	})
	
	// __________POPOVER
	var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
	var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
	return new bootstrap.Popover(popoverTriggerEl)
	})
	
	// ______________ FUNCTION FOR REMOVE CARD
	$(document).on('click', '[data-bs-toggle="card-remove"]', function(e) {
		let $card = $(this).closest(DIV_CARD);
		$card.remove();
		e.preventDefault();
		return false;
	});
	
	
	// ______________ FUNCTIONS FOR COLLAPSED CARD
	$(document).on('click', '[data-bs-toggle="card-collapse"]', function(e) {
		let $card = $(this).closest(DIV_CARD);
		$card.toggleClass('card-collapsed');
		e.preventDefault();
		return false;
	});
	
	// ______________ CARD FULL SCREEN
	$(document).on('click', '[data-bs-toggle="card-fullscreen"]', function(e) {
		let $card = $(this).closest(DIV_CARD);
		$card.toggleClass('card-fullscreen').removeClass('card-collapsed');
		e.preventDefault();
		return false;
	});
	

	//Input file-browser
	$(document).on('change', '.file-browserinput', function() {
		var input = $(this),
		numFiles = input.get(0).files ? input.get(0).files.length : 1,
		label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
	input.trigger('fileselect', [numFiles, label]);
	});// We can watch for our custom `fileselect` event like this

	//______File Upload
	$('.file-browserinput').on('fileselect', function(event, numFiles, label) {
			var input = $(this).parents('.input-group').find(':text'),
			log = numFiles > 1 ? numFiles + ' files selected' : label;
			if( input.length ) {
				input.val(log);
			} else {
				if( log ) alert(log);
			}
	});
	

	
	// ______________ SWITCHER-toggle ______________//

	$('.layout-setting').on("click", function(e) {
		if (document) {
			$('body').toggleClass('dark-mode');
		} else {
			$('body').removeClass('dark-mode');
			$('body').addClass('light-mode');
		}
	});
	$(document).on("click", "a[data-sidetheme]", function() {
		$("head link#sidemenu-theme").attr("href", $(this).data("sidetheme"));
	});
	$('.default-menu').on('click', function() {
		$('body').addClass('menu1') 
		$('body').removeClass('menu2') 
		$('body').removeClass('menu3') 
		var ww = document.body.clientWidth;
		if (ww >= 767) {
			$('body').removeClass('sidenav-toggled');
		}
	});
	$('.sideicon-menu').on('click', function() {
		$('body').addClass('menu3') 
		$('body').removeClass('menu2') 
		$('body').removeClass('menu1') 
		jQuery(document).ready(function($) {
			var alterClass = function() {
			var ww = document.body.clientWidth;
			if (ww < 768) {
				$('body').removeClass('sidenav-toggled');
			} else if (ww >= 767) {
				$('body').addClass('sidenav-toggled');
			};
			};
			$(window).resize(function(){
			alterClass();
			});
			//Fire it when the page first loads:
			alterClass();
		});
	});
	$('.icontext-menu').on('click', function() {
		$('body').addClass('menu2') 
		$('body').removeClass('menu1') 
		$('body').removeClass('menu3') 
		jQuery(document).ready(function($) {
			var alterClass = function() {
			var ww = document.body.clientWidth;
			if (ww < 768) {
				$('body').removeClass('sidenav-toggled');
			} else if (ww >= 767) {
				$('body').addClass('sidenav-toggled');
			};
			};
			$(window).resize(function(){
			alterClass();
			});
			//Fire it when the page first loads:
			alterClass();
		});
	});

	/*Theme-layout*/
	$('#background-left1').on('click', function() {
		$('body').addClass('light-mode');
		$('body').removeClass('gradient-hormenu');
		$('body').removeClass('dark-mode');
		$('body').removeClass('color-header');
		$('body').removeClass('dark-header');
		$('body').removeClass('dark-menu');
		$('body').removeClass('gradient-menu');
		$('body').removeClass('gradient-header');
		$('body').removeClass('color-menu');
		return false;
	  });

	  $('#background-left2').on('click', function() {
		$('body').addClass('dark-mode');
		$('body').removeClass('light-mode');
		$('body').removeClass('light-menu');
		$('body').removeClass('color-menu');
		$('body').removeClass('dark-header');
		$('body').removeClass('color-header');
		$('body').removeClass('light-header');
		$('body').removeClass('dark-menu');
		$('body').removeClass('light-hormenu');
		$('body').removeClass('gradient-hormenu');
		$('body').removeClass('gradient-menu');
		return false;
	  });


	  /*Header Style*/
	  $('#background1').on('click', function() {
		$('body').addClass('light-header');
		$('body').removeClass('color-header');
		$('body').removeClass('dark-header');
		$('body').removeClass('gradient-header');
		return false;
	  });

	  $('#background2').on('click', function() {
		$('body').addClass('color-header');
		$('body').removeClass('light-header');
		$('body').removeClass('dark-header');
		 $('body').removeClass('gradient-header');
		return false;
	  });

	  $('#background3').on('click', function() {
		$('body').addClass('dark-header');
		$('body').removeClass('color-header');
		$('body').removeClass('light-header');
		 $('body').removeClass('gradient-header');
		return false;
	  });
	  $('#background11').on('click', function() {
		$('body').addClass('gradient-header');
		 $('body').removeClass('dark-header');
		$('body').removeClass('color-header');
		$('body').removeClass('light-header');
		return false;
	  });


	  /*Leftmenu Style*/
	  $('#background4').on('click', function() {
		$('body').addClass('light-menu');
		$('body').removeClass('color-menu');
		$('body').removeClass('dark-menu');
		$('body').removeClass('gradient-menu');
		$('body').removeClass('light-hormenu');
		 $('body').removeClass('dark-hormenu');
		 $('body').removeClass('color-hormenu');
		return false;
	  });

	  $('#background5').on('click', function() {
		$('body').addClass('color-menu');
		$('body').removeClass('light-menu');
		$('body').removeClass('dark-menu');
		$('body').removeClass('gradient-menu');
		$('body').removeClass('light-hormenu');
		 $('body').removeClass('dark-hormenu');
		 $('body').removeClass('color-hormenu');
		return false;
	  });

	  $('#background6').on('click', function() {
		$('body').addClass('dark-menu');
		$('body').removeClass('color-menu');
		$('body').removeClass('light-menu');
		$('body').removeClass('gradient-menu');
		$('body').removeClass('light-hormenu');
		 $('body').removeClass('dark-hormenu');
		 $('body').removeClass('dark-hormenu');
		return false;
	  });
	  $('#background10').on('click', function() {
		$('body').addClass('gradient-menu');
		$('body').removeClass('color-menu');
		$('body').removeClass('light-menu');
		$('body').removeClass('dark-menu');
		$('body').removeClass('light-hormenu');
		 $('body').removeClass('dark-hormenu');
		 $('body').removeClass('dark-hormenu');
		return false;
	  });


	  /*Horizontal Style*/
	  $('#background7').on('click', function() {
		$('body').addClass('light-hormenu');
		$('body').removeClass('color-hormenu');
		$('body').removeClass('dark-hormenu');
		$('body').removeClass('gradient-hormenu');
		$('body').removeClass('dark-menu');
		$('body').removeClass('color-menu');
		$('body').removeClass('light-menu');
		$('body').removeClass('gradient-menu');
		return false;
	  });

	  $('#background8').on('click', function() {
		$('body').addClass('color-hormenu');
		$('body').removeClass('light-hormenu');
		$('body').removeClass('dark-hormenu');
		$('body').removeClass('gradient-hormenu');
		$('body').removeClass('dark-menu');
		$('body').removeClass('color-menu');
		$('body').removeClass('light-menu');
		$('body').removeClass('gradient-menu');
		return false;
	  });

	  $('#background9').on('click', function() {
		$('body').addClass('dark-hormenu');
		$('body').removeClass('color-hormenu');
		$('body').removeClass('light-hormenu');
		$('body').removeClass('gradient-hormenu');
		$('body').removeClass('dark-menu');
		$('body').removeClass('color-menu');
		$('body').removeClass('light-menu');
		$('body').removeClass('gradient-menu');
		return false;
	  });

	  $('#background13').on('click', function() {
		$('body').addClass('gradient-hormenu');
		$('body').removeClass('dark-hormenu');
		$('body').removeClass('color-hormenu');
		$('body').removeClass('light-hormenu');
		$('body').removeClass('dark-menu');
		$('body').removeClass('color-menu');
		$('body').removeClass('light-menu');
		$('body').removeClass('gradient-menu');
		return false;
	  });

	   /*Layout-width Styles*/
	   $('#background14').on('click', function() {
		$('body').addClass('layout-fullwidth');
		$('body').removeClass('layout-boxed');
		$('body').removeClass('light-hormenu');
		$('body').removeClass('color-hormenu');
		$('body').removeClass('dark-hormenu');
		$('body').removeClass('gradient-hormenu');
		$('body').removeClass('dark-menu');
		$('body').removeClass('color-menu');
		$('body').removeClass('light-menu');
		$('body').removeClass('gradient-menu');
		return false;
	  });

	  $('#background15').on('click', function() {
		$('body').addClass('layout-boxed');
		$('body').removeClass('layout-fullwidth');
		$('body').removeClass('color-hormenu');
		$('body').removeClass('light-hormenu');
		$('body').removeClass('dark-hormenu');
		$('body').removeClass('gradient-hormenu');
		$('body').removeClass('dark-menu');
		$('body').removeClass('color-menu');
		$('body').removeClass('light-menu');
		$('body').removeClass('gradient-menu');
		return false;
	  });


	   /*Header-Position Styles*/
	   $('#background16').on('click', function() {
		$('body').addClass('fixed-layout');
		$('body').removeClass('scrollable-layout');
		$('body').removeClass('light-hormenu');
		$('body').removeClass('color-hormenu');
		$('body').removeClass('dark-hormenu');
		$('body').removeClass('gradient-hormenu');
		$('body').removeClass('dark-menu');
		$('body').removeClass('color-menu');
		$('body').removeClass('light-menu');
		$('body').removeClass('gradient-menu');
		return false;
	  });

	  $('#background17').on('click', function() {
		$('body').addClass('scrollable-layout');
		$('body').removeClass('fixed-layout');
		$('body').removeClass('color-hormenu');
		$('body').removeClass('light-hormenu');
		$('body').removeClass('dark-hormenu');
		$('body').removeClass('gradient-hormenu');
		$('body').removeClass('dark-menu');
		$('body').removeClass('color-menu');
		$('body').removeClass('light-menu');
		$('body').removeClass('gradient-menu');
		return false;
	  });


	
	
})(jQuery);
