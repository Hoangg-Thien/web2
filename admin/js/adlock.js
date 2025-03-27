document.addEventListener('DOMContentLoaded', function() {
    // Lấy tất cả các nút khóa
    const lockButtons = document.querySelectorAll('.btn.lock');
    
    // Kiểm tra trạng thái khóa ban đầu và cập nhật giao diện
    document.querySelectorAll('tr[data-locked="true"]').forEach(row => {
        updateLockedRowAppearance(row);
    });
    
    lockButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Lấy hàng chứa nút được nhấn
            const row = this.closest('tr');
            const userName = row.cells[0].textContent;
            
            // Hiển thị modal xác nhận
            const modal = document.getElementById('ModalRL');
            modal.querySelector('.modal-body').innerHTML = `<p>Bạn có chắc chắn muốn khóa người dùng <strong>${userName}</strong> không?</p>`;
            $('#ModalRL').modal('show');
            
            // Lưu trữ hàng hiện tại để sử dụng trong sự kiện click của nút Đồng Ý
            modal.setAttribute('data-current-row', row.rowIndex);
        });
    });
    
    // Xử lý khi nhấn nút Đồng Ý trong modal khóa
    document.querySelector('#ModalRL #saveBtn').addEventListener('click', function() {
        // Lấy chỉ số hàng từ thuộc tính data
        const rowIndex = document.getElementById('ModalRL').getAttribute('data-current-row');
        const table = document.querySelector('table');
        const row = table.rows[rowIndex];
        
        // Đánh dấu hàng bị khóa
        row.setAttribute('data-locked', 'true');
        
        // Cập nhật giao diện cho hàng bị khóa
        updateLockedRowAppearance(row);
        
        // Thông báo đã khóa thành công
        alert(`Người dùng ${row.cells[0].textContent} đã khóa thành công!`);
    });
    
    // Hàm cập nhật giao diện cho hàng bị khóa
    function updateLockedRowAppearance(row) {
        // Thay đổi màu và định dạng
        row.style.color = 'red';
        row.style.fontWeight = 'bold';
        
        // Vô hiệu hóa nút khóa và sửa
        const lockButton = row.querySelector('.btn.lock');
        
        if (lockButton) {
            lockButton.disabled = true;
        }
    }
});