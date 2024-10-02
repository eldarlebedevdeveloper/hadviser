jQuery(function($) {
  function isOnScreen(elem) {
    // if the element doesn't exist, abort
    if (elem.length == 0 || $(elem).css("display") === "none") {
      return;
    }
    var $window = jQuery(window);
    var viewport_top = $window.scrollTop();
    var viewport_height = $window.height();
    var viewport_bottom = viewport_top + viewport_height;
    var $elem = jQuery(elem);
    var top = $elem.offset().top - 200;
    var height = $elem.height();
    var bottom = top + height;

    return (
      (top >= viewport_top && top < viewport_bottom) ||
      (bottom > viewport_top && bottom <= viewport_bottom) ||
      (height > viewport_height &&
        top <= viewport_top &&
        bottom >= viewport_bottom)
    );
  }

  function getInitialSlideNumber() {
    var pathName = window.location.pathname.replace(/^\/|\/$/g, "");
    var pathParams = pathName.split("/");
    var lastParam = pathParams[pathParams.length - 1];
    var initialSlideNumber = isNaN(lastParam) ? 1 : lastParam;
  
    return initialSlideNumber;
  };

  var triggerElement = $(".post-content-wrapper");

  hideContent(triggerElement);
  
  window.addEventListener("scroll", function(e) {
    hideContent(triggerElement);
  });
  
  var isContentHidden = false;
  
  function hideContent(triggerElement) {
    if(isContentHidden) return;
    if (isOnScreen(triggerElement)) {
      triggerElement.css("display", "none");
      isContentHidden = true;
    }
  }
  
  var initialSlideNumber = getInitialSlideNumber();

  var header = $(".post-title-line h1");
  var initialHeaderFont = {
    "font-size": "24px",
    "line-height": "26px"
  };

  var increasedHeaderFont = {
    "font-size": "32px",
    "line-height": "35px"
  };

  if (initialSlideNumber === 1 && isMobileScreen()) {
    header.css(increasedHeaderFont);
  };

  function isMobileScreen() {
    if (window.innerWidth < 768) {
        return true;
    }
    return false;
  };

  $(document).bind("theiaPostSlider.changeSlide", function (event, slideIndex) {
    if(isMobileScreen() && slideIndex === 0) {
      header.css(increasedHeaderFont);
    } else if(isMobileScreen() && header.css("font-size") !== initialHeaderFont["font-size"]) {
      header.css(initialHeaderFont);
    }
	});
});
