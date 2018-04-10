<?php
session_start();
require_once("dbcontroller.php");
$db_handle = new DBController();
if(!empty($_GET["action"])) {
switch($_GET["action"]) {
	case "add":
		if(!empty($_POST["quantity"])) {
			$productByCode = $db_handle->runQuery("SELECT * FROM tblproduct WHERE code='" . $_GET["code"] . "'");
			$itemArray = array($productByCode[0]["code"]=>array('name'=>$productByCode[0]["name"], 'code'=>$productByCode[0]["code"], 'quantity'=>$_POST["quantity"], 'price'=>$productByCode[0]["price"]));
			
			if(!empty($_SESSION["cart_item"])) {
				if(in_array($productByCode[0]["code"],$_SESSION["cart_item"])) {
					foreach($_SESSION["cart_item"] as $k => $v) {
							if($productByCode[0]["code"] == $k)
								$_SESSION["cart_item"][$k]["quantity"] = $_POST["quantity"];
					}
				} else {
					$_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray);
				}
			} else {
				$_SESSION["cart_item"] = $itemArray;
			}
		}
	break;
}
}
?>
<HTML>
<HEAD>
<TITLE>Simple PHP Shopping Cart</TITLE>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta property="og:title" content="Vide">
<meta name="keywords" content="Big store Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design">
<!-- <link href="style.css" type="text/css" rel="stylesheet" /> -->
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
<?php
$session_items = 0;
if(!empty($_SESSION["cart_item"])){
	$session_items = count($_SESSION["cart_item"]);
}	
?>


<!-- the logo part -->


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


<!-- logo ends here -->




<!-- sliding pics start here -->

  <div id="myCarousel" class="carousel slide visible-xs visible-sm" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class=""></li>
        <li data-target="#myCarousel" data-slide-to="1" class=""></li>
        <li data-target="#myCarousel" data-slide-to="2" class="active"></li>
      </ol>
      <div class="carousel-inner" role="listbox">
        <div class="item">
         <a href="kitchen.php"> <img class="first-slide" src="images/noimg.jpg" alt="First slide"></a>
       
        </div>
        <div class="item">
         <a href="care.php"> <img class="second-slide " src="images/noimg.jpg" alt="Second slide"></a>
         
        </div>
        <div class="item active">
          <a href="hold.php"><img class="third-slide " src="images/noimg.jpg" alt="Third slide"></a>
          
        </div>
      </div>
    
    </div>



<!-- sliding pics end here -->





<div class="product">
	<div id="container">
		<!-- <div class="top_links">
		Total Items = <?php echo $session_items; ?>
		</div> -->
	<div class="spec ">
				<h3>Recommended</h3>
				<div class="ser-t">
					<b></b>
					<span><i></i></span>
					<b class="line"></b>
				</div>
	</div>	
	<div class=" con-w3l">
		<?php
		$product_array = $db_handle->runQuery("SELECT * FROM tblproduct ORDER BY id ASC");
		if (!empty($product_array)) { 
			foreach($product_array as $key=>$value){
		?>
			
				<div class=" pro-1 col-md-3 " >
					<div class="col-m">
						<form method="post" action="index.php?action=add&code=<?php echo $product_array[$key]["code"]; ?>">
						<div class="product-image  offer-img"><img src="<?php echo $product_array[$key]["image"]; ?>" class="img-responsive" alt=""></div>
						<div class="mid-1"><div class="women"><?php echo $product_array[$key]["name"]; ?></div>
						<div class="add add-2"><?php echo "Rs".$product_array[$key]["price"]; ?></div>
						<div class= "mid-2 add"><input type="text" name="quantity" class="box" value="1" size="2" /><input type="submit"  value="Add to cart " class="btnAddAction btn btn-danger my-cart-btn my-cart-b" /></div>
						</div>
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








<div class="navbar navbar-fixed-bottom">
 <div class="icon-bar">
  <a  href="#" class="active"><i class="fa fa-home"></i></a> 
  <!-- <a href="#"><i class="fa fa-search"></i></a>  -->
  <a href="profile.php" ><i class="fa fa-user"></i></a> 
  <a href="menu.php" ><i class="fa fa-book"></i></a>
  <!-- <span class="my-cart-icon" > -->
  	<!-- </span>  --><!-- 
  <a href="#"><i class="fa fa-credit-card"></i></a> 
 -->  <a href="shopping_cart.php" data-toggle="tooltip" data-placement=	"top" title="<?php echo $session_items ?>" ><i class="fa fa-shopping-cart my-cart-icon"></i></a>
 </div>
</div>
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
});
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