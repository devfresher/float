<?php require "includes/session_check.php"; ?>

    <div class="app-container app-theme-white body-tabs-shadow fixed-header fixed-sidebar">
        
        <?php include_once COMPONENT_DIR.'topnav.php'; ?>
        
        <div class="app-main">
            
            <?php include_once "components/sidebar.php";?>

            <div class="app-main__outer">
                <div class="app-main__inner">
                    <?php include_once COMPONENT_DIR."breadcrumb.php"; ?>

                </div>
            </div>
        </div>
    </div>
    

<?php include_once COMPONENT_DIR."footer_script.php"; include_once INCLUDES_DIR."sweetalert.php"; ?>