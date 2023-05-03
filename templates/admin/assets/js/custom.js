$(document).ready(function () {
    $(document).on('click', '#cf-delete', function () {
        var id = $(this).val();
        var name = $('#name-delete-' + id).text();
        var email = $('#email-delete-' + id).text();
        $('#id-delete').val(id);
        if (!email.trim()) {
            $('#msg-delete').text(name);
        } else {
            $('#msg-delete').text(name + ' - ' + email);
        }
    });
});
