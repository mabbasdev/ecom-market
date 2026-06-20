<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

include('includes/dbconnect.php');
include('includes/common_functions.php');
include('includes/header.php');
include('includes/navbar.php'); ?>
<script>
  document.title = 'Checkout - Ecom Marketplace';
</script>

<main class="main">
  <div class="section-box">
    <div class="breadcrumbs-div">
      <div class="container">
        <ul class="breadcrumb">
          <li><a class="font-xs color-gray-1000" href="index.php">Home</a></li>
          <li><a class="font-xs color-gray-500" href="shop.php">Shop</a></li>
          <li><a class="font-xs color-gray-500" href="cart.php">Checkout</a></li>
        </ul>
      </div>
    </div>
  </div>
  <section class="section-box shop-template">
    <?php
    if (!isset($_SESSION['username'])) {
      include("includes/loginForm.php");
    } else {
      include('payment.php');
    } ?>
  </section>
  <section class="section-box mt-90 mb-50">
    <div class="container">
      <ul class="list-col-5">
        <li>
          <div class="item-list">
            <div class="icon-left"><img src="images/delivery.svg" alt="Ecom"></div>
            <div class="info-right">
              <h5 class="font-lg-bold color-gray-100">Free Delivery</h5>
              <p class="font-sm color-gray-500">For orders over $70</p>
            </div>
          </div>
        </li>
        <li>
          <div class="item-list">
            <div class="icon-left"><img src="images/support.svg" alt="Ecom"></div>
            <div class="info-right">
              <h5 class="font-lg-bold color-gray-100">Support 24/7</h5>
              <p class="font-sm color-gray-500">Shop with an expert</p>
            </div>
          </div>
        </li>
        <li>
          <div class="item-list">
            <div class="icon-left"><img src="images/voucher.svg" alt="Ecom"></div>
            <div class="info-right">
              <h5 class="font-lg-bold color-gray-100">Gift voucher</h5>
              <p class="font-sm color-gray-500">Refer a friend</p>
            </div>
          </div>
        </li>
        <li>
          <div class="item-list">
            <div class="icon-left"><img src="images/return.svg" alt="Ecom"></div>
            <div class="info-right">
              <h5 class="font-lg-bold color-gray-100">Return & Refund</h5>
              <p class="font-sm color-gray-500">Return over $200</p>
            </div>
          </div>
        </li>
        <li>
          <div class="item-list">
            <div class="icon-left"><img src="images/secure.svg" alt="Ecom"></div>
            <div class="info-right">
              <h5 class="font-lg-bold color-gray-100">Secure payment</h5>
              <p class="font-sm color-gray-500">100% Protected</p>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </section>
  <section class="section-box box-newsletter">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 col-md-7 col-sm-12">
          <h3 class="color-white">Subscrible & Get <span class="color-warning">10%</span> Discount</h3>
          <p class="font-lg color-white">Get E-mail updates about our latest shop and <span
              class="font-lg-bold">special offers.</span></p>
        </div>
        <div class="col-lg-4 col-md-5 col-sm-12">
          <div class="box-form-newsletter mt-15">
            <form class="form-newsletter">
              <input class="input-newsletter font-xs" value="" placeholder="Your email Address">
              <button class="btn btn-brand-2">Sign Up</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
  <div class="modal fade" id="ModalQuickview" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-xl">
      <div class="modal-content apply-job-form">
        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="modal-body p-30">
          <div class="row">
            <div class="col-lg-6">
              <div class="gallery-image">
                <div class="galleries-2">
                  <div class="detail-gallery">
                    <div class="product-image-slider-2">
                      <figure class="border-radius-10"><img src="images/img-gallery-1.jpg" alt="product image">
                      </figure>
                      <figure class="border-radius-10"><img src="images/img-gallery-2.jpg" alt="product image">
                      </figure>
                      <figure class="border-radius-10"><img src="images/img-gallery-3.jpg" alt="product image">
                      </figure>
                      <figure class="border-radius-10"><img src="images/img-gallery-4.jpg" alt="product image">
                      </figure>
                      <figure class="border-radius-10"><img src="images/img-gallery-5.jpg" alt="product image">
                      </figure>
                      <figure class="border-radius-10"><img src="images/img-gallery-6.jpg" alt="product image">
                      </figure>
                      <figure class="border-radius-10"><img src="images/img-gallery-7.jpg" alt="product image">
                      </figure>
                    </div>
                  </div>
                  <div class="slider-nav-thumbnails-2">
                    <div>
                      <div class="item-thumb"><img src="images/img-gallery-1.jpg" alt="product image"></div>
                    </div>
                    <div>
                      <div class="item-thumb"><img src="images/img-gallery-2.jpg" alt="product image"></div>
                    </div>
                    <div>
                      <div class="item-thumb"><img src="images/img-gallery-3.jpg" alt="product image"></div>
                    </div>
                    <div>
                      <div class="item-thumb"><img src="images/img-gallery-4.jpg" alt="product image"></div>
                    </div>
                    <div>
                      <div class="item-thumb"><img src="images/img-gallery-5.jpg" alt="product image"></div>
                    </div>
                    <div>
                      <div class="item-thumb"><img src="images/img-gallery-6.jpg" alt="product image"></div>
                    </div>
                    <div>
                      <div class="item-thumb"><img src="images/img-gallery-7.jpg" alt="product image"></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="box-tags">
                <div class="d-inline-block mr-25"><span class="font-sm font-medium color-gray-900">Category:</span><a
                    class="link" href="#">Smartphones</a></div>
                <div class="d-inline-block"><span class="font-sm font-medium color-gray-900">Tags:</span><a
                    class="link" href="#">Blue</a>,<a class="link" href="#">Smartphone</a></div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="product-info">
                <h5 class="mb-15">SAMSUNG Galaxy S22 Ultra, 8K Camera & Video, Brightest Display Screen, S Pen Pro
                </h5>
                <div class="info-by"><span class="bytext color-gray-500 font-xs font-medium">by</span><a
                    class="byAUthor color-gray-900 font-xs font-medium" href="shop-vendor-list.html"> Ecom Tech</a>
                  <div class="rating d-inline-block"><img src="images/star.svg" alt="Ecom"><img src="images/star.svg"
                      alt="Ecom"><img src="images/star.svg" alt="Ecom"><img src="images/star.svg" alt="Ecom"><img
                      src="images/star.svg" alt="Ecom"><span class="font-xs color-gray-500 font-medium"> (65
                      reviews)</span></div>
                </div>
                <div class="border-bottom pt-10 mb-20"></div>
                <div class="box-product-price">
                  <h3 class="color-brand-3 price-main d-inline-block mr-10">$2856.3</h3><span
                    class="color-gray-500 price-line font-xl line-througt">$3225.6</span>
                </div>
                <div class="product-description mt-10 color-gray-900">
                  <ul class="list-dot">
                    <li>8k super steady video</li>
                    <li>Nightography plus portait mode</li>
                    <li>50mp photo resolution plus bright display</li>
                    <li>Adaptive color contrast</li>
                    <li>premium design & craftmanship</li>
                    <li>Long lasting battery plus fast charging</li>
                  </ul>
                </div>
                <div class="box-product-color mt-10">
                  <p class="font-sm color-gray-900">Color:<span class="color-brand-2 nameColor">Pink Gold</span></p>
                  <ul class="list-colors">
                    <li class="disabled"><img src="images/img-gallery-1.jpg" alt="Ecom" title="Pink"></li>
                    <li><img src="images/img-gallery-2.jpg" alt="Ecom" title="Gold"></li>
                    <li><img src="images/img-gallery-3.jpg" alt="Ecom" title="Pink Gold"></li>
                    <li><img src="images/img-gallery-4.jpg" alt="Ecom" title="Silver"></li>
                    <li class="active"><img src="images/img-gallery-5.jpg" alt="Ecom" title="Pink Gold"></li>
                    <li class="disabled"><img src="images/img-gallery-6.jpg" alt="Ecom" title="Black"></li>
                    <li class="disabled"><img src="images/img-gallery-7.jpg" alt="Ecom" title="Red"></li>
                  </ul>
                </div>
                <div class="box-product-style-size mt-10">
                  <div class="row">
                    <div class="col-lg-12 mb-10">
                      <p class="font-sm color-gray-900">Style:<span class="color-brand-2 nameStyle">S22</span></p>
                      <ul class="list-styles">
                        <li class="disabled" title="S22 Ultra">S22 Ultra</li>
                        <li class="active" title="S22">S22</li>
                        <li title="S22 + Standing Cover">S22 + Standing Cover</li>
                      </ul>
                    </div>
                    <div class="col-lg-12 mb-10">
                      <p class="font-sm color-gray-900">Size:<span class="color-brand-2 nameSize">512GB</span></p>
                      <ul class="list-sizes">
                        <li class="disabled" title="1GB">1GB</li>
                        <li class="active" title="512 GB">512 GB</li>
                        <li title="256 GB">256 GB</li>
                        <li title="128 GB">128 GB</li>
                        <li class="disabled" title="64GB">64GB</li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="buy-product mt-5">
                  <p class="font-sm mb-10">Quantity</p>
                  <div class="box-quantity">
                    <div class="input-quantity">
                      <input class="font-xl color-brand-3" type="text" value="1"><span class="minus-cart"></span><span
                        class="plus-cart"></span>
                    </div>
                    <div class="button-buy"><a class="btn btn-cart" href="cart.php">Add to cart</a><a
                        class="btn btn-buy" href="checkout.php">Buy now</a></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

<?php include('includes/footer-nav.php'); ?>
<?php include('includes/bottom.php'); ?>

</body>

</html>