jQuery(function ($) {
    function isNextSession() {
        var hadviser_page_refresh = sessionStorage.getItem(
            "pageRefreshed"
        );
        var oneDay = 60 * 60 * 24 * 1000;
        return new Date() - hadviser_page_refresh < oneDay;
    }

    var slideChangeCount = 0;
    var rehreshOnSlide = 3;
	var slideChangeCountoneDay = 0;
	var rehreshOnSlideoneDay = 3;
	

    if (isNextSession()) {
	$(document).bind("theiaPostSlider.changeSlide", function(
            event,
            slideIndex
        ) {
            slideChangeCountoneDay++;
            if (slideChangeCountoneDay === rehreshOnSlideoneDay) {
				if (typeof googletag !== 'undefined' && typeof googletag.pubads === 'function') {
                            googletag.pubads().refresh();
							console.log('mobileRefresh');
                        }
				slideChangeCountoneDay = 0;
            }
        });
    }

	
    function isMobileScreen() {
        if (window.innerWidth < 767) {
            return true;
        }
        return false;
    }

    if (!isMobileScreen()) return;
	
    var initialSlideNumber = getInitialSlideNumber();

    if(initialSlideNumber !== 1) {
        replaceTextPositionInDom();
		$(".theiaPostSlider_slides").css("margin-top", "20px");
		$(".theiaPostSlider_slides").css("margin-bottom", "40px");
    }

    $(document).bind("theiaPostSlider.changeSlide", function (
        event,
        slideIndex
    ) {
        if (slideIndex !== 0) {
            replaceTextPositionInDom();
			$(".theiaPostSlider_slides").css("margin-top", "20px");
			$(".theiaPostSlider_slides").css("margin-bottom", "40px");
        }
    });
	
    function replaceTextPositionInDom() {
        $(".theiaPostSlider_slides > div:last-child p")
            .detach()
            .appendTo(".theiaPostSlider_slides > div:last-child");
    }

    function getInitialSlideNumber() {
		var pathName = window.location.pathname.replace(/^\/|\/$/g, "");
		var pathParams = pathName.split("/");
		var lastParam = pathParams[pathParams.length - 1];
		var initialSlideNumber = isNaN(lastParam) ? 1 : lastParam;

		return +initialSlideNumber;
	};
});