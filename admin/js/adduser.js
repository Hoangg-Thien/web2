$(document).ready(function () {
    // Hiển thị modal khi nhấn nút "Thêm mới"
    $('.btn.green1').click(function () {
        $('#ModalKP').modal('show');
    });

       // Đóng modal khi nhấn "Hủy bỏ"
       $('#cancelBtn').click(function () {
        $('#ModalKP').modal('hide');
    });

    // Đóng modal khi nhấn "Lưu lại"
    $('#saveBtn').click(function () {
        $('#ModalKP').modal('hide');
    });

});
