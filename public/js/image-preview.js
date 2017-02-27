//Single Upload
function readURL(input, url) {
  if (input.files && input.files[0]) {
      var preview = url;
      var reader = new FileReader();

      reader.onload   = function (e) {
        $(preview).attr('style', 'background: url(' + e.target.result + ') center top no-repeat');
      }

      reader.readAsDataURL(input.files[0]);
  }
}


$("#CoverUpload").change(function () {
  readURL(this, '#cover-container');
});

$("#profileupload").change(function () {
  readURL(this, '.profile-img');
});