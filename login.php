<?php  require "includes/session_check.php";  ?>

    <div class="app-container app-theme-white body-tabs-shadow">
        <div class="app-container">
            <div class="h-100">
                <div class="h-100 no-gutters row">
                    <div class="d-none d-lg-block col-lg-4">                        
                    </div>
                    <div class="h-100 d-flex bg-white justify-content-center align-items-center col-md-12 col-lg-8">
                        <div class="mx-auto app-login-box col-sm-12 col-md-10 col-lg-9">
                            <div>
                                <h4><strong><?php echo SITE_TITLE;?></strong></h4>
                            </div>
                            <h4 class="mb-0">
                                <span class="d-block">Welcome back,</span>
                                <span>Please sign in to your account.</span>
                            </h4>
                            <h6 class="mt-3">No account? <a href="register" class="text-primary">Sign up
                                    now</a></h6>
                            <div class="divider row"></div>
                            <div>
                                
                            <?php 
                            echo $utility->displayFormSuccess();
                            echo $utility->displayFormError(); ?>

                                <form class="" method="post" action="<?php echo BASE_URL;?>controllers/auth.php">
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="position-relative form-group">
                                                <label>Username</label>
                                                <input name="username" placeholder="Enter username" type="text" class="form-control form-control-lg">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="position-relative form-group">
                                                <label class="">Password</label>
                                                <input name="password" placeholder="Enter Password" type="password" class="form-control form-control-lg">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="divider row"></div>
                                    <div class="d-flex align-items-center">
                                        <div class="ml-auto">
                                            <button class="btn btn-primary btn-lg" type="submit" name="logAccount"><b><i class="fa fa-paper-plane"></i>
                                                    Login to Dashboard</b></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="assets/scripts/main.d810cf0ae7f39f28f336.js"></script>
</body>

</html>