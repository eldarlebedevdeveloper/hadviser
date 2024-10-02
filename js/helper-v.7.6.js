jQuery(function ($) {
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

    function resetToInitialStyles() {
        $(".theiaPostSlider_slides").css("overflow", "hidden");
        $(".theiaPostSlider_slides>div").css("overflow", "hidden");
		$(".theiaPostSlider_nav._lower").css("display", "block");
        $(".extra-content").remove();
        $(".pinterest-container").css({ right: "0", left: "0" });
        $(document).off("click touchstart", stopTimer);
    }

    var timer;
	
    function startTimer() {
        timer = setTimeout(function () {
            resetToInitialStyles();
			var advEl = $("div.ad").first();
            var topOffset = advEl.offset().top - 30;
            setTimeout(function () {
                $("html, body").animate({ scrollTop: topOffset }, 0);
            }, 10);
        }, 3000);
    }

    function stopTimer() {
        clearTimeout(timer);
        resetToInitialStyles();
    }

    function isNextSession() {
        var hadviser_mobile_timestamp = localStorage.getItem(
            "hadviser_mobile_timestamp"
        );
        var oneDay = 60 * 60 * 24 * 1000;
        return new Date() - hadviser_mobile_timestamp < oneDay;
    }

    var slideChangeCount = 0;
    var rehreshOnSlide = 5;
	var slideChangeCountoneDay = 0;
	var rehreshOnSlideoneDay = 12;
	
	$(document).bind("theiaPostSlider.changeSlide", function(
            event,
            slideIndex
        ) {
            slideChangeCountoneDay++;
            if (slideChangeCountoneDay === rehreshOnSlideoneDay) {
				location.reload();
            }
        });

    if (isNextSession()) {
        $(document).bind("theiaPostSlider.changeSlide", function(
            event,
            slideIndex
        ) {
            slideChangeCount++;
            if (slideChangeCount === rehreshOnSlide) {
				location.reload();
            }
        });

        return;
    }

    localStorage.setItem("hadviser_mobile_timestamp", new Date().getTime());

    $(document).bind("theiaPostSlider.changeSlide", function (
        event,
        slideIndex
    ) {
            var firstHeight = $(".theiaPostSlider_slides img").eq(0).height();
            var nextHeight = $(".theiaPostSlider_slides img").eq(1).height();
       
	   setTimeout(function () {
        if (nextHeight - firstHeight > 110) {
            $(".theiaPostSlider_slides").css("overflow", "visible");
            $(".theiaPostSlider_slides>div").css("overflow", "visible");
			$(".theiaPostSlider_nav._lower").css("display", "none");
            $("article.post").prepend(
                '<div class="extra-content" style="width: 160%; height: 1px"></div>'
            );
            $(".pinterest-container").css({
                right: "-60%",
                left: "auto",
            });

            startTimer();
            $(document).on("click touchstart", stopTimer);
        }
        }, 300);
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