<?php require "includes/session_check.php"; 
// print_r($userInfo);
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
                                <b>Update PIN</b>
                            </div>
                            <div class="card-body">
                                
                                <?php echo $utility->displayFormError(); ?>

                                <form class="" method="post" action="<?php echo BASE_URL;?>controllers/user.php">

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="position-relative form-group">
                                                <label class="">Current PIN</label>
                                                <input class="form-control currentPin" name="currentPin" type="password" minlength="4" maxlength="4" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-12">
                                            <div class="position-relative form-group">
                                                <label class="">New PIN</label>
                                                <input class="form-control newPin" name="newPin" type="password" minlength="4" maxlength="4" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-12">
                                            <div class="position-relative form-group">
                                                <label class="">Retype New PIN</label>
                                                <input class="form-control retypenewPin" name="retypenewPin" type="password" minlength="4" maxlength="4" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <button class="mt-1 btn btn-primary updatePIN" name="updatePIN" type="submit">
                                        <b><i class="fa fa-paper-plane"></i> Update PIN</b>
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
    var load_form = true; //Should form load...?

    // vending of Airtime...
    $(".updatePIN").click(function(e) {
        e.preventDefault();

        var currentPin = $(".currentPin").val();
        var newPin = $(".newPin").val();
        var retypenewPin = $(".retypenewPin").val();

        if(load_form) {
				
            if(currentPin == '' || newPin == '' || retypenewPin == '') {
                swal.fire({
                    icon: "info",
                    html: "Please fill all filed before proceeding",
                    title: "Missing field",
                    allowOutsideClick: false
                })
            }
            else if(currentPin.length < 4 || currentPin.length > 4 || newPin.length < 4 || newPin.length > 4 || retypenewPin.length < 4 || retypenewPin.length > 4) {
                swal.fire({
                    icon: "info",
                    html: "Transaction PIN should not be less or more than 4 digits",
                    title: "Error",
                    allowOutsideClick: false
                })
            }
            else {

                var form = $(this).parents('form');
                
                swal.fire({
                    icon: "question",
                    html: "You are about to modify your transaction PIN. Action is irreversible",
                    title: "Modify PIN",
                    allowOutsideClick: false,
                    showCancelButton: true,
                    showLoaderOnConfirm: true
                }).then((result) => {
                    if (result.isConfirmed) { 
                        form.append("<input type='hidden' name='updatePIN'/>");
                        form.submit();
                        $(".updatePIN").html("Please wait <i class='fa fa-spinner fa-spin'></i>").prop("disabled", true);
                    }
                });

            }
        }
        return false;
    })
</script>

<?php include_once INCLUDES_DIR."sweetalert.php"; ?>