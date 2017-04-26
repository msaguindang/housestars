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
                <h3>HOUSESTARS USER AGREEMENT</h3>
					<p class="p1"><span class="s1">1. </span><span class="s2">User Agreement</span></p>
<p class="p2">&nbsp;</p>
<p class="p3"><span class="s1">(a) These terms and conditions form an agreement (&ldquo;Agreement&rdquo;) between Masimas Pty Ltd ABN 97 154 412 030 trading as Housestars (&ldquo;we&rdquo; or &ldquo;us&rdquo;) and you in relation to your use of the Housestars website and software, applications, services and documentation (together the &ldquo;Services&rdquo;). </span></p>
<p class="p2">&nbsp;</p>
<p class="p3"><span class="s1">(b) We take your privacy seriously.<span class="Apple-converted-space">&nbsp; </span>Therefore, your use of the Services is also governed by our Privacy Policy.<span class="Apple-converted-space">&nbsp; </span>Our Privacy Policy sets out how we may collect, store and disclose personal information.</span></p>
<p class="p4">&nbsp;</p>
<p class="p1"><span class="s1">(c) By accepting this Agreement and/or utilising the Services, you agree that: </span></p>
<ol class="ol1">
<li class="li1"><span class="s1">if you are using the Services for your own purposes, this Agreement forms a binding agreement between you and us; </span></li>
<li class="li1"><span class="s1">if you are using the Services on behalf of an organisation, you are agreeing on behalf of that organisation to be bound by this Agreement and you have the authority to bind the organisation to this Agreement; </span></li>
<li class="li1"><span class="s1">you consent (on your own behalf or on behalf of the organisation you represent) to the terms of our Privacy Policy; and</span></li>
<li class="li1"><span class="s1">you must ensure that all of your personnel who access the Services comply with this Agreement.</span></li>
</ol>
<p class="p2">&nbsp;</p>
<p class="p1"><span class="s1">(d) Do not use the Services if:</span></p>
<p class="p5"><span class="s1">(i) you do not agree with the terms and conditions of this Agreement; or</span></p>
<p class="p6"><span class="s1">(ii) you do not have the authority (in your own capacity or on behalf of the organisation you represent) to enter into a binding agreement on the terms and conditions of this Agreement. </span></p>
<p class="p2">&nbsp;</p>
<p class="p3"><span class="s1">(e) We may from time to time notify you in writing of changes to this Agreement. If you do not agree to a change, you must contact us immediately through the Contact Us page [##].<span class="Apple-converted-space">&nbsp; </span>If you continue to use the Services following notification by us of a change to this Agreement, you will be deemed to have accepted the change and the relevant change will bind you.</span></p>
<p class="p2">&nbsp;</p>
<p class="p1"><span class="s1">2. </span><span class="s2">Nature of the Services</span></p>
<p class="p2">&nbsp;</p>
<p class="p3"><span class="s1">(a) The Services comprise an online forum which enables: </span></p>
<p class="p6"><span class="s1">(i) tradespersons to advertise their services (&ldquo;Tradespersons&rdquo;);</span></p>
<p class="p6"><span class="s1">(ii) real estate agents (&ldquo;Agents&rdquo;) to advertise their services and be introduced to property owners who wish to sell their properties (&ldquo;Owners&rdquo;); </span></p>
<p class="p6"><span class="s1">(iii) Owners to engage Tradespersons to undertake work on their property to prepare it for sale; </span></p>
<p class="p6"><span class="s1">(iv) Owners to engage Agents to sell their property; and</span></p>
<p class="p6"><span class="s1">(v) Owners to be reimbursed some or all of their costs of engaging Tradespersons to prepare their property for sale.</span></p>
<p class="p2">&nbsp;</p>
<p class="p1"><span class="s1">3. </span><span class="s2">Access to the Services and Creating an Account</span></p>
<p class="p2">&nbsp;</p>
<p class="p3"><span class="s1">(a) You may use the elements of the Services by simply visiting our website.<span class="Apple-converted-space">&nbsp; </span>However, if you wish to access the full benefit of the Services offered to Owners, Tradespersons and Agents, you will need to create an account.</span></p>
<p class="p2">&nbsp;</p>
<p class="p3"><span class="s1">(b) You must provide and are responsible for all costs of all equipment, software and mobile or internet connectivity required to access the Services. </span></p>
<p class="p2">&nbsp;</p>
<p class="p1"><span class="s1">(c) If you create an account, you must not:</span></p>
<ol class="ol1">
<li class="li1"><span class="s1">use any false information, including, a false identity to become; or</span></li>
<li class="li1"><span class="s1">create an account if we have previously cancelled your account or banned you from using any of the Services.</span></li>
</ol>
<p class="p2">&nbsp;</p>
<p class="p1"><span class="s1">(d) You must:</span></p>
<ol class="ol1">
<li class="li1"><span class="s1">provide accurate and complete information when creating your account;</span></li>
<li class="li1"><span class="s1">update all of your account details regularly;</span></li>
<li class="li1"><span class="s1">keep your login and password details confidential; and</span></li>
<li class="li1"><span class="s1">immediately notify us if you become aware of any unauthorised<span class="Apple-converted-space">&nbsp; </span>access to or use of your account.</span></li>
</ol>
<p class="p2">&nbsp;</p>
<p class="p3"><span class="s1">(e) You acknowledge that: </span></p>
<ol class="ol1">
<li class="li1"><span class="s1">you are responsible for all use of your log-in and password details whether authorised or not: and</span></li>
</ol>
<p class="p6"><span class="s1">(ii) we may at any time cancel a username, login details or password with respect to your use of the Services at any time if we consider that such username, login details or password are offensive or infringe on any third party&rsquo;s rights.</span></p>
<p class="p2">&nbsp;</p>
<p class="p1"><span class="s1">4. </span><span class="s2">Use of the Services Generally</span></p>
<p class="p2">&nbsp;</p>
<p class="p3"><span class="s1">(a) Subject at all times to the Services applicable functionality, the Services are intended to: </span></p>
<p class="p6"><span class="s1">(i) provide a forum for Tradespersons and Agents to advertise their services; and</span></p>
<p class="p6"><span class="s1">(ii) allow Owners to engage Tradespersons to prepare their properties for sale and contract with Agents on terms under which Agents agree to rebate from the Agent&rsquo;s commission for the sale of a property some or all the Owner&rsquo;s costs of such preparation.</span></p>
<p class="p2">&nbsp;</p>
<p class="p3"><span class="s1">(b) Subject to the terms of this Agreement, we grant you a non-exclusive, revocable, limited licence to use the Services via the media and on the devices for which the Services were developed for the purposes for which the Services are intended. </span></p>
<p class="p2">&nbsp;</p>
<p class="p3"><span class="s1">(c) You must not: </span></p>
<ol class="ol1">
<li class="li1"><span class="s1">use the Services for any purpose other than the purposes contemplated by paragraph (a) above;</span></li>
<li class="li1"><span class="s1">engage in any illegal, unethical or immoral conduct using the Services;</span></li>
<li class="li1"><span class="s1">transfer, assign, rent, lend, resell or license your right to use the Services or any benefits associated with the Services to any person;</span></li>
<li class="li1"><span class="s1">engage in any activity through the use of the Services: </span></li>
</ol>
<ul class="ul1">
<li class="li1"><span class="s1">to mine or collect information or data from the Services, users of the Services or information in transit to and from the Services;</span></li>
<li class="li1"><span class="s1">to bypass any of the Services&rsquo; features including any features designed to exclude robots, spiders or scraping applications;</span></li>
<li class="li1"><span class="s1">to manipulate, damage, interfere with or impair the functionality any of the Services or any other computer systems or networks (including, without limitation, by way of hacking, uploading of harmful code, using cheats, exploits, automation software, bots or similar software);</span></li>
<li class="li1"><span class="s1">that we consider to be in conflict with the spirit or intent of the Services;</span></li>
<li class="li1"><span class="s1">that is in breach of any applicable law or any third party&rsquo;s rights;</span></li>
<li class="li1"><span class="s1">to disrupt, overburden or assist in such disruption or overburdening of any computer server or network (including, without limitation, those used to provide the Services);</span></li>
<li class="li1"><span class="s1">that is likely to harass, abuse, harm, threaten any person or group of persons (including, without limitation, any activity that degrades a person based on their religion, gender, age or sexuality) or incites or is likely to incite any such activity; </span></li>
<li class="li1"><span class="s1">that is misleading or deceptive or is intended to mislead or deceive any person;</span></li>
<li class="li1"><span class="s1">to alter, vary, modify or otherwise create any derivative works of any aspect of the Services;</span></li>
<li class="li1"><span class="s1">except as expressly permitted by applicable law, to reverse engineer or decompile any aspect of the Services;</span></li>
<li class="li1"><span class="s1">to avoid payment of any licence fees, charges or other amounts due to be paid by you under this Agreement;</span></li>
<li class="li1"><span class="s1">to store or communicate inappropriate content (including, without limitation, any content that infringes any person&rsquo;s rights (including by way of defamation), is illegal, harassing or is in anyway objectionable);</span></li>
<li class="li1"><span class="s1">to access any of our services, systems or accounts that you are not authorised by this Agreement to use.</span></li>
</ul>
<p class="p3"><span class="s1">(d) You must: </span></p>
<ol class="ol1">
<li class="li1"><span class="s1">use the Services at all times in compliance with this Agreement and any reasonable directions given by us from time to time; and</span></li>
<li class="li1"><span class="s1">immediately report to us any conduct that you consider could be misuse of the Services through the Contact Us page [##].</span></li>
</ol>
<p class="p7">&nbsp;</p>
<p class="p1"><span class="s1">5. </span><span class="s2">Owners&rsquo; Use of the Services and Payments to You if an Agent Sells Your Property</span></p>
<p class="p3"><span class="s1">(a) If you are an Owner, this clause 5 applies to you.</span></p>
<p class="p3"><span class="s1">(b) You may access the advertisements for the services provided by Tradespersons and Agents via the Services simply by visiting our website.</span></p>

<p class="p3"><span class="s1">(c)You acknowledge that:</span></p>
<p class="p2">&nbsp;</p>
<ol class="ol1">
<li class="li1"><span class="s1">we make no representations or warranties about the Tradespersons or Agents and the goods and services they provide; </span></li>
<li class="li1"><span class="s1">you are solely responsible for ensuring that the Tradespersons and/or Agents you engage are suitably licensed and insured; and</span></li>
<li class="li1"><span class="s1">except as expressly set out in this Agreement, we have no liability whatsoever to you in relation to any agreements you enter into with Tradespersons and/or Agents.</span></li>
</ol>
<p class="p3"><span class="s1">(d) If, however, you wish to access the full benefit of the Services, you will need to create an account (see clause 3 above).</span></p>
<p class="p2">&nbsp;</p>
<p class="p3"><span class="s1">(e) You acknowledge and agree that in order to obtain a refund in relation to some or all of costs you incur in preparing your property for sale, you must:</span></p>
<p class="p6"><span class="s1">(i) create an account;</span></p>
<p class="p6"><span class="s1">(ii) engage Tradespersons advertised through the Services to prepare your property for sale;</span></p>
<p class="p6"><span class="s1">(iii) upload invoices from the relevant Tradespersons as directed by us via the Services (&ldquo;Invoices&rdquo;);</span></p>
<p class="p6"><span class="s1">(iv) once your property is ready for sale, notify us of an Agent advertised through the Services who you would like to be introduced to;</span></p>
<p class="p6"><span class="s1">(v) subject to the Agent agreeing to us providing them with your details and you agreeing to appoint the Agent, enter into an agreement with an Agent for the sale of your property; </span></p>
<p class="p6"><span class="s1">(vi) upload a copy of your contract with the Agent as directed by use via the Services;</span></p>
<p class="p6"><span class="s1">(vii) upon exchange of contracts for the sale of your property, upload to us the front page of the contract for sale as directed by us via the Services; and</span></p>
<p class="p6"><span class="s1">(vii) notify us immediately upon settlement of the sale occurring.</span></p>
<p class="p3"><span class="s1">(f) We will review and verify the validity of the Invoices you upload in accordance with sub-clause (e) above.</span></p>
<p class="p7">&nbsp;</p>
<p class="p3"><span class="s1">(g) Subject to you complying with sub-clause (e) above and sub-clauses (i) and (j) below, upon receiving notice from you that the sale of your property has settled, we will reimburse you the value of Invoices we have verified up to a cap of 20% of the Agent&rsquo;s entitlement to commission from the sale of your property.<span class="Apple-converted-space">&nbsp; </span>We will make payment to you within 60 days of you completing all of your obligations under sub-clause (e) above. </span></p>
<p class="p2">&nbsp;</p>
<p class="p3"><span class="s1">(h) If you meet certain criteria published through the Services, we may agree with you in writing under a separate agreement to reimburse a portion of the value of the Invoices.</span></p>
<p class="p7">&nbsp;</p>
<p class="p3"><span class="s1">(i) If you have not completed all the requirements set out in sub-clause (e) above within 90 days of settlement of the sale of your property occurring, you waive your right to receive payment under sub-clause (g) above and we will have no liability to you whatsoever in relation to reimbursing any value of the Invoices to you.</span></p>
<p class="p7">&nbsp;</p>
<p class="p3"><span class="s1">(j) If for any reason you do not enter into an agreement for the sale of the property with an Agent through the operation of the Services, we will have no liability whatsoever to you to make payment under sub-clause (g) above or in relation to any costs and expenses you incur through engaging Tradespersons.</span></p>
<p class="p2">&nbsp;</p>
<p class="p1"><span class="s1">6. </span><span class="s2">Tradespersons&rsquo; Use of the Services</span></p>
<p class="p2">&nbsp;</p>
<p class="p3"><span class="s1">(a) If you are a Tradesperson, this clause 6 applies to you.</span></p>
<p class="p7">&nbsp;</p>
<p class="p3"><span class="s1">(b) You may purchase a trade advertising subscription package (&ldquo;Trade Subscription&rdquo;).</span></p>
<p class="p7">&nbsp;</p>
<p class="p3"><span class="s1">(c) The scope of your use of the Services and the fees payable by you will be determined by Trade Subscription (including fees payable) you select. </span></p>
<p class="p7">&nbsp;</p>
<p class="p3"><span class="s1">(d) Subject always to complying with this Agreement, you must create a profile page to advertise your services in accordance with our directions and guidelines.</span></p>
<p class="p2">&nbsp;</p>
<p class="p1"><span class="s1">7. </span><span class="s2">Agent&rsquo;s Use of the Services and Payments to Us if Agent Sells a Property</span></p>
<p class="p7">&nbsp;</p>
<p class="p3"><span class="s1">(a) If you are an Agent, this clause 7 applies to you.</span></p>
<p class="p7">&nbsp;</p>
<p class="p3"><span class="s1">(b) You may purchase a real estate advertising subscription package (&ldquo;Agent Subscription&rdquo;).</span></p>
<p class="p7">&nbsp;</p>
<p class="p3"><span class="s1">(c) The scope of your use of the Services and the fees payable by you will be determined by Agent Subscription (including fees payable) you select. </span></p>
<p class="p7">&nbsp;</p>
<p class="p3"><span class="s1">(d) Subject always to complying with this Agreement, you must create a profile page to advertise your services in accordance with our directions and guidelines.</span></p>
<p class="p3"><span class="s1">(e) If we contact you in relation to an Owner who wishes to engage you to sell their property:</span></p>
<ol class="ol1">
<li class="li1"><span class="s1">we will introduce the Owner to you;</span></li>
<li class="li1"><span class="s1">if you and the Owner enter into an agency agreement for the sale of the Owner&rsquo;s property, you consent to the Owner disclosing that agency agreement to us;</span></li>
<li class="li1"><span class="s1">you will notify us of both the proposed date of settlement of the Owner&rsquo;s property and the date that settlement occurs; </span></li>
<li class="li1"><span class="s1">upon settlement of the sale of the Owner&rsquo;s property, you must immediately pay to us via direct deposit to our nominated account 25% of your entitlement to commission arising from the sale of the property.</span></li>
</ol>
<p class="p2">&nbsp;</p>
<p class="p1"><span class="s1">8. </span><span class="s2">Subscription Fees, Payment</span></p>
<p class="p7">&nbsp;</p>
<p class="p3"><span class="s1">(a) If you subscribe as a Tradesperson or an Agent, you must pay us the relevant published fee for your Subscription in the currency specified on the date(s) the fee is due.</span></p>
<p class="p7">&nbsp;</p>
<p class="p3"><span class="s1">(b) Unless otherwise specified in relation to a Subscription or agreed by us all fees must be paid by direct debit from your credit card and a condition of access to the Services is that you complete and submit a direct debit authorisation form.</span></p>
<ol class="ol1">
<li class="li1"><span class="s1">If you credit card details for payment change you must promptly:</span></li>
<li class="li1"><span class="s1">notify us; and </span></li>
<li class="li1"><span class="s1">complete and submit to us a revised direct debit authorisation form.</span></li>
</ol>
<p class="p2">&nbsp;</p>
<p class="p3"><span class="s1">(d) If you fail to make payment on time, we may cancel your Subscription and prevent you using the Services.</span></p>
<p class="p2">&nbsp;</p>
<p class="p3"><span class="s1">(e) We may vary the amounts payable for Subscriptions from time to time by providing you with at least 30 days prior written notice.<span class="Apple-converted-space">&nbsp; </span>If you do not agree to a change, you must contact us immediately through the Contact Us page [##].<span class="Apple-converted-space">&nbsp; </span>If you do not contact us within 3 days of our notice or you continue to use the Services following notification by us of a change to the amounts payable by you, you will be deemed to have accepted the change and the relevant change will bind you.</span></p>
<p class="p7">&nbsp;</p>
<p class="p1"><span class="s1">9. </span><span class="s2">Termination and Suspension</span></p>
<p class="p7">&nbsp;</p>
<p class="p3"><span class="s1">(a) We may with immediate effect terminate, suspend, limit, delete or modify your access to the Services if we in our sole discretion consider that:</span></p>
<ol class="ol1">
<li class="li1"><span class="s1">you have or may have breached or are likely to breach this Agreement;</span></li>
<li class="li1"><span class="s1">you have or may have engaged or are likely to engage in any activity that is likely to have an adverse impact on any person (including without limitation, any user of the Services), us or our related companies or the Service;</span></li>
<li class="li1"><span class="s1">you have or may have infringed or are likely to infringe any third party&rsquo;s intellectual property or other rights (including by way of defamation); and/or</span></li>
<li class="li1"><span class="s1">you have or may have engaged in or are likely to engage in activities which could give rise to our liability or which we consider to be inconsistent with our philosophy in relation to the Services.</span></li>
</ol>
<p class="p7">&nbsp;</p>
<p class="p3"><span class="s1">(b) Without limiting paragraph (a) above, we may with immediate effect terminate your access to the Services if you fail to make any payment due to us under this Agreement by the applicable due date.</span></p>
<p class="p7">&nbsp;</p>
<p class="p3"><span class="s1">(c) You may terminate your Subscription at any time by contacting us [##].<span class="Apple-converted-space">&nbsp; </span>If you terminate your Subscription as contemplated by this paragraph, except as set out in paragraph 7 above or as otherwise agreed by us in writing, we have no liability to refund to you any fees paid by you prior to the date of termination.</span></p>
<p class="p7">&nbsp;</p>
<p class="p1"><span class="s1">10. </span><span class="s2">Intellectual Property and Content</span></p>
<p class="p7">&nbsp;</p>
<p class="p3"><span class="s1">(a) Subject to paragraph (d) below, all intellectual property rights in and to the Services (including all virtual items, software, files, concepts and content) vest in us or our licensors.</span></p>
<p class="p7">&nbsp;</p>
<p class="p3"><span class="s1">(b) Subject to paragraph (d) below, you acknowledge that you have no right title or interest in or to any aspect of the Services.</span></p>
<p class="p7">&nbsp;</p>
<p class="p3"><span class="s1">(c) Unless the Services specifically permit it, you must not download, reproduce or communicate to any third party any content or materials included in the Services.</span></p>
<p class="p7">&nbsp;</p>
<p class="p3"><span class="s1">(d) You represent and warrant to us that you own or are duly licensed to exploit all intellectual property rights in and to any communications, images, sounds or other material and data stored or communicated by you through the Services (together &ldquo;Your Content&rdquo;). </span></p>
<p class="p7">&nbsp;</p>
<p class="p3"><span class="s1">(e) You hereby grant us a non-exclusive, irrevocable, perpetual, royalty and fee free, unlimited licence (including the right to sub-license) to adapt, modify, communicate, exploit (in any manner) and use Your Content in connection with: </span></p>
<p class="p6"><span class="s1">(i) the provision of the Services;</span></p>
<p class="p6"><span class="s1">(ii) as required by law;</span></p>
<p class="p6"><span class="s1">(iii) to respond to an emergency; or</span></p>
<p class="p6"><span class="s1">(iv) to prevent the commission of a crime or injury or death to any person.</span></p>
<p class="p7">&nbsp;</p>
<p class="p3"><span class="s1">(f) To the maximum extent permitted by applicable law, you hereby irrevocably waive your moral rights (if any) in and to Your Content.<span class="Apple-converted-space">&nbsp; </span>To the extent that applicable law does not permit the waiver of moral rights, you hereby consent to us and our licensees and contractors undertaking all necessary alterations to Your Content and/or failing to attribute Your Content to you as is necessary for the operation of the Services. </span></p>
<p class="p7">&nbsp;</p>
<p class="p3"><span class="s1">(g) You warrant and represent that:</span></p>
<ol class="ol1">
<li class="li1"><span class="s1">you have the right to use Your Content in connection with the Services;</span></li>
<li class="li1"><span class="s1">to the extent that it is relevant, you have obtained appropriate consents and releases from the creator of Your Content (including, if the creator is a child, obtaining consents and releases from the parent or guardian of the child);</span></li>
<li class="li1"><span class="s1">your use and/or our use of Your Content in as contemplated by this Agreement will not:</span></li>
</ol>
<ul class="ul1">
<li class="li1"><span class="s1">breach any applicable laws or regulations;</span></li>
<li class="li1"><span class="s1">infringe any third party&rsquo;s intellectual property or other rights (including by way of defamation);</span></li>
</ul>
<ol class="ol1">
<li class="li1"><span class="s1">Your Content is accurate and not misleading or deceptive;</span></li>
</ol>
<ol class="ol1">
<li class="li1"><span class="s1">Your Content is free from viruses or any form of harmful or malicious code; </span></li>
<li class="li1"><span class="s1">you understand that any personal information relating to you contained in Your Content will be dealt with in accordance with our Privacy Policy.</span></li>
</ol>
<p class="p2">&nbsp;</p>
<p class="p1"><span class="s1">(h) You acknowledge that:</span></p>
<ol class="ol1">
<li class="li1"><span class="s1">all communications and transactions between you and other parties using the Services are between you and those parties only and we are not party to such communications or transactions;</span></li>
<li class="li1"><span class="s1">you are solely responsible at all times for:</span></li>
</ol>
<ul class="ul1">
<li class="li1"><span class="s1"> the nature and accuracy of Your Content;</span></li>
<li class="li1"><span class="s1">ensuring that Your Content complies at all times with this Agreement and all applicable laws;</span></li>
<li class="li1"><span class="s1">resolving any disputes relating to Your Content;</span></li>
<li class="li1"><span class="s1">maintaining adequate security, protection and back-up of Your Content;</span></li>
<li class="li1"><span class="s1">you must immediately notify us if you become aware of any unauthorised access to or use of Your Content;</span></li>
</ul>
<ol class="ol1">
<li class="li1"><span class="s1">to the maximum extent permitted by law, you hereby irrevocably waive any claim you may have against us in relation to any claim arising from the deletion, modification, loss of or damage to any of Your Content;</span></li>
</ol>
<ol class="ol1">
<li class="li1"><span class="s1">if the Services provide you with access to third party content (such as websites, data, software, applications and/or directories) or goods and services (together &ldquo;Third Party Content&rdquo;): </span></li>
</ol>
<ul class="ul1">
<li class="li1"><span class="s1">we are not responsible for such Third Party Content and have no liability to you in relation to such Third Party Content;</span></li>
<li class="li1"><span class="s1">you are entirely responsible for any fees or obligations you incur with respect to such Third Party Content; </span></li>
<li class="li1"><span class="s1">we make no warranties or representations in respect of, and do not sponsor or endorse, such third parties or such Third Party Content;</span></li>
<li class="li1"><span class="s1">to the maximum extent permitted by law, you hereby irrevocably waive any claim you may have against us in relation to such Third Party Content;</span></li>
</ul>
<ol class="ol1">
<li class="li1"><span class="s1">we have no obligation to monitor any content posted or distributed by users of the Services; </span></li>
</ol>
<ol class="ol1">
<li class="li1"><span class="s1">if we do monitor user content uploaded via the Services or your communications using the Services:</span></li>
</ol>
<ul class="ul1">
<li class="li1"><span class="s1">you hereby irrevocably consent to such monitoring; and</span></li>
<li class="li1"><span class="s1">we reserve the right in its sole discretion to delete, edit or refuse to distribute any content for any or no reason; and</span></li>
</ul>
<p class="p6"><span class="s1">(iv) to the maximum extent permitted by applicable law, we have no liability whatsoever with respect to any content uploaded, stored or communicated via the Services.</span></p>
<p class="p7">&nbsp;</p>
<p class="p1"><span class="s1">11. </span><span class="s2">Access and Disclosures</span></p>
<p class="p2">&nbsp;</p>
<p class="p3"><span class="s1">(a) We may access and monitor for the purposes of providing the Services any content, information and/or data contained in Your Content, your communications with other users of the Services and any other materials provided by you via the Services.<span class="Apple-converted-space">&nbsp; </span>We may disclose such content, information and/or data:</span></p>
<ol class="ol1">
<li class="li1"><span class="s1">if we consider it is required to make such disclosure by applicable law (including in respect of legal proceedings);</span></li>
<li class="li1"><span class="s1">if we consider that the Services are being used to commit a crime or infringe a party&rsquo;s rights;</span></li>
<li class="li1"><span class="s1">for the purposes of taking steps against fraud;</span></li>
<li class="li1"><span class="s1">in the case of an emergency that poses or may pose a threat to property or to any person or child&rsquo;s heath or wellbeing; </span></li>
<li class="li1"><span class="s1">to protect our rights; and/or</span></li>
<li class="li1"><span class="s1">to limit our liability.</span></li>
</ol>
<p class="p2">&nbsp;</p>
<p class="p1"><span class="s1">12. </span><span class="s2">LIMITATION OF LIABILITY AND IDEMNITY</span></p>
<p class="p3"><span class="s1">(a) TO THE MAXIMUM EXTENT PERMITTED BY APPLICABLE LAW:</span></p>

<p class="p6"><span class="s1">(i) WE MAKE NO REPRESENTATIONS OR WARRANTIES WHATSOEVER TO YOU;</span></p>
<p class="p6"><span class="s1">(ii) WE HEREBY EXCLUDE ALL REPRESENTATIONS, WARRANTIES, TERMS AND CONDITIONS WHETHER EXPRESS OR IMPLIED (AND INCLUDING WITHOUT LIMITATION, THOSE IMPLIED BY STATUTE, CUSTOM, LAW OR OTHERWISE);</span></p>
<p class="p6"><span class="s1">(iii) IF YOU ARE AN OWNER, OUR CUMULATIVE LIABILITY TO YOU FOR ALL CLAIMS MADE BY YOU UNDER OR IN RELATION TO THIS AGREEMENT, THE PRIVACY POLICY OR YOUR USE OF THE SERVICES WILL NOT EXCEED IN AGGREGATE THE AMOUNT OF INVOICES WE ARE DUE TO REIMBURSE TO YOU UNDER THIS AGREEMENT;</span></p>
<p class="p6"><span class="s1">(iv) IF YOU ARE NOT AN OWNER OUR CUMULATIVE LIABILITY TO YOU FOR ALL CLAIMS MADE BY YOU UNDER OR IN RELATION TO THIS AGREEMENT, THE PRIVACY POLICY OR YOUR USE OF THE SERVICES WILL NOT EXCEED IN AGGREGATE THE AMOUNT ACTUALLY RECEIVED BY US IN RESPECT OF YOUR USE OF THE SERVICES IN THE PERIOD 12 MONTHS PRECEDING THE DATE THE FIRST CLAIM FIRST AROSE;</span></p>
<p class="p6"><span class="s1">(v) WE WILL NOT BE LIABLE TO YOU IN RESPECT OF ANY CLAIM FOR ANY LOSS OF PROFIT, DATA, GOODWILL OR BUSINESS, FOR INTERRUPTION TO BUSINESS, FOR ANY FAILURE TO REALISE ANTICIPATED SAVINGS OR FOR ANY CONSEQUENTIAL, INDIRECT, SPECIAL PUNITIVE OR INCIDENTAL DAMAGES.</span></p>
<p class="p3"><span class="s1">(b) CERTAIN LEGISLATION MAY IMPLY WARRANTIES OR CONDITIONS OR IMPOSE OBLIGATIONS WHICH CANNOT BE EXCLUDED, RESTRICTED OR MODIFIED EXCEPT TO A LIMITED EXTENT.<span class="Apple-converted-space">&nbsp; </span>THIS AGREEMENT AND THE PRIVACY POLICY MUST BE READ SUBJECT TO THOSE STATUTORY PROVISIONS.<span class="Apple-converted-space">&nbsp; </span>IF THOSE STATUTORY PROVISIONS APPLY, TO THE EXTENT TO WHICH WE ARE ENTITLED TO DO SO, WE LIMIT OUR LIABILITY IN RESPECT OF ANY CLAIM TO, AT OUR OPTION:</span></p>
<p class="p10"><span class="s1">(i) IN RELATION TO SERVICES:</span></p>
<p class="p11"><span class="s1">(A) THE SUPPLY OF THE SERVICES AGAIN;</span></p>
<p class="p11"><span class="s1">(B) THE PAYMENT OF THE COST OF HAVING THE SERVICES SUPPLIED AGAIN; AND</span></p>
<p class="p12"><span class="s1">(ii) IN RELATION TO GOODS:</span></p>
<p class="p11"><span class="s1">(A) THE REPLACEMENT OF THE GOODS OR THE SUPPLY OR EQUIVALENT GOODS;</span></p>
<p class="p11"><span class="s1">(B) THE REPAIR OF THE GOODS;</span></p>
<p class="p11"><span class="s1">(C) THE PAYMENT OF THE COST OF REPLACING THE GOODS OR ACQUIRING EQUIVALENT GOODS; OR</span></p>
<p class="p11"><span class="s1">(D) THE PAYMENT OF HAVING THE GOODS REPAIRED.</span></p>
<p class="p2">&nbsp;</p>
<p class="p3"><span class="s1">(c) YOU INDEMNIFY AND MUST KEEP INDEMNIFIED, US, OUR RELATED COMPANIES, THEIR DIRECTORS, OFFICERS AND EMPLOYEES (TOGETHER &ldquo;THOSE INDEMNIFIED&rdquo;) AGAINST ANY CLAIMS, LOSSES, LIABILITY, COSTS (INCLUDING LEGAL FEES AND EXPENSES) INCURRED BY THOSE INDEMNIFIED ARISING OUT OF OR RELATED TO ANY BREACH BY YOU OF ANY PROVISION OF THIS AGREEMENT OR THE RULES OR ANY IMPROPER USE BY YOU OF THE SERVICES.&nbsp;</span></p>
<p class="p7">&nbsp;</p>
<p class="p1"><span class="s1">13. </span><span class="s2">General</span></p>
<p class="p13"><span class="s1">(a) We may assign the benefit of this Agreement and Privacy Policy to any person without your consent. You may only assign this Agreement and Privacy Policy or a right under them with our prior written consent that may be withheld or granted in our absolute discretion. </span></p>
<p class="p13"><span class="s1">(b) This Agreement and Privacy Policy constitute the entire agreement between the parties in connection with their subject matter and supersedes all previous agreements or understandings between the parties in connection with its subject matter.</span></p>
<p class="p13"><span class="s1">(c) If the whole or any part of a provision of this Agreement and Privacy Policy is invalid or unenforceable in a jurisdiction it must, if possible, be read down for the purposes of that jurisdiction so as to be valid and enforceable.<span class="Apple-converted-space">&nbsp; </span>If however, the whole or any part of a provision of this Agreement and Privacy Policy is not capable of being read down, it is severed to the extent of the invalidity or unenforceability without affecting the remaining provisions of this Agreement and Privacy Policy or affecting the validity or enforceability of that provision in any other jurisdiction.</span></p>
<p class="p13"><span class="s1">(d) A party does not waive a right, power or remedy if it fails to exercise or delays in exercising the right, power or remedy.<span class="Apple-converted-space">&nbsp; </span>A single or partial exercise by a party of a right, power or remedy does not prevent another or further exercise of that or another right, power or remedy.<span class="Apple-converted-space">&nbsp; </span>A waiver of a right, power or remedy must be in writing and signed by the party giving the waiver.</span></p>
<p class="p13"><span class="s1">(e) This Agreement and Privacy Policy do not create a relationship of employment, trust, agency or partnership between the parties.</span></p>
<p class="p13"><span class="s1">(f) The provisions of paragraphs [##] will survive termination or expiry of this Agreement will continue to bind the parties.</span></p>
<p class="p13"><span class="s1">(g) YOU IRREVOCABLY WAIVE YOUR RIGHT TO SEEK INJUNCTIVE OR OTHER EQUITABLE RELIEF TO RESTRAIN THE OPERATION OF ANY ELEMENT OF THE SERVICES AND YOU AGREE TO LIMIT YOUR CLAIMS AGAINST US TO CLAIMS FOR MONETARY DAMAGES.</span></p>
<p class="p13"><span class="s1">(h) We will have no liability to you for a failure by us to perform our obligations to you or provide the Services due to any causes outside of our reasonable control including acts of God, war, acts of terrorism, riots, fire, change in laws or failure of infrastructure.</span></p>
<p class="p13"><span class="s1">(i) This Agreement and the Privacy Policy will be governed by and construed in accordance with the law for the time being in force in Victoria, Australia and the parties, are deemed to have submitted to the non-exclusive jurisdiction of the courts of that State.</span></p>
              </div>
            </div>
          </div>
        </div>
    </section>



@endsection

@section('scripts')

@stop
