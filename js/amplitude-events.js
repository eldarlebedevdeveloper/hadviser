jQuery(function ($) {
    function isElementInViewport(el) {
        if (typeof jQuery === "function" && el instanceof jQuery) {
            el = el[0];
        }

        var rect = el.getBoundingClientRect();

        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <=
                (window.innerHeight ||
                    document.documentElement
                        .clientHeight) /* or $(window).height() */ &&
            rect.right <=
                (window.innerWidth ||
                    document.documentElement
                        .clientWidth) /* or $(window).width() */
        );
    }

    function onVisibilityChange(el, callback) {
        var old_visible;
        return function () {
            var visible = isElementInViewport(el);
            if (visible != old_visible) {
                old_visible = visible;
                if (typeof callback == "function") {
                    callback(visible);
                }
            }
        };
    }

    var image = $(".theiaPostSlider_slides img");
    var location = window.location.href;
    var slideNumber = getInitialSlideNumber();

    var changeTimestamp = null;

    function logEventToAmplitude() {
        var timediff = changeTimestamp
            ? new Date().getTime() - changeTimestamp
            : null;
        if (timediff < 1000) return;

        var eventData = {
            location: location,
            image: image.attr("src"),
            isMobile: isMobileScreen(),
            duration: timediff,
            slideNumber: +slideNumber,
        };

        amplitude
            .getInstance()
            .logEvent("Image view duration", eventData);
    }

    function handler() {
        return onVisibilityChange(image, function (isVisible) {
            if (!isVisible) {
                logEventToAmplitude();
            }
            changeTimestamp = new Date().getTime();
        });
    }

    var onChangeHandler = handler();

    $(window).on("resize scroll", onChangeHandler);

    $(document).bind("theiaPostSlider.changeSlide", function (
        event,
        slideIndex
    ) {
        $(window).off("resize scroll", onChangeHandler);
        image = $(".theiaPostSlider_slides img").last();
        location = window.location.href;
        slideNumber = slideIndex + 1;
        onChangeHandler = handler();
        changeTimestamp = null;
        $(window).on("resize scroll", onChangeHandler);
    });

    function onClickSlideBtnsHandler() {
        var isInViewport = isElementInViewport(image);
        if (isInViewport) {
            logEventToAmplitude();
            changeTimestamp = null;
        }
    }

    $("a._button").click(onClickSlideBtnsHandler);

    function isMobileScreen() {
        if (window.innerWidth < 768) {
            return true;
        }
        return false;
    }

    function getInitialSlideNumber() {
        var pathName = window.location.pathname.replace(/^\/|\/$/g, "");
        var pathParams = pathName.split("/");
        var lastParam = pathParams[pathParams.length - 1];
        var initialSlideNumber = isNaN(lastParam) ? 1 : lastParam;

        return initialSlideNumber;
    }
});
