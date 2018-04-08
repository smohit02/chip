<?php
session_start();
require_once("dbcontroller.php");
$db_handle = new DBController();
if(!empty($_GET["action"])) {
	switch($_GET["action"]) {
		case "remove":
			if(!empty($_SESSION["cart_item"])) {
				foreach($_SESSION["cart_item"] as $k => $v) {
						if($_GET["code"] == $k)
							unset($_SESSION["cart_item"][$k]);				
						if(empty($_SESSION["cart_item"]))
							unset($_SESSION["cart_item"]);
				}
			}
		break;
		case "empty":
			unset($_SESSION["cart_item"]);
		break;	
		case "edit":
			$total_price = 0;
			foreach ($_SESSION['cart_item'] as $k => $v) {
			  if($_POST["code"] == $k) {
				  if($_POST["quantity"] == '0') {
					  unset($_SESSION["cart_item"][$k]);
				  } else {
					$_SESSION['cart_item'][$k]["quantity"] = $_POST["quantity"];
				  }
			  }
			  $total_price += $_SESSION['cart_item'][$k]["price"] * $_SESSION['cart_item'][$k]["quantity"];	
				  
			}
			if($total_price!=0 && is_numeric($total_price)) {
				print "$" . number_format($total_price,2);
				exit;
			}
		break;	
	}
}
?>
<HTML>
<HEAD>
<TITLE>Simple PHP Shopping Cart</TITLE>
<!--  <link href="style.css" type="text/css" rel="stylesheet" /> -->

<script type="application/x-javascript"> 
	addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
	function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- //for-mobile-apps -->
<link href="css/bootstrap.css" rel="stylesheet" type="text/css">
<!-- Custom Theme files -->
<link href="css/style.css" rel="stylesheet" type="text/css">
<!-- js -->
   <script src="js/jquery-1.11.1.min.js"></script>
<!-- //js -->
<!-- start-smoth-scrolling -->
<script type="text/javascript" src="js/move-top.js"></script>
<script type="text/javascript" src="js/easing.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		$(".scroll").click(function(event){		
			event.preventDefault();
			$('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
		});
	});
</script>
<!-- start-smoth-scrolling -->
<link href="css/font-awesome.css" rel="stylesheet"> 
<link href="//fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
<link href="//fonts.googleapis.com/css?family=Noto+Sans:400,700" rel="stylesheet" type="text/css">
<!--- start-rate---->
<script src="js/jstarbox.js"></script>
	<link rel="stylesheet" href="css/jstarbox.css" type="text/css" media="screen" charset="utf-8">
		<script type="text/javascript">
			jQuery(function() {
			jQuery('.starbox').each(function() {
				var starbox = jQuery(this);
					starbox.starbox({
					average: starbox.attr('data-start-value'),
					changeable: starbox.hasClass('unchangeable') ? false : starbox.hasClass('clickonce') ? 'once' : true,
					ghosting: starbox.hasClass('ghosting'),
					autoUpdateAverage: starbox.hasClass('autoupdate'),
					buttons: starbox.hasClass('smooth') ? false : starbox.attr('data-button-count') || 5,
					stars: starbox.attr('data-star-count') || 5
					}).bind('starbox-value-changed', function(event, value) {
					if(starbox.hasClass('random')) {
					var val = Math.random();
					starbox.next().text(' '+val);
					return val;
					} 
				})
			});
		});
		</script>
<style>
body {margin:0;}

.icon-bar {
    width: 100%;
    background-color: #555;
    overflow: auto;
}

.icon-bar a {
    float: left;
    width: 25%;
    text-align: center;
    padding: 12px 0;
    transition: all 0.3s ease;
    color: white;
    font-size: 36px;
}

.icon-bar a:hover {
    background-color: #000;
}

.active {
    background-color: #4CAF50 !important;
}
</style>
</HEAD>
<BODY>

<div class="navbar navbar-fixed-bottom">
 <div class="icon-bar">
  <a  href="#" "><i class="fa fa-home"></i></a> 
  <!-- <a href="#"><i class="fa fa-search"></i></a>  -->
  <a href="profile.php" ><i class="fa fa-user"></i></a> 
  <a href="menu.php" ><i class="fa fa-book"></i></a>
  <!-- <span class="my-cart-icon" > -->
  	<!-- </span>  --><!-- 
  <a href="#"><i class="fa fa-credit-card"></i></a> 
 -->  <a href="shopping_cart.php" class="active data-toggle="tooltip" data-placement=	"top" title="<?php echo $session_items ?>" ><i class="fa fa-shopping-cart my-cart-icon"></i></a>
 </div>
</div>


<div class="header">

		<div class="container">
			
			<div class="logo">
				<h1><a href="index.php">CHIPAY<span>SRM Shit Foods</span></a></h1>
			</div>
			<div>
				<a href="login.php"><i class="fa fa-user abc" aria-hidden="true"></i>Login</a></li></right>
				<a href="register.php"><i class="fa fa-arrow-right abc" aria-hidden="true"></i>Register</a>
			</div>			
			<div class="header-ri">					
			</div>							
		</div>			
</div>

<div id="shopping-cart product">
	<div id="container">
		<div class="spec ">
				<h3>CART</h3>
				<div class="ser-t">
					<b></b>
					<span><i></i></span>
					<b class="line"></b>
				</div>
		</div>		
		<div class=" con-w3l">
			
			<?php
			$total_price = 0.00;
			if(isset($_SESSION["cart_item"])){
			?>	
			<?php foreach ($_SESSION["cart_item"] as $item) { 
					$product_info = $db_handle->runQuery("SELECT * FROM tblproduct WHERE code = '" . $item["code"] . "'");
					$total_price += $item["price"] * $item["quantity"];	
			?>
				<div class="product-item pro-1 col-md-3 " onMouseOver="document.getElementById('remove<?php echo $item["code"]; ?>').style.display='block';"  onMouseOut="document.getElementById('remove<?php echo $item["code"]; ?>').style.display='';" >

					<div class="col-m">
					<form name="frmCartEdit" id="frmCartEdit">

						<div class="btnRemoveAction" id="remove<?php echo $item["code"]; ?>"><a href="shopping_cart.php?action=remove&code=<?php echo $item["code"]; ?>" title="Remove from Cart">x</a></div>
				
						<div class="product-image offer-img"><img src="<?php echo $product_info[0]["image"]; ?>" class="img-responsive"></div>
						<div class="mid-1"><div class="women"><?php echo $item["name"]; ?></div></div>
						<div class="product-price  	add add-2"><?php echo "Rs".$item["price"]; ?></div>
						<div class= "mid-2 add">Quantity: <input type="text" name="quantity" id="<?php echo $item["code"]; ?>" value="<?php echo $item["quantity"]; ?>" size="2" onBlur="saveCart(this);" /></div>
						
					
					</form>
				</div>
				</div>
			<?php
				}
			}
			?>
			
		</div>
	</div>
</div>


<footer class="pls">
	<div class="cart_footer_link">
	<div>Total Price: <span id="total_price"><?php echo "Rs". number_format($total_price,2); ?></span></div>
	<button class="btnAddAction btn btn-danger my-cart-btn my-cart-b">
	<a href="shopping_cart.php?action=empty">Clear Cart</a></button>
	<button class="btnAddAction btn btn-danger my-cart-btn my-cart-b"><a href="index.php" title="Cart">Continue Shopping</a></button>
	</div>
</footer>


<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script>
function saveCart(obj) {
	var quantity = $(obj).val();
	var code = $(obj).attr("id");
	$.ajax({
		url: "?action=edit",
		type: "POST",
		data: 'code='+code+'&quantity='+quantity,
		success: function(data, status){$("#total_price").html(data)},
		error: function () {alert("Problen in sending reply!")}
	});
}
</script>
<style type="text/css">
	.box{
    font-size: 1em;
    border: 2px solid #039445;
    border-radius: 75%;
    /*padding: 0.2em 0.5em;*/
    text-align: center;
    outline: none;
    margin-right: 10px;
	}
	.women{
		text-align: center;
	}
	.product-image {
    height:100px;
    width:130px;
    background-color:#FFF;
}
</style>
</BODY>
</HTML>