<?php require "includes/session_check.php";
    require_once MODEL_DIR."Ticket.php";
    $ticket = new Ticket($db);
    $ticketcategories = $ticket->getAllTicketCategory();

    $requestType = isset($_REQUEST['type']) ? $_REQUEST['type'] : NULL;
    echo $requestType;
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
                            <form method="POST" action="<?php echo BASE_URL;?>controllers/ticket.php">

                                <div class="col-md-12 mb-2">
                                    <div class="position-relative form-group">
                                        <label class="">Subject</label>
                                        <input class="form-control form-control-lg subject" name="subject" type="text" required>
                                    </div>
                                </div>
                                            
                                <div class="col-md-12 mb-2">
                                    <div class="position-relative form-group">
                                        <label class="">Select Category</label>
                                        <select class="form-control form-control-lg categoryId" name="categoryId" required>
                                            <option value="">-- Select ticket category --</option>
                                            <?php
                                            if($ticketcategories !== false) {
                                                foreach($ticketcategories as $ticketcategory) { ?>
                                                    <option value="<?php echo $ticketcategory['id'];?>"<?php echo ($requestType ==  $ticketcategory['shorthand'] ? "selected='selected'" :"") ;?>>
                                                        <?php echo $ticketcategory['category_name'] ;?>
                                                    </option>
                                                <?php }
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                                
                                <?php if(isset($_REQUEST['userId'])) { ?>
                                    <div class="col-md-12 mb-2">
                                        <div class="position-relative form-group">
                                            <label class="">Reporting</label>
                                            <input class="form-control form-control-lg" value="<?php echo $user->getUserById($_REQUEST['userId'])->fullname;?>" disabled>
                                            <input class="form-control form-control-lg" value="<?php echo $_REQUEST['userId'];?>" name="reportedId" type="hidden">
                                        </div>
                                    </div>
                                <?php } ?>
                                            
                                <div class="col-md-12 mb-2">
                                    <div class="position-relative form-group">
                                        <label class="">Message</label>
                                        <textarea class="form-control form-control-lg message" name="message" rows="5" required></textarea>
                                    </div>
                                </div>
                                            
                                <div class="col-md-12 mb-2">
                                    <button class="mt-1 btn btn-primary createTicket" name="createTicket" type="submit">
                                        <b><i class="fa fa-plus"></i> Create Ticket</b>
                                    </button>
                                </div>
                            </form>
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
    $(".createTicket").click(function(e) {
        e.preventDefault();

        var subject = $(".subject").val();
        var categoryId = $(".categoryId").val();
        var message = $(".message").val();

        if (load_form) {

            if (subject == '' || categoryId == '' || message == '') {
                swal.fire({
                    icon: "info",
                    html: "Please fill all filed before proceeding",
                    title: "Missing field",
                    allowOutsideClick: false
                })
            } else if (subject.length < 4) {
                swal.fire({
                    icon: "info",
                    html: "Subject title is too short",
                    title: "Missing field",
                    allowOutsideClick: false
                })
            } else if (message.length < 10) {
                swal.fire({
                    icon: "info",
                    html: "Message is too short",
                    title: "Missing field",
                    allowOutsideClick: false
                })
            } else {

                var form = $(this).parents('form');

                swal.fire({
                    icon: "question",
                    html: "You are about to create a ticket",
                    title: "Create Ticket,
                    allowOutsideClick: false,
                    showCancelButton: true,
                    showLoaderOnConfirm: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.append("<input type='hidden' name='createTicket'/>");
                        form.submit();
                        $(".createTicket").html("Please wait <i class='fa fa-spinner fa-spin'></i>").prop("disabled", true);
                    }
                });
            }
        }
        return false;
    })
    
</script>
<?php include_once INCLUDES_DIR."sweetalert.php"; ?>