<?php require "includes/session_check.php";
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
                                <b>Share Float Wallet</b>
                            </div>
                            <div class="card-body">
                                <form class="" method="post" action="<?php echo BASE_URL; ?>controllers/user.php">
                                    <div class="row">
                                        <div class="col-md-6">
                                             <div class="position-relative form-group 
                                                <?php echo isset($myFloatSettings) ? "" : "d-none" ?>">
                                                <label class="">Amount</label>
                                                <small class="float-right">
                                                    <strong>Sharable Balance: </strong>
                                                    <span class="text-success">
                                                        <?php echo CURRENCY . number_format($myFloatSettings->float_amount, 2) ?>
                                                    </span>
                                                </small>

                                                <input id="amount" class="form-control amount" name="amount" type="number" step="0.1" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="position-relative form-group">
                                                <label class="">Receiver's Phone number</label>
                                                <input class="form-control userPhone" name="user_phone">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="position-relative form-group d-none">
                                                <label class="">Receivers' Name</label>
                                                <input class="form-control userName" name="userName" type="text" disabled>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <?php echo $utility->loadTransactionPinInput() ?>
                                        </div>
                                    </div>

                                    <button class="mt-1 btn btn-primary shareFloat" name="shareFloat" type="submit" disabled>
                                        <b><i class="fa fa-paper-plane"></i> Send </b>
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
    
    // confirmation
    $(".shareFloat").click((e) =>{
        e.preventDefault();
        
        var load_form = true; //Should form load

        var amount = $(".amount").val();
        var userPhone = $(".userPhone").val();
        var userName = $(".userName").val();

        if (load_form) {

            if (amount == '' || userPhone == '' || userName == '') {
                swal.fire({
                    icon: "info",
                    html: "Fill up the required fields",
                    title: "Missing field",
                    allowOutsideClick: false
                })
            } else if (userPhone.length < 11 || userPhone.length > 11) {
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
                    html: "You are about to share your Float wallet to "+userName+". Action is irreversible",
                    title: "Share Float Wallet",
                    allowOutsideClick: false,
                    showCancelButton: true,
                    showLoaderOnConfirm: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.append("<input type='hidden' name='shareFloat'/>");
                        form.submit();
                        $(".shareFloat").html("Please wait <i class='fa fa-spinner fa-spin'></i>").prop("disabled", true);
                    }
                });

            }
        }
        return false;
    })

    function checkFields() {
        let userPhone = $('.userPhone').val()
        let userName = $('.userName').val()
        let amount = $('.amount').val()
        let pin = $('.pin').val()

        if (userName != '' && userPhone != '' && amount != '' && pin != '') {
            $(".shareFloat").removeAttr('disabled')
        } else if (userName == '' || userPhone == '' || amount == '' || pin == '') {
            $(".shareFloat").attr('disabled', true)
        }
    }

    $(".userPhone").focusout(() =>{
        let userPhone = $(".userPhone").val();
        $.ajax({
            type:'GET',
			url: "<?php echo BASE_URL ?>api/user",
			data: {
                phone: userPhone,
            },
            beforeSend: function () {
                swal.fire({
                    title: "Fetching User",
                    text: "Please wait",
                    didOpen: function() {
                        swal.showLoading()
                    }
                })
            },
            success: function(data){
                swal.close()
                if (data.error) {
                    $('.userName').parent().addClass('d-none')
                    showTxPin(false);

                    swal.fire({
                        title: "Error",
                        html: data.error,
                    })
                } else {
                    $('.userName').parent().removeClass('d-none')
                    $('.userName').val(data.data.fullname)
                    showTxPin(true);
                }

                checkFields()
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                swal.close()
                checkFields()
            }
		});
    })

    $(".amount, .pin").keyup(() =>{
        checkFields()
    })
</script>

<?php include_once INCLUDES_DIR . "sweetalert.php"; ?>