<?php
$redirectUrl = strtok($_SERVER['REQUEST_URI'], '?');
function get_categories($location)
{
    global $con;

    $select_cat_sql = "SELECT * FROM `ecom_categories` ORDER BY category_title ASC";
    $result = mysqli_query($con, $select_cat_sql);

    if (mysqli_num_rows($result) > 0) {

        while ($row = mysqli_fetch_assoc($result)) {
            $cat_id    = $row['category_id'];
            $cat_title = $row['category_title'];
            $cat_icon  = $row['category_icon'];

            switch ($location) {
                case "header-search":
                    echo "<option value='$cat_id'>$cat_title</option>";
                    break;

                case "navbar":
                    echo '<li>
                            <a href="shop.php?categoryID=' . $cat_id . '">
                                <span class="img-link">
                                    <img src="images/' . $cat_icon . '" alt="' . $cat_title . '">
                                </span>
                                <span class="text-link">' . $cat_title . '</span>
                            </a>
                        </li>';
                    break;

                case "shop-sidebar":
                    // Added a placeholder for count, or you could pass a count variable later
                    echo '<li>
                            <a href="shop.php?categoryID=' . $cat_id . '">
                                ' . $cat_title . '<span class="number">12</span>
                            </a>
                        </li>';
                    break;

                default:
                    // Only hits if an invalid location is passed
                    break;
            }
        }
    } else {
        if ($location === "header-search") {
            echo "<option>No Categories</option>";
        }
    }
}

function get_products($qty, $location)
{
    global $con;
    global $redirectUrl;


    $sql = "SELECT * FROM `ecom_products` ";

    switch ($location) {
        case "home-trending":
            $sql .= "ORDER BY product_id DESC LIMIT $qty";
            break;

        case "home-top-rated":
            $sql .= "ORDER BY product_price DESC LIMIT $qty";
            break;

        case "home-new-products-side":
            $sql .= "ORDER BY created_at DESC LIMIT $qty";
            break;

        case "shop-page-top":
            $sql .= "WHERE product_id BETWEEN 5 AND 10 LIMIT $qty";
            break;

        case "home-top-selling":
        case "home-top-selling-side":
            $sql .= "ORDER BY product_id ASC LIMIT $qty";
            break;

        case "home-tabs":
        case "shop-page-grid":
        case "product-page":
            $sql .= "ORDER BY RAND() LIMIT $qty";
            break;

        case "shop-page-categorize":
            $sql .= "WHERE category_id = $qty";
            break;

        default:
            $sql .= "LIMIT $qty";
            break;
    }

    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $product_id = $row['product_id'];
            $product_title = $row['product_title'];
            $product_price = $row['product_price'];
            $product_image_1 = $row['product_image_1'];
            switch ($location) {
                case "home-tabs":
                    echo '<div class="card-grid-style-3">
                        <div class="card-grid-inner">
                            <div class="tools">
                                <a class="btn btn-trend btn-tooltip mb-10" href="#" aria-label="Trend" data-bs-placement="left"></a><a
                                    class="btn btn-wishlist btn-tooltip mb-10" href="shop-wishlist.html" aria-label="Add To Wishlist"></a><a
                                    class="btn btn-compare btn-tooltip mb-10" href="shop-compare.html" aria-label="Compare"></a><a
                                    class="btn btn-quickview btn-tooltip" aria-label="Quick view" href="#ModalQuickview"
                                    data-bs-toggle="modal"></a>
                            </div>
                            <div class="image-box">
                                <span class="label bg-brand-2">-17%</span>
                                <a href="product.php?productID=' . $product_id . '">
                                    <img src="images/' . $product_image_1 . '" alt="Ecom" />
                                </a>
                            </div>
                            <div class="info-right">
                                <a class="font-xs color-gray-500" href="shop-vendor-single.html?productID=' . $product_id . '">Dell</a><br /><a
                                    class="color-brand-3 font-sm-bold" href="product.php?productID=' . $product_id . '">' . $product_title . '</a>
                                <div class="rating">
                                    <img src="images/star.svg" alt="Ecom" /><img src="images/star.svg" alt="Ecom" /><img
                                        src="images/star.svg" alt="Ecom" /><img src="images/star.svg" alt="Ecom" /><img
                                        src="images/star.svg" alt="Ecom" /><span class="font-xs color-gray-500">(65)</span>
                                </div>
                                <div class="price-info">
                                    <strong class="font-lg-bold color-brand-3 price-main">$' . $product_price . '</strong><span
                                        class="color-gray-500 price-line">$3225.6</span>
                                </div>
                                <div class="mt-20 box-btn-cart">
                                    <a class="btn btn-cart" href="' . $redirectUrl . '?addtoCart=' . $product_id . '">Add To Cart</a>
                                </div>
                            </div>
                        </div>
                    </div>';
                    break;
                case "home-trending":
                    echo '<div class="col-xl-3 col-lg-6 col-md-6">
                        <div class="card-grid-style-3">
                            <div class="card-grid-inner">
                            <div class="tools"><a class="btn btn-trend btn-tooltip mb-10" href="#" aria-label="Trend"
                                data-bs-placement="left"></a><a class="btn btn-wishlist btn-tooltip mb-10" href="shop-wishlist.html"
                                aria-label="Add To Wishlist"></a><a class="btn btn-compare btn-tooltip mb-10" href="shop-compare.html"
                                aria-label="Compare"></a><a class="btn btn-quickview btn-tooltip" aria-label="Quick view"
                                href="#ModalQuickview" data-bs-toggle="modal"></a></div>
                            <div class="image-box"><span class="label bg-brand-2">-17%</span><a href="product.php?productID=' . $product_id . '"><img
                                    src="images/' . $product_image_1 . '" alt="' . $product_title . '"></a></div>
                            <div class="info-right">
                                <a class="font-xs color-gray-500" href="shop-vendor-single.html">SAMSUNG</a><br><a
                                    class="color-brand-3 font-sm-bold" href="product.php?productID=' . $product_id . '">' . $product_title . '</a>
                                <div class="rating"><img src="images/star.svg" alt="' . $product_title . '"><img src="images/star.svg" alt="' . $product_title . '"><img
                                    src="images/star.svg" alt="Ecom"><img src="images/star.svg" alt="Ecom"><img src="images/star.svg"
                                    alt="Ecom"><span class="font-xs color-gray-500">(65)</span></div>
                                <div class="price-info"><strong class="font-lg-bold color-brand-3 price-main">$' . $product_price . '</strong><span
                                    class="color-gray-500 price-line">$3225.6</span></div>
                                <div class="mt-20 box-btn-cart"><a class="btn btn-cart" href="' . $redirectUrl . '?addtoCart=' . $product_id . '">Add To Cart</a></div>

                            </div>
                            </div>
                        </div>
                    </div>';
                    break;
                case "home-top-rated":
                    echo '<div class="col-xl-3 col-lg-6 col-md-6">
                        <div class="card-grid-style-3">
                            <div class="card-grid-inner">
                            <div class="tools"><a class="btn btn-trend btn-tooltip mb-10" href="#" aria-label="Trend"
                                data-bs-placement="left"></a><a class="btn btn-wishlist btn-tooltip mb-10" href="shop-wishlist.html"
                                aria-label="Add To Wishlist"></a><a class="btn btn-compare btn-tooltip mb-10" href="shop-compare.html"
                                aria-label="Compare"></a><a class="btn btn-quickview btn-tooltip" aria-label="Quick view"
                                href="#ModalQuickview" data-bs-toggle="modal"></a></div>
                            <div class="image-box"><span class="label bg-brand-2">-17%</span><a href="product.php?productID=' . $product_id . '"><img
                                    src="images/' . $product_image_1 . '" alt="' . $product_title . '"></a></div>
                            <div class="info-right">
                                <a class="font-xs color-gray-500" href="shop-vendor-single.html">SAMSUNG</a><br><a
                                    class="color-brand-3 font-sm-bold" href="product.php?productID=' . $product_id . '">' . $product_title . '</a>
                                <div class="rating"><img src="images/star.svg" alt="' . $product_title . '"><img src="images/star.svg" alt="' . $product_title . '"><img
                                    src="images/star.svg" alt="Ecom"><img src="images/star.svg" alt="Ecom"><img src="images/star.svg"
                                    alt="Ecom"><span class="font-xs color-gray-500">(65)</span></div>
                                <div class="price-info"><strong class="font-lg-bold color-brand-3 price-main">$' . $product_price . '</strong><span
                                    class="color-gray-500 price-line">$3225.6</span></div>
                                <div class="mt-20 box-btn-cart"><a class="btn btn-cart" href="' . $redirectUrl . '?addtoCart=' . $product_id . '">Add To Cart</a></div>

                            </div>
                            </div>
                        </div>
                    </div>';
                    break;
                case "home-top-selling-side":
                    echo '<div class="card-grid-style-2 card-grid-none-border border-bottom mb-10">
                        <div class="image-box"><span class="label bg-brand-2">-17%</span><a
                            href="product.php?productID=' . $product_id . '"><img src="images/' . $product_image_1 . '" alt="Ecom"></a>
                        </div>
                        <div class="info-right">
                            <a class="color-brand-3 font-xs-bold" href="product.php?productID=' . $product_id . '">' . $product_title . '</a>
                          <div class="rating"><img src="images/star.svg" alt="Ecom"><img src="images/star.svg"
                              alt="Ecom"><img src="images/star.svg" alt="Ecom"><img src="images/star.svg"
                              alt="Ecom"><img src="images/star.svg" alt="Ecom"><span class="font-xs color-gray-500">
                              (65)</span></div>
                          <div class="price-info"><strong
                              class="font-md-bold color-brand-3 price-main">$' . $product_price . '</strong><span
                              class="color-gray-500 font-sm price-line">$3225.6</span>
                          </div>
                        </div>
                      </div>';
                    break;
                case "home-new-products-side":
                    echo '<div class="card-grid-style-2 card-grid-none-border border-bottom mb-10">
                        <div class="image-box"><span class="label bg-brand-2">-17%</span><a
                            href="product.php?productID=' . $product_id . '"><img src="images/' . $product_image_1 . '" alt="Ecom"></a>
                        </div>
                        <div class="info-right">
                            <a class="color-brand-3 font-xs-bold" href="product.php?productID=' . $product_id . '">' . $product_title . '</a>
                          <div class="rating"><img src="images/star.svg" alt="Ecom"><img src="images/star.svg"
                              alt="Ecom"><img src="images/star.svg" alt="Ecom"><img src="images/star.svg"
                              alt="Ecom"><img src="images/star.svg" alt="Ecom"><span class="font-xs color-gray-500">
                              (65)</span></div>
                          <div class="price-info"><strong
                              class="font-md-bold color-brand-3 price-main">$' . $product_price . '</strong><span
                              class="color-gray-500 font-sm price-line">$3225.6</span>
                          </div>
                        </div>
                      </div>';
                    break;
                case "home-top-selling":
                    echo '<div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="card-grid-style-2">
                        <div class="image-box"><a href="product.php?productID=' . $product_id . '"><img src="images/' . $product_image_1 . '" alt="Ecom"></a></div>
                        <div class="info-right"><span class="font-xs color-gray-500">SAMSUNG</span><br><a
                            class="color-brand-3 font-sm-bold" href="product.php?productID=' . $product_id . '">' . $product_title . '</a>
                            <div class="rating"><img src="images/star.svg" alt="Ecom"><img src="images/star.svg" alt="Ecom"><img
                                src="images/star.svg" alt="Ecom"><img src="images/star.svg" alt="Ecom"><img src="images/star.svg"
                                alt="Ecom"><span class="font-xs color-gray-500">(65)</span></div>
                            <div class="price-info"><strong class="font-lg-bold color-brand-3 price-main">$' . $product_price . '</strong><span
                                class="color-gray-500 price-line">$3225.6</span></div>
                        </div>
                        </div>
                    </div>';
                    break;
                case "shop-page-grid":
                    if (!isset($_GET['view']) || $_GET['view'] === 'grid') {
                        echo '<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                                <div class="card-grid-style-3">
                                    <div class="card-grid-inner">
                                        <div class="tools"><a class="btn btn-trend btn-tooltip mb-10" href="#" aria-label="Trend"
                                                data-bs-placement="left"></a><a class="btn btn-wishlist btn-tooltip mb-10" href="shop-wishlist.html"
                                                aria-label="Add To Wishlist"></a><a class="btn btn-compare btn-tooltip mb-10"
                                                href="shop-compare.html" aria-label="Compare"></a><a class="btn btn-quickview btn-tooltip"
                                                aria-label="Quick view" href="#ModalQuickview" data-bs-toggle="modal"></a></div>
                                        <div class="image-box"><span class="label bg-brand-2">-17%</span><a href="product.php?productID=' . $product_id . '"><img
                                        src="images/' . $product_image_1 . '" alt="Ecom"></a></div>
                                        <div class="info-right"><a class="font-xs color-gray-500" href="shop-vendor-single.html">Apple</a><br><a
                                        class="color-brand-3 font-sm-bold" href="product.php?productID=' . $product_id . '">' . $product_title . '</a>
                                        <div class="rating"><img src="images/star.svg" alt="Ecom"><img src="images/star.svg" alt="Ecom"><img
                                                    src="images/star.svg" alt="Ecom"><img src="images/star.svg" alt="Ecom"><img
                                                    src="images/star.svg" alt="Ecom"><span class="font-xs color-gray-500">(65)</span></div>
                                            <div class="price-info"><strong class="font-lg-bold color-brand-3 price-main">$' . $product_price . '</strong><span
                                                    class="color-gray-500 price-line">$3225.6</span></div>
                                            <div class="mt-20 box-btn-cart"><a class="btn btn-cart" href="' . $redirectUrl . '?addtoCart=' . $product_id . '">Add To Cart</a>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>';
                    } else if (!isset($_GET['view']) || $_GET['view'] === 'list') {
                        echo '
                        <div class="col-lg-12">
                            <div class="card-grid-style-3">
                            <div class="card-grid-inner">
                                <div class="tools">
                                    <a class="btn btn-trend btn-tooltip mb-10" href="#" aria-label="Trend"></a>
                                    <a class="btn btn-wishlist btn-tooltip mb-10" href="shop-wishlist.html" aria-label="Add To Wishlist"></a>
                                    <a class="btn btn-compare btn-tooltip mb-10" href="shop-compare.html" aria-label="Compare"></a>
                                    <a class="btn btn-quickview btn-tooltip" aria-label="Quick view" href="#ModalQuickview" data-bs-toggle="modal"></a>
                                </div>
                                <div class="image-box">
                                    <span class="label bg-brand-2">-17%</span>
                                    <a href="product.php?productID=' . $product_id . '"><img src="images/' . $product_image_1  . '" alt="Ecom"></a>
                                </div>
                                <div class="info-right"><span class="font-xs color-gray-500">Apple</span><br>
                                <a href="product.php?productID=' . $product_id . '">
                                    <h4 class="color-brand-3">' . $product_title . '</h4>
                                </a>
                                <div class="rating"><img src="images/star.svg" alt="Ecom"><img src="images/star.svg"
                                    alt="Ecom"><img src="images/star.svg" alt="Ecom"><img src="images/star.svg" alt="Ecom"><img
                                    src="images/star.svg" alt="Ecom"><span class="font-xs color-gray-500"> (65)</span></div>
                                <div class="price-info"><strong
                                    class="font-lg-bold color-brand-3 price-main">$' . $product_price . '</strong><span
                                    class="color-gray-500 price-line">$3225.6</span></div>
                                <ul class="list-features">
                                    <li> 27-inch (diagonal) Retina 5K display</li>
                                    <li>3.1GHz 6-core 10th-generation Intel Core i5</li>
                                    <li>AMD Radeon Pro 5300 graphics</li>
                                </ul>
                                <div class="mt-20"><a class="btn btn-cart" href="' . $redirectUrl . '?addtoCart=' . $product_id . '">Add To Cart</a></div>
                                </div>
                            </div>
                            </div>
                        </div>
                        ';
                    }
                    break;
                case "shop-page-top":
                    echo '<div class="swiper-slide">
                        <div class="card-grid-style-2"><span class="label bg-brand-2">-12%</span>
                            <div class="image-box"><a href="product.php?productID=' . $product_id . '"><img src="images/' . $product_image_1 . '"
                                alt="Ecom"></a></div>
                            <div class="info-right"><span class="font-xs color-gray-500">YSSOA Store</span><br><a
                                class="color-brand-3 font-sm-bold" href="product.php?productID=' . $product_id . '">' . substr($product_title, 0, 47) . '...</a>
                            <div class="rating"><img src="images/star.svg" alt="Ecom"><img src="images/star.svg" alt="Ecom"><img
                                src="images/star.svg" alt="Ecom"><img src="images/star.svg" alt="Ecom"><img
                                src="images/star.svg" alt="Ecom"><span class="font-xs color-gray-500">(65)</span></div>
                            <div class="price-info"><strong class="font-lg-bold color-brand-3 price-main">$' . $product_price . '</strong><span
                                class="color-gray-500 price-line">$3225.6</span></div>
                            </div>
                        </div>
                        </div>';
                    break;
                case "shop-page-categorize":
                    if (!isset($_GET['view']) || $_GET['view'] === 'grid') {
                        echo '<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                                <div class="card-grid-style-3">
                                    <div class="card-grid-inner">
                                        <div class="tools"><a class="btn btn-trend btn-tooltip mb-10" href="#" aria-label="Trend"
                                                data-bs-placement="left"></a><a class="btn btn-wishlist btn-tooltip mb-10" href="shop-wishlist.html"
                                                aria-label="Add To Wishlist"></a><a class="btn btn-compare btn-tooltip mb-10"
                                                href="shop-compare.html" aria-label="Compare"></a><a class="btn btn-quickview btn-tooltip"
                                                aria-label="Quick view" href="#ModalQuickview" data-bs-toggle="modal"></a></div>
                                        <div class="image-box"><span class="label bg-brand-2">-17%</span><a href="product.php?productID=' . $product_id . '"><img
                                        src="images/' . $product_image_1 . '" alt="Ecom"></a></div>
                                        <div class="info-right"><a class="font-xs color-gray-500" href="shop-vendor-single.html">Apple</a><br><a
                                        class="color-brand-3 font-sm-bold" href="product.php?productID=' . $product_id . '">' . $product_title . '</a>
                                        <div class="rating"><img src="images/star.svg" alt="Ecom"><img src="images/star.svg" alt="Ecom"><img
                                                    src="images/star.svg" alt="Ecom"><img src="images/star.svg" alt="Ecom"><img
                                                    src="images/star.svg" alt="Ecom"><span class="font-xs color-gray-500">(65)</span></div>
                                            <div class="price-info"><strong class="font-lg-bold color-brand-3 price-main">$' . $product_price . '</strong><span
                                                    class="color-gray-500 price-line">$3225.6</span></div>
                                            <div class="mt-20 box-btn-cart"><a class="btn btn-cart" href="' . $redirectUrl . '?addtoCart=' . $product_id . '">Add To Cart</a>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>';
                    } else if (!isset($_GET['view']) || $_GET['view'] === 'list') {
                        echo '
                        <div class="col-lg-12">
                            <div class="card-grid-style-3">
                            <div class="card-grid-inner">
                                <div class="tools">
                                    <a class="btn btn-trend btn-tooltip mb-10" href="#" aria-label="Trend"></a>
                                    <a class="btn btn-wishlist btn-tooltip mb-10" href="shop-wishlist.html" aria-label="Add To Wishlist"></a>
                                    <a class="btn btn-compare btn-tooltip mb-10" href="shop-compare.html" aria-label="Compare"></a>
                                    <a class="btn btn-quickview btn-tooltip" aria-label="Quick view" href="#ModalQuickview" data-bs-toggle="modal"></a>
                                </div>
                                <div class="image-box">
                                    <span class="label bg-brand-2">-17%</span>
                                    <a href="product.php?productID=' . $product_id . '"><img src="images/' . $product_image_1  . '" alt="Ecom"></a>
                                </div>
                                <div class="info-right"><span class="font-xs color-gray-500">Apple</span><br>
                                <a href="product.php?productID=' . $product_id . '">
                                    <h4 class="color-brand-3">' . $product_title . '</h4>
                                </a>
                                <div class="rating"><img src="images/star.svg" alt="Ecom"><img src="images/star.svg"
                                    alt="Ecom"><img src="images/star.svg" alt="Ecom"><img src="images/star.svg" alt="Ecom"><img
                                    src="images/star.svg" alt="Ecom"><span class="font-xs color-gray-500"> (65)</span></div>
                                <div class="price-info"><strong
                                    class="font-lg-bold color-brand-3 price-main">$' . $product_price . '</strong><span
                                    class="color-gray-500 price-line">$3225.6</span></div>
                                <ul class="list-features">
                                    <li> 27-inch (diagonal) Retina 5K display</li>
                                    <li>3.1GHz 6-core 10th-generation Intel Core i5</li>
                                    <li>AMD Radeon Pro 5300 graphics</li>
                                </ul>
                                <div class="mt-20"><a class="btn btn-cart" href="' . $redirectUrl . '?addtoCart=' . $product_id . '">Add To Cart</a></div>
                                </div>
                            </div>
                            </div>
                        </div>
                        ';
                    }
                    break;
                case "product-page-recent":
                    echo '<div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="card-grid-style-2 card-grid-none-border hover-up">
                                <div class="image-box"><a href="product.php?productID=' . $product_id . '"><img src="images/' . $product_image_1 . '"
                                    alt="Ecom"></a>
                                </div>
                                <div class="info-right"><span class="font-xs color-gray-500">Apple</span><br><a
                                    class="color-brand-3 font-xs-bold" href="product.php?productID=' . $product_id . '">' . $product_title . '</a>
                                <div class="rating"><img src="images/star.svg" alt="Ecom"><img src="images/star.svg" alt="Ecom"><img
                                    src="images/star.svg" alt="Ecom"><img src="images/star.svg" alt="Ecom"><img
                                    src="images/star.svg" alt="Ecom"><span class="font-xs color-gray-500"> (65)</span></div>
                                <div class="price-info"><strong class="font-lg-bold color-brand-3 price-main">$' . $product_price . '</strong><span
                                    class="color-gray-500 price-line">$3225.6</span></div>
                                </div>
                            </div>
                        </div>';
                    break;
                case "product-page":
                    echo '<div class="card-grid-style-3">
                            <div class="card-grid-inner">
                                <div class="tools"><a class="btn btn-trend btn-tooltip mb-10" href="#" aria-label="Trend"
                                    data-bs-placement="left"></a><a class="btn btn-wishlist btn-tooltip mb-10"
                                    href="shop-wishlist.html" aria-label="Add To Wishlist"></a><a
                                    class="btn btn-compare btn-tooltip mb-10" href="shop-compare.html" aria-label="Compare"></a><a
                                    class="btn btn-quickview btn-tooltip" aria-label="Quick view" href="#ModalQuickview"
                                    data-bs-toggle="modal"></a></div>
                                <div class="image-box"><span class="label bg-brand-2">-17%</span><a
                                    href="product.php?productID=' . $product_id . '"><img src="images/' . $product_image_1 . '" alt="Ecom"></a></div>
                                <div class="info-right"><a class="font-xs color-gray-500"
                                    href="shop-vendor-single.html">Apple</a><br><a class="color-brand-3 font-sm-bold"
                                    href="product.php?productID=' . $product_id . '">' . $product_title . '</a>
                                <div class="rating"><img src="images/star.svg" alt="Ecom"><img src="images/star.svg" alt="Ecom"><img
                                    src="images/star.svg" alt="Ecom"><img src="images/star.svg" alt="Ecom"><img
                                    src="images/star.svg" alt="Ecom"><span class="font-xs color-gray-500">(65)</span></div>
                                <div class="price-info"><strong class="font-lg-bold color-brand-3 price-main">$' . $product_price . '</strong><span
                                    class="color-gray-500 price-line">$3225.6</span></div>
                                <div class="mt-20 box-btn-cart"><a class="btn btn-cart" href="' . $redirectUrl . '?addtoCart=' . $product_id . '">Add To Cart</a></div>

                                </div>
                            </div>
                        </div>';
                    break;
                default:
                    echo "No Results Found";
                    break;
            }
        }
    } else {
        echo '<main class="main">
                <section class="section-box shop-template mt-60">
                <div class="container">
                    <div class="text-center mb-150 mt-50">
                    <div class="image-404 mb-50"> <img src="images/404.png" alt="Ecom"></div>
                    <h3>Products Not Found</h3>
                    <p class="font-md-bold color-gray-600">This Place is Abandoned</p>
                    <div class="mt-15"> <a class="btn btn-buy w-auto arrow-back" href="index.php">Back to Homepage</a></div>
                    </div>
                </div>
                </section>
            </main>';
    }
}

function get_product_details($data)
{
    global $con;
    global $redirectUrl;
    if (isset($_GET['productID']) && filter_var($_GET['productID'], FILTER_VALIDATE_INT)) {
        $productID = (int)$_GET['productID'];
        $sql = "SELECT * FROM `ecom_products` WHERE `product_id` = ?";

        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "i", $productID);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);


        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $product_id = htmlspecialchars($row['product_id']);
                $product_title = htmlspecialchars($row['product_title']);
                $product_description = htmlspecialchars($row['product_description']);
                $product_price = htmlspecialchars($row['product_price']);
                $product_image_1 = htmlspecialchars($row['product_image_1']);
                $product_image_2 = htmlspecialchars($row['product_image_2']);
                $product_image_3 = htmlspecialchars($row['product_image_3']);
                $product_image_4 = htmlspecialchars($row['product_image_4']);
                $product_image_5 = htmlspecialchars($row['product_image_5']);

                $base_image_path = "images/";
                switch ($data) {
                    case "main-product":
                        echo '
<section class="section-box shop-template">
    <div class="container">
        <div class="row">
            <div class="col-lg-5">
                <div class="gallery-image">
                    <div class="galleries">
                        <div class="detail-gallery">
                            <label class="label">-17%</label>
                            <div class="product-image-slider">
                                <figure class="border-radius-10">
                                    <img src="images/' . $product_image_1 . '" alt="product image" />
                                </figure>
                                <figure class="border-radius-10">
                                    <img src="' . $product_image_2 . '" alt="product image" />
                                </figure>
                                <figure class="border-radius-10">
                                    <img src="' . $product_image_3 . '" alt="product image" />
                                </figure>
                                <figure class="border-radius-10">
                                    <img src="' . $product_image_4 . '" alt="product image" />
                                </figure>
                                <figure class="border-radius-10">
                                    <img src="' . $product_image_5 . '" alt="product image" />
                                </figure>
                                <figure class="border-radius-10">
                                    <img src="' . $product_image_2 . '" alt="product image" />
                                </figure>
                                <figure class="border-radius-10">
                                    <img src="' . $product_image_4 . '" alt="product image" />
                                </figure>
                            </div>
                        </div>
                        <div class="slider-nav-thumbnails">
                            <div>
                                <div class="item-thumb">
                                    <img src="images/' . $product_image_1 . '" alt="product image" />
                                </div>
                            </div>
                            <div>
                                <div class="item-thumb">
                                    <img src="' . $product_image_2 . '" alt="product image" />
                                </div>
                            </div>
                            <div>
                                <div class="item-thumb">
                                    <img src="' . $product_image_3 . '" alt="product image" />
                                </div>
                            </div>
                            <div>
                                <div class="item-thumb">
                                    <img src="' . $product_image_4 . '" alt="product image" />
                                </div>
                            </div>
                            <div>
                                <div class="item-thumb">
                                    <img src="' . $product_image_5 . '" alt="product image" />
                                </div>
                            </div>
                            <div>
                                <div class="item-thumb">
                                    <img src="' . $product_image_2 . '" alt="product image" />
                                </div>
                            </div>
                            <div>
                                <div class="item-thumb">
                                    <img src="' . $product_image_4 . '" alt="product image" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <h3 class="color-brand-3 mb-25">' . $product_title . '</h3>
                <div class="row align-items-center">
                    <div class="col-lg-4 col-md-4 col-sm-3 mb-mobile">
                        <span class="bytext color-gray-500 font-xs font-medium">by</span><a
                            class="byAUthor color-gray-900 font-xs font-medium" href="shop-vendor-single.html">
                            Ecom Tech</a>
                        <div class="rating mt-5">
                            <img src="images/star.svg" alt="Ecom" /><img src="images/star.svg" alt="Ecom" /><img
                                src="images/star.svg" alt="Ecom" /><img src="images/star.svg" alt="Ecom" /><img
                                src="images/star.svg" alt="Ecom" /><span class="font-xs color-gray-500 font-medium">
                                (65 reviews)</span>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-9 text-start text-sm-end">
                        <a class="mr-20" href="shop-wishlist.html"><span
                                class="btn btn-wishlist mr-5 opacity-100 transform-none"></span><span
                                class="font-md color-gray-900">Add to Wish list</span></a><a
                            href="shop-compare.html"><span
                                class="btn btn-compare mr-5 opacity-100 transform-none"></span><span
                                class="font-md color-gray-900">Add to Compare</span></a>
                    </div>
                </div>
                <div class="border-bottom pt-10 mb-20"></div>
                <div class="box-product-price">
                    <h3 class="color-brand-3 price-main d-inline-block mr-10">$' . $product_price . '</h3>
                    <span class="color-gray-500 price-line font-xl line-througt">$3225.6</span>
                </div>
                <div class="product-description mt-20 color-gray-900">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <ul class="list-dot">
                                <li>8k super steady video</li>
                                <li>Nightography plus portait mode</li>
                                <li>50mp photo resolution plus bright display</li>
                            </ul>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <ul class="list-dot">
                                <li>Adaptive color contrast</li>
                                <li>premium design & craftmanship</li>
                                <li>Long lasting battery plus fast charging</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="box-product-color mt-20">
                    <p class="font-sm color-gray-900">
                        Color:<span class="color-brand-2 nameColor">Pink Gold</span>
                    </p>
                    <ul class="list-colors">
                        <li class="disabled">
                            <img src="images/' . $product_image_1 . '" alt="Ecom" title="Pink" />
                        </li>
                        <li>
                            <img src="' . $product_image_2 . '" alt="Ecom" title="Gold" />
                        </li>
                        <li>
                            <img src="' . $product_image_3 . '" alt="Ecom" title="Pink Gold" />
                        </li>
                        <li>
                            <img src="' . $product_image_4 . '" alt="Ecom" title="Silver" />
                        </li>
                        <li class="active">
                            <img src="' . $product_image_5 . '" alt="Ecom" title="Pink Gold" />
                        </li>
                        <li class="disabled">
                            <img src="' . $product_image_3 . '" alt="Ecom" title="Black" />
                        </li>
                        <li class="disabled">
                            <img src="' . $product_image_4 . '" alt="Ecom" title="Red" />
                        </li>
                    </ul>
                </div>
                <div class="box-product-style-size mt-20">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 mb-20">
                            <p class="font-sm color-gray-900">
                                Style:<span class="color-brand-2 nameStyle">S22</span>
                            </p>
                            <ul class="list-styles">
                                <li class="disabled" title="S22 Ultra">S22 Ultra</li>
                                <li class="active" title="S22">S22</li>
                                <li title="S22 + Standing Cover">S22 + Standing Cover</li>
                            </ul>
                        </div>
                        <div class="col-lg-6 col-md-6 mb-20">
                            <p class="font-sm color-gray-900">
                                Size:<span class="color-brand-2 nameSize">512GB</span>
                            </p>
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
                <div class="buy-product mt-30">
                    <p class="font-sm mb-20">Quantity</p>
                    <div class="box-quantity">
                        <div class="input-quantity">
                            <input class="font-xl color-brand-3" type="text" value="1" /><span
                                class="minus-cart"></span><span class="plus-cart"></span>
                        </div>
                        <div class="button-buy">
                            <a class="btn btn-cart" href="' . $redirectUrl . '?addtoCart=' . $product_id . '">Add to cart</a><a class="btn btn-buy"
                                href="checkout.php">Buy now</a>
                        </div>
                    </div>
                </div>
                <div class="info-product mt-40">
                    <div class="row align-items-end">
                        <div class="col-lg-4 col-md-4 mb-20">
                            <span class="font-sm font-medium color-gray-900">SKU:<span
                                    class="color-gray-500">iphone12pro128</span><br />Category:<span
                                    class="color-gray-500">Smartphones</span><br />Tags:<span
                                    class="color-gray-500">Blue, Smartphone</span></span>
                        </div>
                        <div class="col-lg-4 col-md-4 mb-20">
                            <span class="font-sm font-medium color-gray-900">Free Delivery<br /><span
                                    class="color-gray-500">Available for all locations.</span><br /><span
                                    class="color-gray-500">Delivery Options & Info</span></span>
                        </div>
                        <div class="col-lg-4 col-md-4 mb-20 text-start text-md-end">
                            <div class="d-inline-block">
                                <div class="share-link">
                                    <span class="font-md-bold color-brand-3 mr-15">Share</span><a
                                        class="facebook hover-up" href="#"></a><a class="printest hover-up"
                                        href="#"></a><a class="twitter hover-up" href="#"></a><a
                                        class="instagram hover-up" href="#"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
    </div>
</section>';

                        break;
                    case "product-details-desc":
                        echo $product_description;
                        break;
                    default:
                        echo "No Results Found";
                        break;
                }
            }
        } else {
            echo '<main class="main">
            <section class="section-box shop-template mt-60">
            <div class="container">
            <div class="text-center mb-150 mt-50">
            <div class="image-404 mb-50"> <img src="images/404.png" alt="Ecom"></div>
            <h3>Products Not Found</h3>
            <p class="font-md-bold color-gray-600">This Place is Abandoned</p>
            <div class="mt-15"> <a class="btn btn-buy w-auto arrow-back" href="index.php">Back to Homepage</a></div>
            </div>
            </div>
            </section>
            </main>';
        }
        mysqli_stmt_close($stmt);
    } else {
        echo '<main class="main">
                <section class="section-box shop-template mt-60">
                <div class="container">
                    <div class="text-center mb-150 mt-50">
                    <div class="image-404 mb-50"> <img src="images/404.png" alt="Ecom"></div>
                    <h3>Products Not Found</h3>
                    <p class="font-md-bold color-gray-600">This Place is Abandoned</p>
                    <div class="mt-15"> <a class="btn btn-buy w-auto arrow-back" href="index.php">Back to Homepage</a></div>
                    </div>
                </div>
                </section>
            </main>';
    }
}


function search_product()
{
    global $con;
    global $redirectUrl;

    if (isset($_GET['search_product'])) {
        $search_data_value = mysqli_real_escape_string($con, $_GET['search_product']);
        $search_query = "SELECT * FROM `ecom_products` WHERE `product_keywords` LIKE '%$search_data_value%' OR `product_title` LIKE '%$search_data_value%'";
        $result_query = mysqli_query($con, $search_query);

        if (mysqli_num_rows($result_query) > 0) {
            while ($row = mysqli_fetch_assoc($result_query)) {
                $product_id = $row['product_id'];
                $product_title = $row['product_title'];
                $product_price = $row['product_price'];
                $product_image_1 = $row['product_image_1'];

                echo '<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card-grid-style-3">
                        <div class="card-grid-inner">
                            <div class="tools"><a class="btn btn-trend btn-tooltip mb-10" href="#" aria-label="Trend"
                                    data-bs-placement="left"></a><a class="btn btn-wishlist btn-tooltip mb-10" href="shop-wishlist.html"
                                    aria-label="Add To Wishlist"></a><a class="btn btn-compare btn-tooltip mb-10"
                                    href="shop-compare.html" aria-label="Compare"></a><a class="btn btn-quickview btn-tooltip"
                                    aria-label="Quick view" href="#ModalQuickview" data-bs-toggle="modal"></a></div>
                            <div class="image-box"><span class="label bg-brand-2">-17%</span><a href="product.php?productID=' . $product_id . '"><img
                            src="images/' . $product_image_1 . '" alt="Ecom"></a></div>
                            <div class="info-right"><a class="font-xs color-gray-500" href="shop-vendor-single.html">Apple</a><br><a
                            class="color-brand-3 font-sm-bold" href="product.php?productID=' . $product_id . '">' . $product_title . '</a>
                            <div class="rating"><img src="images/star.svg" alt="Ecom"><img src="images/star.svg" alt="Ecom"><img
                                        src="images/star.svg" alt="Ecom"><img src="images/star.svg" alt="Ecom"><img
                                        src="images/star.svg" alt="Ecom"><span class="font-xs color-gray-500">(65)</span></div>
                                <div class="price-info"><strong class="font-lg-bold color-brand-3 price-main">$' . $product_price . '</strong><span
                                        class="color-gray-500 price-line">$3225.6</span></div>
                                <div class="mt-20 box-btn-cart"><a class="btn btn-cart" href="' . $redirectUrl . '?addtoCart=' . $product_id . '">Add To Cart</a>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>';
            }
        } else {
            echo '<main class="main">
                    <section class="section-box shop-template mt-60">
                    <div class="container">
                        <div class="text-center mb-150 mt-50">
                            <div class="image-404 mb-50"> <img src="images/404.png" alt="Ecom"></div>
                            <h3>Nothing Found</h3>
                            <p class="font-md-bold color-gray-600">Nothing Found for your search!</p>
                        </div>
                    </div>
                    </section>
                </main>';
        }
    } else {
        echo '<main class="main">
                    <section class="section-box shop-template mt-60">
                    <div class="container">
                        <div class="text-center mb-150 mt-50">
                        <div class="image-404 mb-50"> <img src="images/404.png" alt="Ecom"></div>
                        <h3>404 - Not Found</h3>
                        <p class="font-md-bold color-gray-600">Looks like, You are lost!</p>
                        <div class="mt-15"> <a href="index.php" class="btn btn-buy w-auto arrow-back">Back to Homepage</a></div>
                        </div>
                    </div>
                    </section>
                </main>';
    }
}


function cart()
{
    global $con;
    $redirectUrl = strtok($_SERVER['REQUEST_URI'], '?');
    // include('toast-notify.php');

    if (isset($_GET['addtoCart'])) {
        $getProductId = intval($_GET['addtoCart']);
        if (isset($_SESSION['username'])) {
            //logged in user
            $username = $_SESSION['username'];
            $stmt = $con->prepare("SELECT `user_id` FROM `ecom_users` WHERE `user_username`=?");
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $result = $stmt->get_result();
            $user_data = $result->fetch_assoc();
            $user_id = $user_data['user_id'];
            // echo $user_id;

            // Check if the product already exist or not
            $check_cart = $con->prepare("SELECT * FROM `ecom_cart_details` WHERE `user_id`=? AND `product_id`=?");
            $check_cart->bind_param('ii', $user_id, $getProductId);
            $check_cart->execute();
            $result_check = $check_cart->get_result();
            if ($result_check->num_rows > 0) {
                // update
                $update = $con->prepare("UPDATE `ecom_cart_details` SET quantity=quantity+1 WHERE `user_id`=? AND `product_id`=?");
                $update->bind_param('ii', $user_id, $getProductId);
                $update->execute();
                $_SESSION['toast-message'] = "Quantity Updated";
                $_SESSION['toast-icon'] = "info";

                echo "<script>window.location.href='$redirectUrl'</script>";
                exit();
            } else {
                // insert
                $insert = $con->prepare("INSERT INTO `ecom_cart_details` (`user_id`, `product_id`, `quantity`)
                VALUES (?,?,1)");
                $insert->bind_param('ii', $user_id, $getProductId);
                $insert->execute();
                // echo "Product Added Successfully L";

                $_SESSION['toast-message'] = "Product Added Successfully";
                $_SESSION['toast-icon'] = "success";
                // header("Location: $redirectUrl");
                echo "<script>window.location.href='$redirectUrl'</script>";
                exit();
            }
        } else {
            // guest user
            if (!isset($_SESSION['cart']))
                $_SESSION['cart'] = [];

            if (isset($_SESSION['cart'][$getProductId])) {
                $_SESSION['cart'][$getProductId] += 1;
                $_SESSION['toast-message'] = "Product Quantity Updated";
                $_SESSION['toast-icon'] = "info";
                // echo "Product Quantity Updated NL";
                header("Location: $redirectUrl");
            } else {
                $_SESSION['cart'][$getProductId] = 1;
                $_SESSION['toast-message'] = "Product Added Successfully";
                $_SESSION['toast-icon'] = "success";
                // echo "Product Added Successfully NL";
                // header("Location: $redirectUrl");
            }

            $redirectUrl = strtok($_SERVER['REQUEST_URI'], '?');
            echo "<script>window.location.href='$redirectUrl'</script>";
            // echo $redirectUrl;
            exit();
        }
    }
}

function cart_item()
{
    global $con;
    $count = 0;
    if (isset($_SESSION['username'])) {
        //loggedin user
        $username = $_SESSION['username'];
        $stmt = $con->prepare("SELECT `user_id` FROM `ecom_users` WHERE `user_username` = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user_data = $result->fetch_assoc();
        $user_id = $user_data['user_id'];
        $count_query = $con->prepare("SELECT SUM(quantity) AS total FROM `ecom_cart_details` WHERE user_id =?");
        $count_query->bind_param('i', $user_id);
        $count_query->execute();
        $data = $count_query->get_result()->fetch_assoc();
        $count = $data['total'] ?? 0;
    } else {
        // guest user
        if (isset($_SESSION['cart'])) {
            $count = array_sum($_SESSION['cart']);
        }
    }
    echo $count;
}
function total_price()
{
    global $con;
    $total = 0;
    if (isset($_SESSION['username'])) {
        // logged in user
        $username = $_SESSION['username'];
        if (!isset($_SESSION['user_id'])) {
            $stmt = $con->prepare("SELECT user_id FROM `ecom_users` WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $_SESSION['user_id'] = $stmt->get_result()->fetch_assoc()['user_id'];
        }
        $uid = $_SESSION['user_id'];
        $sql = "SELECT p.product_price,c.quantity FROM ecom_cart_details c JOIN ecom_products p ON c.product_id=p.product_id WHERE c.user_id=?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $uid);
        $stmt->execute();
        $items = $stmt->get_result();
        while ($row = $items->fetch_assoc()) {
            $total += $row['product_price'] * $row['quantity'];
        }
    } else {
        // guest user
        if (isset($_SESSION['cart']) && count($_SESSION) > 0) {
            $product_ids = array_keys($_SESSION['cart']);
            $placeholders = implode(',', array_fill(0, count($product_ids), "?"));
            $sql = "SELECT product_id,product_price FROM ecom_products WHERE product_id IN ($placeholders)";
            $stmt = $con->prepare($sql);
            $types = str_repeat('i', count($product_ids));
            $stmt->bind_param($types, ...$product_ids);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $pid = $row['product_id'];
                $total += $row['product_price'] * $_SESSION['cart'][$pid];
            }
        }
    }
    echo $total;
}
