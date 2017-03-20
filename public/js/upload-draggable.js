jQuery.event.props.push('dataTransfer');
function allowDrop(ev) {
    ev.preventDefault();
    return false;
}

function drag(ev) {
  ev.stopPropagation();
}

$('#profile-img, #cover-container').bind('drop', function( event ) {
  $target = $(event.target);
  url = event.dataTransfer.getData('URL');
  $target.find("input[type='hidden']:first").val(url);
  $target.find("input[type='file']:first").val('');
  $target.css('background-image', "url('" + url + "')");
});