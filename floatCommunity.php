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
                        <div class="col-sm-12 col-md-12 col-xl-9">
                            <div class="row">
                                <?php if ($floatUsers) {
                                    foreach ($floatUsers as $index => $user) { ?>
                                        <div class="col-sm-12 col-md-6 col-xl-4">
                                            <div class="card-shadow-primary card-border mb-3 profile-responsive card">
                                                <div class="dropdown-menu-header">
                                                    <div class="dropdown-menu-header-inner bg-alternate">
                                                        <div class="menu-header-image opacity-2"
                                                            style="background-image: url('assets/images/dropdown-header/abstract1.jpg');">
                                                        </div>
                                                        <div class="menu-header-content btn-pane-right">
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
                                                                <a href="" class="btn-wide btn-hover-shine btn btn-success">
                                                                    <i class="fa fa-whatsapp"></i>
                                                                    Chat
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
                                                                        <strong class="d-block" style="font-size: 21px;"><?php echo number_format($user->userMeta->float_wallet, 2) ?></strong>
                                                                        Float Balance
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
                        <div class="col-sm-12 col-md-12 col-xl-3">
                            <div class="mb-3 card card-sticky" style="height: 100%;">
                                <div class="card-header-tab card-header">
                                    <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                                        <i class="header-icon lnr-shirt mr-3 text-muted opacity-6"></i>
                                        Recent Float Winners
                                    </div>
                                </div>

                                <div class="pt-2 pb-0 card-body mt-3">
                                    <div class="scroll-area-md shadow-overflow">
                                        <div class="scrollbar-container">
                                            <ul
                                                class="rm-list-borders rm-list-borders-scroll list-group list-group-flush">
                                                <li class="list-group-item">
                                                    <div class="widget-content p-0">
                                                        <div class="widget-content-wrapper">
                                                            <div class="widget-content-left mr-3">
                                                                <img width="38" class="rounded-circle"
                                                                    src="assets/images/avatars/1.jpg" alt="">
                                                            </div>
                                                            <div class="widget-content-left">
                                                                <div class="widget-heading">Viktor Martin</div>
                                                                <div class="widget-subheading mt-1 opacity-10">
                                                                    <div class="badge badge-pill badge-dark">$152
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="widget-content-right">
                                                                <div class="fsize-1 text-focus">
                                                                    <small class="opacity-5 pr-1">$</small>
                                                                    <span>752</span>
                                                                    <small class="text-warning pl-2">
                                                                        <i class="fa fa-angle-down"></i>
                                                                    </small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="widget-content p-0">
                                                        <div class="widget-content-wrapper">
                                                            <div class="widget-content-left mr-3">
                                                                <img width="38" class="rounded-circle"
                                                                    src="assets/images/avatars/2.jpg" alt="">
                                                            </div>
                                                            <div class="widget-content-left">
                                                                <div class="widget-heading">Denis Delgado</div>
                                                                <div class="widget-subheading mt-1 opacity-10">
                                                                    <div class="badge badge-pill badge-dark">$53
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="widget-content-right">
                                                                <div class="fsize-1 text-focus">
                                                                    <small class="opacity-5 pr-1">$</small>
                                                                    <span>587</span>
                                                                    <small class="text-danger pl-2">
                                                                        <i class="fa fa-angle-up"></i>
                                                                    </small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="widget-content p-0">
                                                        <div class="widget-content-wrapper">
                                                            <div class="widget-content-left mr-3">
                                                                <img width="38" class="rounded-circle"
                                                                    src="assets/images/avatars/3.jpg" alt="">
                                                            </div>
                                                            <div class="widget-content-left">
                                                                <div class="widget-heading">Shawn Galloway</div>
                                                                <div class="widget-subheading mt-1 opacity-10">
                                                                    <div class="badge badge-pill badge-dark">$239
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="widget-content-right">
                                                                <div class="fsize-1 text-focus">
                                                                    <small class="opacity-5 pr-1">$</small>
                                                                    <span>163</span>
                                                                    <small class="text-muted pl-2">
                                                                        <i class="fa fa-angle-down"></i>
                                                                    </small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="widget-content p-0">
                                                        <div class="widget-content-wrapper">
                                                            <div class="widget-content-left mr-3">
                                                                <img width="38" class="rounded-circle"
                                                                    src="assets/images/avatars/4.jpg" alt="">
                                                            </div>
                                                            <div class="widget-content-left">
                                                                <div class="widget-heading">Latisha Allison</div>
                                                                <div class="widget-subheading mt-1 opacity-10">
                                                                    <div class="badge badge-pill badge-dark">$21
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="widget-content-right">
                                                                <div class="fsize-1 text-focus">
                                                                    <small class="opacity-5 pr-1">$</small>
                                                                    653
                                                                    <small class="text-primary pl-2">
                                                                        <i class="fa fa-angle-up"></i>
                                                                    </small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="widget-content p-0">
                                                        <div class="widget-content-wrapper">
                                                            <div class="widget-content-left mr-3">
                                                                <img width="38" class="rounded-circle"
                                                                    src="assets/images/avatars/5.jpg" alt="">
                                                            </div>
                                                            <div class="widget-content-left">
                                                                <div class="widget-heading">Lilly-Mae White</div>
                                                                <div class="widget-subheading mt-1 opacity-10">
                                                                    <div class="badge badge-pill badge-dark">$381
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="widget-content-right">
                                                                <div class="fsize-1 text-focus">
                                                                    <small class="opacity-5 pr-1">$</small> 629
                                                                    <small class="text-muted pl-2">
                                                                        <i class="fa fa-angle-up"></i>
                                                                    </small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="widget-content p-0">
                                                        <div class="widget-content-wrapper">
                                                            <div class="widget-content-left mr-3">
                                                                <img width="38" class="rounded-circle"
                                                                    src="assets/images/avatars/8.jpg" alt="">
                                                            </div>
                                                            <div class="widget-content-left">
                                                                <div class="widget-heading">Julie Prosser</div>
                                                                <div class="widget-subheading mt-1 opacity-10">
                                                                    <div class="badge badge-pill badge-dark">$74
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="widget-content-right">
                                                                <div class="fsize-1 text-focus">
                                                                    <small class="opacity-5 pr-1">$</small>462
                                                                    <small class="text-muted pl-2">
                                                                        <i class="fa fa-angle-down"></i>
                                                                    </small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="border-bottom-0 list-group-item">
                                                    <div class="widget-content p-0">
                                                        <div class="widget-content-wrapper">
                                                            <div class="widget-content-left mr-3">
                                                                <img width="38" class="rounded-circle"
                                                                    src="assets/images/avatars/8.jpg" alt="">
                                                            </div>
                                                            <div class="widget-content-left">
                                                                <div class="widget-heading">Amin Hamer</div>
                                                                <div class="widget-subheading mt-1 opacity-10">
                                                                    <div class="badge badge-pill badge-dark">$7
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="widget-content-right">
                                                                <div class="fsize-1 text-focus">
                                                                    <small class="opacity-5 pr-1">$</small>
                                                                    956
                                                                    <small class="text-success pl-2">
                                                                        <i class="fa fa-angle-up"></i>
                                                                    </small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-block text-center rm-border card-footer">
                                    
                                </div>
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