<?php 
	/**** get argements ****/
	$mainPageId = 0;
	$pluginPageDetector = 0;
	$pluginArguments = array();	
	foreach($urlArg as $arg){
		if($pluginPageDetector == 0){
			$getPageQuery = 'select * from `pages` where `id` > 0 and `slug` = "'.$arg.'" and `pages`.`page_of` = '.$mainPageId;	
			$getPageResult = query_result($getPageQuery);
			if(count($getPageResult) > 0){
				$mainPageId = $getPageResult[0]['id'];
			}
		}else{
			array_push($pluginArguments,strtolower($arg));
		}
		if($getPageResult[0]['plugin_id'] > 0){
			$pluginPageDetector =1;
		}
	}
	/******* /get argements  ***/
	echo '
	<section id="projects_section" class="text-center">';
		if(count($pluginArguments) == 0){
			//plugin index 		
			$getAllCategoriesQuery = 'select * from `categories` where `publish` = 1 and `main_category` = 0 and `site_id` = '.$siteId;
			$Categories = query_result($getAllCategoriesQuery);		
			if(count($Categories) != 3){
				$cols = (12 / ceil(sqrt(count($Categories))));		
			}else{
				$cols = 4;
			}	
			echo '
			<h2 class="mb-5 font-weight-bold animated fadeInDown">Products Catalog</h2>
			<div class="row">';
				foreach($Categories as $category){
					echo '
					<!--Grid column-->
					<div class="col-lg-'.$cols.' col-md-12 mb-'.$cols.'">
						<div class="anim" data-av-animation="rotateIn">
							<div class="view overlay z-depth-1-half">
								<img src="/'.$category['icon'].'" class="card-img-top" alt="">
								<div class="mask rgba-white-slight"></div>
							</div>
							<a href="'.$pluginPages['p_5'].'/'.$category['url'].'"><h4 class="my-4 font-weight-bold link-color">'.$category['category_name'].'</h4></a>
							<p class="grey-text">'.$category['short_description'].'</p>
						</div>
					</div>';
				}
				echo '
		    </div>
			<!--Grid row-->';
		}elseif(count($pluginArguments) == 1 && $pluginArguments[0] == 'cart'){
			$getCartProductsQuery = '
			select 
				`cart_id`,`products`.`icon`,`products`.`product_name`,`cart`.`price`,`cart`.`quantity`,`cart`.`total_price` 
			from 
				`cart` 
				inner join `products` on(`products`.`product_id` = `cart`.`product_id`) 
			where 
				`user_id` = '.$_SESSION['jskhaKJHGUYTssh-jkxq3lk84xu@kjhds'];
			$Products = query_result($getCartProductsQuery);
			echo '<link rel="stylesheet" href="/css/cart.css">
			<div class="container mb-4">
				<div class="row">
					<div class="col-12">
						<div class="table-responsive">
							<table class="table table-striped">
								<thead>
									<tr>
										<th scope="col"> </th>
										<th scope="col">Product</th>										
										<th scope="col" class="text-center">Quantity</th>
										<th scope="col" class="text-right">Price</th>
										<th scope="col" class="text-right">Total Price</th>
										<th> </th>
									</tr>
								</thead>
								<tbody>';
									$total = 0;
									$index = 0;
									foreach($Products as $product){
										echo'
										<tr>
											<td><img src="/'.$product['icon'].'" width="100px"/> </td>
											<td>'.$product['product_name'].'</td>
											<td><input class="form-control" type="number" value="'.$product['quantity'].'" name="quantity" data-id="'.$product['cart_id'].'" data-price="'.$product['price'].'" data-total-price="'.$product['total_price'].'" data-index="'.$index.'"/></td>
											<td class="text-right">$'.$product['price'].'</td>
											<td class="text-right" id="total_'.$index.'">$'.$product['total_price'].'</td>
											<td class="text-right"><a href="/products_pro.php?action=deleteFromCart&id='.$product['cart_id'].'" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> </a> </td>
										</tr>';	
										$total = ($total + $product['total_price']);
										$index++;
									}
									echo'
									<tr>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td>Sub-Total</td>
										<td class="text-right" id="overall">$'.$total.'</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="col mb-2">
						<div class="row">
							<div class="col-sm-12  col-md-6">
								<a href="/products_pro.php?action=clearCart" class="btn btn-block btn-light">Clear Cart</a>
							</div>
							<div class="col-sm-12 col-md-6 text-right">
								<a href="'.$pluginPages['p_5'].'/cart/checkout" class="btn btn-lg btn-block btn-success text-uppercase">Checkout</a>
							</div>
						</div>
					</div>
				</div>
			</div>';
			$pageReadyScript.='
			$(".form-control").change(
				function(){	
					var p = $(this).data("price");
					var q = $(this).val();
					var index = $(this).data("index");
					var total = Number(Number(p) * Number(q));
					$(this).data("totalPrice",total);					
					var id = $(this).data("id");
					$("#total_"+$(this).data("index")).html("$"+total);
					var items = document.getElementsByName("quantity");
					items[index].dataset.totalPrice = total;
					var overallItems = 0;
					for(x = 0; x < items.length; x++){
						var total = items[x].dataset.totalPrice;
						overallItems = Number(overallItems) + Number(total);
					}
					document.getElementById("overall").innerHTML = "$" + overallItems;
					$.get("/products_pro.php",{cartId:id,quantity:q,action:"setCartQuantity",price:p,total_price:total});				
				}
			);';
		}elseif(count($pluginArguments) == 2 && $pluginArguments[0] == 'cart' && $pluginArguments[1] == 'checkout'){
			$getCartProductsQuery = '
			select 
				`cart_id`,`products`.`icon`,`products`.`short_description`,`products`.`product_name`,`cart`.`price`,`cart`.`quantity`,`cart`.`total_price` 
			from 
				`cart` 
				inner join `products` on(`products`.`product_id` = `cart`.`product_id`) 
			where 
				`user_id` = '.$_SESSION['jskhaKJHGUYTssh-jkxq3lk84xu@kjhds'];
			$Products = query_result($getCartProductsQuery);
			$getUserInfoQuery = 'select * from `users` where `id` = '.$_SESSION['jskhaKJHGUYTssh-jkxq3lk84xu@kjhds'];
			$User = query_result($getUserInfoQuery);
			echo '
			<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
			<meta name="theme-color" content="#563d7c">
			<div class="row">
				<div class="col-md-4 order-md-2 mb-4">
					<h4 class="d-flex justify-content-between align-items-center mb-3">
						<span class="text-muted">Your cart</span>
						<span class="badge badge-secondary badge-pill">'.count($Products).'</span>
					</h4>
					<ul class="list-group mb-3">';
						$total = 0;
						foreach($Products as $product){
							echo '
							<li class="list-group-item d-flex justify-content-between lh-condensed">
								<div class="">
									<h6 class="my-0">'.$product['quantity'].' '.$product['product_name'].'</h6>								
								</div>
								<span class="text-muted">$'.$product['total_price'].'</span>
							</li>';
							$total = ($total + $product['total_price']);
						}
						echo'
						<li class="list-group-item d-flex justify-content-between">
						<span>Total (USD)</span>
						<strong>$'.$total.'</strong>
						</li>
					</ul>
				</div>
				<div class="col-md-8 order-md-1">
					<h4 class="mb-3">Billing address</h4>
					<form action="/checkout.php" class="needs-validation" method="POST" id="paymentFrm" novalidate>
						<div class="mb-3">
							<label for="fullName" class="pull-left">full name</label>
							<input type="text" class="form-control" id="fullName" name="fullName" placeholder="" value="'.$User[0]['name'].'" required>
							<div class="invalid-feedback">
								Valid full name is required.
							</div>
						</div>
						<div class="mb-3">
							<label for="email" class="pull-left">Email</label>
							<input type="email" class="form-control" id="email" name="email" placeholder="you@example.com" value="'.$User[0]['email'].'" required>
							<div class="invalid-feedback">
								Please enter a valid email address for shipping updates.
							</div>
						</div>		
						<div class="mb-3">
							<label for="address" class="pull-left">Address</label>
							<input type="text" class="form-control" id="address" name="address" placeholder="1234 Main St" value="'.$User[0]['address_1'].'" required>
							<div class="invalid-feedback">
								Please enter your shipping address.
							</div>
						</div>				
						<div class="mb-3">
							<label for="address2" class="pull-left">Address 2 <span class="text-muted">(Optional)</span></label>
							<input type="text" class="form-control" id="address2" name="address2" placeholder="Apartment or suite" value="'.$User[0]['address_2'].'">
						</div>			
						<div class="row">
							<div class="col-md-6 mb-3">
								<label for="cc-name" class="pull-left">Name on card</label>
								<input type="text" class="form-control" id="cc-name" name="cc-name" placeholder="" value="'.$User[0]['name_on_card'].'" required>
								<small class="text-muted">Full name as displayed on card</small>
								<div class="invalid-feedback">
									Name on card is required
								</div>
							</div>
							<div class="col-md-6 mb-3">
								<label for="cc-number" class="pull-left">Credit card number</label>
								<input type="text" class="form-control" id="cc-number" name="cc-number" placeholder="" value="'.$User[0]['card_number'].'" required>
								<div class="invalid-feedback">
									Credit card number is required
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3 mb-3">
								<label for="cc-expiration-month" class="pull-left">Expiration Month</label>
								<input type="number" class="form-control" id="cc-expiration-month" name="cc-expiration-month" placeholder="" value="'.$User[0]['card_ex_month'].'" required>
								<div class="invalid-feedback">
									Expiration month required
								</div>
							</div>
							<div class="col-md-3 mb-3">
								<label for="cc-expiration-year" class="pull-left">Expiration Year</label>
								<input type="number" class="form-control" id="cc-expiration-year" name="cc-expiration-year" placeholder="" value="'.$User[0]['card_ex_year'].'" required>
								<div class="invalid-feedback">
									Expiration year required
								</div>
							</div>
						</div>
						<div class="row">
						<div class="col-md-3 mb-3">
							<label for="cc-cvv" class="pull-left">CVV</label>
							<input type="number" class="form-control" id="cc-cvv" name="cc-cvv" placeholder="" value="" required>
							<div class="invalid-feedback">
								Security code required
							</div>
						</div>
						</div>
						<hr class="mb-4">
						<div class="custom-control custom-checkbox pull-left">
							<input type="checkbox" class="custom-control-input" id="save-info" name="save-info">
							<label class="custom-control-label" for="save-info">Save this information for next time</label>
					  	</div>
						<button class="btn btn-primary button-color " id="payBtn" type="submit">Continue to checkout</button>
					</form>
				</div>
			</div>
			<script type="text/javascript">
				//set your publishable key
				Stripe.setPublishableKey("pk_test_51JAYk6BHruTtVVwTaeEQ74NUxTqPVDliiitkmuu6je2snMjO8Wwereu4FvhDk2ygpNkpgLwRTsD5dByNKHZbyqqX007e1e97eE");
				//callback to handle the response from stripe
				function stripeResponseHandler(status, response) {
					if (response.error) {
						//enable the submit button
						$("#payBtn").removeAttr("disabled");
						//display the errors on the form
						$(".payment-errors").html(response.error.message);
					} else {
						var form$ = $("#paymentFrm");
						//get token id
						var token = response["id"];
						//insert the token into the form
						form$.append("<input type=hidden name=stripeToken value=" + token + " />");
						//submit form to the server
						form$.get(0).submit();
					}
				}				
				// Example starter JavaScript for disabling form submissions if there are invalid fields
				(function () {				
				  window.addEventListener("load", function () {
					// Fetch all the forms we want to apply custom Bootstrap validation styles to
					var forms = document.getElementsByClassName("needs-validation")				
					// Loop over them and prevent submission
					Array.prototype.filter.call(forms, function (form) {
					  form.addEventListener("submit", function (event) {
						if (form.checkValidity() === false) {
						  event.preventDefault()
						  event.stopPropagation()
						}
						form.classList.add("was-validated")
					  }, false)
					})
				  }, false)
				}())				
				</script>';
				$pageReadyScript.='				
				$("#paymentFrm").submit(function(event) {
					//disable the submit button to prevent repeated clicks
					$("#payBtn").attr("disabled", "disabled");			
					//create single-use token to charge the user
					Stripe.createToken({
						number: $("#cc-number").val(),
						cvc: $("#cc-cvv").val(),
						exp_month: $("#cc-expiration-month").val(),
						exp_year: $("#cc-expiration-year").val()
					}, stripeResponseHandler);			
					//submit from callback
					return false;
				});';
		}elseif(count($pluginArguments) == 2 && $pluginArguments[0] == 'order'){
			$setOrderDeliveryQuery = 'update `orders` set `status` = "2" where `order_id` = '.$pluginArguments[1];
			$setOrderDeliveryResult = query_result($setOrderDeliveryQuery);
			/***** review products ******/
			$getCartProductsQuery = '
			select 
				`products`.`icon`,`products`.`product_name`,`products`.`product_id`
			from 
				`orders` 
				inner join `order_details` on (`order_details`.`order_id` = `orders`.`order_id`)
				inner join `products` on(`products`.`product_id` = `order_details`.`product_id`) 
			where 
				`orders`.`order_id` = '.$pluginArguments[1];
			$Products = query_result($getCartProductsQuery);
			echo '<link rel="stylesheet" href="/css/cart.css">
			<style>
			.checked{
				color: #ff9f1a; 
			}
			.checked2{
				color: #ff9f1a; 
			}
			</style>
			<div class="container mb-4">
				<h4>Review Order Products</h4>
				<div class="row">
					<div class="col-12">
						<div class="table-responsive">
							<table class="table table-striped">
								<thead>
									<tr>
										<th scope="col"> </th>
										<th scope="col">Product</th>										
										<th scope="col" class="text-center">Review</th>
										<th> </th>
									</tr>
								</thead>
								<tbody>';
									$total = 0;
									$index = 0;
									foreach($Products as $product){
										echo'
										<tr>
											<td><input type="hidden" name="productId[]" value="'.$product['product_id'].'"><input type="hidden" name="rating[]" value=""><img src="/'.$product['icon'].'" width="100px"/> </td>
											<td>'.$product['product_name'].'</td>
											<td>
												<div class="stars">
													<span class="fa fa-star star" data-product-id="'.$product['product_id'].'" data-rating="1"></span>
													<span class="fa fa-star star" data-product-id="'.$product['product_id'].'" data-rating="2"></span>
													<span class="fa fa-star star" data-product-id="'.$product['product_id'].'" data-rating="3"></span>
													<span class="fa fa-star star" data-product-id="'.$product['product_id'].'" data-rating="4"></span>
													<span class="fa fa-star star" data-product-id="'.$product['product_id'].'" data-rating="5"></span>
												</div>
											</td>
										</tr>';	
										$index++;
									}
									echo'
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="col mb-2">
					<div class="row">
						<div class="col-sm-12  col-md-12">
							<a href="/" class="btn  btn-light">Go To Home Page</a>
						</div>
					</div>
				</div>
			</div>';
			$pageReadyScript.='
			$(".star").click(
				function(){
					var productId = $(this).data("productId");
					var rating = $(this).data("rating");					
					$.get("/products_pro.php",{product_id:productId,ratingNumber:rating,action:"setRating"});
					var parent = $(this).parent();
					var rating = $(this).data("rating");
					var children = parent.children();				
					$(this).parent().children().each(
						function(){
							if(Number(this.dataset.rating) <=  Number(rating)){
								this.classList.add("checked2");
							}else{
								this.classList.remove("checked2");
							}
						}
					);					
				}				
			);
			$(".star").mouseover(
				function(){
					var parent = $(this).parent();
					var rating = $(this).data("rating");
					var children = parent.children();
					
					$(this).parent().children().each(
						function(){
							if(Number(this.dataset.rating) <=  Number(rating)){
								this.classList.add("checked");
							}else{
								this.classList.remove("checked");
							}
						}
					);
				}
			);
			$(".form-control").change(
				function(){	
					var p = $(this).data("price");
					var q = $(this).val();
					var index = $(this).data("index");
					var total = Number(Number(p) * Number(q));
					$(this).data("totalPrice",total);					
					var id = $(this).data("id");
					$("#total_"+$(this).data("index")).html("$"+total);
					var items = document.getElementsByName("quantity");
					items[index].dataset.totalPrice = total;
					var overallItems = 0;
					for(x = 0; x < items.length; x++){
						var total = items[x].dataset.totalPrice;
						overallItems = Number(overallItems) + Number(total);
					}
					document.getElementById("overall").innerHTML = "$" + overallItems;
					$.get("/products_pro.php",{cartId:id,quantity:q,action:"setCartQuantity",price:p,total_price:total});				
				}
			);';
		}else{
			$categoryId = 0;
			$productId = 0;
			foreach($pluginArguments as $argument){
				$argumentText = $argument;//strtolower(str_replace("-"," ",$argument));
				$getCategoryQuery = 'select * from `categories` where `publish` = 1 and `site_id` = '.$siteId.' and `slug` = "'.$argumentText.'" and `main_category` = '.$categoryId;
				$argCategory = query_result($getCategoryQuery);
				if(count($argCategory) > 0){
					$categoryId = $argCategory[0]['category_id'];
				}else{
					$getProductQuery = 'select * from `products` where `product_id` > 0 and `publish` = 1 and `site_id` = '.$siteId.' and `category_id` = '.$categoryId.' and `slug` = "'.$argumentText.'"';
					$argProduct = query_result($getProductQuery);
					if(count($argProduct) > 0){
						$productId = $argProduct[0]['product_id'];
					}
				}
			}
			if($categoryId == 0 && $productId == 0){
				echo '
				<h2 class="mb-5 font-weight-bold">Page Not Found</h2>';
			}elseif($categoryId > 0 && $productId == 0){
				//category page
				echo'
				<h2 class="mb-5 font-weight-bold animated fadeInDown">'.$argCategory[0]['category_name'].'</h2>';
				$checkSubCategoriesQuery = 'select * from `categories` where `publish` = 1 and `main_category` = '.$categoryId.' and `site_id` = '.$siteId;
				$subCategories = query_result($checkSubCategoriesQuery);
				if(count($subCategories) > 0){
					//subcategories
					if(count($subCategories) != 3){
						$cols = (12 / ceil(sqrt(count($subCategories))));		
					}else{
						$cols = 4;
					}
					echo '
					<div class="row">';
						foreach($subCategories as $category){
							echo '
							<!--Grid column-->
							<div class="col-lg-'.$cols.' col-md-12 mb-'.$cols.'">
								<div class="anim" data-av-animation="rotateIn">
									<div class="view overlay z-depth-1-half">
										<img src="/'.$category['icon'].'" class="card-img-top" alt="">
										<div class="mask rgba-white-slight"></div>
									</div>
									<a href="'.$pluginPages['p_5'].'/'.$category['url'].'" ><h4 class="my-4 font-weight-bold link-color">'.$category['category_name'].'</h4></a>
									<p class="grey-text">'.$category['short_description'].'</p>
								</div>
							</div>';
						}
						echo '
					</div>';
				}else{
					//products
					$getProductsQuery = 'select * from `products` where `publish` = 1 and `site_id` = '.$siteId.' and `category_id` = '.$categoryId;
					$products = query_result($getProductsQuery);
					if(count($products) > 0){
						if(count($products) != 3){
							$cols = (12 / ceil(sqrt(count($products))));		
						}else{
							$cols = 4;
						}
						echo '
						<div class="row">';
							foreach($products as $product){
								echo '
								<!--Grid column-->
								<div class="col-lg-'.$cols.' col-md-12 mb-'.$cols.'">
									<div class="anim" data-av-animation="rotateIn">
										<div class="view overlay z-depth-1-half">
											<img src="/'.$product['icon'].'" class="card-img-top" alt="">
											<div class="mask rgba-white-slight"></div>
										</div>
										<a href="'.$pluginPages['p_5'].'/'.$product['url'].'" ><h4 class="my-4 font-weight-bold link-color">'.$product['product_name'].'</h4></a>
										<p class="grey-text">'.$product['short_description'].'</p>
									</div>
								</div>';
							}
							echo '
						</div>';
					}else{
						echo '
						<h2 class="mb-5 font-weight-bold">Empity Category</h2>';	
					}
				}
			}elseif($productId > 0){
				//product page
				$getProductInfoQuery = 'select * from products where product_id = '.$productId;
				$product = query_result($getProductInfoQuery);
				if(count($product) > 0){
					$getProductFilesQuery = 'select * from `product_files` where `product_id` = '.$productId;
					$images = query_result($getProductFilesQuery);
					if(isset($_SESSION['jskhaKJHGUYTssh-jkxq3lk84xu@kjhds'])){
						$getWishListStatusQuery = 'select * from `user_products` where `user_id` = "'.$_SESSION['jskhaKJHGUYTssh-jkxq3lk84xu@kjhds'].'" and `product_id` = "'.$productId.'"'; 
						$wishList = query_result($getWishListStatusQuery);
						$cartStatusQuery = 'select * from `cart` where `user_id` = "'.$_SESSION['jskhaKJHGUYTssh-jkxq3lk84xu@kjhds'].'" and `product_id` = "'.$productId.'"';
						$cart = query_result($cartStatusQuery);
						if(count($wishList) > 0){
							$wishListStatus = "1";
							$wishListChecked = "checked";
						}else{
							$wishListStatus = "0";
							$wishListChecked = "";
						}
						if(count($cart) > 0){
							$cartStatus = "1";
							$cartChecked = "REMOVE FROM CART";
						}else{
							$cartStatus = "0";
							$cartChecked = "Add To CART";
						}
					}else{
						$wishListStatus = "0";
						$wishListChecked = "";
						$cartStatus = "0";
						$cartChecked = "Add To CART";
					}
					
					echo '
					<link rel="stylesheet" href="/css/productpage.css">
					<div class="container mb-5">
						<div class="card">
							<div class="container-fliud">
								<div class="wrapper row">
									<div class="preview col-md-6">						
										<div class="preview-pic tab-content" id="lightgallery">';
											$counter = 0; 
											foreach($images as $image){
												if($counter == 0){
													$active = 'active';
												}else{
													$active = '';
												}
												echo '
												<div class="tab-pane '.$active.'" id="pic-'.$counter.'" data-responsive="/'.$image['file_url'].'" data-src="/'.$image['file_url'].'" data-sub-html="'.$image['short_description'].'"><img src="/'.$image['file_url'].'" /></div>';
												$counter++;
											}
											echo'
										</div>
										<ul class="preview-thumbnail nav nav-tabs">';
											$counter = 0; 
											foreach($images as $image){
												if($counter == 0){
													$active = 'active';
												}else{
													$active = '';
												}
												echo'
												<li class="'.$active.'"><a data-target="#pic-'.$counter.'" data-toggle="tab"><img src="/'.$image['file_url'].'" /></a></li>';
												$counter++;
											}
											echo'
										</ul>					
									</div>
									<div class="details col-md-6">
										<h3 class="product-title">'.$product[0]['product_name'].'</h3>
										<div class="rating">
											<div class="stars">
												<span class="fa fa-star checked"></span>
												<span class="fa fa-star checked"></span>
												<span class="fa fa-star checked"></span>
												<span class="fa fa-star"></span>
												<span class="fa fa-star"></span>
											</div>
											<span class="review-no">41 reviews</span>
										</div>
										<p class="product-description text-justify">'.$product[0]['description'].'</p>
										<h4 class="price">current price: <span>$'.$product[0]['price'].'</span></h4>
										<p class="vote"><strong>91%</strong> of buyers enjoyed this product! <strong>(87 votes)</strong></p>';
										if(isset($_SESSION['jskhaKJHGUYTssh-jkxq3lk84xu@kjhds'])){
											echo'
											<div class="action">
												<button class="add-to-cart btn btn-default button-color" id="cart-btn" data-product-id="'.$product[0]['url'].'" data-status="'.$cartStatus.'" type="button">'.$cartChecked.'</button>
												<button class="like btn btn-default" type="button" id="bookmark-btn" data-product-id="'.$product[0]['url'].'" data-status="'.$wishListStatus.'"><span class="fa fa-heart '.$wishListChecked.'"></span></button>
											</div>';
										}
										echo'
										<!-- Load Facebook SDK for JavaScript -->
										<div id="fb-root"></div>
										<script>
											(function(d, s, id) {
											var js, fjs = d.getElementsByTagName(s)[0];
											if (d.getElementById(id)) return;
											js = d.createElement(s); js.id = id;
											js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0";
											fjs.parentNode.insertBefore(js, fjs);
											}(document, "script", "facebook-jssdk"));
										</script>
										<!-- Your share button code -->
										<div class="fb-share-button" data-href="'.$_SERVER['REQUEST_URI'].'" data-layout="button_count"></div>

									</div>
								</div>
							</div>
						</div>
					</div>';
					// Initialize photo gallery
					$pageReadyScript.= '
					$("#lightgallery").lightGallery();
					$("#bookmark-btn").click(
						function(){							
							if($(this).data("status") == 0){
								actionType = "addToWishlist";
							}else{
								actionType = "removeFromWishlist";
							}
							$.get("/products_pro.php",{productId:$(this).data("productId"),action:actionType}).done(
								function(){									
									if($("#bookmark-btn").data("status") == 0){
										$("#bookmark-btn").data("status","1");
										$("#bookmark-btn").children().first().addClass(" checked");										
									}else{
										$("#bookmark-btn").data("status","0");
										$("#bookmark-btn").children().first().removeClass("checked");
									}		
								}
							);
						}
					);
					
					$("#cart-btn").click(
						function(){							
							if($(this).data("status") == 0){
								actionType = "addToCart";
							}else{
								actionType = "removeFromCart";
							}
							$.get("/products_pro.php",{productId:$(this).data("productId"),action:actionType}).done(
								function(){									
									if($("#cart-btn").data("status") == 0){
										$("#cart-btn").data("status","1");
										$("#cart-btn").html("REMOVE FROM CART");
									}else{
										$("#cart-btn").data("status","0");
										$("#cart-btn").html("ADD TO CART");
									}		
								}
							);
						}
					);';
				}else{
					echo '
					<h2 class="mb-5 font-weight-bold">Page Not Found</h2>';	
				}
			}
		}
		echo '
	</section>';
?>
	
