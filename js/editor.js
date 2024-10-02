jQuery(function($){
	 $('.multiSelect select').multiSelect();
	 $('#goplyak-tabs a').click(function() {
		 var form = $(this).attr("href");
		$('#goplyak-tabs a').removeClass('nav-tab-active');
		$(this).addClass('nav-tab-active');
		$('.goplyaktab').hide();
		$(form).show();
		return false;
	});
	$(document).on('click', '.changeSelect', function() {
        $('.multiSelect select').multiSelect();
		$(this).next().show();
		return false;
	});
	$(document).on('click', '.widget-inside .button-primary', function() {
        $('.hideSelect').hide();
		return false;
	});
});
