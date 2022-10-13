<?php require "includes/session_check.php"; 
$userBank = isset($userInfo->userMeta->bankInfo) ? $userInfo->userMeta->bankInfo : NULL;
if($userBank != NULL) {
    $userBank = json_decode($userBank);
    $bankName = $userBank->bankName;
    $accountName = $userBank->accountName;
    $accountNo = $userBank->accountNo;
} else {
    $bankName = $accountName = $accountNo = '';
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
                                <b>Update Banking Information</b>
                            </div>
                            <div class="card-body">
                                
                                <?php echo $utility->displayFormError(); ?>

                                <form class="" method="post" action="<?php echo BASE_URL;?>controllers/user.php">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="position-relative form-group">
                                                <label class="">Full Name</label>
                                                <input class="form-control" value="<?php echo $userInfo->fullname;?>" disabled>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="position-relative form-group">
                                                <label class="">Username</label>
                                                <input class="form-control" value="<?php echo $userInfo->username;?>" disabled>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="position-relative form-group">
                                                <label class="">Bank Name</label>
                                                <input class="form-control bankName" value="<?php echo $bankName;?>" name="bankName" type="text" required>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-12">
                                            <div class="position-relative form-group">
                                                <label class="">Account Name</label>
                                                <input class="form-control accountName" value="<?php echo $accountName;?>" name="accountName" type="text" required>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-12">
                                            <div class="position-relative form-group">
                                                <label class="">Account Number</label>
                                                <input class="form-control accountNo" value="<?php echo $accountNo;?>" name="accountNo" type="text" minlength="10" maxlength="10" required>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <button class="mt-1 btn btn-primary updateBankInfo" name="updateBankInfo" type="submit">
                                        <b><i class="fa fa-paper-plane"></i> Update Banking Info</b>
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
    $(".updateBankInfo").click(function(e) {
        e.preventDefault();

        var bankName = $(".bankName").val();
        var accountName = $(".accountName").val();
        var accountNo = $(".accountNo").val();

        if(load_form) {
				
            if(bankName == '' || accountName == '' || accountNo == '') {
                swal.fire({
                    icon: "info",
                    html: "Please fill all filed before proceeding",
                    title: "Missing field",
                    allowOutsideClick: false
                })
            }
            else if(accountNo.length < 10 || accountNo.length > 10) {
                swal.fire({
                    icon: "info",
                    html: "Please enter a valid bank account number",
                    title: "Missing field",
                    allowOutsideClick: false
                })
            }
            else {

                var form = $(this).parents('form');
                
                swal.fire({
                    icon: "question",
                    html: "You are about to modify your banking information. Action is irreversible",
                    title: "Modify Profile",
                    allowOutsideClick: false,
                    showCancelButton: true,
                    showLoaderOnConfirm: true
                }).then((result) => {
                    if (result.isConfirmed) { 
                        form.append("<input type='hidden' name='updateBankInfo'/>");
                        form.submit();
                        $(".updateBankInfo").html("Please wait <i class='fa fa-spinner fa-spin'></i>").prop("disabled", true);
                    }
                });
            }
        }
        return false;
    })
</script>

<?php include_once INCLUDES_DIR."sweetalert.php"; ?>