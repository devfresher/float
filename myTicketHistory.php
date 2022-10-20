<?php require "includes/session_check.php"; 
require_once MODEL_DIR."Ticket.php";
$ticket = new Ticket($db);
$userTickets = $ticket->getAllTickets($user->loggedInUser()->id);

// print_r($userTickets);

// die;

?>

<div class="app-container app-theme-white body-tabs-shadow fixed-header fixed-sidebar">

    <?php include_once COMPONENT_DIR.'topnav.php'; ?>

    <div class="app-main">

        <?php include_once "components/sidebar.php";?>

        <div class="app-main__outer">
            <div class="app-main__inner">
                <?php include_once COMPONENT_DIR."breadcrumb.php"; ?>


                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <table style="width: 100%" id="example" class="table table-hover" cellpadding="20">
                            <thead>
                                <tr>
                                    <th>Department</th>
                                    <th>Subject</th>
                                    <th>Status</th>
                                    <th>Last Updated</th>
                                </tr>
                            </thead>
                            <tbody style="font-size: 16px">
                                <?php 
                                if($userTickets != NULL) {

                                    foreach($userTickets as $ticketIndex => $ticketDetail) { 
                                        $reference = substr($ticketDetail['ticket_reference'],0,4).'-'. substr($ticketDetail['ticket_reference'],4,4). '-'. substr($ticketDetail['ticket_reference'],8,4);
                                    ?>
                                    <tr>
                                        <td><?php echo $ticket->getTicketCategoryById($ticketDetail['category_id'])->category_name; ?></td>
                                        <td>
                                            <!-- <?php echo $reference; ?> <br> -->
                                            <span class='text-success' style='font-size: 18px'><?php echo $ticketDetail['subject'];?></span> <br>
                                            <a href="<?php echo BASE_URL;?>viewticket?tid=<?php echo $ticketDetail['ticket_reference'];?>">Read Message</a>
                                        </td>
                                        <td><?php echo ucfirst($ticketDetail['status']); ?></td>
                                        <td><?php echo $utility->niceDateFormat($ticketDetail['date_updated']); ?></td>
                                    </tr>
                                    <?php }
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<?php include_once COMPONENT_DIR."footer_script.php"; include_once INCLUDES_DIR."sweetalert.php"; ?>