		</div>
	</main>
	<!--Main layout-->
	<!--Footer-->
	<footer class="page-footer pt-0">
	    <!-- Social buttons -->
	    <div class="social-bar" >
	        <div class="container">
	            <!--Grid row-->
	            <div class="row py-4 d-flex align-items-center">
	                <!--Grid column-->
	                <div class="col-md-6 col-lg-5 text-center text-md-<?php echo $SocialBarTextAlign;?> mb-4 mb-md-0">
	                    <h6 class="mb-0 white-text">Get connected with me on social networks!</h6>
	                </div>
	                <!--Grid column-->
	                <div class="col-md-6 col-lg-7 text-center text-md-<?php echo $SocialBarIconsAlign;?>">
						<?php
							foreach($socialLinks as $link){
								echo '
								<a class="fb-ic ml-0" href="'.$link['attribute_value'].'" title="'.$link['attribute_name'].'" target="new">
									<i class="fa fa-'.$link['attribute_name'].' white-text mr-4"> </i>
								</a>';
							}
						?>
	                </div>
	                <!--Grid column-->
	            </div>
	            <!--Grid row-->
	        </div>
	    </div>
	    <!-- Social buttons -->
		<!--Footer Links-->
		<div class="container mt-5 mb-4 text-center text-md-<?php echo $SocialBarTextAlign;?>">
		    <div class="row mt-3">
		        <!--First column-->
		        <div class="col-md-3 col-lg-4 col-xl-3 mb-4">
					<div class="anim" data-av-animation="bounce">
			            <h6 class="text-uppercase font-weight-bold">
			                <strong><?php info("website_name"); ?></strong>
			            </h6>
					</div>
		            <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
		            <p></p>
		        </div>
		        <!--/.First column-->
		        <!--Fourth column-->
		        <div class="col-md-9 col-lg-8 col-xl-9">
					<div class="anim" data-av-animation="bounce">
			            <h6 class="text-uppercase font-weight-bold"><strong>Contact</strong></h6>
					</div>
		            <hr class="deep-purple accent-2 mb-4 " style="width: 90%;">
		            <p><i class="fa fa-home mr-3"></i><?php info("address"); ?></p>
		            <p><i class="fa fa-envelope mr-3"></i><?php info("e-mail"); ?></p>
		            <p><i class="fa fa-phone mr-3"></i><?php info("phone"); ?></p>
					<p><i class="fa fa-fax mr-3"></i><?php info("fax"); ?></p>
					<p><i class="fa fa-mobile mr-3"></i><?php info("mobile"); ?></p>
		        </div>
		        <!--/.Fourth column-->
		    </div>
		</div>
		<!--/.Footer Links-->
	    <!--Copyright-->
	    <div class="footer-copyright py-3 text-center" >
	        � 2018 Copyright:
	        <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>"> <?php echo $_SERVER['HTTP_HOST']; ?></a>
	    </div>
	    <!--/.Copyright-->
	</footer>
	<!--/.Footer-->
   
    <!-- SCRIPTS -->
    <!-- JQuery -->
    <script type="text/javascript" src="/js/jquery-3.3.1.min.js"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="/js/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="/js/bootstrap.min.js"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="/js/mdb.min.js"></script>
    <!-- image gallery -->
    <script type="text/javascript" src="/js/lightgallery.js"></script>
    <!-- jquery aniview-->
	<!--Google Maps-->
	<script src="https://maps.google.com/maps/api/js"></script>
    <!-- animate -->
    <script type="text/javascript" src="/js/jquery.aniview.js"></script>
	
	<script src="/js/owl.carousel.min.js"></script>
    <script src="/js/main.js"></script>
	<!-- google login-->
	<script src="https://apis.google.com/js/platform.js?onload=renderButton" async defer></script>
	<script>
	    $('.carousel').carousel({
	        interval: 10000,
			pause: "false"
	    })
		$("a[href^='#']").on('click', function(e) {
			// prevent default anchor click behavior
			e.preventDefault();
			//remove active calss from navbar links
			$('.navbar-nav>.active').removeClass('active');
			//add active calss to selected navbar link
   			$(this).parent('li').addClass('active');
			// store hash
   			var hash = this.hash;
		   // animate
		   $('html, body').animate({
		       scrollTop: $(hash).offset().top
		    }, 300, function(){
		       // when done, add hash to url
		       // (default click behaviour)
		       window.location.hash = hash;
		    });
		});
	</script>	
	<!-- Google Maps settings -->
	<script>
		//Regular map
		function regular_map() {
			var var_location = new google.maps.LatLng(<?php info('lat'); ?>, <?php info('long'); ?>);
			var var_mapoptions = {
				center: var_location,
				zoom: 14
			};
			var var_map = new google.maps.Map(document.getElementById("map-container"),var_mapoptions);
			var var_marker = new google.maps.Marker({
				position: var_location,
				map: var_map,
				title: "<?php  info('address'); ?>"
			});
		}
		$('.anim').AniView({animateThreshold: 100,scrollPollInterval: 0});
		//alert("<? echo $_GET['go']; ?>");
		$(document).ready(function(){
			<?php 
				echo $pageReadyScript;
			?>
		});



		document.querySelectorAll( 'oembed[url]' ).forEach( element => {
			// Create the <a href="..." class="embedly-card"></a> element that Embedly uses
			// to discover the media.
			const anchor = document.createElement( 'a' );

			anchor.setAttribute( 'href', element.getAttribute( 'url' ) );
			anchor.className = 'embedly-card';

			element.appendChild( anchor );
		} );


	//google login
	function onSuccess(googleUser) {
      console.log('Logged in as: ' + googleUser.getBasicProfile().getName());
    }
    function onFailure(error) {
      console.log(error);
    }
    function renderButton() {
      gapi.signin2.render('my-signin2', {
        'scope': 'profile email',
        'width': 240,
        'height': 50,
        'longtitle': true,
        'theme': 'dark',
        'onsuccess': onSuccess,
        'onfailure': onFailure
      });
    }
	</script>
</body>
</html>
