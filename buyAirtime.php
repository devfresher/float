<?php require "includes/session_check.php"; ?>
<div class="app-container app-theme-white body-tabs-shadow fixed-header fixed-sidebar">

    <?php include_once COMPONENT_DIR . 'topnav.php'; ?>
    <div class="app-main">

        <?php include_once "components/sidebar.php"; ?>

        <div class="app-main__outer">
            <div class="app-main__inner">
                <?php include_once COMPONENT_DIR . 'breadcrumb.php'; ?>
                <div style="margin-top: 2%; margin-bottom: 2%;" align="center"><img src="assets/images/mtn.jpg" width="120px"></div><br/>
                <div class="row">
                    <div class="col-md-12">
                        <div class="main-card mb-3 card">
                            <div class="card-header">
                                <b><?php echo PAGE_NAME; ?></b>
                            </div>
                            <div class="card-body">
                                <form class="buyairtime" method="post" action="#">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="position-relative form-group">
                                                <label class="">Phone number</label>
                                                <input class="form-control" name="userPhone" minlength="11" maxlength="11" required>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="position-relative form-group">
                                                <label class="">Amount</label>
                                                <input class="form-control" name="amount" required>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="position-relative form-group">
                                                <label class="">Payable Amount</label>
                                                <input class="form-control" name="payable" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="mt-1 btn btn-primary shareFloat" name="shareFloat" type="submit">
                                        <b><i class="fa fa-paper-plane"></i> Purchase </b>
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


<script src="https://topupsocket.com/gift/assets/scripts/jquery-3.3.1.min.js" type="text/javascript"></script>
<script type="text/javascript" src="assets/scripts/main.d810cf0ae7f39f28f336.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.0/dist/sweetalert2.all.min.js"></script>

<script>
    function showTxPin(isShow = false) {
        if(isShow) {
            $(".transctPinDiv").removeClass('d-none');
        }
        else {
            $(".transctPinDiv").addClass('d-none');
        }
    }
</script>
<script>
    const selfPhoneNo = "08129871451"

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
                url: "https://topupsocket.com/gift/api/user",
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
                    html: "You are about to share float worth &#8358;"+amount+" to "+userName,
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


</body>


</html>