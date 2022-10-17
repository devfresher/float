<?php require "includes/session_check.php"; 
require_once MODEL_DIR."Ticket.php";
$ticket = new Ticket($db);
if(!isset($_REQUEST['tid'])) {
    header("location: ".BASE_URL."createTicket");
    exit;
}
$getTicket = $ticket->getTicketByReference($_REQUEST['tid']);
$reference = substr($_REQUEST['tid'],0,4).'-'. substr($_REQUEST['tid'],4,4). '-'. substr($_REQUEST['tid'],8,4);

//for getting ticket replies...
$ticketReplies = $ticket->getTicketReplyByReference($_REQUEST['tid']);
?>

<title>Ticket #<?php echo $reference;?> - <?php echo $getTicket->subject;?> - <?php echo 111;?></title>

<div class="app-container app-theme-white body-tabs-shadow fixed-header fixed-sidebar">

    <?php include_once COMPONENT_DIR.'topnav.php'; ?>

    <div class="app-main">

        <?php include_once "components/sidebar.php";?>

        <div class="app-main__outer">
            <div class="app-main__inner">
                <?php include_once COMPONENT_DIR."breadcrumb.php";
                echo $utility->displayFormError() ; ?>
                <h4><b><?php echo $getTicket->subject;?></b></h4>

                <div class="main-card mb-3 card">
                    <div class="card-header">
                        <div class="media flex-wrap w-100 align-items-center">
                            <img style="width: 40px; height: auto" src="<?php echo BASE_URL;?>assets/images/avatars/default-avatar.png" class="d-block ui-w-40 rounded-circle" alt="" />
                            <div class="media-body ml-3">
                                <a href="javascript:void(0)"><?php echo $user->getUserById($getTicket->creator_id)->fullname;?></a>
                                <div class="text-muted small"><div class="badge badge-primary">Creator</div></div>
                            </div>
                            <div class="text-muted small ml-3">
                                <div><strong><?php echo $utility->niceDateFormat($getTicket->date_created); ?></strong></div>
                                <div><strong>1,234</strong> replies</div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <?php echo nl2br($getTicket->ticket_content);?>
                    </div>
                </div>

                <?php if ($ticketReplies != NULL) {
                    foreach($ticketReplies as $ticketReply) { ?>
                        <div class="main-card mb-3 card">
                            <div class="card-header">
                                <div class="media flex-wrap w-100 align-items-center">
                                    <img style="width: 40px; height: auto" src="<?php echo BASE_URL;?>assets/images/avatars/default-avatar.png" class="d-block ui-w-40 rounded-circle" alt="" />
                                    <div class="media-body ml-3">
                                        <a href="javascript:void(0)"><?php echo $ticketReply['user']->fullname; ?></a>
                                        <div class="text-muted small"><div class="badge badge-primary">Reply</div></div>
                                    </div>
                                    <div class="text-muted small ml-3">
                                        <div><strong><?php echo $utility->niceDateFormat($ticketReply["date_created"]); ?></strong></div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <?php echo nl2br($ticketReply["message"]);?>
                            </div>
                        </div>

                    <?php }
                } ?>

                <div class="main-card mb-3 card">
                    <div class="card-footer">
                        <div class="col-md-12">
                            <form method="post" action="<?php echo BASE_URL;?>controllers/ticket.php">
                                <textarea class="form-control form-control-lg" rows="3" name="replyTxt"></textarea>
                                <input type="hidden" value="<?php echo $_REQUEST['tid']; ?>" name="ticketReference" />
                                <button class="mt-1 btn btn-primary addReply" name="addReply" type="submit">
                                    <b><i class="fa fa-plus"></i> Add Reply</b>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include_once COMPONENT_DIR."footer_script.php"; include_once INCLUDES_DIR."sweetalert.php"; ?>