<?php require "includes/session_check.php";
require MODEL_DIR."BuyWin.php";
$buywin = new BuyWin($db);
$getBuyWinOffers = $buywin->getBuyWinOffers();

if($getBuyWinOffers === false) {
    header("location: ".BASE_URL."dashboard");
    die;
} 
?>

<div class="app-container app-theme-white body-tabs-shadow fixed-header fixed-sidebar">

    <?php include_once COMPONENT_DIR.'topnav.php'; ?>

    <div class="app-main">

        <?php include_once "components/sidebar.php";?>

        <div class="app-main__outer">
            <div class="app-main__inner">
                <?php include_once COMPONENT_DIR."breadcrumb.php"; ?>

                <div class="row col-md-12">
                    <div class="col-md-9">
                        <div class="row">
                            <?php
                            if($getBuyWinOffers != NULL) {
                                foreach($getBuyWinOffers as $offerIndex => $package) {
                                    $reward = json_decode($package['reward']);   
                                    $promoRange = json_decode($package['promoRange']);    
                                    if($package['isActive'] === 'active') { ?>
                                        <div class="col-md-6 col-lg-4 mb-3">
                                            <div class="card buy-win-item">
                                                <div class="card-header"></div>
                                                <div class="card-body text-center">
                                                    <span class="d-block">Stand a chance to win: </span>
                                                    <h6 class="buy-win-reward"><?php echo $reward->reward;?></h6>
                                                </div>
                                                <div class="card-footer d-flex justify-content-between buy-win-footer">
                                                    <div>
                                                        <strong><small><?php echo $package['promoType'];?></small></strong>
                                                        <h6 class="m-0"><?php echo CURRENCY.number_format($package['amount'], 2);?></h6>
                                                    </div>
                                                    
                                                    <?php if(isset($promoRange->expired)) { ?>
                                                        <button type="button" class="btn mr-2 mb-2 btn-secondary btn-lg" disabled>
                                                            <b><i class='fa fa-ban'></i> Expired</b>
                                                        </button>
                                                    <?php } else { ?>
                                                        <button type="button" class="btn mr-2 mb-2 btn-primary btn-lg" data-toggle="modal" data-target="#offerModal<?php echo $package['promo_reference'];?>">
                                                            <b><i class='fa fa-shopping-basket'></i> Buy Now</b>
                                                        </button>
                                                    <?php } ?>
        
                                                    <div class="modal fade" id="offerModal<?php echo $package['promo_reference'];?>" tabindex="-1" role="dialog" aria-labelledby="offerModal" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="offerModal">Buy <?php echo $package['promoType'];?></h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                    </button> <?php echo $package['isActive'];?>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <?php echo nl2br(substr($package['description'], 0, 1000)); ?>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary btn-lg" data-dismiss="modal">Close</button>
                                                                    <a href="<?php echo BASE_URL;?>purchaseBuyWin?&offerReference=<?php echo $package['promo_reference'];?>" class="btn btn-primary btn-lg">
                                                                        <b><i class='fa fa-shopping-basket'></i> Buy Now</b>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                <?php }
                                }
                            } ?>
                        </div>

                    </div>
                    <div class="col-md-3 col-lg-3 mb-5">
                        <?php include_once COMPONENT_DIR."recentWinners.php"; ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


<?php include_once COMPONENT_DIR."footer_script.php"; include_once INCLUDES_DIR."sweetalert.php"; ?>