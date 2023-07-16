<?php

// Prevent direct access to file
if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}
?>

</div>
<!-- /.login-card-body -->
</div>
<!-- /.card -->
</div>
<!-- /.login-box -->


<!-- jQuery -->
<script src="<?php echo _WEB_HOST_ADMIN_TEMPLATE; ?>/assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo _WEB_HOST_ADMIN_TEMPLATE; ?>/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo _WEB_HOST_ADMIN_TEMPLATE; ?>/assets/js/adminlte.min.js"></script>

<script type="text/javascript">
    function getNewCaptcha() {
        $("#captcha-img img").attr("src", "<?php echo getAbsUrlAdmin('auth', 'captcha'); ?>&ver=" + (new Date()).getTime());
    }
</script>

</body>
</html>
