<?php require "includes/session_check.php";
require MODEL_DIR."BuyWin.php";
$buywin = new BuyWin($db);
$getBuyWinOffers = $buywin->getBuyWinOffers();

if($getBuyWinOffers === false) {
    header("location: ".BASE_URL."dashboard");
    die;
}
else if(!isset($_REQUEST['offerReference'])) {
    $_SESSION['formErrorMessage'] = $language->unexpected_error;
    header("location: ".BASE_URL."dashboard");
    die;
}

$offerInfo = $buywin->getBuyWinPackageByReference($_REQUEST['offerReference']);
$promoReward = json_decode($offerInfo->reward);
$promoRange = json_decode($offerInfo->promoRange);

if($offerInfo === false) {
    $_SESSION['formErrorMessage'] = $language->promo_not_found;
    header("location: ".BASE_URL."dashboard");
    die;
} else if($offerInfo->isActive == 'inactive') {
    $_SESSION['formErrorMessage'] = $language->promo_not_found;
    header("location: ".BASE_URL."dashboard");
    die;
} else if(isset($promoRange->expired)) {
    $_SESSION['formErrorMessage'] = $language->promo_expired;
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

                    <div class="row">

                        <div class="col-md-12">
                            <?php echo $utility->displayFormError(); ?>

                            <div class="main-card mb-3 card">
                                <div class="card-header">
                                    <b><?php echo PAGE_NAME ; ?></b>
                                </div>
                                <div class="card-body">
                                    <form method="post" action="<?php echo BASE_URL;?>controllers/buywin.php">
                                        <div class="row">
                                            <div class="col-md-6 mb-2">
                                                <label>Product</label>
                                                <input type="text" value="<?php echo $offerInfo->promoType;?>" class="form-control" disabled />
                                                <input type="hidden" class="form-control" name="offerReference" value="<?php echo $_REQUEST['offerReference']; ?>" />
                                            </div>

                                            <div class="col-md-6 mb-2">
                                                <label>Selling Price</label>
                                                <input type="text" value="<?php echo CURRENCY.number_format($offerInfo->amount, 2);?>" class="form-control" disabled />
                                            </div>

                                            <div class="col-md-6 mb-2">
                                                <label>Reward (<em>You might Win</em>)</label>
                                                <input type="text" value="<?php echo $promoReward->reward;?>" class="form-control" disabled />
                                            </div>

                                            <div class="col-md-6 mb-2">
                                                <label>Mobile Number</label>
                                                <input type="text" class="form-control mobileNo" name="mobileNo" maxlength="11" minlength="11" />
                                            </div>

                                            <div class="col-md-12 mb-2">
                                                <?php echo $utility->loadTransactionPinInput(); ?>
                                            </div>
                                        </div>
                                        
                                        <button class="mt-1 btn btn-primary activateBuyWin" name="activateBuyWin" type="submit">
                                            <b><i class="fa fa-paper-plane"></i> Buy Package</b>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

<?php include_once COMPONENT_DIR."footer_script.php"; ?> 
<script>
    $(".mobileNo").keyup(() => {
        if($(".mobileNo").val().length < 11 || $(".mobileNo").val().length > 11) {
            showTxPin(false);
        } else {
            showTxPin(true);
        }
    })
    
    var load_form = true; //Should form load...?

    $(".activateBuyWin").click(function(e) {
        e.preventDefault();
        if (load_form) {
            if($(".mobileNo").val() == "" || $(".pin").val() == "") {
                swal.fire({
                    icon: "info",
                    html: "Please fill all filed before proceeding",
                    title: "Missing field",
                    allowOutsideClick: false
                })
            }
            else if($(".pin").val() < 4) {
                swal.fire({
                    icon: "info",
                    html: "Incorrect transaction pin",
                    title: "Incorrect",
                    allowOutsideClick: false
                })
            }
            else {
                var promoName = "<?php echo $offerInfo->promoType;?>";
                var promoAmount = "<?php echo $offerInfo->amount;?>";
                var promoReward = "<?php echo $promoReward->reward;?>";
                var mobileNo = $(".mobileNo").val();
                
                var form = $(this).parents('form');

                swal.fire({
                    icon: "question",
                    html: "You are about to participate in the Ongoing Buy & Win Promo offer for "+promoName+"<br> Buy "+promoName+" for "+mobileNo+" and stand a chance to win "+promoReward+"<br> Proceed ?",
                    title: "Confirm",
                    allowOutsideClick: false,
                    showCancelButton: true,
                    showLoaderOnConfirm: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.append("<input type='hidden' name='activateBuyWin'/>");
                        form.submit();
                        $(".activateBuyWin").html("Please wait <i class='fa fa-spinner fa-spin'></i>").prop("disabled", true);
                    }
                });
            }
        }
        return false;
    });
</script>
<?php include_once INCLUDES_DIR."sweetalert.php"; ?>