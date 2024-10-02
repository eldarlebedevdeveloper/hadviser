// Hide author block on all slides except slide 1;
// Hide comments block on all slides except slide 1;
// Hide last 2 popular posts blocks on 1st slide

jQuery(function ($) {

  var initialSlideNumber = getInitialSlideNumber();

  function getInitialSlideNumber() {
    var pathName = window.location.pathname.replace(/^\/|\/$/g, '');
    var pathParams = pathName.split('/');
    var lastParam = pathParams[pathParams.length - 1];
    var initialSlideNumber = isNaN(lastParam) ? 1 : lastParam;

    return +initialSlideNumber;
  };

  if (initialSlideNumber > 1) {
    $('.author-boxline_single').hide();
    $('#comments').hide();
  };

  if (initialSlideNumber === 1) {
    $('.posts-after-single .item-popular_posts').slice(-2).hide();
  };

  function manageAuthorBlock(slideIndex) {
    var authorBlock = $('.author-boxline_single');
    var comments = $('#comments');

    if (slideIndex === 0 && authorBlock.is(':hidden')) {
      authorBlock.show();
      comments.show();
    } else if (authorBlock.is(':visible')) {
      authorBlock.hide();
      comments.hide();
    }
  };

  function managePopularPosts(slideIndex) {
    var popularPosts = $('.posts-after-single .item-popular_posts').slice(-2);

    if (slideIndex === 0 && popularPosts.is(':visible')) {
      popularPosts.hide();
    } else if (popularPosts.is(':hidden')) {
      popularPosts.show();
    }
  };

  $(document).bind('theiaPostSlider.changeSlide', function (event, slideIndex) {
    manageAuthorBlock(slideIndex);
    managePopularPosts(slideIndex);
  });
});
