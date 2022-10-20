<?php require "includes/session_check.php"; 

if (!empty($userInfo->userMeta->float_settings)) {
    $myFloatSettings = json_decode($userInfo->userMeta->float_settings);
}
?>

<div class="app-container app-theme-white body-tabs-shadow fixed-header fixed-sidebar">

    <?php include_once COMPONENT_DIR.'topnav.php'; ?>

    <div class="app-main">

        <?php include_once "components/sidebar.php";?>

        <div class="app-main__outer">
            <div class="app-main__inner">
                <?php include_once COMPONENT_DIR.'breadcrumb.php'; ?>

                <div class="row">
                    <div class="col-md-12">

                        <div class="main-card mb-3 card">
                            <div class="card-header">
                                <b><?php echo PAGE_NAME;?></b>
                            </div>
                            <div class="card-body">

                                <form class="" method="post" action="<?php echo BASE_URL; ?>controllers/user.php">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="position-relative form-group">
                                                <input id="sellOnFloat" name="sell_on_float" type="checkbox" data-on="Yes" data-off="No" data-onstyle="success" data-offstyle="danger" <?php echo isset($myFloatSettings) ? "checked disabled" : "" ?>>
                                                <label for="sellOnFloat" class="form-check-label">Sell on float community?</label>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="position-relative form-group 
                                                <?php echo isset($myFloatSettings) ? "" : "d-none" ?>">
                                                <label class="">Amount</label>
                                                <small class="text-success float-right">Available Float: <?php echo CURRENCY . number_format($userInfo->userMeta->wallets->float_wallet, 2) ?></small>
                                                <input id="amount" class="form-control amount" name="amount" value="<?php echo isset($myFloatSettings) ? $myFloatSettings->float_amount : "" ?>" type="number" step="0.1" required <?php echo isset($myFloatSettings) ? "disabled" : "" ?>>
                                            </div>
                                        </div>
                                    </div>

                                    <button class="mt-1 btn btn-primary updateFloatSettings" name="updateFloatSettings" type="submit">
                                        <b><i class="fa fa-paper-plane"></i> Update Settings</b>
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
    

    $('#sellOnFloat').on('change', function(e) {
        if ($(this).is(":checked")) {
            $('#amount').parent('div').removeClass('d-none');
        } else {
            $('#amount').parent('div').addClass('d-none');
        }
    })
</script>

<?php include_once INCLUDES_DIR."sweetalert.php"; ?>