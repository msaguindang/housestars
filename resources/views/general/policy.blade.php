@extends("layouts.main")
@section("content")
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
                    <!-- <li><a href="#" data-toggle="modal" data-target="#signup">Signup Me Up!</a></li> -->

                     @if(Sentinel::check())
                     <li><a href="{{env('APP_URL')}}/profile">Hi, {{Sentinel::getUser()->name}}</a></li>
                    @else
                      <li><a href="#" data-toggle="modal" data-target="#login">Login</a></li>
                      <li><a href="#" data-toggle="modal" data-target="#signup">Signup</a></li>
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
                      <li class="active"><span class="icon icon-customer-dark"></span><a href="{{env('APP_URL')}}/customer" >Customer</a></li>
                      <li><span class="icon icon-tradesman-dark"></span><a href="{{env('APP_URL')}}/trades-services">Trades & Services</a></li>
                      <li><span class="icon icon-agency-dark"></span><a href="{{env('APP_URL')}}/agency">Agency</a></li>
                    @else
                      <li class="active"><span class="icon icon-customer-dark"></span><a href="{{env('APP_URL')}}/customer" >Customer</a></li>
                      <li><span class="icon icon-tradesman-dark"></span><a href="{{env('APP_URL')}}/trades-services">Trades & Services</a></li>
                      <li><span class="icon icon-agency-dark"></span><a href="{{env('APP_URL')}}/agency">Agency</a></li>
                    @endif
                  </ul>
                </div>
              </div>
            </div>
          </div>
    </header>

    <section class="header-margin default-page">
        <div class="container">
          <div class="breadcrumbs">
            <div class="row">
              <p class="links"><a href="">Home Page</a> > <span class="blue">Terms & Conditions</span> </p>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12">
              <div class="about-wrapper page long-text">
                <h3>HOUSESTARS PRIVACY POLICY</h3>
				<p>Last updated [date] March 2017</p>
				<p>We at Masimas Pty Ltd ABN 97 154 412 030 trading as Housestars (“Housestars”) think privacy is important. We are committed to ensuring the privacy and protection of personal information from customers and business clients. </p>		
				<p>This Policy reflects both Australian privacy law and Housestars' policies in relation to the use and protection of personal information (which is information that could reasonably be used to identify you). Information relating to your rights under Australian privacy law can be found on The Australian Privacy Commissioners website at www.privacy.gov.au. </p>
				<p>This Policy will be available for free access on our website at all times. Let us know if you would like a hard-copy of this Policy sent to you.</p>
				<p><b>1. How is Information collected and what is collected? </b></p>
				<p>Generally, Housestars collects personal information from you when completing transactions, when you register to use any of Housestars’ services or through your use of Housestars’ services. </p>
				<p>Housestars only collects and holds your personal information if it is reasonably necessary and relevant to providing Housestars’ services. This personal information may include:</p>
				<ul>
					<li>your full name, address and other contact details (like your telephone number, social media addresses); </li>
					<li>your email address; </li>
					<li>your business name and business type; </li>
					<li>your business logo;</li>
					<li>the Housestars services you use and your satisfaction with them;</li>
					<li>the features of the Housestars services you require;</li>
					<li>records of your correspondence with us; </li>
					<li>transaction details relating to your use of Housestars’ services;</li>
					<li>details of your transactions with other users of Housestars’ services such as your transactions with tradespersons and agents (including the commercial terms of those transactions);</li>
					<li>files you upload using Housestars’ services and comments you add to those files;</li>
					<li>documents you upload using Housestars’ services</li>
					<li>reports you create;</li>
					<li>access logs; and</li>
					<li>messages you may send when sharing files and playlists using Housestars’ services.</li>
				</ul>
				<p>Housestars will take reasonable steps to ensure that the personal information we hold about you is accurate, up to date and complete.</p>
				<p>From time to time, Housestars may receive information relating to you that we have not requested and which is not otherwise described above (“Unsolicited Information”). If Housestars does receive Unsolicited Information, we will check whether it is reasonably necessary for us to keep it. If it is, we will treat the Unsolicited Information in the same way as the other information described above. If Housestars determines that it is not reasonably necessary for us to keep it, we will, as soon as practicable, destroy or de-identify the relevant Unsolicited Information.</p>
				
				<p><b>2. How do we hold your personal information?</b></p>
				<p>Housestars may hold your personal information in electronic or hard copy form. We will take reasonable steps to destroy or de-identifiy your personal information once it is no longer needed, unless we are required by Australian law, or a court or tribunal order, to retain it.</p>
				<p><b>3. How do we use and disclose your personal information?</b></p>
				<p>The personal information collected by Housestars is used to enable us to provide Housestars’ services to you and to provide you with information about Housestars’, its related companies’ and business partners’ products and services from time to time.  Without limiting the foregoing, we will use personal information as follows:</p>
				<ul>
					<li>to facilitate your use of Housestars’ services including creating and maintaining your account;</li>
					<li>to enable you to contact other users of Housestars’ services (including tradespersons and real estate agents);</li>
					<li>to provide you with support services (which may include requesting you to provide customer surveys); and</li>
					<li>to provide you with information in relation products and services which we think may be of interest to you.</li>
				</ul>
				<p>Housestars may need to disclose some personal information about you in certain circumstances to third parties who are not users of Housestars’ services. For example, to service providers we engage to enable us to provide Housestars’ services.  We will require these organisations to agree to comply with this Policy and with strict conditions governing how personal information is to be handled. </p>
				<p>Housestars will not sell, rent or trade personal information about you to or with third parties without your express permission or as set out in this Policy.</p>
				<p>Housestars will only disclose personal information in accordance with this Policy, if required to by law or as permitted under the Privacy Act.  For example, if we are legally required to do so (such as pursuant to a court or tribunal order or under taxation laws), if there is a serious threat to an individual’s health or safety, there is reasonable suspicion of unlawful activity, for the conduct of surveillance and intelligence gathering by an enforcement body, or to assist in locating a missing person.</p>
				<p><b>4. Access to and Changing your Information </b></p>
				<p>You have the right to seek access to information that Housestars holds about you. You also have the right to ask us to correct information about you, which is inaccurate, incomplete or out of date.  You may access the information that Housestars may have collected about you by placing your request in writing and sending it to us using the contact details below. Please include your phone number and enclose a copy of a form of identification such as a current driver's license or passport with your request. </p>
				<p>Housestars’ policy is to consider any requests for access or correction within 28 days of receipt. If we are unable to correct your information, we will provide to you within a reasonable period a written notice setting out the reason, and the complaint mechanisms available to you.</p>
				<p>Housestars’ Privacy Officer 
				</br>[address]
				</br>[email address]</p>
				<p><b>5. Making a complaint</b></p>
				<p>If you are not satisfied with how we have handled your personal information, please contact Housestars’ Privacy Officer via the details listed above.</p>
				<p>You can also lodge a complaint with the Federal Privacy Commissioner. For more details on how to do this, please visit <a href="http://www.privacy.gov.au">www.privacy.gov.au</a>.</p>
				<p><b>6. Marketing</b></p>
				<p>Housestars may wish to send you marketing communications about offers that we believe may be of interest to you. We may send these to you via email, telephone, SMS or other electronic means. We may also send you marketing communications in the post.</p>
				<p>We will ensure that all electronic marketing communications contain a clearly marked ‘opt-out’ or ‘unsubscribe’ for you to click on.</p>
				<p><b>7. Information Security</b></p>
				<p>Housestars will ensure that it takes reasonable commercial steps to keep secure any information that we hold about you. Housestars has security measures, proprietary data protection algorithms, in place to protect the loss, misuse and alteration of the information under our control. </p>
				<p>From time to time, we may also need to transfer your information overseas. For example, we may store your personal information in a cloud, or other type of networking electronic storage which is based in a jurisdiction outside Australia. If we do this, Housestars will ensure reasonable steps are taken so that the overseas recipient does not breach the Privacy Act 1988 (Cth), or the Australian Privacy Principles in relation to that information, or adheres to laws substantially similar to Australian privacy laws. Housestars will also take reasonable steps to prevent unauthorised access and reduce the risk of disclosure to unknown entities. </p>
				<p><b>8. Online Privacy Considerations </b></p>
				<p>Other matters specific to Housestars’ collection and use of personal information online are set out below. </p>
				<p><b>i. Cookies. </b> For each visitor to our website, our server automatically collects information about your session such as your login details to keep you signed in, and delivering you personalised content. Most web browsers are set by default to accept cookies. However, if you do not wish to receive any cookies you may set your browser to either prompt or refuse cookies. Note that if you disable cookies, you may not be able to fully enjoy Housestars’ services. </p>
				<p><b>ii. Social Media.</b> Housestars’ services may contain links to online forums such as Facebook and Twitter. Think carefully before you post or publish any personal information in these forums as it may be publicly available. </p>
				<p><b>iii Secure Online Transactions.</b> f you engage in a financial transaction through use of Housestars’ services, we will process your credit card details securely over the Internet using an accredited internet payment security system. With the combination of SSL encryption on our website and a secure browser at your end, we take all reasonable measures to ensure that your credit card and personal information are protected when you purchase online. We also recommend that you take appropriate security precautions when accessing the Internet via public Wi-Fi networks or shared computers. </p>
				<p><b>iv. Links to other websites.</b> Sometimes Housestars’ services will contain links to third party websites or services. We recommend that you review the privacy policies of each third party website or services you visit because Housestars is not responsible for privacy practices of that site.</p>
			  </div>
            </div>
          </div>
        </div>
    </section>



@endsection

@section('scripts')

@stop
