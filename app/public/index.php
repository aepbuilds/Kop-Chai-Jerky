<?php 
error_reporting(E_ALL);

session_start();
$sessid = session_id();
$total=0;

//Database connection, replace with your connection string.. Used PDO
$dbh = new PDO("mysql:host=localhost;dbname=kopchaijerky", "root", "root");
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//get action string
$action = isset($_GET['action'])?$_GET['action']:"";

//get cart items
$getcart = $dbh->prepare("select products.name, products.product_id, products.price, cartitems.qty
from products, cartitems
where cartitems.productid = products.product_id and cartitems.sessionid = '$sessid'");

$getcart->execute();
$getcartrow = $getcart->fetch();
$qty = $getcartrow['qty'];

//Add to cart
if($action=='addcart' && $_SERVER['REQUEST_METHOD']=='POST') {
	
  $qty = $_POST['qty'];

	//Finding the product by code
	$query = "SELECT * FROM products WHERE sku=:sku";
	$stmt = $dbh->prepare($query);
	$stmt->bindParam('sku', $_POST['sku']);
	$stmt->execute();
	$product = $stmt->fetch();

  $productid = $product['product_id'];


  //check the cartitem table to see if sku is in there
  $chkquery = "SELECT * FROM cartitems WHERE productid = '$productid' and sessionid = '$sessid'";
  $chkstmt = $dbh->prepare($chkquery);
  $chkstmt->execute();
  $productincart = $chkstmt->fetch();
  $id = $productincart['id'];
  if (!empty($id)){
    $upstmt = $dbh->prepare("update cartitems set qty = '$qty' where productid = '$productid' and sessionid = '$sessid'");
    $upstmt->execute();
  }
  else {
    $instmt = $dbh->prepare("insert into cartitems (productid,sessionid,timeofentry,qty) values ('$productid','$sessid',now(),'$qty')");
    $instmt->execute();

  }
  //if it is, we'll write an update statement


  //else write an insert statement

	
	$currentQty = $_POST['qty']; //Incrementing the product qty in cart
	$_SESSION['products'][$_POST['sku']] =array('qty'=>$currentQty,'name'=>$product['name'],'image'=>$product['image'],'price'=>$product['price']);
	$product='';
	header("Location:index.php");
}
 
 //Get all Products
$query = "SELECT * FROM products";
$stmt = $dbh->prepare($query);
$stmt->execute();
$products = $stmt->fetchAll();


?>

<!DOCTYPE html>
<html>
  <head>
    <!-- Basic -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Mobile Metas -->
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <title>Kop Chai Jerky</title>
    <link rel="icon" type="image/x-icon" href="images/favicon.png" />
    <!-- bootstrap core css -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
      integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
      crossorigin="anonymous"
    />
    <!-- font awesome style -->
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
      rel="stylesheet"
    />
    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet" />
    <!-- responsive style -->
    <link href="css/responsive.css" rel="stylesheet" />
  </head>
  <body>
    <div class="top-header-special">
      <h6>FREE SHIPPING ON ORDERS $40 OR MORE!</h6>
    </div>
    <!-- header section starts -->
    <header class="header_section container">
      <nav class="navbar navbar-expand-lg">
        <a class="kpj-navbar-brand" href="index.php">
          <img src="images/logo.png" alt="KopChai Jerky" />
        </a>
        <div class="mr-auto flex-column flex-lg-row me-auto">
          <ul class="navbar-nav User_option">
            <li class="">
              <a class="" href="#about"> About </a>
            </li>
            <li class="">
              <a class="" href="#contact"> Contact </a>
            </li>
          </ul>
        </div>
        <div class="header-search col-md-4">
          <!-- <div class="search">
            <form action="">
              <input type="text" placeholder="Search" />
              <button type="submit">Search</button>
            </form>
          </div> -->
          <div class="shopping-cart">
            <a href="checkout.php">
              <i class="fa fa-shopping-cart"></i>
            </a>
            <p><span><?php echo $qty; ?></span> Items in Cart</p>
          </div>
        </div>
      </nav>
    </header>
    <!-- end header section -->
    <div class="hero_area">
      <div class="hero_bg_box">
        <!-- <img src="images/black_bomb_small_business.png" alt="" /> -->
      </div>
      <!-- slider section -->
      <section class="slider_section">
        <div id="customCarousel1" class="carousel slide" data-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <div class="container">
                <div class="row">
                  <div class="col-md-6">
                    <div class="detail-box">
                      <div class="detail-box-body">
                        <h3>Flavor Of The Week</h3>
                        <h1>
                          Spicy <br />
                          Bomb
                        </h1>
                        <div class="detail-box-text">
                          <p>
                            Our spiciest Beef Jerky offering for the adventurous
                            type. Made with our secret homemade spice blend.
                            Spicy Bomb is sure not to disappoint!
                          </p>
                        </div>
                        
                        <form action = "https://www.sandbox.paypal.com/us/cgi-bin/webscr" method = "post" target = "paypal">
                          <input type = "hidden" name = "cmd" value = "_ext-enter" />
                          <input type = "hidden" name = "redirect_cmd" value = "_xclick" /> 
                          <input type = "hidden" name = "return" value = "https://kopchaijerky.com/" /> 
                          <input type = "hidden" name = "business" value = "aphomthavong@business.example.com" /> 
                          <input type = "hidden" name = "item_name" value = "Spicy Bomb" />
                          <input type = "hidden" name = "amount" value = "10.00" />
                          <input type = "hidden" name = "item_number" value = "2" />
                          <button type="submit" class="btn btn-warning">Buy Now</button>
                        </form>

                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="detail-box-image">
                      <img
                        src="images/spicy_bomb_cut_2.png"
                        alt="Spicy Bomb"
                      />
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- end slider section -->
    </div>
    <!-- For Sale -->
    <section class="veg_section layout_padding">
      <div class="container">
        <div class="heading_container heading_center">
          <h2>Currently On Sale</h2>
        </div>
        <div class="row">
          <?php foreach($products as $product): ?>
          <div class="col-md-6 col-lg-3">
            <div class="box">
              <div class="img-box">
                <img src="<?php print $product['image']?>" alt="<?php print $product['name']?>" />
              </div>
              <div class="detail-box">
                <h3><?php print $product['name']?></h3>



                <div class="box-rating">
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                </div>



                <div class="price_box">
                  <h6 class="price_heading">$<?php print $product['price']?></h6>
                </div>
                <div class="purchase-buttons">

            <form method="post" action="index.php?action=addcart">
                <select name="qty">
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="3">4</option>
                  <option value="3">5</option>
                </select>
                <button type="submit" class="btn btn-warning">Add To Cart</button>
                <input type="hidden" name="sku" value="<?php print $product['sku']?>">
            </form>

            <form action = "https://www.sandbox.paypal.com/us/cgi-bin/webscr" method = "post" target = "paypal">
              <input type = "hidden" name = "cmd" value = "_ext-enter" />
              <input type = "hidden" name = "redirect_cmd" value = "_xclick" /> 
              <input type = "hidden" name = "return" value = "https://kopchaijerky.com/" /> 
              <input type = "hidden" name = "business" value = "aphomthavong@business.example.com" /> 
              <input type = "hidden" name = "item_name" value = "<?php print $product['name'];?>" />
              <input type = "hidden" name = "amount" value = "<?php print $product['price'];?>" />
              <input type = "hidden" name = "item_number" value = "<?php print $product['product_id'];?>" />
              <button type="submit" class="btn btn-warning">Buy Now</button>
            </form>

                </div>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <!-- end veg section -->

    <!-- about section -->

    <section class="about_section" id="about">
      <!-- <div class="about_bg_box"></div> -->
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <div class="detail-box-image">
              <img src="images/sweet_sesame_w_logo_2.png" alt="Sweet Sesame" />
            </div>
          </div>
          <div class="col-md-6">
            <div class="detail-box">
              <div class="detail-box-body">
                <h3>About</h3>
                <h1>Kop Chai Jerky</h1>
                <div class="detail-box-text">
                  <p>
                    “Kop Chai” means “Thank You” in Laotian. And we are thankful
                    for every customer! We are a small business based out of San
                    Diego, CA. We use nothing but the best ingredients for all
                    of our offerings. We offer many different flavors to satisfy
                    what you’re feeling. Our Beef Jerky is made daily and
                    usually sells out within hours of packaging. Order yours
                    today!
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- end about section -->

    <!-- Unique section -->
    <section class="contact_section" id="contact">
      <div class="container">
        <div class="heading_container text-center">
          <h2>What Makes Us Unique</h2>
        </div>
        <div class="d-flex flex-row justify-content-between">
          <div class="unique-img">
            <img src="images/golf_2.png" alt="Golf" />
            <div class="unique-text text-center">
              <p>Fresh Ingredients</p>
            </div>
          </div>
          <div class="unique-img">
            <img src="images/lao_thum_thum_sauce.png" alt="Lao Thum-Thum Sauce" />
            <div class="unique-text text-center">
              <p>Homemade</p>
            </div>
          </div>
          <div class="unique-img">
            <img src="images/pad_thai.png" alt="Pad Thai" />
            <div class="unique-text text-center">
              <p>Made Daily</p>
            </div>
          </div>
          <div class="unique-img">
            <img src="images/papaya_salad.png" alt="Papaya Salad" />
            <div class="unique-text text-center">
              <p>Organic</p>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Unique section -->
    <!-- footer section -->
    <section class="container-fluid footer_section">
      <div class="container">
        <div class="row justify-content-between">
          <div class="col-md-4 footer-col">
            <div class="footer_form">
              <h4>Join Our Newsletter!</h4>
              <form action="">
                <input type="text" placeholder="Enter Your Email" />
                <button type="submit">Subscribe</button>
              </form>
            </div>
          </div>
          <div class="col-sm-6 col-md-4 col-lg-3 footer-col text-center">
            <div class="footer_detail">
              <a href="index.html">
                <h4>Kop Chai Jerky</h4>
              </a>
              <p>
                Kop Chai Jerky is a Woman-Owned Small Business based out of San
                Diego, CA. Your support means everything to us!
              </p>
              <div class="social_box">
                <a href="">
                  <i class="fa fa-facebook" aria-hidden="true"></i>
                </a>
                <a href="">
                  <i class="fa fa-instagram" aria-hidden="true"></i>
                </a>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-md-4 col-lg-3 footer-col">
            <h4>Contact us</h4>
            <div class="contact_nav">
              <a href="">
                <i class="fa fa-map-marker" aria-hidden="true"></i>
                <span> San Diego, CA </span>
              </a>
              <a href="">
                <i class="fa fa-phone" aria-hidden="true"></i>
                <span> Call: (619) 555-1234 </span>
              </a>
              <a href="">
                <i class="fa fa-envelope" aria-hidden="true"></i>
                <span> Email: sales@kopchaijerky.com </span>
              </a>
            </div>
          </div>
        </div>
        <div class="footer-info">
          <p>
            &copy; <span id="displayYear"></span> All Rights Reserved By Kop
            Chai Jerky
          </p>
        </div>
      </div>
    </section>
    <!-- end  footer section -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
      crossorigin="anonymous"
    ></script>
    <script type="text/javascript" src="js/custom.js"></script>
  </body>
</html>
