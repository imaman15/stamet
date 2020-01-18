<!-- Bootstrap core JavaScript-->
<script src="<?= base_url('assets'); ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?= base_url('assets'); ?>/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="<?= base_url('assets'); ?>/js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<script src="<?= base_url('assets'); ?>/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets'); ?>/vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- custom scripts -->
<script>
    // Call the dataTables jQuery plugin
    $(document).ready(function() {
        $('#dataTable').DataTable();
        $(function() {
            $('[data-toggle="tooltip"]').tooltip();
        })
    });
</script>

<script>
    $('#checkme').click(function() {
        if ($(this).is(':checked')) {
            $('#btnsubmit').removeAttr('disabled');
        } else {
            $('#btnsubmit').attr('disabled', 'disabled');
        }
    });
</script>

<script>
    function numberOnly(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))

            return false;
        return true;
    }
</script>

<!-- custom scripts Jquery -->
<script>
    // File Browser
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });
</script>

