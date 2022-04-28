<!-- Heading -->
<h2 class="mb-5 font-weight-bold text-center">Contact Us</h2>
<!--Grid row-->
<div class="row">
	<!--Grid column-->
	<div class="col-lg-5 col-md-12">
		<!-- Form contact -->
		<div class="anim" data-av-animation="slideInLeft">
			<form class="p-5" method="POST">
				<div class="md-form form-sm"> <i class="fa fa-user prefix grey-text"></i>
					<input type="text" id="form3" name="name" class="form-control form-control-sm" required>
					<label for="form3">Your name</label>
				</div>
				<div class="md-form form-sm"> <i class="fa fa-envelope prefix grey-text"></i>						
					<input type="text" id="form2" name="email" class="form-control form-control-sm" required>
					<label for="form2">Your email</label>
				</div>
				<div class="md-form form-sm"> <i class="fa fa-tag prefix grey-text"></i>
					<input type="text" id="form32" name="subject" class="form-control form-control-sm" required>
					<label for="form34">Subject</label>
				</div>
				<div class="md-form form-sm"> <i class="fa fa-pencil prefix grey-text"></i>
					<textarea type="text" id="form8" name="message" class="md-textarea form-control form-control-sm" rows="4" required></textarea>
					<label for="form8">Your message</label>
				</div>
				<div class="text-center mt-4">
					<a class="btn btn-primary button-color" id="send_btn">Send <i class="fa fa-paper-plane-o ml-1"></i></a>
				</div>
			</form>
		</div>
		<!-- Form contact -->
	</div>
	<!--Grid column-->
	<!--Grid column-->
	<div class="col-lg-7 col-md-12">
		<!--Grid row-->
		<div class="row text-center">
			<!--Grid column-->
			<div class="col-lg-4 col-md-12 mb-3">
				<div class="anim" data-av-animation="slideInDown">
					<p><i class="fa fa-map fa-1x mr-2 grey-text"></i><?php  info('address'); ?> </p>
				</div>
		    </div>
			<!--Grid column-->
			<!--Grid column-->
			<div class="col-lg-4 col-md-6 mb-3">
				<div class="anim" data-av-animation="slideInDown">
					<p><i class="fa fa-building fa-1x mr-2 grey-text"></i>'Sat'-Thu, </br><?php info('start_hour'); ?>-<?php info('end_hour'); ?></p>
				</div>
			</div>
		    <!--Grid column-->
			<!--Grid column-->
			<div class="col-lg-4 col-md-6 mb-3">
				<div class="anim" data-av-animation="slideInDown">
					<p><i class="fa fa-phone fa-1x mr-2 grey-text"></i><?php  info('phone'); ?> - <?php  info('mobile'); ?></p>
				</div>
			</div>
			<!--Grid column-->
		</div>
		<!--Grid row-->
		<!--Google map-->
		<div class="anim" data-av-animation="slideInRight">
			<div id="map-container" class="z-depth-1-half map-container mb-5" style="height: 400px"></div>
		</div>
	</div>
	<!--Grid column-->
</div>
<!--Grid row-->
<?php 
	$pageReadyScript.= '
	// Initialize maps
	google.maps.event.addDomListener(window, "load", regular_map);
	$("#send_btn").on("click",function(e){
		var data = $("form").serialize();
		$.post("contacts_pro.php", data,function(){
			alert("your message was sent successfully. We will reply as soon as possible.thank you. best regards");
			document.getElementById("form3").value = "";
			document.getElementById("form2").value = "";
			document.getElementById("form32").value = "";
			document.getElementById("form8").value = "";
		});
	});';
?>

