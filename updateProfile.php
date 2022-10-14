<?php require "includes/session_check.php";
require_once MODEL_DIR . "Banks.php";
$banks = new Banks($db);

if (!empty($userInfo->userMeta->float_settings)) {
    $myFloatSettings = json_decode($userInfo->userMeta->float_settings);
}

?>

<div class="app-container app-theme-white body-tabs-shadow fixed-header fixed-sidebar">

    <?php include_once COMPONENT_DIR . 'topnav.php'; ?>

    <div class="app-main">

        <?php include_once "components/sidebar.php"; ?>

        <div class="app-main__outer">
            <div class="app-main__inner">
                <?php include_once COMPONENT_DIR . 'breadcrumb.php'; ?>

                <div class="row">

                    <div class="col-md-12">
                        <?php echo $utility->displayFormError(); ?>

                        <div class="main-card mb-3 card">
                            <div class="card-header">
                                <b><?php echo PAGE_NAME;?></b>
                            </div>
                            <div class="card-body">
                                <form class="" method="post" action="<?php echo BASE_URL; ?>controllers/user.php">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="position-relative form-group">
                                                <label class="">Full Name</label>
                                                <input class="form-control" value="<?php echo $userInfo->fullname; ?>" disabled>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="position-relative form-group">
                                                <label class="">Mobile Number</label>
                                                <input class="form-control mobile_no" value="<?php echo $userInfo->mobile_no; ?>" disabled>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="position-relative form-group">
                                                <label class="">Email Address</label>
                                                <input class="form-control email" value="<?php echo $userInfo->email; ?>" name="email" type="email" required>
                                            </div>
                                        </div>
                                    </div>

                                    <button class="mt-1 btn btn-primary updateProfile" name="updateProfile" type="submit">
                                        <b><i class="fa fa-paper-plane"></i> Update Profile</b>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div class="main-card mb-3 card">
                            <div class="card-header">
                                <b>Float Settings</b>
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
                                                <small class="text-success float-right"><?php echo CURRENCY . number_format($userInfo->userMeta->wallets->float_wallet, 2) ?></small>
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

<?php include_once COMPONENT_DIR . "footer_script.php"; ?>

<script>
    var load_form = true; //Should form load...?

    // vending of Airtime...
    $(".updateProfile").click(function(e) {
        e.preventDefault();

        var email = $(".email").val();
        var mobile_no = $(".mobile_no").val();

        if (load_form) {

            if (email == '' || mobile_no == '') {
                swal.fire({
                    icon: "info",
                    html: "Please fill all filed before proceeding",
                    title: "Missing field",
                    allowOutsideClick: false
                })
            } else if (mobile_no.length < 11 || mobile_no.length > 11) {
                swal.fire({
                    icon: "info",
                    html: "Please enter a valid mobile number",
                    title: "Missing field",
                    allowOutsideClick: false
                })
            } else {

                var form = $(this).parents('form');

                swal.fire({
                    icon: "question",
                    html: "You are about to modify your profile. Action is irreversible",
                    title: "Modify Profile",
                    allowOutsideClick: false,
                    showCancelButton: true,
                    showLoaderOnConfirm: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.append("<input type='hidden' name='updateProfile'/>");
                        form.submit();
                        $(".updateProfile").html("Please wait <i class='fa fa-spinner fa-spin'></i>").prop("disabled", true);
                    }
                });

            }
        }
        return false;
    })

    $('#sellOnFloat').on('change', function(e) {
        if ($(this).is(":checked")) {
            $('#amount').parent('div').removeClass('d-none');
        } else {
            $('#amount').parent('div').addClass('d-none');
        }
    })
</script>

<?php include_once INCLUDES_DIR . "sweetalert.php"; ?>