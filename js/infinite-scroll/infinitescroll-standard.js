( function( $ ) {
    "use strict";

    // Run on window loaded
    $( window ).load( function() {

        // Get infinite scroll container
        var $container = $('#blog-entries');

        // Start infinite sccroll
        $container.infinitescroll( {
            loading : {
                msg         : null,
                finishedMsg : null,
                msgText     : '<div class="infinite-scroll-loader">'+ wpspInfiniteScroll.msgText +'</div>',
            },
            navSelector  : 'div.infinite-scroll-nav',
            nextSelector : 'div.infinite-scroll-nav div.older-posts a',
            itemSelector : '.blog-entry',
        },

        // Callback function
        function( newElements ) {
            var $newElems = $( newElements ).css( {
                opacity : 0
            } );
            $newElems.imagesLoaded( function() {

                // Animate new Items
                $newElems.animate( {
                    opacity : 1
                } );

                // Tipsy
                $("a.tooltip-left").tipsy({fade:!0,gravity:"e"}),$("a.tooltip-right").tipsy({fade:!0,gravity:"w"}),$("a.tooltip-up").tipsy({fade:!0,gravity:"s"}),$("a.tooltip-down").tipsy({fade:!0,gravity:"n"});

                // Gallery Slider
                if($.fn.imagesLoaded!=undefined&&$.fn.sliderPro!=undefined){
                    $(".wpsp-slider").each(function(){var e=$(this),i=e.data(),t="undefined"!=typeof i.animationSpeed?i.animationSpeed:600,o="undefined"!=typeof i.loop?i.loop:!1,n="undefined"!=typeof i.fade?i.fade:600,a="undefined"!=typeof i.direction?i.direction:"horizontal",d="undefined"!=typeof i.autoplay?i.autoplay:!0,u="undefined"!=typeof i.autoPlayDelay?i.autoPlayDelay:5e3,l="undefined"!=typeof i.touchSwipe?i.touchSwipe:!0,f="undefined"!=typeof i.buttons?i.buttons:!0,r="undefined"!=typeof i.arrows?i.arrows:!0,p="undefined"!=typeof i.fadeArrows?i.fadeArrows:!0,s="undefined"!=typeof i.shuffle?i.shuffle:!1,h="undefined"!=typeof i.fullscreen?i.fullscreen:!1,y="undefined"!=typeof i.slideDistance?i.slideDistance:0,m="undefined"!=typeof i.heightAnimationDuration?i.heightAnimationDuration:500,c="undefined"!=typeof i.thumbnailPointer?i.thumbnailPointer:!1,b="undefined"!=typeof i.thumbnailHeight?i.thumbnailHeight:70,g="undefined"!=typeof i.thumbnailWidth?i.thumbnailWidth:70,w="undefined"!=typeof i.updateHash?i.updateHash:!1,A="undefined"!=typeof i.fadeCaption?i.fadeCaption:!0,D="undefined"!=typeof i.autoHeight?i.autoHeight:!0;$(".wpsp-slider-slide, .wpsp-slider-thumbnails").css({opacity:1,display:"block"}),e.sliderPro({responsive:!0,width:"100%",height:"300",fade:n,touchSwipe:l,fadeDuration:t,slideAnimationDuration:t,autoHeight:D,heightAnimationDuration:m,arrows:r,fadeArrows:p,autoplay:d,autoplayDelay:u,buttons:f,shuffle:s,orientation:a,loop:o,keyboard:!1,fullScreen:h,slideDistance:y,thumbnailHeight:b,thumbnailWidth:g,thumbnailPointer:c,updateHash:w,thumbnailArrows:!1,fadeThumbnailArrows:!1,thumbnailTouchSwipe:!0,fadeCaption:A,captionFadeDuration:500,waitForLayers:!0,autoScaleLayers:!0,forceSize:"none",thumbnailPosition:"bottom",reachVideoAction:"playVideo",leaveVideoAction:"pauseVideo",endVideoAction:"nextSlide",init:function(){e.prev(".wpsp-slider-preloaderimg").hide(),e.parent(".gallery-format-post-slider")&&$(".blog-masonry-grid").length&&setTimeout(function(){$(".blog-masonry-grid").isotope("layout")},m+1)},gotoSlideComplete:function(){e.parent(".gallery-format-post-slider")&&$(".blog-masonry-grid").length&&$(".blog-masonry-grid").isotope("layout")}})});
                }

                // Lightbox
                if ( $.fn.iLightBox != undefined) {

                    wpspLocalize.lightboxArrows="1"===wpspLocalize.lightboxArrows?!0:!1,wpspLocalize.lightboxThumbnails="1"===wpspLocalize.lightboxThumbnails?!0:!1,wpspLocalize.lightboxFullScreen="1"===wpspLocalize.lightboxFullScreen?!0:!1,wpspLocalize.lightboxMouseWheel="1"===wpspLocalize.lightboxMouseWheel?!0:!1,wpspLocalize.lightboxTitles="1"===wpspLocalize.lightboxTitles?!0:!1,$(".wpsp-lightbox, .wpb_single_image.image-lightbox a").each(function(){var e=$(this),i=e.data(),l="undefined"!=typeof i.skin?i.skin:wpspLocalize.lightboxSkin;e.iLightBox({skin:l,controls:{fullscreen:wpspLocalize.lightboxFullScreen}})}),$(".wpsp-lightbox-video, .wpb_single_image.video-lightbox a, .wpsp-lightbox-autodetect, .wpsp-lightbox-autodetect a").iLightBox({skin:wpspLocalize.LightboxSkin,path:"horizontal",smartRecognition:!0,show:{title:wpspLocalize.lightboxTitles},controls:{fullscreen:wpspLocalize.lightboxFullScreen,mousewheel:wpspLocalize.lightboxMouseWheel}}),$(".lightbox-group").each(function(){var e=$(this),i=e.find("a.wpsp-lightbox-group-item"),l=e.data(),o="undefined"!=typeof l.skin?l.skin:wpspLocalize.lightboxSkin,t="undefined"!=typeof l.path?l.path:"horizontal",x="undefined"!=typeof l.arrows?l.arrows:wpspLocalize.lightboxArrows,a="undefined"!=typeof l.thumbnails?l.thumbnails:wpspLocalize.lightboxThumbnails;i.iLightBox({skin:o,path:t,show:{title:wpspLocalize.lightboxTitles},controls:{arrows:x,thumbnail:a,fullscreen:wpspLocalize.lightboxFullScreen,mousewheel:wpspLocalize.lightboxMouseWheel}})}),$(".wpsp-lightbox-gallery").on(wpspLocalize.isMobile?"touchstart":"click",function(e){e.preventDefault();var i=$(this).data("gallery").split(",");i&&$.iLightBox(i,{skin:wpspLocalize.lightboxSkin,path:"horizontal",show:{title:wpspLocalize.lightboxTitles},controls:{arrows:wpspLocalize.lightboxArrows,thumbnail:wpspLocalize.lightboxThumbnails,fullscreen:wpspLocalize.lightboxFullScreen,mousewheel:wpspLocalize.lightboxMouseWheel}})});

                }

            } );
        } );
    } );
} )( jQuery );