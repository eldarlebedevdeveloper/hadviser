$(document).ready(function() {
    $('[data-author-click-link]').on('click', function(e) {
        let authorLinkValue = $(this).data('author-click-link')
        let popupElement = $('[data-author-popup="' + authorLinkValue + '"]')
        $('[data-author-popup]').addClass('hidden')
        popupElement.removeClass('hidden');
    });
    $('[data-author-popup]').click(function(){
        $('.author-popup').addClass('hidden')
    })   

    $('[data-author-click-link]').each(function(){
        let linkElement = $(this)
        let authorLinkValue = linkElement.data('author-click-link')
        let popupElement = $('[data-author-popup="' + authorLinkValue + '"]')
        addOrRemoveClass(linkElement, popupElement);
    })
});
 

function addOrRemoveClass(linkElement, popupElement) {
    let distances = getHorizontalDistance(linkElement);
    if (distances.left < distances.right) {
        popupElement.removeClass('author-popup--right')
    } else {
        popupElement.addClass('author-popup--right');
    }
}
function getHorizontalDistance(element) {
    let offset = element.offset();
    let elementWidth = element.outerWidth(true)
    let windowWidth = $(window).width();
    let distanceToLeft = offset.left;
    let distanceToRight = windowWidth - (offset.left + elementWidth);
    return {
        left: distanceToLeft, 
        right: distanceToRight
    };
}

