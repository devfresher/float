<?php require "includes/session_check.php";
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
                                <b><?php echo PAGE_NAME; ?></b>
                            </div>
                            <div class="card-body">
                                <form class="" method="post" action="<?php echo BASE_URL; ?>controllers/wallet.php">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="position-relative form-group">
                                                <label class="">Amount</label>
                                                <small class="float-right">
                                                    <strong>Main Balance: </strong>
                                                    <span class="text-success">
                                                        <?php echo CURRENCY . number_format($userInfo->userMeta->wallets->main_wallet, 2) ?>
                                                    </span>
                                                </small>
                                                <input id="amount" class="form-control amount" name="amount" type="number" step="0.1" min="1" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="position-relative form-group">
                                                <label>Receiver's Phone Number</label>
                                                <input class="form-control userPhone" name="userPhone" minlength="11" maxlength="11">
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

                                    <button class="mt-1 btn btn-primary shareMoney" name="shareMoney" type="submit" disabled>
                                        <b><i class="fa fa-paper-plane"></i> Proceed </b>
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
    const selfPhoneNo = "<?php echo $userInfo->mobile_no;?>"

    function enableButton() {
        let userPhone = $('.userPhone').val()
        let userName = $('.userName').val()
        let amount = $('.amount').val()
        let pin = $('.pin').val()

        if (userName != '' && userPhone != '' && amount != '' && pin != '') {
            $(".shareMoney").removeAttr('disabled')
        } else if (userName == '' || userPhone == '' || amount == '' || pin == '') {
            $(".shareMoney").attr('disabled', true)
        }
    }

    $(".userPhone").keyup(() =>{
        let userPhone = $(".userPhone").val();

        if(selfPhoneNo == userPhone) {
            $('.userName').parent().addClass('d-none')
            showTxPin(false);

            swal.fire({
                title: "Error",
                html: "You can not share float to yourself",
            })
        }
        else if(userPhone.length == 11) {
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
    
                    enableButton()
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    swal.close()
                    enableButton()
                }
            });
        } else {
            $('.userName').parent().addClass('d-none')
            showTxPin(false);
        }
    })

    $(".amount, .pin").keyup(() =>{
        enableButton()
    })

    var load_form = true;
    $(".shareMoney").click(function (e) {
        e.preventDefault();

        var amount = $(".amount").val();
        var userPhone = $(".userPhone").val();
        var transactPin = $(".pin").val();
        var userName = $(".userName").val();

        if (load_form) {

            if (amount == '' || amount == undefined || amount < 0 || userPhone == '' || transactPin == '') {
                swal.fire({
                    icon: "info",
                    html: "Please fill all filed before proceeding",
                    title: "Missing field",
                    allowOutsideClick: false
                })
            } else {
                var form = $(this).parents('form');

                swal.fire({
                    icon: "question",
                    html: "You are about to share wallet worth <?php echo CURRENCY;?>"+amount+" to "+userName,
                    title: "Confirm",
                    allowOutsideClick: false,
                    showCancelButton: true,
                    showLoaderOnConfirm: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.append("<input type='hidden' name='shareMoney'/>");
                        form.submit();
                        $(".shareMoney").html("Please wait <i class='fa fa-spinner fa-spin'></i>").prop("disabled", true);
                    }
                });

            }
        }
        return false;
    })

</script>

<?php include_once INCLUDES_DIR . "sweetalert.php"; ?>