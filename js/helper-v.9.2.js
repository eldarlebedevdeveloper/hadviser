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

    manageNavigationButtons(6);
	

    if (isNextSession()) {}
	
	$(document).bind("theiaPostSlider.changeSlide", function(
            event,
            slideIndex
        ) {
            slideChangeCountoneDay++;
            if (slideChangeCountoneDay === rehreshOnSlideoneDay) {
				if (typeof pbjs !== 'undefined' && typeof pbjs.refresh === 'function') {
							pbjs.refresh(['admixer-hb-715-638022160357002547','admixer-hb-715-638022162181042805', 'admixer-hb-715-638022151786192846', 'admixer-hb-715-638022159672184155']);
							console.log('admixerRefresh');
                        }
				slideChangeCountoneDay = 0;
            }
        });

    function manageNavigationButtons(countOfSlideChanges) {

        if(sessionStorage.getItem("allowHrefBtn") === "no") {
            return;
        }

        var count = 0;

        $(document).bind("theiaPostSlider.changeSlide", function(
            event,
            slideIndex
        ) {
            count++;
            if (count === countOfSlideChanges - 1) {
                count = 0;
                sessionStorage.setItem("allowHrefBtn", "no");

                var pathName = window.location.pathname.replace(/^\/|\/$/g, "");
                var pathParams = pathName.split("/");

                var slideNummber = slideIndex + 1;

                var nextSlideNumber = slideNummber < 50 ? slideNummber + 1 : 1;
                var prevSlideNumber = slideIndex != 0 ? slideIndex : 50;

                var nextUrl = window.location.origin + '/' + pathParams[0] + '/' + nextSlideNumber + '/';
                var prevUrl = window.location.origin + '/' + pathParams[0] + '/' + prevSlideNumber + '/'

                $('._button._next').attr("href", nextUrl);
                $('._button._prev').attr("href", prevUrl);
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