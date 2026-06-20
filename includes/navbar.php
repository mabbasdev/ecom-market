<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<div id="preloader-active">
    <div class="preloader d-flex align-items-center justify-content-center">
        <div class="preloader-inner position-relative">
            <div class="text-center"><img class="mb-10" src="images/favicon.svg" alt="Ecom">
                <div class="preloader-dots"></div>
            </div>
        </div>
    </div>
</div>
<div class="topbar top-gray-1000">
    <div class="container-topbar">
        <div class="menu-topbar-left d-none d-xl-block">
            <ul class="nav-small">
                <li><a class="font-xs" href="page-about-us.html">About Us</a></li>
                <li><a class="font-xs" href="#">Careers</a></li>
                <li><a class="font-xs" href="#">Open a shop</a></li>
            </ul>
        </div>
        <div class="info-topbar text-center d-none d-xl-block"><span class="font-xs color-brand-3">Free shipping for
                all
                orders over</span><span class="font-sm-bold color-success"> $75.00</span></div>
        <div class="menu-topbar-right"><span class="font-xs color-brand-3">Need help? Call Us:</span><span
                class="font-sm-bold color-success"> + 1800 900</span>
            <div class="dropdown dropdown-language">
                <button class="btn dropdown-toggle" id="dropdownPage" type="button" data-bs-toggle="dropdown"
                    aria-expanded="true" data-bs-display="static"><span
                        class="dropdown-right font-xs color-brand-3"><img src="images/en.svg" alt="Ecom">
                        English</span></button>
                <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="dropdownPage" data-bs-popper="static">
                    <li><a class="dropdown-item" href="#"><img src="images/flag-en.svg" alt="Ecom"> English</a></li>
                    <li><a class="dropdown-item" href="#"><img src="images/flag-fr.svg" alt="Ecom"> Français</a></li>
                    <li><a class="dropdown-item" href="#"><img src="images/flag-es.svg" alt="Ecom"> Español</a></li>
                    <li><a class="dropdown-item" href="#"><img src="images/flag-pt.svg" alt="Ecom"> Português</a></li>
                    <li><a class="dropdown-item" href="#"><img src="images/flag-cn.svg" alt="Ecom"> 中国人</a></li>
                </ul>
            </div>
            <div class="dropdown dropdown-language">
                <button class="btn dropdown-toggle" id="dropdownPage2" type="button" data-bs-toggle="dropdown"
                    aria-expanded="true" data-bs-display="static"><span
                        class="dropdown-right font-xs color-brand-3">USD</span></button>
                <ul class="dropdown-menu dropdown-menu-light dropdown-menu-end" aria-labelledby="dropdownPage2"
                    data-bs-popper="static">
                    <li><a class="dropdown-item active" href="#">USD</a></li>
                    <li><a class="dropdown-item" href="#">EUR</a></li>
                    <li><a class="dropdown-item" href="#">AUD</a></li>
                    <li><a class="dropdown-item" href="#">SGP</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<header class="header header-container sticky-bar">
    <div class="container">
        <div class="main-header">
            <div class="header-left">
                <div class="header-logo"><a href="<?php echo getAbsoluteLink('index.php', $baseURL); ?>"><img alt="Ecom" src="images/logo.svg"></a></div>
                <div class="header-search">
                    <div class="box-header-search">
                        <form class="form-search" method="get" action="<?php echo getAbsoluteLink('search-products.php', $baseURL); ?>">
                            <div class="box-category">
                                <select class="select-active select2-hidden-accessible" data-select2-id="1"
                                    tabindex="-1" aria-hidden="true">
                                    <option>All categories</option>
                                    <?php get_categories("header-search") ?>
                                </select>
                            </div>
                            <div class="box-keysearch">
                                <input class="form-control font-xs" type="text" name="search_product" value=""
                                    placeholder="Search for items">
                            </div>
                        </form>
                    </div>
                </div>
                <div class="header-nav text-start">
                    <nav class="nav-main-menu d-none d-xl-block">
                        <ul class="main-menu">
                            <li><a class="active" href="#">Flash Deals</a></li>
                            <li><a href="#">Special</a></li>
                            <li><a href="#">Top Sellers</a></li>
                        </ul>
                    </nav>
                    <div class="burger-icon burger-icon-white"><span class="burger-icon-top"></span><span
                            class="burger-icon-mid"></span><span class="burger-icon-bottom"></span></div>
                </div>
                <div class="header-shop">
                    <div class="d-inline-block box-dropdown-cart"><span
                            class="font-lg icon-list icon-account"><span>Account</span></span>
                        <div class="dropdown-account">
                            <ul>
                                <?php
                                if (isset($_SESSION['username'])) {
                                    echo '<li><a href="page-account.html">My Account</a></li>
                                <li><a href="page-account.html">Order Tracking</a></li>
                                <li><a href="page-account.html">My Orders</a></li>
                                <li><a href="page-account.html">My Wishlist</a></li>
                                <li><a href="page-account.html">Setting</a></li>
                                <li><a href="' . getAbsoluteLink('logout.php', $baseURL) . '">Sign out</a></li>';
                                } else {
                                    echo '<li><a href="login.php">Login</a></li>
                                <li><a href="' . getAbsoluteLink('register.php', $baseURL) . '">Create Account</a></li>';
                                }
                                ?>

                            </ul>
                        </div>
                    </div><a class="font-lg icon-list icon-wishlist"
                        href="shop-wishlist.html"><span>Wishlist</span><span class="number-item font-xs">5</span></a>
                    <div class="d-inline-block box-dropdown-cart"><span
                            class="font-lg icon-list icon-cart"><span>Cart</span><span
                                class="number-item font-xs"><?php cart_item(); ?></span></span>
                        <div class="dropdown-cart">
                            <div class="item-cart mb-20">
                                <div class="cart-image"><img src="images/imgsp5.png" alt="Ecom"></div>
                                <div class="cart-info"><a class="font-sm-bold color-brand-3"
                                        href="product.php">2022
                                        Apple iMac with Retina 5K Display 8GB RAM, 256GB SSD</a>
                                    <p><span class="color-brand-2 font-sm-bold">1 x $2856.4</span></p>
                                </div>
                            </div>
                            <div class="item-cart mb-20">
                                <div class="cart-image"><img src="images/imgsp4.png" alt="Ecom"></div>
                                <div class="cart-info"><a class="font-sm-bold color-brand-3"
                                        href="shop-single-product-2.html">2022
                                        Apple iMac with Retina 5K Display 8GB RAM, 256GB SSD</a>
                                    <p><span class="color-brand-2 font-sm-bold">1 x $2856.4</span></p>
                                </div>
                            </div>
                            <div class="border-bottom pt-0 mb-15"></div>
                            <div class="cart-total">
                                <div class="row">
                                    <div class="col-6 text-start"><span
                                            class="font-md-bold color-brand-3">Total</span></div>
                                    <div class="col-6"><span class="font-md-bold color-brand-1">$<?php total_price(); ?></span></div>
                                </div>
                                <div class="row mt-15">
                                    <div class="col-6 text-start"><a class="btn btn-cart w-auto"
                                            href="<?php echo getAbsoluteLink('cart.php', $baseURL); ?>">View cart</a>
                                    </div>
                                    <div class="col-6"><a class="btn btn-buy w-auto"
                                            href="checkout.php">Checkout</a></div>
                                </div>
                            </div>
                        </div>
                    </div><a class="font-lg icon-list icon-compare" href="shop-compare.html"><span>Compare</span></a>
                </div>
            </div>
        </div>
    </div>
    <div class="header-bottom">
        <div class="container">
            <div class="dropdown d-inline-block">
                <button class="btn dropdown-toggle btn-category" id="dropdownCategory" type="button"
                    data-bs-toggle="dropdown" aria-expanded="true" data-bs-display="static"><span
                        class="dropdown-right font-sm-bold color-white">Shop By
                        Categories</span></button>
                <div class="sidebar-left dropdown-menu dropdown-menu-light" aria-labelledby="dropdownCategory"
                    data-bs-popper="static">
                    <ul class="menu-texts menu-close">
                        <!-- <li class="has-children"><a href="javascript:;"><span class="img-link"><img
                                        src="images/monitor.svg" alt="Ecom"></span><span class="text-link">Computers &
                                    Accessories</span></a>
                            <ul class="sub-menu">
                                <li><a href="#">Computer Accessories</a></li>
                                <li><a href="#">Computer Cases</a></li>
                                <li><a href="#">Laptop</a></li>
                                <li><a href="#">HDD</a></li>
                                <li><a href="#">RAM</a></li>
                                <li><a href="#">Headphone</a></li>
                            </ul>
                        </li>
                        <li class="has-children"><a class="active" href="javascript:;"><span class="img-link"><img
                                        src="images/mobile.svg" alt="Ecom"></span><span class="text-link">Cell
                                    Phones</span></a>
                            <ul class="sub-menu">
                                <li><a href="#">Phone Accessories</a></li>
                                <li><a href="#">Phone Cases</a></li>
                                <li><a href="#">Postpaid Phones</a></li>
                                <li><a href="#">Unlocked Phones</a></li>
                                <li><a href="#">Prepaid Phones</a></li>
                                <li><a href="#">Prepaid Plans</a></li>
                                <li><a href="#">Refurbished Phones</a></li>
                                <li><a href="#">Straight Talk</a></li>
                                <li><a href="#">iPhone</a></li>
                                <li><a href="#">Samsung Galaxy</a></li>
                                <li><a href="#">Samsung Galaxy</a></li>
                                <li><a href="#">Samsung Galaxy</a></li>
                                <li><a href="#">Samsung Galaxy</a></li>
                                <li><a href="#">Samsung Galaxy</a></li>
                            </ul>
                        </li> -->
                        <!-- <li><a href="#"><span class="img-link"><img src="images/game.svg" alt="Ecom"></span><span
                                    class="text-link">Gaming Gatgets</span></a></li>
                        <li><a href="#"><span class="img-link"><img src="images/clock.svg" alt="Ecom"></span><span
                                    class="text-link">Smart watches</span></a></li>
                        <li><a href="#"><span class="img-link"><img src="images/airpod.svg" alt="Ecom"></span><span
                                    class="text-link">Airpod</span></a></li>
                        <li><a href="#"><span class="img-link"><img src="images/airpods.svg" alt="Ecom"></span><span
                                    class="text-link">Wired Headphone</span></a></li>
                        <li><a href="#"><span class="img-link"><img src="images/mouse.svg" alt="Ecom"></span><span
                                    class="text-link">Mouse & Keyboard</span></a></li>
                        <li><a href="#"><span class="img-link"><img src="images/music-play.svg"
                                        alt="Ecom"></span><span class="text-link">Headphone</span></a></li>
                        <li><a href="#"><span class="img-link"><img src="images/bluetooth.svg" alt="Ecom"></span><span
                                    class="text-link">Bluetooth devices</span></a></li>
                        <li><a href="#"><span class="img-link"><img src="images/clound.svg" alt="Ecom"></span><span
                                    class="text-link">Cloud Software</span></a></li>
                        <li><a href="#"><span class="img-link"><img src="images/electricity.svg"
                                        alt="Ecom"></span><span class="text-link">Electric accessories</span></a></li>
                        <li><a href="#"><span class="img-link"><img src="images/cpu.svg" alt="Ecom"></span><span
                                    class="text-link">Mainboard & CPU</span></a></li>
                        <li><a href="#"><span class="img-link"><img src="images/devices.svg" alt="Ecom"></span><span
                                    class="text-link">Desktop</span></a></li>
                        <li><a href="#"><span class="img-link"><img src="images/driver.svg" alt="Ecom"></span><span
                                    class="text-link">Speaker</span></a></li>
                        <li><a href="#"><span class="img-link"><img src="images/lamp.svg" alt="Ecom"></span><span
                                    class="text-link">Computer Decor</span></a></li> -->
                        <?php get_categories("navbar") ?>
                    </ul>
                </div>
            </div>
            <div class="header-nav d-inline-block">
                <nav class="nav-main-menu d-none d-xl-block">
                    <ul class="main-menu">
                        <li><a class="active" href="index.php">Home</a></li>
                        <li><a href="shop.php">Shop</a></li>
                        <li><a href="shop-vendor-list.html">Vendors</a></li>
                        <li><a href="blog-grid.html">Blog</a></li>
                        <li><a href="page-contact.html">Contact Us</a></li>
                    </ul>
                </nav>
            </div>
            <div class="discount font-16 font-bold">SPECIAL OFFER</div>
        </div>
    </div>
</header>
<div class="mobile-header-active mobile-header-wrapper-style perfect-scrollbar">
    <div class="mobile-header-wrapper-inner">
        <div class="mobile-header-content-area">
            <div class="mobile-logo"><a class="d-flex" href="index.php"><img alt="Ecom" src="images/logo.svg"></a>
            </div>
            <div class="perfect-scroll">
                <div class="mobile-menu-wrap mobile-header-border">
                    <nav class="mt-15">
                        <ul class="mobile-menu font-heading">
                            <li><a class="active" href="index.php">Home</a></li>
                            <li><a href="shop.php">Shop</a></li>
                            <li><a href="shop-vendor-list.html">Vendors</a></li>
                            <li><a href="blog-list.html">Blog</a></li>
                            <li><a href="page-contact.html">Contact Us</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="mobile-account">
                    <div class="mobile-header-top">
                        <div class="user-account"><a href="page-account.html"><img src="images/ava_1.png"
                                    alt="Ecom"></a>
                            <div class="content">
                                <h6 class="user-name">Hello<span class="text-brand"> Steven !</span></h6>
                                <p class="font-xs text-muted">You have 3 new messages</p>
                            </div>
                        </div>
                    </div>
                    <ul class="mobile-menu">
                        <?php
                        if (isset($_SESSION['username'])) {
                            echo '<li><a href="page-account.html">My Account</a></li>
                        <li><a href="page-account.html">Order Tracking</a></li>
                        <li><a href="page-account.html">My Orders</a></li>
                        <li><a href="page-account.html">My Wishlist</a></li>
                        <li><a href="page-account.html">Setting</a></li>
                        <li><a href="' . getAbsoluteLink('logout.php', $baseURL) . '">Sign out</a></li>';
                        } else {
                            echo '<li><a href="page-account.html">My Account</a></li>
                        <li><a href="' . getAbsoluteLink('register.php', $baseURL) . '">Order Tracking</a></li>';
                        }
                        ?>
                    </ul>
                </div>
                <div class="mobile-banner">
                    <div class="bg-5 block-iphone"><span class="color-brand-3 font-sm-lh32">Starting from $899</span>
                        <h3 class="font-xl mb-10">iPhone 12 Pro 128Gb</h3>
                        <p class="font-base color-brand-3 mb-10">Special Sale</p><a class="btn btn-arrow"
                            href="shop.php">learn more</a>
                    </div>
                </div>
                <div class="site-copyright color-gray-400 mt-30">Copyright 2022 © Ecom - Marketplace.</div>
            </div>
        </div>
    </div>
</div>