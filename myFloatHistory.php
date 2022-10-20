<?php require "includes/session_check.php"; 
require_once MODEL_DIR."Floats.php";
$floats = new Floats($db);
$myFloatHistories = $floats->userFloatHistory($userInfo->id, 10);
?>

<div class="app-container app-theme-white body-tabs-shadow fixed-header fixed-sidebar">

    <?php include_once COMPONENT_DIR.'topnav.php'; ?>

    <div class="app-main">

        <?php include_once "components/sidebar.php";?>

        <div class="app-main__outer">
            <div class="app-main__inner">
                <?php include_once COMPONENT_DIR."breadcrumb.php"; ?>

                <div class="main-card mb-3 card">
                    <div class="card-header">
                        <b><?php echo PAGE_NAME;?></b>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Old Balance</th>
                                        <th>Amount</th>
                                        <th>New Balance</th>
                                        <th>Remark</th>
                                        <th>Date Created</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if($myFloatHistories !== false) {
                                        $i = 1;
                                        foreach($myFloatHistories as $myFloatHistory) {
                                            $sellfloat_remark = json_decode($myFloatHistory['sellfloat_remark']);
                                            ?>
                                            <tr>
                                                <th scope="row"><?php echo $i ;?></th>
                                                <td><?php echo CURRENCY.number_format($myFloatHistory['old_balance'], 2);?></td>
                                                <td><?php echo CURRENCY.number_format($myFloatHistory['amount'], 2);?></td>
                                                <td><?php echo CURRENCY.number_format($myFloatHistory['new_balance'], 2);?></td>
                                                <td>
                                                    <?php 
                                                    $floatReceiver = NULL;
                                                    if($myFloatHistory['operation'] == 0) { 
                                                        $floatRemark = 'Sell Float Created';
                                                    } 
                                                    else {
                                                        $floatRemark = 'Float Shared';
                                                        $floatReceiver = $myFloatHistory['receiver']->fullname;
                                                    }
                                                    
                                                    echo $floatRemark;
                                                    if($floatReceiver != NULL) { ?>
                                                        <br><span class='text-success'><?php echo CURRENCY.number_format($sellfloat_remark->amount, 2);?> Float Sold to <?php echo $floatReceiver;?></span>
                                                    <?php } ?>
                                                </td>
                                                <td><?php echo $utility->niceDateFormat($myFloatHistory['date_created']) ?></td>
                                            </tr>
                                        
                                        <?php $i++; }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<?php include_once COMPONENT_DIR."footer_script.php"; include_once INCLUDES_DIR."sweetalert.php"; ?>