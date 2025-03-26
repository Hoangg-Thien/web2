$(document).ready(function() {
    // Biến lưu mã đơn hàng cần xóa
    let orderIdToDelete = null;

    // Bắt sự kiện click nút xóa
    $('.btn-outline-danger.trash').click(function() {
        // Lấy mã đơn hàng từ dòng tương ứng
        let row = $(this).closest('tr');
        orderIdToDelete = row.find('td:first').text(); // Lấy mã đơn hàng ở cột đầu tiên

        // Cập nhật nội dung modal
        $('#ModalRM .modal-body').html(`
            Bạn có chắc chắn muốn xóa đơn hàng <strong>${orderIdToDelete}</strong> này không?
        `);

        // Hiển thị modal
        $('#ModalRM').modal('show');
    });

    // Xử lý khi nhấn nút "Đồng Ý"
    $('#confirmDelete').click(function() {
// Chỉ đóng modal mà không thực hiện xóa
$('#ModalRM').modal('hide');
});
});