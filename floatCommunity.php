<?php 
require "includes/session_check.php"; 
$floatUsers = $user->getFloatUsers();
?>

    <div class="app-container app-theme-white body-tabs-shadow fixed-header fixed-sidebar">
        
        <?php include_once COMPONENT_DIR.'topnav.php'; ?>
        
        <div class="app-main">
            
            <?php include_once COMPONENT_DIR."sidebar.php";?>

            <div class="app-main__outer">
                <div class="app-main__inner">
                    <?php include_once COMPONENT_DIR.'breadcrumb.php' ?>
                    <div class="row">
                        <?php if ($floatUsers) {
                            foreach ($floatUsers as $index => $user) {
                                $userFloatSettings = json_decode($user->userMeta->float_settings) ?>

                                <div class="col-sm-12 col-md-6 col-xl-3">
                                    <div class="card-shadow-primary card-border mb-3 profile-responsive card">
                                        <div class="dropdown-menu-header">
                                            <div class="dropdown-menu-header-inner bg-alternate">
                                                <div class="menu-header-image opacity-2"
                                                    style="background-image: url('assets/images/dropdown-header/abstract1.jpg');">
                                                </div>
                                                <div class="menu-header-content">
                                                    <div class="avatar-icon-wrapper mr-3 avatar-icon-xl btn-hover-shine">
                                                        <div class="avatar-icon rounded">
                                                            <img src="<?php echo BASE_URL ?>assets/images/avatars/default-avatar.png"
                                                                alt="<?php echo $user->fullname ?>'s avatar">
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <h5 class="menu-header-title"><?php echo $user->fullname ?></h5>
                                                        <small class="menu-header-subtitle">Community Member</small>
                                                    </div>
                                                    <div class="menu-header-btn-pane">
                                                        <a href="" class="btn-wide btn-hover-shine btn btn-success btn-sm">
                                                            <i class="fa fa-whatsapp"></i>
                                                            Chat
                                                        </a>

                                                        <a href="createTicket?type=float&userId=<?php echo $user->id;?>" class="btn-wide btn-hover-shine btn btn-warning btn-sm">
                                                            Report
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <ul class="list-group list-group-flush">
                                            <li class="p-0 list-group-item">
                                                <div class="grid-menu grid-menu-2col">
                                                    <div class="no-gutters row">
                                                        <div class="col-sm-12">
                                                            <button
                                                                class="btn-icon-vertical btn-square btn-transition br-bl btn btn-outline-link">
                                                                <strong class="d-block" style="font-size: 21px;"><?php echo number_format($userFloatSettings->float_amount, 2) ?></strong>
                                                                Available for Sale
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            <?php }
                        } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script type="text/javascript" src="assets/scripts/main.d810cf0ae7f39f28f336.js"></script>
</body>


</html>