<div class="mb-3 card sticky-recent-winners">
    <div class="card-header-tab card-header">
        <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
            <i class="header-icon lnr-shirt mr-3 text-muted opacity-6"></i>
            Recent Float Winners
        </div>
    </div>

    <div class="pt-2 pb-0 card-body mt-3">
        <div class="scroll-area-md shadow-overflow">
            <div class="scrollbar-container">
                <ul class="rm-list-borders rm-list-borders-scroll list-group list-group-flush">
                    
                    <?php 
                    for($i = 1; $i <= 10; $i++ ) { ?>
                        <li class="list-group-item sticky-border-bottom">
                            <div class="widget-content p-0">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left mr-3">
                                        <img width="38" class="rounded-circle" src="assets/images/avatars/default-avatar.png" alt="">
                                    </div>
                                    <div class="widget-content-left">
                                        <div class="widget-heading text-dark"><?php echo $user->getUserById(7)->fullname;?></div>
                                        <div class="widget-subheading mt-1 opacity-10">
                                            <div class="badge badge-pill badge-dark"><?php echo CURRENCY.number_format(15500, 2);?> </div>
                                        </div>
                                    </div>
                                    <div class="widget-content-right">
                                        <div class="fsize-1 text-focus">
                                            <small class="opacity-5 pr-1 text-success pl-2"><?php echo $utility->niceDateFormat('2022-10-11 14:45:20');?></small>
                                            <!-- <span>752</span> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="d-block text-center rm-border card-footer">
        
    </div>
</div>