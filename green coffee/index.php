<?php

 session_start();
 include dirname(__FILE__) . '/component/connection.php';



// include $_SERVER['DOCUMENT_ROOT'] .'/green coffee (2)/green coffee/component/connection.php';
  
  if(isset($_SESSION['user-id'])){
	$user_id= $_SESSION['user_id'];
 }else{
	$user_id='';
 }
 if (isset($_POST['logout'])) {
	session_destroy();
	header("location:login.php");
 }
?>
<style type="text/css">
	<?php include "style.css"?>
</style>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
 
	<title>Green coffee - home page</title>
</head>
<body>
	<?php include 'component/header.php';?>
	<div class="main">
		<section class="home section">
			<div class="slider">
			<div class="slider_slider slide1">
				<div class="overlay"></div>
				<div class="slide-detail">
					<h1>Premium Quality Products</h1>
					<p>"Sourced from nature, brewed for greatness—your cup deserves the best! 😃☕"</p>
					<a href="view_product.php" class="btn">shop now</a>
				</div>
				<div class="hero-dec-top"></div>
				<div class="hero-dec-bottom"></div>
			</div>
			<!------slide end---->
			<div class="slider_slider slide2">
				<div class="overlay"></div>
				<div class="slide-detail">
					<h1>welcome to my shop</h1>
					<p>"Welcome to our shop—where every sip brings joy and freshness straight to your cup!☕🍵"</p>
					<a href="view_product.php" class="btn">shop now</a>
				</div>
				<div class="hero-dec-top"></div>
				<div class="hero-dec-bottom"></div>
			</div>
			<!------slide end---->
			<div class="slider_slider slide3">
				<div class="overlay"></div>
				<div class="slide-detail">
					<h1>Sustainability & Transparency</h1>
					<p>"Saving the planet, one eco-friendly sip at a time—because green is more than just our name!☕🍵"</p>
					<a href="view_product.php" class="btn">shop now</a>
				</div>
				<div class="hero-dec-top"></div>
				<div class="hero-dec-bottom"></div>
			</div>
			<!------slide end---->
			<div class="slider_slider slide4">
				<div class="overlay"></div>
				<div class="slide-detail">
					<h1>Loyalty & Discounts</h1>
					<p>Join the sip squad—where every cup gets you closer to free refills!😃☕"</p>
					<a href="view_product.php" class="btn">shop now</a>
				</div>
				<div class="hero-dec-top"></div>
				<div class="hero-dec-bottom"></div>
			</div>
			<!------slide end---->
			<div class="slider_slider slide5">
				<div class="overlay"></div>
				<div class="slide-detail">
					<h1>Easy Online Shopping</h1>
					<p>"Shop, sip, repeat—because good coffee shouldn’t be hard to buy!😃☕"</p>
					<a href="view_product.php" class="btn">shop now</a>
				</div>
				<div class="hero-dec-top"></div>
				<div class="hero-dec-bottom"></div>
			</div>
			<!--- slide end --->
			<div class="left-arrow"><i class="bx bxs-left-arrow"></i></div>
			<div class="right-arrow"><i class="bx bxs-right-arrow"></i></div>
		</div>
	</section>
			<!-----home slider end---->	
			<section class="thumb">
				<div class="box-container">
					<div class="box">
						<img src="img/thumb2.jpg">
						<h3>green tea</h3>	
						<!-- <p>"Green tea: because adulting is hard, but at least your drink can be smooth, fresh, and full of zen! 🍵😌"</p> -->
						<!-- <i class="bx bx-chevron-right"></i> --->
					</div>
					<div class="box">
						<img src="img/thumb0.jpg">
						<h3>lemon tea</h3>	
						<!-- <p>"Lemon tea: because life gives you lemons, and we turn them into a zesty, sippable hug! 🍋🍵😄"</p> -->
						<!-- <i class="bx bx-chevron-right"></i> -->
					</div>
					<div class="box">
						<img src="img/thumb2.jpg">
						<h3>green coffee</h3>	
						<!-- <p>"Green coffee: for when you want caffeine with a side of health—because who said energy can’t be guilt-free? ☕💚😆"</p> -->
						<!-- <i class="bx bx-chevron-right"></i> -->
					</div>
					<div class="box">
						<img src="img/thumb.jpg">
						<h3>green tea</h3>	
						<!-- <p>"Green tea: the only green thing you’ll actually enjoy drinking—refreshing, healthy, and totally zen! 🍵😆"</p> -->
						<!-- <i class="bx bx-chevron-right"></i> -->
					</div>	
				</div>	
			</section>
			<section class="container">
				<div class="box-container">
					<div class="box">
						<img src="img/about-us.jpg">
					</div>
					<div class="box">
						<img src="img/download.png">
						<span>healthy tea</span>
						
						<h1>save up to 50% off</h1>
						<p>"Save up to 50% off—because great tea and coffee taste even better on a deal! ☕🍵💰"</p>
					</div>
				</div>
			</section>
			<section class="shop">
				<div class="title">
					<img src="img/download.png">
					<h1>Trending Products</h1>
				</div>
				<div class="row">
					<img src="img/about.jpg">
					<div class="row-detail">
						<img src="img/basil.jpg">
						<div class="top-footer">
							<h1>a cup of green tea makes you healthy</h1>
						</div>
					</div>
				</div>
				<div class="box-container">
					<div class="box">
						<img src="img/card.jpg">
						<a href="view_product.php" class="btn">shop now</a>
					</div>
					<div class="box">
						<img src="img/card0.jpg">
						<a href="view_product.php" class="btn">shop now</a>
					</div>
					<div class="box">
						<img src="img/card1.jpg">
						<a href="view_product.php" class="btn">shop now</a>
					</div>
					<div class="box">
						<img src="img/card2.jpg">
						<a href="view_product.php" class="btn">shop now</a>
					</div>	
					<div class="box">
						<img src="img/10.jpg">
						<a href="view_product.php" class="btn">shop now</a>
					</div>	
					<div class="box">
						<img src="img/6.webp">
						<a href="view_product.php" class="btn">shop now</a>
					</div>		
				</div>
			</section>
			<section class="shop-category">
				<div class="box-container">
					<div class="box">
						<img src="img/6.jpg">
						<div class="detail">
							<span>BIG OFFERS</span>
							<h1>Extra 15% Off</h1>
							<a href="view_product.php" class="btn">shop now</a>
						</div>
					</div>
					<div class="box">
						<img src="img/7.jpg">
						<div class="detail">
							<span>new in taste</span>
							<h1>coffee house</h1>
							<a href="view_product.php" class="btn">shop now</a>
						</div>
					</div>
				</div>
			</section>
			<section class="services">
				<div class="box-container">
					<div class="box">
						<img src="img/icon2.png">
						<div class="detail">
							<h3>great saving</h3>
							<h3>save big every order</h3>
							<!-- <p>save big every order</p> -->
						</div>
					</div>
					<div class="box">
						<img src="img/icon1.png">
						<div class="detail">
							<h3>24*7 support</h3>
							<h3>one-on-one support</h3>
							<!-- <p>one-on-one support</p> -->
						</div>
					</div>
					<div class="box">
						<img src="img/icon0.png">
						<div class="detail">
							<h3>gift vouchers</h3>
							<h3>vouchers on every festivals</h3>
							<!-- <p>vouchers on every festivals</p> -->
						</div>
					</div>
					<div class="box">
						<img src="img/icon.png">
						<div class="detail">
							<h3>worldwide delivery</h3>
							<h3>dropship worldwide</h3>
							<!-- <p>dropship worldwide</p> -->
						</div>
					</div>
				</div>
			</section>
			<section class="brand">
				<div class="box-container">
					<div class="box">
						<img src="img/brand (1).jpg">
					</div>
					<div class="box">
						<img src="img/brand (2).jpg">
					</div>
					<div class="box">
						<img src="img/brand (3).jpg">
					</div>
					<div class="box">
						<img src="img/brand (4).jpg">
					</div>
					<div class="box">
						<img src="img/brand (5).jpg">
						<!-- <img src="img/brand (5).jpg"> -->
					</div>
				</div>
				<?php include 'component/footer.php'; ?>
			</section>
			</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
	<script src="script.js"></script>
	<?php include 'component/alert.php'; ?>
	
</body>
</html>
