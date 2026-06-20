<main class="main">
    <section class="section-box shop-template mt-60">
        <div class="container">
            <div class="row mb-100">
                <div class="col-lg-1"></div>
                <div class="col-lg-5">
                    <h3>Login to Your Account</h3>
                    <p class="font-md color-gray-500">Welcome back!</p>
                    <form action="login.php" method="post" class="form-register mt-30 mb-30">
                        <div class="form-group">
                            <label class="mb-5 font-sm color-gray-700">Email / Phone / Username *</label>
                            <input class="form-control" type="text" name="loginUser" placeholder="stevenjob@gmail.com">
                        </div>
                        <div class="form-group">
                            <label class="mb-5 font-sm color-gray-700">Password *</label>
                            <input class="form-control" type="password" name="loginPassword" placeholder="******************">
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="color-gray-500 font-xs">
                                        <input class="checkagree" type="checkbox">Remember me
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6 text-end">
                                <div class="form-group"><a class="font-xs color-gray-500" href="#">Forgot your password? </a></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <?php if (!empty($gotocheckout)): ?>
                                <input type="hidden" name="gotocheckout" value="1">
                            <?php endif; ?>
                            <input class="font-md-bold btn btn-buy" type="submit" name="loginSubmit" value="Login">
                        </div>
                        <div class="mt-20"><span class="font-xs color-gray-500 font-medium">Have not an account?</span><a
                                class="font-xs color-brand-3 font-medium" href="register.php">Sign Up</a></div>
                    </form>
                </div>
                <div class="col-lg-5"></div>
            </div>
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
</main>