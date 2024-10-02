


$(document).ready(function() {
    $('#button-comments-colapse').on('click', function(){
        $('.comments-box__list-comments-container').slideToggle(500)
    })
});

$('.header__mobile-menu-open').on('click', function(){
    $('.header__mobile-menu-open').fadeOut(500)
    $('.header__mobile-menu-close').delay(400).fadeIn()
    $('.header__navigation').slideToggle(500)
})
$('.header__mobile-menu-close').on('click', function(){
    $('.header__mobile-menu-close').fadeOut(500)
    $('.header__mobile-menu-open').delay(400).fadeIn()
    $('.header__navigation').slideToggle(500) 
})


if (window.matchMedia('(max-width: 992px)').matches && window.matchMedia('(min-width: 680px)').matches ) {
    $('.header__search-form-open').on('click', function(e){
        $('.search-form').addClass('active')
        $('.header__search-form-open').fadeOut(500)
        $('.header__search-form-close').delay(500).fadeIn()
        $('.header__container .social-icons ').slideUp(100)
    })
    $('.header__search-form-close').on('click', function(e){
        $('.search-form').removeClass('active')
        $('.header__search-form-open').delay(500).fadeIn()
        $('.header__search-form-close').fadeOut(500)
        $('.header__container .social-icons ').slideDown(100)
    })
}

if (window.matchMedia('(max-width: 680px)').matches && window.matchMedia('(min-width: 600px)').matches) {
    $('.header__search-form-open').on('click', function(e){
        $('.search-form').addClass('active')
        $('.header__search-form-open').fadeOut(500)
        $('.header__search-form-close').delay(500).fadeIn()
        $('.header__container .social-icons').slideUp(100)
        $('.header__container .logo').slideUp(100)
    }) 
    $('.header__search-form-close').on('click', function(e){
        $('.search-form').removeClass('active')
        $('.header__search-form-open').delay(500).fadeIn()
        $('.header__search-form-close').fadeOut(500)
        $('.header__container .social-icons').slideDown(100)
        $('.header__container .logo').slideDown(100)
    })
} 

if (window.matchMedia('(max-width: 600px)').matches && window.matchMedia('(min-width: 0px)').matches) {
    $('.header__search-form-open').on('click', function(e){
        $('.search-form').delay(100).addClass('active')
        $('.header__search-form-open').fadeOut(500)
        $('.header__search-form-close').delay(500).fadeIn()
        $('.header__container .social-icons').slideUp(0)
        $('.header__container .logo').slideUp(100)
    }) 
    $('.header__search-form-close').on('click', function(e){
        $('.search-form').delay(100).removeClass('active')
        $('.header__search-form-open').delay(500).fadeIn()
        $('.header__search-form-close').fadeOut(500)
        $('.header__container .social-icons').slideUp(0)
        $('.header__container .logo').slideDown(100)
    })
} 



