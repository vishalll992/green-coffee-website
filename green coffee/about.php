<?php

  session_start();
  include dirname(__FILE__) . '/component/connection.php';
 // include $_SERVER['DOCUMENT_ROOT'] . '/green coffee (2)/green coffee/component/connection.php';

  
  if(isset($_SESSION['user-id'])){
	$user_id= $_SESSION['user_id'];
 }else{
	$user_id='';
 }
 if (isset($_POST['logout'])) {
	session_destroy();
	header("location::login.php");
 }
?>
<style type="text/css">
	<?php include 'style.css'; ?>
</style>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
	<title>Green coffee - about us  page</title>
</head>
<body>
	<?php include 'component/header.php';?>
	<div class="main">
		<div class="banner">
            <h1>about us</h1>
        </div>
        <div class="title2">
            <a href="home.php">home</a><span>about</span>
        </div>
        <div class="about-category">
            <div class="box">
                <img src="img/3.webp">
                <div class="detail">
                    <span>coffee</span>
                    <h1>lemon green</h1>
                    <a href="view_product.php" class="btn">shop now</a>
                </div>
            </div>
            <div class="box">
                <img src="img/about.png">
                <div class="detail">
                    <span>coffee</span>
                    <h1>lemon Teaname</h1>
                    <a href="view_product.php" class="btn">shop now</a>
                </div>
            </div>
			<div class="box">
                <img src="img/2.webp">
                <div class="detail">
                    <span>coffee</span>
                    <h1>lemon Teaname</h1>
                    <a href="view_product.php" class="btn">shop now</a>
                </div>
            </div>
            <div class="box">
                <img src="img/1.webp">
                <div class="detail">
                    <span>coffee</span>
                    <h1>lemon green</h1>
                    <a href="view_product.php" class="btn">shop now</a>
                </div>
            </div>
        </div>
        <section class="services">
			<div class="title">
				<img src="img/download.png" class="logo">
				<h1>why choose us</h1>
				<p>"Choose us for premium quality, sustainable sourcing, and an unforgettable coffee experience! ☕✨"</p>
			</div>
				<div class="box-container">
					<div class="box">
						<img src="img/icon2.png">
						<div class="detail">
							<h3>great saving</h3>
							<p>save big every order</p>
						</div>
					</div>
					<div class="box">
						<img src="img/icon1.png">
						<div class="detail">
							<h3>24*7 support</h3>
							<p>one-on-one support</p>
						</div>
					</div>
					<div class="box">
						<img src="img/icon0.png">
						<div class="detail">
							<h3>gift vouchers</h3>
							<p>vouchers on every festivals</p>
						</div>
					</div>
					<div class="box">
						<img src="img/icon.png">
						<div class="detail">
							<h3>worldwide delivery</h3>
							<p>dropship worldwide</p>
						</div>
					</div>
				</div>
			</section>
			<div class="about">
				<div class="row">
					<div class="img-box">
						<img src="img/3.png">
					</div>
					<div class="detail">
						<h1>visit our beautiful showroom!</h1>
						<p>Our showroom is an expression of what we love doing; being creative with floral and 
						plant
						     arrangements.
							 whether you looking for a florist for your perfect wedding, or just want to uplift
							 any room 
							 with
							 some one of a kind living decor, Blossom with love can help.</p>
						<a href="view_product.php" class="btn">shop now</a>	 
					</div>
				</div>
			</div>
			<!--<div class="testimonial-container">
				<div class="title">
					<img src="img/download.png" class="logo">
					<h1>what people say about us</h1>
					<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa, consequatur est! Deserunt esse hic.
					</p>
			    </div>
					<div class="container">
						<div class="testimonial-item active">
							<img src="img/01.jpg">
							<h1>sara smith</h1>
							<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. ipsum dolor sit amet consectetur, adipisicing elit. Quidem voluptatem nostrum officiis quibusdam, ut error earum, consequatur soluta temporibus illum nulla ducimus, nemo blanditiis voluptatum.</p>
						</div>
						<div class="testimonial-item">
							<img src="img/02.jpg">
							<h1>john smith</h1>
							<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. ipsum dolor sit amet consectetur, adipisicing elit. Quidem voluptatem nostrum officiis quibusdam, ut error earum, consequatur soluta temporibus illum nulla ducimus, nemo blanditiis voluptatum.</p>
						</div>
						<div class="testimonial-item">
							<img src="img/03.jpg">
							<h1>vishal gupta</h1>
							<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. ipsum dolor sit amet consectetur, adipisicing elit. Quidem voluptatem nostrum officiis quibusdam, ut error earum, consequatur soluta temporibus illum nulla ducimus, nemo blanditiis voluptatum.</p>
						</div>
						<div class="left-arrow" onclick="nextSlide()"><i class="bx bxs-left-arrow-alt"></i></div> 
						<div class="right-arrow" onclick="prevSlide()"><i class="bx bxs-right-arrow-alt"></i></div> 
					</div>		
				</div>-->
		<?php include 'component/footer.php'; ?>
	</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
	<script src="script.js"></script>
	<script type="text/javascript">
		let slide = document.querySelectorAll('testimonial-item')
	    let index = 0

		function nextSlide(){
			slides[index].classList.remove('active');
			index = (index + 1) % slides.length;
			slides[index].classList.add('active');
		}
		function prevSlide(){
			slides[index].classList.remove('active');
			index = (index - 1 + slide .length) % slides.length;
			slides[index].classList.add('active');
		}
	</script>
	<?php include 'component/alert.php'; ?>
</body>
</html>