@extends("layouts.main")

<?php
  $uploadUrl = config('app.url') . '/upload' . ($data['isAdmin'] ? '/'.$data['id'] : '');
  $userId = $data['isAdmin'] ? '/' . $data['id'] : '';
?>

@section("content")
<div id="loading"><div class="loading-screen"><img id="loader" src="{{asset('assets/loader.png')}}" /></div></div>

<header id="header" class="animated desktop">
        <div class="container">
          <div class="row">
            <div class="col-xs-3 branding">
              <a href="{{env('APP_URL')}}/"><img src="{{asset('assets/logo-nav.png')}}" alt="HouseStars Logo"></a>
            </div>
            <div class="col-xs-7 col-xs-offset-2 navigation">
              <div class="row top-links">
                <div class="customer-care">
                  <p><span class="label">Call Customer Care </span><a href="tel:0404045597" class="number">0404045597</a></p>
                </div>
                <div class="nav-items">
                  <ul>
                    @if(Sentinel::check())
                      <li><a>Hi, {{Sentinel::getUser()->name}}</a></li>
                    @else
                      <li><a href="#" data-toggle="modal" data-target="#login">Login</a></li>
                    @endif
                  </ul>
                </div>
              </div>
              <div class="row">
                <div class="main-nav">
                  <ul>
                    @if(Sentinel::check())
                    <li><span class="icon icon-logout-dark"></span>
                      <form action="{{env('APP_URL')}}/logout" method="POST" id="logout-form">
                        {{csrf_field() }}
                        <a href="#" onclick="document.getElementById('logout-form').submit()">Logout</a>
                      </form>
                    </li>
                    <li><span class="icon icon-tradesman-dark"></span><a href="{{env('APP_URL')}}/profile">Profile</a></li>
                    <li><span class="icon icon-home-dark"></span><a href="{{env('APP_URL')}}/">Home</a></li>
                    @else
                    <li><span class="icon icon-customer-dark"></span><a href="{{env('APP_URL')}}/customer" >Customer</a></li>
                    <li><span class="icon icon-tradesman-dark"></span><a href="{{env('APP_URL')}}/trades-services">Trades & Services</a></li>
                    <li><span class="icon icon-agency-dark"></span><a href="{{env('APP_URL')}}/agency">Agency</a></li>
                    <li><span class="icon icon-home-dark"></span><a href="{{env('APP_URL')}}/">Home</a></li>
                    @endif
                  </ul>
                </div>
              </div>
            </div>
          </div>
    </header>
 <form action="{{env('APP_URL')}}/update-profile{{$userId}}" method="POST" enctype="multipart/form-data">
    @if(filter_var($data['cover-photo'], FILTER_VALIDATE_URL) === FALSE)
      @php ($data['cover-photo'] = config('app.url') . '/' . $data['cover-photo'])
    @endif
    <section ondragover="allowDrop(event);" id="cover-container" class="header-margin" style="background: url({{$data['cover-photo']}})">
      {{csrf_field() }}
      <div class="cover-img">
        <div class="breadcrumbs container">
          <div class="row">
            <p class="links small-screen"><a href="/">Home Page</a> > <a href="/agency">Agency</a> > <span class="blue">Agency Dashboard</span> </p>
            <div class="upload">
              <input id="CoverUpload" type="file" name="cover-photo" class="tooltip-info" data-toggle="tooltip" data-placement="left" title="" data-original-title="" data-html="true"> <!-- <b>Minimum size: 1328 x 272</b> -->
              <input id="cover-photo-drag" type='hidden' name="cover-photo-drag" />
            <button class="btn hs-secondary update-cover"><span class="icon icon-image"></span> Change Photo</button>
            </div>
          </div>
          <div class="profile">
            @if(filter_var($data['profile-photo'], FILTER_VALIDATE_URL) === FALSE)
              @php ($data['profile-photo'] = config('app.url') . '/' . $data['profile-photo'])
            @endif
            <div ondragover="allowDrop(event);" class="profile-img" id="profile-img" style="background: url('{{ $data['profile-photo'] }}') 100%">
              <button class="btn hs-secondary update-profile"><span class="icon icon-image"></span> Change Photo</button>
              <input id="profileupload" type="file" name="profile-photo" class="tooltip-info" data-toggle="tooltip" data-placement="right" title="" data-original-title="" data-html="true"> <!-- <b>Minimum size: 117 x 117</b> -->
              <input id="profileupload-drag" type='hidden' name="profile-photo-drag" />
            </div>
            <div class="profile-info edit">
              <label>Agency Trading Name</label>

              @if(isset($data['trading-name']))
              <input type="text" name="trading-name" value="{{$data['trading-name']}}">
              @else
              <input type="text" name="trading-name" value="">
              @endif
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="edit-user-info">
      <div class="container">
        <div class="row">
          <div class="col-xs-10 col-xs-offset-2">
            <div class="col-xs-4">
              <div id="image-holder"> </div>
              <label>ABN</label>
              @if(isset($data['abn']))
              <input type="text" name="abn" value="{{$data['abn']}}">
              @else
              <input type="text" name="abn" value="">
              @endif
            </div>
            <div class="col-xs-4">
              <label>Address</label>

              @if(isset($data['business-address']))
              <input type="text" name="business-address" value="{{$data['business-address']}}">
              @else
              <input type="text" name="business-address" value="">
              @endif
            </div>
            <div class="col-xs-4">
              <label>Base Commission Charge</label>

              @if(isset($data['base-commission']))
              <input type="text" name="base-commission" value="{{$data['base-commission']}}">
              @else
              <input type="text" name="base-commission" value="">
              @endif
            </div>
          </div>
          <div class="col-xs-2">

            </div>
          <div class="col-xs-10">
            <div class="col-xs-4">
              <label>Business Name</label>

              @if(isset($data['agency-name']))
              <input type="text" name="agency-name" value="{{$data['agency-name']}}">
              @else
              <input type="text" name="agency-name" value="">
              @endif
            </div>
            <div class="col-xs-4">
              <label>Website</label>

              @if(isset($data['website']))
              <input type="text" name="website" value="{{$data['website']}}">
              @else
              <input type="text" name="website" value="">
              @endif
            </div>
            <div class="col-xs-4">
              <label>Marketing Budget</label>

               @if(isset($data['marketing-budget']))
              <input type="text" name="marketing-budget" value="{{$data['marketing-budget']}}">
              @else
              <input type="text" name="marketing-budget" value="">
              @endif
            </div>
          </div>
          <div class="col-xs-10 col-xs-offset-2">
            <div class="col-xs-4">
              <label>Principal Name</label>
              <input type="text" name="principal-name" value="{{ isset($data['principal-name']) ? $data['principal-name'] : '' }}">
            </div>
            <div class="col-xs-4">
              <label>Phone</label>
              <input type="text" name="phone" value="{{ isset($data['phone']) ? $data['phone'] : ''}}">
            </div>
          </div>
          <!-- Gallery -->
          <div class="container gallery-uploader agency">
            <div class="col-xs-10 col-xs-offset-2">
                <div class="upload-gallery" style="margin: 35px 0;">
                  <div class="col-xs-7">
                    <label>Gallery Photos</label>
                    <div id="gallery-carousel" class="carousel slide multi-item-carousel">
                      <div class="carousel-inner" id='lightgallery'>
                        @include('dashboard.agency.partials.gallery_items')
                      </div>
                      <!-- Left and right controls -->
                      <a class="left carousel-control" href="#gallery-carousel" role="button" data-slide="prev" style="display: {{ $data['hasGallery'] ? 'block;' : 'none;'}} ">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                      </a>
                      <a class="right carousel-control" href="#gallery-carousel" role="button" data-slide="next" style="display: {{ $data['hasGallery'] ? 'block;' : 'none;'}} ">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                      </a>
                    </div>
                  </div>
                  <div class="col-xs-5">
                    <label>Upload More Gallery Photos</label>
                    <div id='msg'>
                      <span class='error gallery-error-span' style="display: none;"> </span>
                      <span class='success gallery-success-span' style="display: none;"> </span>
                    </div>
                    <div class="upload-media">
                      <div id="agency-gallery" class="dropzone">
                        {{ csrf_field() }}
                        <div class="dz-default dz-message">
                          click or drag photos here
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
          </div>
          <!-- end Gallery -->
          <div class="col-xs-10 col-xs-offset-2">
            <div class="col-xs-8">
            <label>Write Agency Summary</label>

            @if(isset($data['summary']))
              <textarea style="height: 150px;" name="summary">{{$data['summary']}}</textarea>
              @else
              <textarea style="height: 150px;" name="summary"></textarea>
              @endif
            </div>
            <div class="col-xs-4 btn-holder">
              <div class="spacing"></div>
              <button class="btn hs-primary" style="margin-bottom: 5px;"><span class="icon icon-save" style="margin-top: 6px;"></span>SAVE CHANGES <span class="icon icon-arrow-right"></span></button>
              <a href="/profile{{$data['isAdmin'] ? '/agency/'.$data['id'] : '/' }}" class="btn hs-primary">
                <span class="fa fa-times"></span>
                CANCEL
                <span class="icon icon-arrow-right pull-right"></span>
              </a>
            </div>
          </div>
          <div class="spacing"></div>
        </div>
      </div>
    </section>
  </form>

@endsection

 @section('scripts')
  @parent
  <script>
    function lightGalleryInit() {
      return $("#lightgallery").lightGallery({
                selector: '.img-item'
              });
    }
    var gallery = lightGalleryInit();
    var hasError = '{{ $errors->any() }}';
    if(hasError) {
      $('#editErrorModal').modal('show');
    }
  </script>
  <script type="text/javascript">
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
      });
      function readURL(input, url) {
          if (input.files && input.files[0]) {
              var preview = url;
              var reader = new FileReader();

              reader.onload   = function (e) {
                  $(preview).attr('style', 'background: url(' + e.target.result + ') center top no-repeat');
              }

              reader.readAsDataURL(input.files[0]);
          }
          $(url).find("input[type='hidden']").val('');
      }

      $("#CoverUpload").change(function () {
          readURL(this, '#cover-container');
      });

      $("#profileupload").change(function () {
          readURL(this, '.profile-img');
      });

      $(document).ready(function () {
          Dropzone.autoDiscover = false;
          $("#agency-gallery").dropzone({
              url: "{{ $uploadUrl }}",
              acceptedFiles: ".png, .jpg, .gif, .tiff, .bmp",
              sending: function(file, xhr, formData) {
                  formData.append("_token", $('[name=_token').val());
                  if ($("#loading").not(':visible')) {
                    $("#loading").fadeIn("slow");
                  }
                  if (gallery.data('lightGallery')) {
                    gallery.data('lightGallery').destroy(true);
                  }
              },
              queuecomplete: function() {
                $("#loading").fadeOut("slow");
                gallery = lightGalleryInit();
              },
              success: function (file, response) {
                  var imgName = response;
                  file.previewElement.classList.add("dz-success");
                  $('.carousel-inner .item').remove();
                  $('.carousel-inner').append(response.data.html);
                  $('.gallery-success-span').show().text('Successfully added to the gallery.').delay(1000).fadeOut('slow');
                  file.previewElement.remove();
                  $('.carousel-control').show();
              },
              error: function (file, response) {
                $('.gallery-error-span').show().text(response.error).delay(1000).fadeOut('slow');
                file.previewElement.remove();
              }
          });
      });
      
      $('body').on('click', '.remove-photo', function (e) {
        if(confirm("Are you sure you want to delete this photo?")) {
          $.ajax({
            method: "POST",
            url: "{{ route('delete.gallery.photo')  }}",
            data: {
              id: $(this).data('id'),
              filename: $(this).data('filename')
            },
            dataType : 'json',
            beforeSend: function() {
              if (gallery.data('lightGallery')) {
                gallery.data('lightGallery').destroy(true);
              }
            },
            error: function() {
              gallery = lightGalleryInit();
            },
            success: function(responseData, textStatus, jqXHR) {
              $('.carousel-inner .item').remove();
              $('.carousel-inner').append(responseData.html);
              gallery = lightGalleryInit();
              if($('.carousel-inner .item').get().length == 0) {
                $('.carousel-control').hide();
              }
            }
          });
        }
      });
  </script>
  <script type="text/javascript" src="{{asset('js/upload-draggable.js')}}"></script>
  <script src="{{asset('js/image-preview.js')}}"></script>
 @stop
