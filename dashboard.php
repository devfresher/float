<?php require "includes/session_check.php"; 
require_once MODEL_DIR."Banks.php";
$banks = new Banks($db);

$fullUserInfo = $userInfo;
$wallets = $userInfo->userMeta->wallets;
$monnify =  $userInfo->userMeta->monnify; ?>

    <div class="app-container app-theme-white body-tabs-shadow fixed-header fixed-sidebar">
        
        <?php include_once COMPONENT_DIR.'topnav.php'; ?>
        
        <div class="app-main">
            
            <?php include_once "components/sidebar.php";?>

            <div class="app-main__outer">
                <div class="app-main__inner">
                    <?php include_once COMPONENT_DIR.'breadcrumb.php'; ?>
                    
                    <div class="row">
                        <?php foreach($wallets as $headerIndex => $walletBalance) {
                            unset($wallets->monnify);
                            unset($wallets->plan_id);
                            unset($wallets->bankInfo);
                        ?>
                        
                            <div class="col-md-6 col-lg-3">
                                <div class="widget-chart widget-chart2 text-left mb-3 card-btm-border card-shadow-primary border-primary card card-custom-bg">
                                    <div class="widget-chat-wrapper-outer">
                                        <div class="widget-chart-content">
                                            <div class="widget-title opacity-5 text-uppercase"><?php echo ucwords(str_replace("_", " ", $headerIndex));?></div>
                                            <div class="widget-numbers mt-2 fsize-4 mb-0 w-100">
                                                <div class="widget-chart-flex align-items-center">
                                                    <div>
                                                        <?Php echo CURRENCY.number_format($walletBalance, 2); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php } 
                        foreach(json_decode($monnify, true) as $bankId => $accountNo) { ?>
                            
                            <div class="col-md-6 col-lg-3">
                                <div class="widget-chart widget-chart2 text-left mb-3 card-btm-border card-shadow-primary border-primary card card-custom-bg">
                                    <div class="widget-chat-wrapper-outer">
                                        <div class="widget-chart-content">
                                            <div class="widget-title opacity-5 text-uppercase"><?php echo $banks->getAutoBankByCode($bankId)->bank_name;?></div>
                                            <div class="widget-numbers mt-2 fsize-4 mb-0 w-100">
                                                <div class="widget-chart-flex align-items-center">
                                                    <div>
                                                        <?Php echo $accountNo; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    
                </div>
                
            </div>
        </div>
    </div>

<?php include_once COMPONENT_DIR."footer_script.php"; include_once INCLUDES_DIR."sweetalert.php"; ?>