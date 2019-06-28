jQuery(document).ready(function($){
    if ($('#billing_country').find('option:selected').html() == 'Hrvatska'){
	if(typeof mx_hr_postcodes != 'undefined' && $('.woocommerce-checkout #billing_postcode').length){
		var $postcodeField = $('.woocommerce-checkout #billing_postcode');
		var $cityField = $('.woocommerce-checkout #billing_city');
		var cityFieldTouched = false;

		// If city is manually added, don't change it.
		$cityField.keyup(function() {
			cityFieldTouched = true;
		});

		$postcodeField.on('input change focusout keyup', function(){
			var postcode = parseInt($postcodeField.val());
			var cityIndex = mx_hr_postcodes.indexOf(postcode);
			var city = mx_hr_cities[cityIndex];
			if($postcodeField.val().length == 5 && cityIndex > -1 && ($cityField.val() == '' || !cityFieldTouched) && mx_hr_postcodes[cityIndex+1] != postcode){
				$cityField.val( city );
			}
		});
	}
	}

});
