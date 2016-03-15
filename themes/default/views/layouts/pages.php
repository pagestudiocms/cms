{{ theme:partial name="header" }}

    <!-- Section: about -->
    <section id="about" class="home-section color-dark bg-white">
		<div class="container marginbot-50">
			<div class="row">
				<div class="col-lg-8 col-lg-offset-2">
					<div class="animatedParent">
					<div class="section-heading text-center animated bounceInDown">
					<h2 class="h-bold">{{ body_heading }}</h2>
					<div class="divider-header"></div>
					</div>
					</div>
				</div>
			</div>

		</div>

		<div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 animatedParent">		
                    <div class="text-center">
                        {{ body_content }}
                        <a href="#service" class="btn btn-skin btn-scroll">What we do</a>
                    </div>
                </div>
            </div>		
		</div>
	</section>
	<!-- /Section: about -->
	
	<!-- Section: services -->
    <section id="features" class="home-section color-dark bg-gray">
		<div class="container marginbot-50">
			<div class="row">
				<div class="col-lg-8 col-lg-offset-2">
					<div>
					<div class="section-heading text-center">
					<h2 class="h-bold">Out of the box features</h2>
					<div class="divider-header"></div>
					</div>
					</div>
				</div>
			</div>

		</div>

		<div class="text-center">
		<div class="container">

        <div class="row animatedParent">
            <div class="col-xs-6 col-sm-4 col-md-4">
				<div class="animated rotateInDownLeft">
                <div class="service-box">
					<div class="service-icon">
						<span class="fa fa-laptop fa-2x"></span> 
					</div>
					<div class="service-desc">						
						<h5>Web Design</h5>
						<div class="divider-header"></div>
						<p>
						Ad denique euripidis signiferumque vim, iusto admodum quo cu. No tritani neglegentur mediocritatem duo.
						</p>
						<a href="#" class="btn btn-skin">Learn more</a>
					</div>
                </div>
				</div>
            </div>
			<div class="col-xs-6 col-sm-4 col-md-4">
				<div class="animated rotateInDownLeft slow">
                <div class="service-box">
					<div class="service-icon">
						<span class="fa fa-camera fa-2x"></span> 
					</div>
					<div class="service-desc">
						<h5>Photography</h5>
						<div class="divider-header"></div>
						<p>
						Ad denique euripidis signiferumque vim, iusto admodum quo cu. No tritani neglegentur mediocritatem duo.
						</p>
						<a href="#" class="btn btn-skin">Learn more</a>
					</div>
                </div>
				</div>
            </div>
			<div class="col-xs-6 col-sm-4 col-md-4">
				<div class="animated rotateInDownLeft slower">
                <div class="service-box">
					<div class="service-icon">
						<span class="fa fa-code fa-2x"></span> 
					</div>
					<div class="service-desc">
						<h5>Graphic design</h5>
						<div class="divider-header"></div>
						<p>
						Ad denique euripidis signiferumque vim, iusto admodum quo cu. No tritani neglegentur mediocritatem duo.
						</p>
						<a href="#" class="btn btn-skin">Learn more</a>
					</div>
                </div>
				</div>
            </div>

        </div>		
		</div>
		</div>
	</section>
	<!-- /Section: services -->
	

	<!-- Section: works -->
    <section id="gallery" class="home-section color-dark text-center bg-white">
		<div class="container marginbot-50">
			<div class="row">
				<div class="col-lg-8 col-lg-offset-2">
					<div>
					<div class="animatedParent">
					<div class="section-heading text-center">
					<h2 class="h-bold animated bounceInDown">Lightbox Gallery Example</h2>
					<div class="divider-header"></div>
					</div>
					</div>
					</div>
				</div>
			</div>

		</div>

		<div class="container">

            <div class="row animatedParent">
                <div class="col-sm-12 col-md-12 col-lg-12" >

                    <div class="row gallery-item">
                        {{ galleries:gallery gallery_id="1" }}
                            <div class="col-md-3 animated fadeInUp">
                                <a href="{{ site_url }}{{ image }}" title="{{ title }}" data-lightbox-gallery="gallery1" data-lightbox-hidpi="img/works/1@2x.jpg">
                                    <img src="{{ site_url }}{{ image }}" alt="{{ alt }}" class="img-responsive"  />
                                </a>
                            </div>
                        {{ /galleries:gallery }}
                    </div>
                    	
                </div>
            </div>	
		</div>

	</section>
	<!-- /Section: works -->

	<!-- Section: contact -->
    <section id="contact" class="home-section nopadd-bot color-dark bg-gray text-center">
		<div class="container marginbot-50">
			<div class="row">
				<div class="col-lg-8 col-lg-offset-2">
					<div class="animatedParent">
					<div class="section-heading text-center">
					<h2 class="h-bold animated bounceInDown">Ajax Contact Form Example</h2>
					<div class="divider-header"></div>
					</div>
					</div>
				</div>
			</div>

		</div>
		
		<div class="container">

			<div class="row marginbot-80">
				<div class="col-md-8 col-md-offset-2">
                
                    {{ contact:form required="name|email|message" captcha="false" id="contact-form" class="js-contact-form" ajax="true|js-result" }}                        
                        <div class="js-result"></div>
                        
                        <div class="row marginbot-20">
							<div class="col-md-6 xs-marginbot-20">
                                <p class="help-block text-danger"></p>
								<input name="name" type="text" class="form-control input-lg" id="name" required placeholder="Enter name" data-validation-required-message="Please enter your name." />
							</div>
							<div class="col-md-6">
                                <p class="help-block text-danger"></p>
								<input name="email" type="email" class="form-control input-lg" id="email" required placeholder="Enter email" />
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
                                    <input name="subject" type="text" class="form-control input-lg" id="subject" required placeholder="Subject" />
								</div>
								<div class="form-group">
									<textarea name="message" id="message" class="form-control" rows="4" cols="25" required placeholder="Message"></textarea>
								</div>
							</div>
						</div>
                       
                        <div class="row">
                            <div class="form-group col-xs-12">
                                <button type="submit" class="btn btn-skin btn-lg btn-block" id="btnContactUs">Send Message</button>
                            </div>
                        </div>
                    {{ /contact:form }}
                    
				</div>
			</div>	

		</div>
	</section>
	<!-- /Section: contact -->

{{ theme:partial name="footer" }}
