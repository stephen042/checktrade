jQuery(function(){
	jQuery("li:first-child").addClass("first");
	jQuery("li:last-child").addClass("last");	

	jQuery('.sf-menu').superfish({ 
		delay:       500,                           
		animation:   {opacity:'show',height:'show'}, 
		speed:       'fast',
		autoArrows:  false,
		dropShadows: false,      
	});
	

	
	
	jQuery('.selectpicker').selectpicker({
		
			
		
	});
	

    jQuery('.collapse').on('shown.bs.collapse', function() {
        jQuery(this).parent().find(".panel-heading").addClass("active");
    }).on('hidden.bs.collapse',
        function() {
            jQuery(this).parent().find(".panel-heading").removeClass("active");
        });
		
		
  jQuery("#home_banner ul").owlCarousel({

	  loop: true,
	  autoplay: true,
	  autoplayTimeout:6000,
	   items: 1,
	  singleItem: true,
	  nav: false,
	  dots: true
	
 
  });

    jQuery("#testi_slider").owlCarousel({

	  loop: true,
	  autoplay: true,
	  autoplayTimeout:6000,
	   items: 1,
	  singleItem: true,
	  nav: false,
	  dots: true
	
 
  });
  
  
  

  
    
  jQuery(".coin_slider").owlCarousel({

	  loop: false,
	   autoplayTimeout:6000,
	  autoplay: true,
	  items: 4,
	  nav: true,
	  dots: false,
		responsive:{
			0:{
				items:1//Mobile
			},
			991:{
				items:4// @media (min-width: 768px) and (max-width: 991px)
			},
			768:{
				items:3//Ipad
			},
			500:{
				items:1//Mobile
			}
		}
	
 
  });
  
jQuery("#opt_smart_slider").owlCarousel({

	 items:2,
    loop:true,
    autoplay:true,
    autoplayTimeout:1000,
    autoplayHoverPause:true,
		responsive:{
			0:{
				items:1//Mobile
			},
			991:{
				items:2// @media (min-width: 768px) and (max-width: 991px)
			},
			768:{
				items:1//Ipad
			},
			500:{
				items:1//Mobile
			}
		}
	
 
  });

  
if (jQuery('#back-to-top').length) {
    var scrollTrigger = 100, // px
        backToTop = function () {
            var scrollTop = jQuery(window).scrollTop();
            if (scrollTop > scrollTrigger) {
                jQuery('#back-to-top').addClass('show');
            } else {
                jQuery('#back-to-top').removeClass('show');
            }
        };
    backToTop();
    jQuery(window).on('scroll', function () {
        backToTop();
    });
    jQuery('#back-to-top').on('click', function (e) {
        e.preventDefault();
        jQuery('html,body').animate({
            scrollTop: 0
        }, 700);
    });
}
  
  





 

	jQuery(".header_1").sticky({ topSpacing: 0, className: 'sticky', wrapperClassName: 'header_1_main' });
	
	
	jQuery(".mobile_header").sticky({ topSpacing: 0, className: 'sticky', wrapperClassName: 'mobile_header_main' });
	
	
	
	
	
	

	
	
	
	
	
	
	
	
	
jQuery(".side_menu_toogle").click(function(e) {

	
	jQuery('.side_menu_toogle').toggleClass("active");
	
	
	  if(jQuery('.side_menu_toogle').hasClass('active')){
	  	jQuery('body').css({'overflow': 'hidden'});
		jQuery('.mobile_menu').animate({
                right: "0px",
            }, 500);	
	  }
	  else{
	  	jQuery('body').css({'overflow': 'inherit'});
		jQuery('.mobile_menu').animate({
                right: "-300px",
            }, 500);	
	  }
	
	
	
	
	
	/*jQuery('.mobile_menu').toggle();*/
	
	
	
/*		var lft =  jQuery(".mobile_menu").css("top");
		lft = parseInt(lft);
		if(lft < 0){
        	jQuery(".mobile_menu").animate({top:100+'%'},250);
		}else{
			jQuery(".mobile_menu").animate({top:'-100vw'},250);	
		}
		e.stopPropagation();*/
    });
	
	
	jQuery(".mobile_menu").click(function(e) {
		
		e.stopPropagation();
		
		 });
		 
		 
		 
	
	jQuery(".mobile_menu > ul > li > a").click(function(e) {
		var dd = jQuery(this).next("ul");
		jQuery(dd).toggle(250);
		jQuery(".mobile_menu > ul ul").not(dd).slideRight(250);
	});
	
	jQuery(".mobile_menu > ul > li > ul > li.menu-item-has-children > a").click(function(e) {
		e.preventDefault();
		//jQuery(this).find('ul.sub-menu').toggle(250);
		 jQuery(this).next().toggle(250);
		
    });

		

		
    jQuery('.fancy_video').fancybox({
        'padding': 0,
        'autoScale': false,
        'transitionIn': 'none',
        'transitionOut': 'none',
        'width': 800,
        'height': 450,
        helpers: {
            media: {}
        }
    });
	
	
    jQuery('.fancy_photo').fancybox({
        'titleShow': false,
        'transitionIn': 'elastic',
        'transitionOut': 'elastic',
        'easingIn': 'easeOutBack',
        'easingOut': 'easeInBack'
    });




		

	
});


