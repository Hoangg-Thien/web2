$(document).ready(function() {
    // Xử lý sự kiện khi nhấn nút chỉnh sửa
    $('.btn.gear').click(function() {
        // Hiển thị modal chỉnh sửa
        $('#ModalUP').modal('show');
    });

    // Xử lý sự kiện khi nhấn nút "Lưu lại"
    $('#saveBtn').click(function() {
        $('#ModalUP').modal('hide');
    });

    // Xử lý sự kiện khi nhấn nút "Hủy bỏ"
    $('#cancelBtn').click(function() {
        // Chuyển về trang danh sách sản phẩm
        $('#ModalUP').modal('hide');
    });

});