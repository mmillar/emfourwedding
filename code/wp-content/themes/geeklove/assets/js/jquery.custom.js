jQuery(document).ready(function($){
    /*------------------------------------------------------------------------------*/
    /* Set cookie for retina displays; refresh if not set
    /*------------------------------------------------------------------------------*/

    (function(){
        "use strict";
        if( document.cookie.indexOf('retina') === -1 && 'devicePixelRatio' in window && window.devicePixelRatio === 2 ){
            document.cookie = 'retina=' + window.devicePixelRatio + ';';
        }
    })();

    /*------------------------------------------------------------------------------*/
    /* Mobile Navigation Setup
    /*------------------------------------------------------------------------------*/
    var mobileNav = $('#primary-menu').clone().attr('id', 'mobile-primary-nav');

    function stag_mobilemenu(){
        "use strict";
        var windowWidth = $(window).width();
        if( windowWidth <= 992 ) {
            if( !$('#mobile-nav').length ) {
                $('<a id="mobile-nav" href="#mobile-primary-nav"><i class="icon icon-navicon"></i></a>').prependTo('#navigation');
                mobileNav.insertAfter('#mobile-nav').wrap('<div id="mobile-primary-nav-wrap" />');
                mobile_responder();
            }
        }else{
            mobileNav.css('display', 'none');
        }
    }
    stag_mobilemenu();

    function mobile_responder(){
        $('#mobile-nav').click(function(e) {
            if( $('body').hasClass('ie8') ) {
                var mobileMenu = $('#mobile-primary-nav');
                if( mobileMenu.css('display') === 'block' ) {
                    mobileMenu.css({
                        'display' : 'none'
                    });
                } else {
                    mobileMenu.css({
                        'display' : 'block',
                        'height' : 'auto',
                        'z-index' : 999,
                        'position' : 'absolute'
                    });
                }
            } else {
                $('#mobile-primary-nav').stop().slideToggle(500);
            }
            e.preventDefault();
        });
    }

    $(window).resize(function() {
        stag_mobilemenu();
    });

    /* Custom Dropdown for <select> */
    if ( $.isFunction( $.fn.dropdown ) ) {
        $('.custom-dropdown').each(function(){
            $(this).dropdown({
                stack : false
            });
        });
    }

    /*------------------------------------------------------------------------------*/
    /* Photo Gallery - Isotope
    /*------------------------------------------------------------------------------*/
    var container = $('#photo-list');

    if ($.fn.isotope) {
        container.isotope({
          itemSelector : '.photo',
          layoutMode: 'fitRows',
        });
    }


    // A small hack to make Isotope work on responsive stuff
    $(window).scroll(function(){
        container.resize();
    });
    container.resize();
    $(window).resize();

    $('#filters a').click(function(){
      var selector = $(this).attr('data-filter');
      container.isotope({ filter: selector });

      $('#filters a').removeClass('active');
      $(this).addClass('active');

      return false;
    });


    /*------------------------------------------------------------------------------*/
    /* Keyboard Navigation
    /*------------------------------------------------------------------------------*/
    $("body").keydown(function(e){
      if(e.keyCode === 39){
        if($('a[rel=next]').attr('href') !== undefined){
            document.location.href = $('a[rel=next]').attr('href');
        }
      }else if(e.keyCode === 37){
        if($('a[rel=prev]').attr('href') !== undefined){
            document.location.href = $('a[rel=prev]').attr('href');
        }
      }
    });

    /*------------------------------------------------------------------------------*/
    /* FitVids
    /*------------------------------------------------------------------------------*/
    $(".container").fitVids();

    /**
     * RSVP form ajax.
     */
    $('#rsvp-form').on('submit', function(e) {
    	e.preventDefault();

    	var form = $(this);

		$.ajax({
			type: 'POST',
			url: stag_vars.ajaxurl,
			data: $(this).serialize() + '&action=rsvp_widget',
			success: function( response ) {
				form.find('.submit').prepend( $('<div class="thanks">'+ response +'</div>') );
				form.find('input[type="submit"]').attr('disabled', 'disabled');
			}
		});

    });

    var $isWidgetized = $('body').hasClass('page-template-widgetized-php');

    if($isWidgetized) {
        staticContentBackground();
    }

    function staticContentBackground() {
        $('.page-template-widgetized-php').find('.stag_widget_static_content').each(function(){
            var _this = $(this),
                bgColor = _this.find('.hentry').data('bg-color'),
                bgImage = _this.find('.hentry').data('bg-image'),
                bgOpacity = parseInt(_this.find('.hentry').data('bg-opacity'), 10),
                textColor = _this.find('.hentry').data('text-color'),
                linkColor = _this.find('.hentry').data('link-color');

            _this.prepend('<div class="static-content-cover" />');
            _this.find('.static-content-cover').css({ 'background-image' : 'url('+bgImage+')', 'opacity' : bgOpacity/100, '-ms-filter': '"alpha(opacity='+bgOpacity+')"' });

            _this.css({ 'background-color': bgColor, 'color' : textColor });
            _this.find('a').css('color', linkColor);
            _this.find('h1, h2, h3, h4, h5, h6, blockquote').css('color', textColor);
        });
    }

});
