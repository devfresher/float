<?php require "includes/session_check.php";
$walletFundingInfo = json_decode($allSettings->wallet_funding_info);
$bankingInfo = json_decode($allSettings->banking_info);
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
                                    <div class="col-md-12">
                                        <div class="position-relative form-group">
                                            <label class="">Amount</label>
                                            <input id="amount" class="form-control amount" name="amount" type="number" step="0.1" min="1" required>
                                        </div>
                                        <p class="text-dark">
                                            <strong class="text-danger">NOTE: </strong> Minimum wallet funding is <?php echo CURRENCY.number_format($walletFundingInfo->min_wallet_fund, 2);?>
                                        </p>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="position-relative form-group">
                                            <label for="paytype">Select Payment Method</label>
                                            <select name="paytype" id="paytype" class="form-control">
                                                <option value="">---</option>
                                                <option value="auto_funding"> Auto Funding </option>
                                                <option value="manual_funding"> Manual Funding </option>
                                            </select>
                                        </div>
                                        <p class="text-dark d-none" id="man_fund_div">
                                            <strong class="text-danger">NOTE: </strong> Manual funding attracts <?php echo CURRENCY.number_format($walletFundingInfo->stamp_duty_amount, 2);?> on payment above <?php echo CURRENCY.number_format($walletFundingInfo->stamp_duty_limit, 2);?> and you must contact Admin for approval
                                        </p>
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <div class="position-relative form-group d-none" id="payOpt_div">
                                            <label><b>Select Payment Option:</b></label>
                                            <select name="payOpt" id="payOpt" class="form-control input-sm">
                                                <option value="">---</option>
                                                <option value="pay_ussd">Pay with Your Bank USSD</option>
                                                <option value="pay_wema">Pay with WEMA BANK Account</option>
                                            </select>
                                        </div>

                                        <p class="text-dark d-none" id="pay_bank_div">
                                            <strong class="text-danger">NOTE: </strong> This option is suitable for customers who has account with any of the below listed banks; 
                                            <strong>Alat by WEMA, GTB, Kuda, UBA and Zenith</strong>
                                        </p>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="position-relative form-group">
                                            <label class="">Amount to be Credited </label>
                                            <input id="toCredit" class="form-control toCredit" value="0" name="toCredit" disabled>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <button class="mt-1 btn btn-primary fundWallet" name="fundWallet" type="submit" disabled>
                                            <b><i class="fa fa-paper-plane"></i> Proceed </b>
                                        </button>
                                    </div>
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
    $(document).ready(function() {
        function enableButton() {
            let paytype = $("#paytype").val();
        	let airAmnt = $("#amount").val();
            let toCredited = $("#toCredit").val();
            let paymentOption = $("#payOpt");

            if (paytype != '' && airAmnt != '' && toCredited != '') {
                $(".fundWallet").removeAttr('disabled')
            } else if (paytype == '' || airAmnt == '' || toCredited == '') {
                $(".fundWallet").attr('disabled', true)
            }
        }

        $("#paytype").on("change", function() {
        	let paytype = $(this).val();
        	let airAmnt = $("#amount").val();
        	let stampduty = 0;

            $("#toCredit").parent('div').removeClass('d-none')

            if (paytype == "auto_funding") {
                $("#payOpt_div").removeClass('d-none');
    		    $("#man_fund_div").addClass('d-none');
    		    $("#toCredit").val(airAmnt);
    		    $("#payOpt").attr("required");
            } 
            else if (paytype == "manual_funding") {
                $("#man_fund_div").removeClass('d-none');
        		$("#payOpt_div").addClass('d-none');
    		    $("#payOpt").removeAttr("required");

                let stampduty = <?php echo $walletFundingInfo->stamp_duty_amount;?>;
        		let stampdutyLimit = <?php echo $walletFundingInfo->stamp_duty_limit;?>;
        		let amntCredit = airAmnt - stampduty;

                if(amntCredit < 0 ) { 
                    amntCredit = 0; 
                } else if(airAmnt>0 && airAmnt >= stamp_amnt) {
                    amntCredit = amntCredit.toLocaleString(); 
                } else { 
                    amntCredit = airAmnt.toLocaleString(); 
                }
        		
        		$("#toCredit").val(amntCredit);
            }
            else { 
                $("#man_fund_div").addClass('d-none');
                $("#payOpt_div").addClass('d-none'); 
            }

            enableButton()
        });

        $("#payOpt").on("change", function() {
        	let payOpt = $(this).val();
        	
        	if(payOpt == "pay_bank") {
        		$("#pay_bank_div").removeClass('d-none');
        	} else {
                $("#pay_bank_div").addClass('d-none');
            }
        	
            enableButton()
        });

        $("#amount").on("change", function() {
            
        	let airAmnt = $(this).val();
        	let paytype = $("#paytype").val();
        	let stampduty = 0;
        	
        	if(paytype == "manual_funding") {

        		let stampduty = <?php echo $walletFundingInfo->stamp_duty_amount;?>;
        		let stampdutyLimit = <?php echo $walletFundingInfo->stamp_duty_limit;?>;
        		let amntCredit = airAmnt - stampduty;

                if(amntCredit < 0 ) { 
                    amntCredit = 0; 
                } else if(airAmnt>0 && airAmnt >= stamp_amnt) {
                    amntCredit = amntCredit.toLocaleString(); 
                } else { 
                    amntCredit = airAmnt.toLocaleString(); 
                }
        		
        		$("#toCredit").val(amntCredit);
        		
        	} else { 
                $("#toCredit").parent('div').removeClass('d-none')
                $("#toCredit").val(airAmnt);
                $("#payOpt").attr("required"); 
            }
        	
            enableButton()
        });
    });

</script>

<?php include_once INCLUDES_DIR . "sweetalert.php"; ?>