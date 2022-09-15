function log( message ) {
    $( "<div>" ).text( message ).prependTo( "#log" );
    $( "#log" ).scrollTop( 0 );
}

$(document).ready(function(){

    $("#home-location-search").autocomplete({
        source: function( request, response ) {
            $.ajax( {
                url: "https://nominatim.openstreetmap.org/search?q="+ request.term +"&format=json&polygon=1&addressdetails=1",
                beforeSend: function() {
                    $("#home-location-search").prop('readonly', true);
                    $(".home-location-btn").val("Please Wait...");
                },
                success: function( data ) {
                    var c = [];
                    $("#home-location-search").prop('readonly', false)
                    $(".home-location-btn").val("Search");
                    $(".home-location-search").focus();
                    $.each(data, function (i, a) {
                        a.label = a.display_name;
                        c.push(a);
                    });

                    response(data);
                },
            });
        },
        select: function(event, selectedOpt) {
            console.log(selectedOpt)
            $("#home-location-lat").val(selectedOpt.item.lat);
            $("#home-location-long").val(selectedOpt.item.lon);
        },
        minLength: 4,
    });
});
