
<script src="<?Php echo BASE_URL;?>assets/scripts/jquery-3.3.1.min.js" type="text/javascript"></script>
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