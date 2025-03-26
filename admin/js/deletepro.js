$(document).ready(function() {
    // Đảm bảo modal luôn ở giữa màn hình
    function centerModal() {
        $(this).css('display', 'block');
        var $dialog = $(this).find(".modal-dialog"),
            offset = ($(window).height() - $dialog.height()) / 16,
            bottomMargin = parseInt($dialog.css('marginBottom'), 10);

        if (offset < bottomMargin) offset = bottomMargin;
        $dialog.css("margin-top", offset);
    }

    $('.modal').on('show.bs.modal', centerModal);
    $(window).on('resize', function() {
        $('.modal:visible').each(centerModal);
    });

    // Khi click vào nút xóa bất kỳ
    $('.trash').click(function() {
        // Lấy tên sản phẩm của dòng hiện tại
        var productName = $(this).closest('tr').find('td:nth-child(3)').text();
        var productCode = $(this).closest('tr').find('td:nth-child(2)').text();
        
        // Cập nhật nội dung modal với tên sản phẩm
        $('#ModalRM .modal-body').html(`
            <div class="alert alert-warning">
                <strong>Cảnh báo!</strong>
            </div>
            <p>Bạn có chắc chắn muốn xóa sản phẩm:</p>
            <h4><strong>${productName}</strong></h4>
            <small>Mã sản phẩm: ${productCode}</small>
        `);
        
        // Hiển thị modal
        $('#ModalRM').modal('show');
    });

    // Khi click nút "Đồng ý" trong modal
    $('#confirmDelete').click(function() {
        // Chỉ đóng modal mà không thực hiện xóa
        $('#ModalRM').modal('hide');
    });
});