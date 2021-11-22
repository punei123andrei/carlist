(function($) {
    $(document).ready(function() {
    $('#car-listing-form select').on('change', function(){
        $('#car-listing-form').submit();
    });

    $('#car-listing-form').on('submit', function(e){
        e.preventDefault();
       let formvalue = $(this).serialize();
       let ajaxargs = formvalue + '&token=' + car_obj.token + '&action=get_cars';
    //    console.log(ajaxargs);
       $.ajax({
        type: "POST",
        url: car_obj.ajaxurl,
        data: ajaxargs,
        success: function (response) {
            $('.car-results').empty();
            for(var i = 0 ;  i < response.length ; i++) { 
                $('.car-results').append(`
                <div class="car-item-wrapper">
                <div class="car-title">${response[i].title}</div>
                <div class="d-flex justify-content-around fields-wrapper">
                    <div class="car-specs car-fuel">
                        <p>${response[i].fuel}</p>
                    </div>
                    <div class="car-specs car-brand">
                        <p>${response[i].brand}</p>
                    </div>
                    <div class="car-specs car-color">
                        <p>${response[i].color}</p>
                    </div>
                </div>
            </div>
                `);
            }
            
        },
        error: function (errorThrown) {
            console.log(errorThrown);
        }
    });
    });
    });
})(jQuery);