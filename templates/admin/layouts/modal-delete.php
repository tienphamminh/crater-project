<?php

$currentModule = getCurrentModule();
?>

<div class="modal fade" id="modal-delete">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Are You Sure?</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?php echo getAbsUrlAdmin($currentModule, 'delete'); ?>" method="post">
                <input type="hidden" name="id" id="id-delete">

                <div class="modal-body">
                    <p>Delete <?php echo rtrim($currentModule, 's'); ?>: <span id="msg-delete"></span></p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Delete</button>
                </div>
            </form>
        </div> <!-- /.modal-content -->
    </div> <!-- /.modal-dialog -->
</div> <!-- /.modal -->
