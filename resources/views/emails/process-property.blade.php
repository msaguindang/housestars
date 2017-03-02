<!doctype html>
<html>
  <head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Simple Transactional Email</title>
    <style>
      /* -------------------------------------
          GLOBAL RESETS
      ------------------------------------- */
      img {
        border: none;
        -ms-interpolation-mode: bicubic;
        max-width: 100%; }

      body {
        background-color: #f6f6f6;
        font-family: sans-serif;
        -webkit-font-smoothing: antialiased;
        font-size: 14px;
        line-height: 1.4;
        margin: 0;
        padding: 0; 
        -ms-text-size-adjust: 100%;
        -webkit-text-size-adjust: 100%; }

      table {
        border-collapse: separate;
        mso-table-lspace: 0pt;
        mso-table-rspace: 0pt;
        width: 100%; }
        table td {
          font-family: sans-serif;
          font-size: 14px;
          vertical-align: top; }

      /* -------------------------------------
          BODY & CONTAINER
      ------------------------------------- */

      .body {
        background-color: #f6f6f6;
        width: 100%; }

      /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
      .container {
        display: block;
        Margin: 0 auto !important;
        /* makes it centered */
        max-width: 580px;
        padding: 10px;
        width: 580px; }

      /* This should also be a block element, so that it will fill 100% of the .container */
      .content {
        box-sizing: border-box;
        display: block;
        Margin: 0 auto;
        max-width: 580px;
        padding: 10px; }

      /* -------------------------------------
          HEADER, FOOTER, MAIN
      ------------------------------------- */
      .main {
        border-radius: 3px;
        width: 100%; }

      .wrapper {
        box-sizing: border-box;
        padding: 20px; }

      .footer {
        clear: both;
        padding-top: 10px;
        text-align: center;
        width: 100%; }
        .footer td,
        .footer p,
        .footer span,
        .footer a {
          color: #999999;
          font-size: 12px;
          text-align: center; }

      /* -------------------------------------
          TYPOGRAPHY
      ------------------------------------- */
      h1,
      h2,
      h3,
      h4 {
        color: #000000;
        font-family: sans-serif;
        font-weight: 400;
        line-height: 1.4;
        margin: 0;
        Margin-bottom: 30px; }

      h1 {
        font-size: 35px;
        font-weight: 300;
        text-align: center;
        text-transform: capitalize; }

      p,
      ul,
      ol {
        font-family: sans-serif;
        font-size: 14px;
        font-weight: normal;
        margin: 0;
        Margin-bottom: 15px; }
        p li,
        ul li,
        ol li {
          list-style-position: inside;
          margin-left: 5px; }

      a {
        color: #3498db;
        text-decoration: underline; }

      /* -------------------------------------
          BUTTONS
      ------------------------------------- */
      .btn {
        box-sizing: border-box;
        width: 100%; }
        .btn > tbody > tr > td {
          padding-bottom: 15px; }
        .btn table {
          width: auto; }
        .btn table td {
          background-color: #ffffff;
          border-radius: 5px;
          text-align: center; }
        .btn a {
          background-color: #ffffff;
          border: solid 1px #3498db;
          border-radius: 5px;
          box-sizing: border-box;
          color: #3498db;
          cursor: pointer;
          display: inline-block;
          font-size: 14px;
          font-weight: bold;
          margin: 0;
          padding: 12px 25px;
          text-decoration: none;
          text-transform: capitalize; }

      .btn-primary table td {
        background-color: #3498db; }

      .btn-primary a {
          background-color: #0f70b7;
          border-color: #0f70b7;
          color: #ffffff;
          text-transform: uppercase;
      }

      /* -------------------------------------
          OTHER STYLES THAT MIGHT BE USEFUL
      ------------------------------------- */
      .last {
        margin-bottom: 0; }

      .first {
        margin-top: 0; }

      .align-center {
        text-align: center; }

      .align-right {
        text-align: right; }

      .align-left {
        text-align: left; }

      .clear {
        clear: both; }

      .mt0 {
        margin-top: 0; }

      .mb0 {
        margin-bottom: 0; }

      .preheader {
        color: transparent;
        display: none;
        height: 0;
        max-height: 0;
        max-width: 0;
        opacity: 0;
        overflow: hidden;
        mso-hide: all;
        visibility: hidden;
        width: 0; }

      .powered-by a {
        text-decoration: none; }

      hr {
        border: 0;
        border-bottom: 1px solid #f6f6f6;
        Margin: 20px 0; }

      .socialmedia {
          width: 150px;
          margin: 0 auto;
          float: right;
      }

      .socialmedia a{
        float: left;
      }


      /* -------------------------------------
          RESPONSIVE AND MOBILE FRIENDLY STYLES
      ------------------------------------- */
      @media only screen and (max-width: 620px) {
        table[class=body] h1 {
          font-size: 28px !important;
          margin-bottom: 10px !important; }
        table[class=body] p,
        table[class=body] ul,
        table[class=body] ol,
        table[class=body] td,
        table[class=body] span,
        table[class=body] a {
          font-size: 16px !important; }
        table[class=body] .wrapper,
        table[class=body] .article {
          padding: 10px !important; }
        table[class=body] .content {
          padding: 0 !important; }
        table[class=body] .container {
          padding: 0 !important;
          width: 100% !important; }
        table[class=body] .main {
          border-left-width: 0 !important;
          border-radius: 0 !important;
          border-right-width: 0 !important; }
        table[class=body] .btn table {
          width: 100% !important; }
        table[class=body] .btn a {
          width: 100% !important; }
        table[class=body] .img-responsive {
          height: auto !important;
          max-width: 100% !important;
          width: auto !important; }}

      /* -------------------------------------
          PRESERVE THESE STYLES IN THE HEAD
      ------------------------------------- */
      @media all {
        .ExternalClass {
          width: 100%; }
        .ExternalClass,
        .ExternalClass p,
        .ExternalClass span,
        .ExternalClass font,
        .ExternalClass td,
        .ExternalClass div {
          line-height: 100%; }
        .apple-link a {
          color: inherit !important;
          font-family: inherit !important;
          font-size: inherit !important;
          font-weight: inherit !important;
          line-height: inherit !important;
          text-decoration: none !important; } 
        .btn-primary table td:hover {
          background-color: #34495e !important; }
        .btn-primary a:hover {
          background-color: #34495e !important;
          border-color: #34495e !important; } }

    </style>
  </head>
  <body class="">
    <table border="0" cellpadding="0" cellspacing="0" class="body">
      <tr>
        <td>&nbsp;</td>
        <td class="container">
          <div class="content">

            <!-- START CENTERED WHITE CONTAINER -->
            <span class="preheader">This is preheader text. Some clients will show this text as a preview.</span>
            <table class="main">

              <!-- START MAIN CONTENT AREA -->
              <tr>
                <td>
                  <table border="0" cellpadding="0" cellspacing="0">
                    <tr style="background: url('{{env('APP_URL')}}/assets/img-banner-main.jpg');" >
                      <td style="padding: 10px 20px;border-top-left-radius: 10px;border-top-right-radius: 10px;">
                        <img src="{{env('APP_URL')}}/assets/logo-header-home.png" alt="Housestars" width="250">
                        <div class="socialmedia">
                          <a href="#"><img src="http://app.jobholler.com/frontend/img/jobholler/facebook.png" alt="facebook" width="30" style="display: block; padding-bottom: 20px;" /></a>
                          <a href="#"><img src="http://app.jobholler.com/frontend/img/jobholler/twitter.png" alt="twitter" width="30" style="display: block; padding-bottom: 20px;" /></a>
                          <a href="#"><img src="http://app.jobholler.com/frontend/img/jobholler/Googleplus.png" alt="facebook" width="30" style="display: block; padding-bottom: 20px;" /></a>
                          <a href="#"><img src="http://app.jobholler.com/frontend/img/jobholler/linkedin.png" alt="facebook" width="30" style="display: block; padding-bottom: 20px;" /></a>
                          <a href="#"><img src="http://app.jobholler.com/frontend/img/jobholler/instagram.png" alt="facebook" width="30" style="display: block; padding-bottom: 20px;" /></a>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td style="padding: 20px; background: #fff;">
                        <p>{{$user['name']}} submitted a Property to be processed.</p>
                        <p>Here's the Property Details</p>
                          <div style="width: 464px; border: 1px dashed #a9a9a9; margin: 20px auto; padding: 20px">
                            <table>
                              <tbody>
                                <tr>
                                  <td><b>Property Renovated: </b>
                                      <p>{{$data['suburb']}}, {{$data['state']}}</p></td>
                                  <td><b>Commission Discount: </b>
                                      <p>${{$data['discount']}}</p></td>
                                </tr>

                                <tr>
                                  <td><b>Amount Sold: </b>
                                      <p>${{$data['value-to']}}</p></td>
                                  <td><b>Commission (%): </b>
                                      <p>{{$data['commission']}}%</p></td>
                                </tr>

                                 <tr>
                                  <td><b>Agency Name: </b>
                                      <p>ABBEYWOOD, QUEENSLAND</p></td>
                                  <td><b>Contract: </b>
                                      <a href="{{env('APP_URL')}}/{{$data['contract']}}" style="border: 1px solid #000;padding: 5px;font-size: 9px;text-decoration: none;color: #000;margin-left: 10px;">CLICK TO VIEW</a></td>
                                </tr>
                              </tbody>
                            </table>
                            @if(isset($data['transactions']))
                            <div style="background: #696969;padding: 2px 10px;color: #fff;font-weight: bold;text-transform: uppercase;">Transactions</div>
                              <div style="border-bottom: 1px solid #696969;">
                                <table>
                                  <thead>
                                    <tr>
                                      <td width="25%"><p style="margin: 10px 0;"><b>DATE</p></td>
                                      <td width="50%"><p style="margin: 10px 0;"><b>BUSINESS NAME</td>
                                      <td width="25%"><p style="margin: 10px 0;"><b>AMOUNT SPENT</p></td>
                                    </tr>
                                  </thead>
                                </table>
                              </div>
                              @foreach($data['transactions'] as $transaction)
                                <div style="border-bottom: 1px solid #696969;">
                                  <table>
                                    <tbody>
                                      <tr>
                                        <td width="25%"><p style="margin: 10px 0;">{{$transaction['date']}}</p></td>
                                        <td width="50%"><p style="margin: 10px 0;">{{$transaction['name']}}</p></td>
                                        <td width="25%"><p style="margin: 10px 0;">${{$transaction['amount_spent']}}</p></td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
                              @endforeach
                              <div style="background: #d4d4d4;padding: 2px 10px;color: #000;text-align: right;"><b>Total:</b> ${{$data['total']}}</div>
                            @endif
                          </div>


                        <p>Cheers,</p>
                        <img src="https://trello-attachments.s3.amazonaws.com/58abe1cd025a65a1e39f2205/200x50/d55d597a4311edbdbc9789d1ac05744f/signature.png">
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>

              <!-- END MAIN CONTENT AREA -->
              </table>

            <!-- START FOOTER -->
            <div class="footer">
              <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td class="content-block">
                    <span class="apple-link">Housestars Ltd., 3 Abbey Road, Sydney Australia 94102</span>
                  </td>
                </tr>
              </table>
            </div>

            <!-- END FOOTER -->
            
<!-- END CENTERED WHITE CONTAINER --></div>
        </td>
        <td>&nbsp;</td>
      </tr>
    </table>
  </body>
</html>

                                   