        jQuery(function ($) {
   
        var executed = false;
        $(document).bind('theiaPostSlider.changeSlide', function (event, slideIndex) {
            if (!executed) {
                executed = true; 
                $('.slides').css({
                    'margin-bottom': '30px',
                    'margin-top': '30px',
                    'height': ''
                }).attr('id', 'hadvisecom_slider_pages_1');
                loadAd(slideIndex);
            }
        });
            function loadAd(slideIndex) {
                freestar.queue.push(function() {
                    freestar.newAdSlots([
                        {
                            placementName: 'hadvisecom_slider_pages_1',
                            slotId: 'hadvisecom_slider_pages_1',
                        }
                    ]);
                });
            }
        });