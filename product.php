<?php include('includes/dbconnect.php'); ?>
<?php include('includes/common_functions.php'); ?>
<?php include('includes/header.php'); ?>
<?php include('includes/navbar.php'); ?>
<script>
  document.title = 'Welcome to Ecom Marketplace';
</script>

<main class="main">
  <div class="section-box">
    <div class="breadcrumbs-div">
      <div class="container">
        <ul class="breadcrumb">
          <li><a class="font-xs color-gray-1000" href="index.php">Home</a></li>
          <li><a class="font-xs color-gray-500" href="shop.php">Electronics</a></li>
          <li><a class="font-xs color-gray-500" href="shop.php">Cell phone</a></li>
          <li><a class="font-xs color-gray-500" href="shop.php">Accessories</a></li>
        </ul>
      </div>
    </div>
  </div>
  <?php get_product_details("main-product") ?>
  <section class="section-box shop-template">
    <div class="container">
      <div class="pt-30 mb-10">
        <ul class="nav nav-tabs nav-tabs-product" role="tablist">
          <li><a class="active" href="#tab-description" data-bs-toggle="tab" role="tab"
              aria-controls="tab-description" aria-selected="true">Description</a></li>
          <li><a href="#tab-specification" data-bs-toggle="tab" role="tab" aria-controls="tab-specification"
              aria-selected="true">Specification</a></li>
          <li><a href="#tab-additional" data-bs-toggle="tab" role="tab" aria-controls="tab-additional"
              aria-selected="true">Additional information</a></li>
          <li><a href="#tab-reviews" data-bs-toggle="tab" role="tab" aria-controls="tab-reviews"
              aria-selected="true">Reviews (2)</a></li>
          <li><a href="#tab-vendor" data-bs-toggle="tab" role="tab" aria-controls="tab-vendor"
              aria-selected="true">Vendor</a></li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane fade active show" id="tab-description" role="tabpanel"
            aria-labelledby="tab-description">
            <div class="display-text-short">
              <p><?php get_product_details("product-details-desc") ?></p>
            </div>
            <div class="mt-20 text-center"><a class="btn btn-border font-sm-bold pl-80 pr-80 btn-expand-more">More
                Details</a></div>
          </div>
          <div class="tab-pane fade" id="tab-specification" role="tabpanel" aria-labelledby="tab-specification">
            <h5 class="mb-25">Specification</h5>
            <div class="table-responsive">
              <table class="table table-striped">
                <tbody>
                  <tr>
                    <td>Mode</td>
                    <td>#SK10923</td>
                  </tr>
                  <tr>
                    <td>Brand</td>
                    <td>SamSung</td>
                  </tr>
                  <tr>
                    <td>Size</td>
                    <td>6.7"</td>
                  </tr>
                  <tr>
                    <td>Finish</td>
                    <td>Pacific Blue</td>
                  </tr>
                  <tr>
                    <td>Origin of Country</td>
                    <td>United States</td>
                  </tr>
                  <tr>
                    <td>Manufacturer</td>
                    <td>USA</td>
                  </tr>
                  <tr>
                    <td>Released Year</td>
                    <td>2022</td>
                  </tr>
                  <tr>
                    <td>Warranty</td>
                    <td>International</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="tab-pane fade" id="tab-additional" role="tabpanel" aria-labelledby="tab-additional">
            <h5 class="mb-25">Additional information</h5>
            <div class="table-responsive">
              <table class="table table-striped">
                <tbody>
                  <tr>
                    <td>Weight</td>
                    <td>
                      <p>0.240 kg</p>
                    </td>
                  </tr>
                  <tr>
                    <td>Dimensions</td>
                    <td>
                      <p>0.74 x 7.64 x 16.08 cm</p>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="tab-pane fade" id="tab-reviews" role="tabpanel" aria-labelledby="tab-reviews">
            <div class="comments-area">
              <div class="row">
                <div class="col-lg-8">
                  <h4 class="mb-30 title-question">Customer questions & answers</h4>
                  <div class="comment-list">
                    <div class="single-comment justify-content-between d-flex mb-30 hover-up">
                      <div class="user justify-content-between d-flex">
                        <div class="thumb text-center"><img src="images/author-2.png" alt="Ecom"><a
                            class="font-heading text-brand" href="#">Sienna</a></div>
                        <div class="desc">
                          <div class="d-flex justify-content-between mb-10">
                            <div class="d-flex align-items-center"><span class="font-xs color-gray-700">December 4,
                                2022 at 3:12 pm</span></div>
                            <div class="product-rate d-inline-block">
                              <div class="product-rating" style="width: 100%"></div>
                            </div>
                          </div>
                          <p class="mb-10 font-sm color-gray-900">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Delectus, suscipit
                            exercitationem accusantium obcaecati quos voluptate nesciunt facilis itaque modi commodi
                            dignissimos sequi
                            repudiandae minus ab deleniti totam officia id incidunt?<a class="reply" href="#">
                              Reply</a>
                          </p>
                        </div>
                      </div>
                    </div>
                    <div class="single-comment justify-content-between d-flex mb-30 ml-30 hover-up">
                      <div class="user justify-content-between d-flex">
                        <div class="thumb text-center"><img src="images/author-3.png" alt="Ecom"><a
                            class="font-heading text-brand" href="#">Brenna</a></div>
                        <div class="desc">
                          <div class="d-flex justify-content-between mb-10">
                            <div class="d-flex align-items-center"><span class="font-xs color-gray-700">December 4,
                                2022 at 3:12 pm</span></div>
                            <div class="product-rate d-inline-block">
                              <div class="product-rating" style="width: 80%"></div>
                            </div>
                          </div>
                          <p class="mb-10 font-sm color-gray-900">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Delectus, suscipit
                            exercitationem accusantium obcaecati quos voluptate nesciunt facilis itaque modi commodi
                            dignissimos sequi
                            repudiandae minus ab deleniti totam officia id incidunt?<a class="reply" href="#">
                              Reply</a>
                          </p>
                        </div>
                      </div>
                    </div>
                    <div class="single-comment justify-content-between d-flex hover-up">
                      <div class="user justify-content-between d-flex">
                        <div class="thumb text-center"><img src="images/author-4.png" alt="Ecom"><a
                            class="font-heading text-brand" href="#">Gemma</a></div>
                        <div class="desc">
                          <div class="d-flex justify-content-between mb-10">
                            <div class="d-flex align-items-center"><span class="font-xs color-gray-700">December 4,
                                2022 at 3:12 pm</span></div>
                            <div class="product-rate d-inline-block">
                              <div class="product-rating" style="width: 80%"></div>
                            </div>
                          </div>
                          <p class="mb-10 font-sm color-gray-900">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Delectus, suscipit
                            exercitationem accusantium obcaecati quos voluptate nesciunt facilis itaque modi commodi
                            dignissimos sequi
                            repudiandae minus ab deleniti totam officia id incidunt?<a class="reply" href="#">
                              Reply</a>
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-4">
                  <h4 class="mb-30 title-question">Customer reviews</h4>
                  <div class="d-flex mb-30">
                    <div class="product-rate d-inline-block mr-15">
                      <div class="product-rating" style="width: 90%"></div>
                    </div>
                    <h6>4.8 out of 5</h6>
                  </div>
                  <div class="progress"><span>5 star</span>
                    <div class="progress-bar" role="progressbar" style="width: 50%" aria-valuenow="50"
                      aria-valuemin="0" aria-valuemax="100">50%</div>
                  </div>
                  <div class="progress"><span>4 star</span>
                    <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25"
                      aria-valuemin="0" aria-valuemax="100">25%</div>
                  </div>
                  <div class="progress"><span>3 star</span>
                    <div class="progress-bar" role="progressbar" style="width: 45%" aria-valuenow="45"
                      aria-valuemin="0" aria-valuemax="100">45%</div>
                  </div>
                  <div class="progress"><span>2 star</span>
                    <div class="progress-bar" role="progressbar" style="width: 65%" aria-valuenow="65"
                      aria-valuemin="0" aria-valuemax="100">65%</div>
                  </div>
                  <div class="progress mb-30"><span>1 star</span>
                    <div class="progress-bar" role="progressbar" style="width: 85%" aria-valuenow="85"
                      aria-valuemin="0" aria-valuemax="100">85%</div>
                  </div><a class="font-xs text-muted" href="#">How are ratings calculated?</a>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="tab-vendor" role="tabpanel" aria-labelledby="tab-vendor">
            <div class="vendor-logo d-flex mb-30"><img src="images/futur.png" alt="">
              <div class="vendor-name ml-15">
                <h6><a href="shop-vendor-single.html">Futur Tech.</a></h6>
                <div class="product-rate-cover text-end">
                  <div class="product-rate d-inline-block">
                    <div class="product-rating" style="width: 90%"></div>
                  </div><span class="font-small ml-5 text-muted"> (32 reviews)</span>
                </div>
              </div>
            </div>
            <ul class="contact-infor mb-50">
              <li><img src="images/icon-location.svg" alt=""><strong>Address:</strong><span> 5171 W Campbell Ave
                  undefined Kent, Utah 53127 United States</span></li>
              <li><img src="images/icon-contact.svg" alt=""><strong>Contact Seller:</strong><span> (+91) -
                  540-025-553</span></li>
            </ul>
            <div class="d-flex mb-25">
              <div class="mr-30">
                <p class="color-brand-1 font-xs">Rating</p>
                <h4 class="mb-0">92%</h4>
              </div>
              <div class="mr-30">
                <p class="color-brand-1 font-xs">Ship on time</p>
                <h4 class="mb-0">100%</h4>
              </div>
              <div>
                <p class="color-brand-1 font-xs">Chat response</p>
                <h4 class="mb-0">89%</h4>
              </div>
            </div>
            <p class="font-sm color-gray-500 mb-15">
              Noodles & Company is an American fast-casual restaurant that offers international and American noodle
              dishes and pasta in addition to soups and salads. Noodles & Company was founded in 1995 by Aaron Kennedy
              and is headquartered in Broomfield,
              Colorado. The company went public in 2013 and recorded a $457 million revenue in 2017.In late 2018,
              there were 460 Noodles & Company locations across 29 states and Washington, D.C.
            </p>
            <p class="font-sm color-gray-500">Proin congue dapibus rhoncus. Curabitur ipsum orci, malesuada in
              porttitor a, porttitor quis diam. Nunc at arcu ut turpis facilisis volutpat. Proin tristique, mauris non
              gravida dignissim, purus mauris malesuada tellus, in tincidunt orci enim eget ligula. Quisque bibendum,
              ipsum id malesuada placerat, purus felis vehicula risus, vel fringilla justo erat ullamcorper ligula.
              Fusce congue ullamcorper ligula, at commodo turpis molestie vel.</p>
          </div>
          <div class="border-bottom pt-30 mb-50"></div>
          <h4 class="color-brand-3">Related Products</h4>
          <div class="list-products-5 mt-20">
            <?php get_products(5, "product-page") ?>
          </div>
          <div class="border-bottom pt-20 mb-40"></div>
          <h4 class="color-brand-3">You may also like</h4>
          <div class="list-products-5 mt-20">
            <?php get_products(5, "product-page") ?>
          </div>
          <div class="border-bottom pt-20 mb-40"></div>
          <h4 class="color-brand-3">Recently viewed items</h4>
          <div class="row mt-40">
            <?php get_products(4, "product-page-recent") ?>
          </div>
          <div class="border-bottom pt-20 mb-40"></div>
          <h4 class="color-brand-3">Similar products to compare</h4>
          <div class="list-products-5 mt-20">
            <?php get_products(5, "product-page") ?>
          </div>
        </div>
      </div>
    </div>
  </section>
  <div class="container mt-20">
    <div class="text-center"><a href="#"><img src="images/banner-ads.png" alt="Ecom"></a></div>
  </div>
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
  <div class="modal fade" id="ModalFiltersForm" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-xl">
      <div class="modal-content apply-job-form">
        <div class="modal-header">
          <h5 class="modal-title color-gray-1000 filters-icon">Addvance Fillters</h5>
          <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-30">
          <div class="row">
            <div class="col-w-1">
              <h6 class="color-gray-900 mb-0">Brands</h6>
              <ul class="list-checkbox">
                <li>
                  <label class="cb-container">
                    <input type="checkbox" checked="checked"><span class="text-small">Apple</span><span
                      class="checkmark"></span>
                  </label>
                </li>
                <li>
                  <label class="cb-container">
                    <input type="checkbox"><span class="text-small">Samsung</span><span class="checkmark"></span>
                  </label>
                </li>
                <li>
                  <label class="cb-container">
                    <input type="checkbox"><span class="text-small">Baseus</span><span class="checkmark"></span>
                  </label>
                </li>
                <li>
                  <label class="cb-container">
                    <input type="checkbox"><span class="text-small">Remax</span><span class="checkmark"></span>
                  </label>
                </li>
                <li>
                  <label class="cb-container">
                    <input type="checkbox"><span class="text-small">Handtown</span><span class="checkmark"></span>
                  </label>
                </li>
                <li>
                  <label class="cb-container">
                    <input type="checkbox"><span class="text-small">Elecom</span><span class="checkmark"></span>
                  </label>
                </li>
                <li>
                  <label class="cb-container">
                    <input type="checkbox"><span class="text-small">Razer</span><span class="checkmark"></span>
                  </label>
                </li>
                <li>
                  <label class="cb-container">
                    <input type="checkbox"><span class="text-small">Auto Focus</span><span class="checkmark"></span>
                  </label>
                </li>
                <li>
                  <label class="cb-container">
                    <input type="checkbox"><span class="text-small">Nillkin</span><span class="checkmark"></span>
                  </label>
                </li>
                <li>
                  <label class="cb-container">
                    <input type="checkbox"><span class="text-small">Logitech</span><span class="checkmark"></span>
                  </label>
                </li>
                <li>
                  <label class="cb-container">
                    <input type="checkbox"><span class="text-small">ChromeBook</span><span class="checkmark"></span>
                  </label>
                </li>
              </ul>
            </div>
            <div class="col-w-1">
              <h6 class="color-gray-900 mb-0">Special offers</h6>
              <ul class="list-checkbox">
                <li>
                  <label class="cb-container">
                    <input type="checkbox"><span class="text-small">On sale</span><span class="checkmark"></span>
                  </label>
                </li>
                <li>
                  <label class="cb-container">
                    <input type="checkbox" checked="checked"><span class="text-small">FREE shipping</span><span
                      class="checkmark"></span>
                  </label>
                </li>
                <li>
                  <label class="cb-container">
                    <input type="checkbox"><span class="text-small">Big deals</span><span class="checkmark"></span>
                  </label>
                </li>
                <li>
                  <label class="cb-container">
                    <input type="checkbox"><span class="text-small">Shop Mall</span><span class="checkmark"></span>
                  </label>
                </li>
              </ul>
              <h6 class="color-gray-900 mb-0 mt-40">Ready to ship in</h6>
              <ul class="list-checkbox">
                <li>
                  <label class="cb-container">
                    <input type="checkbox"><span class="text-small">1 business day</span><span
                      class="checkmark"></span>
                  </label>
                </li>
                <li>
                  <label class="cb-container">
                    <input type="checkbox" checked="checked"><span class="text-small">1–3 business days</span><span
                      class="checkmark"></span>
                  </label>
                </li>
                <li>
                  <label class="cb-container">
                    <input type="checkbox"><span class="text-small">in 1 week</span><span class="checkmark"></span>
                  </label>
                </li>
                <li>
                  <label class="cb-container">
                    <input type="checkbox"><span class="text-small">Shipping now</span><span class="checkmark"></span>
                  </label>
                </li>
              </ul>
            </div>
            <div class="col-w-1">
              <h6 class="color-gray-900 mb-0">Ordering options</h6>
              <ul class="list-checkbox">
                <li>
                  <label class="cb-container">
                    <input type="checkbox"><span class="text-small">Accepts gift cards</span><span
                      class="checkmark"></span>
                  </label>
                </li>
                <li>
                  <label class="cb-container">
                    <input type="checkbox"><span class="text-small">Customizable</span><span class="checkmark"></span>
                  </label>
                </li>
                <li>
                  <label class="cb-container">
                    <input type="checkbox" checked="checked"><span class="text-small">Can be gift-wrapped</span><span
                      class="checkmark"></span>
                  </label>
                </li>
                <li>
                  <label class="cb-container">
                    <input type="checkbox"><span class="text-small">Installment 0%</span><span
                      class="checkmark"></span>
                  </label>
                </li>
              </ul>
              <h6 class="color-gray-900 mb-0 mt-40">Rating</h6>
              <ul class="list-checkbox">
                <li class="mb-5"><a href="#"><img src="images/star.svg" alt="Ecom"><img src="images/star.svg"
                      alt="Ecom"><img src="images/star.svg" alt="Ecom"><img src="images/star.svg" alt="Ecom"><img
                      src="images/star.svg" alt="Ecom"><span
                      class="ml-10 font-xs color-gray-500 d-inline-block align-top">(5 stars)</span></a></li>
                <li class="mb-5"><a href="#"><img src="images/star.svg" alt="Ecom"><img src="images/star.svg"
                      alt="Ecom"><img src="images/star.svg" alt="Ecom"><img src="images/star.svg" alt="Ecom"><img
                      src="images/star-gray.svg" alt="Ecom"><span
                      class="ml-10 font-xs color-gray-500 d-inline-block align-top">(4 stars)</span></a></li>
                <li class="mb-5"><a href="#"><img src="images/star.svg" alt="Ecom"><img src="images/star.svg"
                      alt="Ecom"><img src="images/star.svg" alt="Ecom"><img src="images/star-gray.svg" alt="Ecom"><img
                      src="images/star-gray.svg" alt="Ecom"><span
                      class="ml-10 font-xs color-gray-500 d-inline-block align-top">(3 stars)</span></a></li>
                <li class="mb-5"><a href="#"><img src="images/star.svg" alt="Ecom"><img src="images/star.svg"
                      alt="Ecom"><img src="images/star-gray.svg" alt="Ecom"><img src="images/star-gray.svg"
                      alt="Ecom"><img src="images/star-gray.svg" alt="Ecom"><span
                      class="ml-10 font-xs color-gray-500 d-inline-block align-top">(2 stars)</span></a></li>
                <li class="mb-5"><a href="#"><img src="images/star.svg" alt="Ecom"><img src="images/star-gray.svg"
                      alt="Ecom"><img src="images/star-gray.svg" alt="Ecom"><img src="images/star-gray.svg"
                      alt="Ecom"><img src="images/star-gray.svg" alt="Ecom"><span
                      class="ml-10 font-xs color-gray-500 d-inline-block align-top">(1 star)</span></a></li>
              </ul>
            </div>
            <div class="col-w-2">
              <h6 class="color-gray-900 mb-0">Material</h6>
              <ul class="list-checkbox">
                <li>
                  <label class="cb-container">
                    <input type="checkbox"><span class="text-small">Nylon (8)</span><span class="checkmark"></span>
                  </label>
                </li>
                <li>
                  <label class="cb-container">
                    <input type="checkbox"><span class="text-small">Tempered Glass (5)</span><span
                      class="checkmark"></span>
                  </label>
                </li>
                <li>
                  <label class="cb-container">
                    <input type="checkbox" checked="checked"><span class="text-small">Liquid Silicone Rubber
                      (5)</span><span class="checkmark"></span>
                  </label>
                </li>
                <li>
                  <label class="cb-container">
                    <input type="checkbox"><span class="text-small">Aluminium Alloy (3)</span><span
                      class="checkmark"></span>
                  </label>
                </li>
              </ul>
              <h6 class="color-gray-900 mb-20 mt-40">Product tags</h6>
              <div><a class="btn btn-border mr-5" href="#">Games</a><a class="btn btn-border mr-5"
                  href="#">Electronics</a><a class="btn btn-border mr-5" href="#">Video</a><a
                  class="btn btn-border mr-5" href="#">Cellphone</a><a class="btn btn-border mr-5"
                  href="#">Indoor</a><a class="btn btn-border mr-5" href="#">VGA Card</a><a
                  class="btn btn-border mr-5" href="#">USB</a><a class="btn btn-border mr-5" href="#">Lightning</a><a
                  class="btn btn-border mr-5" href="#">Camera</a></div>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-start pl-30"><a class="btn btn-buy w-auto" href="#">Apply
            Fillter</a><a class="btn font-sm-bold color-gray-500" href="#">Reset Fillter</a></div>
      </div>
    </div>
  </div>
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