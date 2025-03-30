$(document).ready(function() {
    $('.btn-outline-warning.edit').click(function() {
        $('#editModal').modal('show');

    });

    $('#saveBtn').click(function() {
        $('#ModalUP').modal('hide');
    });

    $('#cancelBtn').click(function() {
        $('#ModalUP').modal('hide');
    });

});