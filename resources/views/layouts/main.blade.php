<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>HouseStars -  Smarter Property Sales</title>

    <link rel="icon" type="image/png" sizes="16x16" href="favicon.png">

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/housestars-main.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>

@yield("content")


    <footer>
      <div class="container main-footer">
        <div class="row widget">
          <div class="col-xs-3 company-identity">
              <img src="assets/logo-footer.png" alt="HouseStars" class="logo">
              <p class="label">Office Address</p>
              <p>100th Floor and Ground Floor, Commerce </br> Somewhere Avenue corner Somewhere Avenue, </br>Somewhere Disterict, Sydney</br>New South Wales, Australia</p>
              <p>Tel No: (000) 888-8888  |   Fax No: ((000) 888-8888 </p>
              <a href="#" class="hs-transparent-dark">Become Our Partner Agency</a>
          </div>
          <div class="col-xs-8 col-xs-offset-1 links">
            <div class="row footer-nav">
              <div class="col-xs-3 nav-category">
                <p class="label">The Company</p>
                <ul>
                  <li><a href="#">About Us</a></li>
                  <li><a href="#">Sitemap</a></li>
                  <li><a href="#">Contact Us</a></li>
                </ul>
              </div>
              <div class="col-xs-3 nav-category">
                <p class="label">Agency</p>
                <ul>
                  <li><a href="#">Our Agent Philosophy</a></li>
                  <li><a href="#">Agent FAQ</a></li>
                  <li><a href="#">Be an Agency</a></li>
                </ul>
              </div>
              <div class="col-xs-3 nav-category">
                <p class="label">Tradesman</p>
                <ul>
                  <li><a href="#">Our Service Philosophy</a></li>
                  <li><a href="#">Service FAQ</a></li>
                  <li><a href="#">Provide a Service</a></li>
                </ul>
              </div>
              <div class="col-xs-3 nav-category">
                <p class="label">Customer</p>
                <ul>
                  <li><a href="#">Customer FAQ</a></li>
                  <li><a href="#">Review Guidelines</a></li>
                  <li><a href="#">Processing Page</a></li>
                </ul>
              </div>
            </div>
            <div class="row social-media">
              <div class="col-xs-4 social-item">
                <span class="icon icon-fb"></span>
                <a href="#">Housestars</a>
                <p>www.facebook.com/housestars</p>
              </div>
              <div class="col-xs-4 social-item">
                <span class="icon icon-ig"></span>
                <a href="#">@Housestars</a>
                <p>www.instagram.com/housestars</p>
              </div>
              <div class="col-xs-4 social-item">
                <span class="icon icon-tw"></span>
                <a href="#">@Housestars</a>
                <p>www.twitter.com/housestars</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="copyright">
        <div class="container">
          <p class="trademark">Copyright 2016 HouseStars</p>
          <ul class="legal-links">
            <li><a href="#">Terms and Conditions</a></li>
            <li><a href="#">Privacy Policy</a></li>
          </ul>
        </div>
      </div>
    </footer>
@include("modals")

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/custom.js"></script>

    @yield("scripts")
  </body>
</html>