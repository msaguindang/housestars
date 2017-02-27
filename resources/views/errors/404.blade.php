  @extends("layouts.main")
  @section("content")

  <section id="sign-up-form" class="header-margin">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 form-box" style="background: #fff;">
        <div class="form-desc">
        </br></br>
        <a href="/"><img src="{{asset('assets/logo-nav.png')}}" alt="HouseStars Logo"></a>
          <h2 style="margin: 36px; font-size: 109px;">Oops.</h2>
          <p style="font-size: 28px;">This page is not available.</p>
          <p style="
    background: #0f70b7;
    color: #fff;
    font-weight: bold;
    font-size: 15px;
    padding: 11px;
    width: 28%;
    margin: 0 auto;
">Go back to <a href="/">housestars.com.au</a></p>
        </div>
      </div>
    </div>
  </div>
</section>
<style type="text/css">
footer{
  display: none;
}

body, html {
  background: #0f70b7;
}
</style>

    @endsection