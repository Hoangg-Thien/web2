$(document).ready(function() {
    // Biến lưu mã đơn hàng cần xóa
    let userLock = null;

    // Bắt sự kiện click nút xóa
    $('.btn.lock').click(function() {
        // Lấy mã đơn hàng từ dòng tương ứng
        let row = $(this).closest('tr');
        userLock = row.find('td:first').text(); // Lấy mã đơn hàng ở cột đầu tiên

        // Cập nhật nội dung modal
        $('#ModalRL .modal-body').html(`
            Bạn có chắc chắn muốn khóa người dùng <strong>${userLock}</strong> này không?
        `);
        // Hiển thị modal
        $('#ModalRL').modal('show');
    });

    $('#cancelBtn').click(function () {
        $('#ModalRL').modal('hide');
    });

    $('#saveBtn').click(function () {
        $('#ModalRL').modal('hide');
    });
});