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
                                <b>Fund Wallet</b>
                            </div>
                            <div class="card-body">
                                <form class="" method="post" action="<?php echo BASE_URL; ?>controllers/float.php">
                                    <div class="col-md-12">
                                        <div class="position-relative form-group">
                                            <label class="">Amount</label>
                                            <input id="amount" class="form-control amount" name="amount" type="number" step="0.1" min="1" required>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="position-relative form-group">
                                            <label class="">Select Payment Method</label>
                                            <select class="form-control">
                                                <option> ... Select Payment Method ... </option>
                                                <option> Auto Funding </option>
                                                <option> Manual Funding </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="position-relative form-group">
                                            <label class="">Amount to be Credited </label>
                                            <input id="amount" class="form-control amount" name="amount" >
                                        </div>
                                    </div>

                                    <button class="mt-1 btn btn-primary shareFloat" name="shareFloat" type="submit" disabled>
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

    // $(".userPhone").focusout(() =>{
        
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
    
                    checkFields()
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    swal.close()
                    checkFields()
                }
            });
        } else {
            $('.userName').parent().addClass('d-none')
            showTxPin(false);
        }
    })

    $(".amount, .pin").keyup(() =>{
        checkFields()
    })
    
    var load_form = true; //Should form load...?

    // confirmation
    // $(".shareFloat").click((e) => {
    $(".shareFloat").click(function(e) {
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
            } else if (transactPin.length < 4 || transactPin.length > 4) {
                swal.fire({
                    icon: "info",
                    html: "Transaction pin should not be more or less than 4 digit length",
                    title: "Error",
                    allowOutsideClick: false
                })
            } else if (userPhone.length < 11 || userPhone.length > 11) {
                swal.fire({
                    icon: "info",
                    html: "Please enter a valid mobile number",
                    title: "Missing field",
                    allowOutsideClick: false
                })
            } else if (selfPhoneNo == userPhone) {
                swal.fire({
                    icon: "info",
                    html: "You can not share float to yourself",
                    title: "Missing field",
                    allowOutsideClick: false
                })
            } else {

                var form = $(this).parents('form');

                swal.fire({
                    icon: "question",
                    html: "You are about to share float worth <?php echo CURRENCY;?>"+amount+" to "+userName,
                    title: "Confirm",
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

</script>

<?php include_once INCLUDES_DIR . "sweetalert.php"; ?>