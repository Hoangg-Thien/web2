$(document).ready(function() {
    // Xử lý sự kiện khi nhấn nút chỉnh sửa
    $(document).on('click', '.btn-outline-warning.edit', function() {
        // Lấy ID sản phẩm từ thuộc tính data-id
        var productId = $(this).data('id');

        if (!productId) {
            console.error("Không tìm thấy ID sản phẩm!");
            return;
        }

        // Gọi API lấy dữ liệu sản phẩm
        fetch(`get_product.php?id=${productId}`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    console.error(data.error);
                    return;
                }

                // Hiển thị dữ liệu lên modal
                $('#product-code').val(data.product_id);
                $('#product-name').val(data.product_name);
                $('#product-price').val(data.product_price);
                $('#product-status').val(data.product_status);
                $('#product-type').val(data.product_type);
                $('#product-image').attr('src', `../img/${data.product_image}`);
                

                // Hiển thị modal chỉnh sửa
                $('#ModalUP').modal('show');
            })
            .catch(error => console.error("Lỗi:", error));
    });

    // Xử lý sự kiện khi nhấn nút "Lưu lại"
    $('#saveBtn').click(function() {
        // Đóng modal sau khi lưu
        $('#ModalUP').modal('hide');
    });

    // Xử lý sự kiện khi nhấn nút "Hủy bỏ"
    $('#cancelBtn').click(function() {
        // Đóng modal
        $('#ModalUP').modal('hide');
    });
});
