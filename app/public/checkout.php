<?php
//error_reporting(E_ALL);
//Setting session start
session_start();
$sessid = session_id();
var_dump($_SESSION);

$numcart = count($_SESSION['products']);

//Database connection, replace with your connection string.. Used PDO
$dbh = new PDO("mysql:host=localhost;dbname=kopchaijerky", "root", "root");
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//write a qry to get all the data we need. (name,itemnumber,price)

$getcart = $dbh->prepare("select products.name, products.product_id, products.price, cartitems.qty
from products, cartitems
where cartitems.productid = products.product_id and cartitems.sessionid = '$sessid'");

$getcart->execute();

$qty = 0;


?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">

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

    <style>
        .border-top { 
            border-top: 1px solid #e5e5e5; 
        }
        .border-bottom { 
            border-bottom: 1px solid #e5e5e5; 
        }
        .border-top-gray { 
            border-top-color: #adb5bd; 
        }

        .box-shadow { 
            box-shadow: 0 .25rem .75rem rgba(0, 0, 0, .05); 
        }

        .lh-condensed { 
            line-height: 1.25; 
        }
    </style>
  </head>

  <body class="bg-light">

    <div class="container checkout-form">
      <div class="py-5 text-center">
        <a href="index.php"><img class="d-block mx-auto mb-4" src="images/logo.png" alt="Kop Chai Jerky" width="150" height="150"></a>
        <h2>Checkout form</h2>
      </div>

      <div class="row">
        <div class="col-md-4 order-md-2 mb-4">

        <form action="https://www.sandbox.paypal.com/us/cgi-bin/webscr" method="post" class="needs-validation" target="paypal">

          <input type = "hidden" name = "cmd" value = "_ext-enter" />
          <input type = "hidden" name = "redirect_cmd" value = "_xclick" /> 
          <input type = "hidden" name = "cancel_return" value = "/checkout.php" /> 
          <input type = "hidden" name = "return" value = "/" /> 
          <input type="hidden" name="business" value="aphomthavong@business.example.com">

          <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-muted">Your cart</span>
            <span><?php echo $qty; ?></span>
          </h4>


<!-- PAYMENT SECTION BEGIN -->

          <ul class="list-group mb-3">

          <?php

          $total = 0;
          $i = 0;

          while($getcartrow = $getcart->fetch()) {
            $itemname = $getcartrow['name'];
            $itemnumber = $getcartrow['product_id'];
            $price = $getcartrow['price'];
            $qty = $getcartrow['qty'];
            if ($qty == 0) $qty = 1;
            $total += $price * $qty;

            if ($numcart > 1) {
              $out = '_'.$i;
            }
            else {
              $out = '';
            }
          
          ?>

            <li class="list-group-item d-flex justify-content-between lh-condensed">
              <div>
                <h6 class="my-0"><?php echo $itemname; ?></h6>
              </div>
              <span class="text-muted"><?php echo $qty. ' @ $' .$price; ?></span>
            </li>
          <?php 

          echo '<input type = "hidden" name = "item_name'.$out.'" value = "'.$itemname.'" />
          <input type = "hidden" name = "quantity'.$out.'" value = "'.$qty.'" /> 
          <input type = "hidden" name = "amount'.$out.'" value = "'.$price.'" /> ';

          $i++;
          } 
          ?>

          


            <li class="list-group-item d-flex justify-content-between">
              <span>Total (USD)</span>
              <strong>$<?php echo $total; ?></strong>
            </li>
          </ul>


<!-- PAYMENT SECTION END -->


        </div>
        <div class="col-md-8 order-md-1">
          <h4 class="mb-3">Billing address</h4>
          
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="firstName">First name</label>
                <input type="text" name="first_name" class="form-control" id="firstName" placeholder="" value="" required>
                <div class="invalid-feedback">
                  Valid first name is required.
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="lastName">Last name</label>
                <input type="text" name="last_name" class="form-control" id="lastName" placeholder="" value="" required>
                <div class="invalid-feedback">
                  Valid last name is required.
                </div>
              </div>
            </div>

            <div class="mb-3">
              <label for="email">Email <span class="text-muted">(Optional)</span></label>
              <input type="email" name="email" class="form-control" id="email" placeholder="you@example.com">
              <div class="invalid-feedback">
                Please enter a valid email address for shipping updates.
              </div>
            </div>

            <div class="mb-3">
              <label for="address">Address</label>
              <input type="text" name="address1" class="form-control" id="address" placeholder="1234 Main St" required>
              <div class="invalid-feedback">
                Please enter your shipping address.
              </div>
            </div>

            <div class="mb-3">
              <label for="address2">Address 2 <span class="text-muted">(Optional)</span></label>
              <input type="text" name="address2" class="form-control" id="address2" placeholder="Apartment or suite">
            </div>

            <div class="row">
              <div class="col-md-5 mb-3" id ="City">
                <label for="city">City</label>
                <input type="text" class="form-control" name="city"  placeholder="City">
                <div class="invalid-feedback">
                  Please select a valid city.
                </div>
              </div>
              <div class="col-md-4 mb-3" id ="State">
              <label for="state">State</label>
                <input type="text" class="form-control" name="state"  placeholder="State">
                <div class="invalid-feedback">
                  Please provide a valid state.
                </div>
              </div>
              <div class="col-md-3 mb-3">
                <label for="zip">Zip</label>
                <input type="text" class="form-control" name="zip" id="zip" placeholder="" >
                <div class="invalid-feedback">
                  Zip code required.
                </div>
              </div>
            </div>

            <hr class="mb-4">
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" id="same-address">
              <label class="custom-control-label" for="same-address">Shipping address is the same as my billing address</label>
            </div>

<!-- 
            <h4 class="mb-3">Payment</h4>

            <div class="d-block my-3">
              <div class="custom-control custom-radio">
                <input id="credit" name="paymentMethod" type="radio" class="custom-control-input" checked required>
                <label class="custom-control-label" for="credit">Credit card</label>
              </div>
              <div class="custom-control custom-radio">
                <input id="debit" name="paymentMethod" type="radio" class="custom-control-input" required>
                <label class="custom-control-label" for="debit">Debit card</label>
              </div>
              <div class="custom-control custom-radio">
                <input id="paypal" name="paymentMethod" type="radio" class="custom-control-input" required>
                <label class="custom-control-label" for="paypal">Paypal</label>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="cc-name">Name on card</label>
                <input type="text" class="form-control" id="cc-name" placeholder="" required>
                <small class="text-muted">Full name as displayed on card</small>
                <div class="invalid-feedback">
                  Name on card is required
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="cc-number">Credit card number</label>
                <input type="text" class="form-control" id="cc-number" placeholder="" required>
                <div class="invalid-feedback">
                  Credit card number is required
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3 mb-3">
                <label for="cc-expiration">Expiration</label>
                <input type="text" class="form-control" id="cc-expiration" placeholder="" required>
                <div class="invalid-feedback">
                  Expiration date required
                </div>
              </div>
              <div class="col-md-3 mb-3">
                <label for="cc-expiration">CVV</label>
                <input type="text" class="form-control" id="cc-cvv" placeholder="" required>
                <div class="invalid-feedback">
                  Security code required
                </div>
              </div>
            </div> -->
            <hr class="mb-4">
            <button class="btn btn-primary btn-lg btn-block" type="submit">Continue to checkout</button>
          </form>
        </div>
      </div>

          
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

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>

    <script>
      // Example starter JavaScript for disabling form submissions if there are invalid fields
      (function() {
        'use strict';

        window.addEventListener('load', function() {
          // Fetch all the forms we want to apply custom Bootstrap validation styles to
          var forms = document.getElementsByClassName('needs-validation');

          // Loop over them and prevent submission
          var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
              if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
              }
              form.classList.add('was-validated');
            }, false);
          });
        }, false);
      })();
    </script>
  </body>
</html>
