document.addEventListener('DOMContentLoaded', function() {
    // Lấy tất cả các nút sửa
    const editButtons = document.querySelectorAll('.btn.gear');
    
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Lấy thông tin từ hàng chứa nút được nhấn
            const row = this.closest('tr');
            
            // Kiểm tra xem người dùng có bị khóa không
            const isLocked = row.getAttribute('data-locked') === 'true';
            
            const userData = {
                username: row.cells[0].textContent,
                fullName: row.cells[1].textContent,
                address: row.cells[2].textContent,
                email: row.cells[3].textContent,
                role: row.cells[4].textContent,
                status: isLocked ? 'Đã khóa' : 'Hoạt động'
            };

            // Điền thông tin vào modal
            const modal = document.getElementById('ModalUP');
            modal.querySelector('input[placeholder="Nhập tên người dùng"]').value = userData.username;
            modal.querySelector('input[placeholder="Nhập họ và tên"]').value = userData.fullName;
            modal.querySelector('input[placeholder="Nhập địa chỉ"]').value = userData.address;
            modal.querySelector('input[placeholder="Nhập email"]').value = userData.email;
            modal.querySelector('input[placeholder="Nhập vai trò"]').value = userData.role;
            modal.querySelector('input[placeholder="Trạng thái"]').value = userData.status;
            
            // Lưu trữ hàng hiện tại để sử dụng trong sự kiện lưu
            modal.setAttribute('data-current-row', row.rowIndex);

            $('#ModalUP').modal('show');
        });
    });

    // Xử lý sự kiện khi nhấn nút Lưu
    document.getElementById('saveBtn').addEventListener('click', function() {
        // Lấy giá trị từ các trường input
        const modal = document.getElementById('ModalUP');
        const newData = {
            username: modal.querySelector('input[placeholder="Nhập tên người dùng"]').value,
            fullName: modal.querySelector('input[placeholder="Nhập họ và tên"]').value,
            address: modal.querySelector('input[placeholder="Nhập địa chỉ"]').value,
            email: modal.querySelector('input[placeholder="Nhập email"]').value,
            role: modal.querySelector('input[placeholder="Nhập vai trò"]').value
        };

        // Ở đây bạn có thể thêm code để cập nhật dữ liệu vào database
        console.log('Dữ liệu cập nhật:', newData);
            
        $('#ModalUP').modal('hide');
    });
});