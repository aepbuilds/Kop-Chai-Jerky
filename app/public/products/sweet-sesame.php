<?php include '../dbconnection.php' ?>

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
    <title>Kop Chai Jerky - Sweet Sesame</title>
    <link rel="icon" type="image/x-icon" href="../images/favicon.png" />
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
    <link href="../css/style.css" rel="stylesheet" />
    <!-- responsive style -->
    <link href="../css/responsive.css" rel="stylesheet" />
  </head>
  <body>
    <div class="top-header-special">
      <h6>FREE SHIPPING ON ORDERS $40 OR MORE!</h6>
    </div>
    <!-- header section starts -->
    <header class="header_section container">
      <nav class="navbar navbar-expand-lg">
        <a class="kpj-navbar-brand" href="../index.php">
          <img src="../images/logo.png" alt="KopChai Jerky" />
        </a>

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
    <div class="hero_area single-product">
      <section class="slider_section">
        <div id="customCarousel1" class="carousel slide" data-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <div class="container">
                <div class="row">

                <div class="col-md-6">
                    <div class="detail-box-image">
                      <img
                        src="../images/spicy_bomb_cut_2.png"
                        alt="Spicy Bomb"
                      />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="detail-box">
                      <div class="detail-box-body">
                        <h1>Sweet Sesame</h1>
                        <div class="detail-box-text">
                          <p>
                            This is our take on Teriyaki! Nice and sweet, Sweet Sesame is a perfect jerky to have on the go. 
                          </p>
                        </div>

                        <div class="single-product-buttons">
                          <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?action=addcart">
                            <select name="qty">
                              <option value="1">1</option>
                              <option value="2">2</option>
                              <option value="3">3</option>
                              <option value="3">4</option>
                              <option value="3">5</option>
                            </select>
                            <button type="submit" class="btn btn-warning">Add To Cart</button>
                            <input type="hidden" name="sku" value="sweetsesame">
                          </form>
                          
                          <form action = "https://www.sandbox.paypal.com/us/cgi-bin/webscr" method = "post" target = "paypal">
                            <input type = "hidden" name = "cmd" value = "_ext-enter" />
                            <input type = "hidden" name = "redirect_cmd" value = "_xclick" /> 
                            <input type = "hidden" name = "return" value = "https://kopchaijerky.com/" /> 
                            <input type = "hidden" name = "business" value = "aphomthavong@business.example.com" /> 
                            <input type = "hidden" name = "item_name" value = "Sweet Sesame" />
                            <input type = "hidden" name = "amount" value = "10.00" />
                            <input type = "hidden" name = "item_number" value = "2" />
                            <button type="submit" class="btn btn-warning">Buy Now</button>
                          </form>
                        </div>
                        
                      </div>
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
    <script type="text/javascript" src="../js/custom.js"></script>
  </body>
</html>
