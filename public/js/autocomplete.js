$(function () {
    var projects = [{
        value: "Cagayan de Oro",
        label: "9000",
        available: "1"
    }, {
        value: "Davao City",
        label: "9001",
        available: "2"
    }, {
        value: "Iligan City",
        label: "9002",
        available: "3"
    }, {
        value: "Manila City",
        label: "9000",
        available: "0"
    }, {
        value: "Cebu City",
        label: "9001",
        available: "2"
    }, {
        value: "Bohol City",
        label: "9002",
        available: "2"
    }];

    $("#postcode").autocomplete({
        minLength: 0,
        source: projects,
        focus: function (event, ui) {
            $("#postcode").val(ui.item.label);
            return false;
        },
        select: function (event, ui) {
            $("#postcode").val(ui.item.label);
            $("#postcode-icon").attr("src", "assets/" + ui.item.icon);

            return false;
        }
    })
        .data( "ui-autocomplete" )._renderItem = function( ul, item ) {
          return $( "<li>" )
            .data( "ui-autocomplete-item", item )
            .append( '<a>' + item.value + '<span class="icn icon-available-' +  item.available + '"></span></a>' )
            .appendTo( ul );
        };
});