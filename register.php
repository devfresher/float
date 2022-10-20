<?php  require "includes/session_check.php";  ?>

    <div class="app-container app-theme-white body-tabs-shadow">
        <div class="app-container">
            <div class="h-100">
                <div class="h-100 no-gutters row">
                    <div
                        class="h-100 d-md-flex d-sm-block bg-white justify-content-center align-items-center col-md-12 col-lg-7">
                        <div class="mx-auto app-login-box col-sm-12 col-md-10 col-lg-9">
                            <div>
                                <h4><strong><?php echo SITE_TITLE;?></strong></h4>
                            </div>
                            <h4>
                                <div>Welcome,</div>
                                <span>It only takes a <span class="text-success">few seconds</span> to create your
                                    account</span>
                            </h4>
                            <div>
                                
                                <?php 
                                echo $utility->displayFormSuccess();
                                echo $utility->displayFormError(); ?>
                                
                                <form action="<?php echo BASE_URL;?>controllers/auth.php" method="post">
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="position-relative form-group">
                                                <label><b>Full Name</b></label>
                                                <input name="fullname" id="exampleName" placeholder="Enter your full name " type="text" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="position-relative form-group">
                                                <label><b>Username</b></label>
                                                <input name="username" placeholder="Enter your username" type="text" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="position-relative form-group">
                                                <label><b>Mobile Number</b></label>
                                                <input name="mobileno" placeholder="Enter your mobile number" type="text" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="position-relative form-group">
                                                <label><b>Email Address</b></label>
                                                <input name="email" placeholder="Enter your email address" type="email" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="position-relative form-group">
                                                <label> <b>Password</b></label>
                                                <input name="password" placeholder="Enter your password" type="password" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="position-relative form-group">
                                                <label><b>Repeat Password</b></label>
                                                <input name="passwordrep" placeholder="Repeat your password" type="password" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-4 d-flex align-items-center">
                                        <h5 class="mb-0" style="color: #000">Already have an account? <a href="login" class="text-primary"> Sign in </a></h5>
                                        <div class="ml-auto">
                                            <button class="btn-wide btn-pill btn-shadow btn-hover-shine btn btn-primary btn-lg" type="submit" name="createAccount">
                                                Create Account </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="d-lg-flex d-xs-none col-lg-5 signIn-Register">
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="assets/scripts/main.d810cf0ae7f39f28f336.js"></script>
</body>
</html>