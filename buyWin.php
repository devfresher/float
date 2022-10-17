<?php require "includes/session_check.php";
require MODEL_DIR."BuyWin.php";
$buywin = new BuyWin($db);
$getBuyWinOffers = $buywin->getBuyWinOffers();
$dataOffer = $getBuyWinOffers->offer->data;
$airtimeOffer = $getBuyWinOffers->offer->airtime;
 
if($dataOffer != NULL AND $airtimeOffer != NULL) {
    $offerPackages = array_merge($airtimeOffer, $dataOffer);
}
else if($dataOffer != NULL) {
    $offerPackages = $dataOffer;
}
else if($airtimeOffer != NULL) {
    $offerPackages = $airtimeOffer;
}

// echo "<pre>";
//     print_r($offerPackages);
    // print_r($getBuyWinOffers);
    // print_r($dataOffer);
// echo "</pre>";

// die;
?>

    <div class="app-container app-theme-white body-tabs-shadow fixed-header fixed-sidebar">
        
        <?php include_once COMPONENT_DIR.'topnav.php'; ?>
        
        <div class="app-main">
            
            <?php include_once "components/sidebar.php";?>

            <div class="app-main__outer">
                <div class="app-main__inner">
                    <?php include_once COMPONENT_DIR."breadcrumb.php"; ?>

                <div class="row">
                    <?php
                    if($offerPackages != NULL) {
                        foreach($offerPackages as $offerIndex => $package) { ?>
                            <div class="col-md-6 col-lg-3 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="text-center">
                                            <img src="<?php echo BASE_URL;?>assets/images/mtn.svg">
                                            <h5 style="color: #000"><?php echo $package->promoType;?></h5>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="d-flex justify-content-between">
                                            <a href="<?Php echo BASE_URL;?>purchaseBuyWin?promoRef=<?php echo $package->win_ref;?>" class="btn btn-primary btn-lg">
                                                <b><i class='fa fa-shopping-basket'></i> Buy Now</b>
                                            </a>
                                            <h6><?php echo CURRENCY.number_format($package->amount, 2);?></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php }
                    }
                    ?>

                </div>

                </div>
            </div>
        </div>
    </div>
    

<?php include_once COMPONENT_DIR."footer_script.php"; include_once INCLUDES_DIR."sweetalert.php"; ?>