document.addEventListener('DOMContentLoaded', function() {
    // Lấy tất cả các nút mở khóa
    const unlockButtons = document.querySelectorAll('.btn.delete');
    
    unlockButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Lấy hàng chứa nút được nhấn
            const row = this.closest('tr');
            const userName = row.cells[0].textContent;
            
            // Kiểm tra xem người dùng có bị khóa không
            const isLocked = row.getAttribute('data-locked') === 'true';
            
            if (!isLocked) {
                alert('Người dùng này chưa bị khóa!');
                return;
            }
            
            // Hiển thị modal xác nhận
            const modal = document.getElementById('ModalRM');
            modal.querySelector('.modal-body').innerHTML = `<p>Bạn có chắc chắn muốn mở khóa người dùng <strong>${userName}</strong> không?</p>`;
            $('#ModalRM').modal('show');
            
            // Lưu trữ hàng hiện tại để sử dụng trong sự kiện click của nút Đồng Ý
            modal.setAttribute('data-current-row', row.rowIndex);
        });
    });
    
    // Xử lý khi nhấn nút Đồng Ý trong modal mở khóa
    const confirmUnlockButton = document.getElementById('confirmDelete');
    if (confirmUnlockButton) {
        confirmUnlockButton.addEventListener('click', function() {
            console.log('Nút Đồng Ý mở khóa được nhấn');
            
            // Lấy chỉ số hàng từ thuộc tính data
            const modal = document.getElementById('ModalRM');
            const rowIndex = modal.getAttribute('data-current-row');
            
            if (!rowIndex) {
                console.error('Không tìm thấy rowIndex');
                return;
            }
            
            const table = document.querySelector('table');
            const row = table.rows[rowIndex];
            
            if (!row) {
                console.error('Không tìm thấy hàng với chỉ số:', rowIndex);
                return;
            }
            
            // Đánh dấu hàng được mở khóa
            row.setAttribute('data-locked', 'false');
            
            // Khôi phục giao diện cho hàng đã mở khóa
            restoreUnlockedRowAppearance(row);
            
            // Thông báo đã mở khóa thành công
            alert(`Người dùng ${row.cells[0].textContent} đã được mở khóa thành công!`);
            
            // Đóng modal
            $('#ModalRM').modal('hide');
        });
    } else {
        console.error('Không tìm thấy nút confirmOpen');
    }
    
    // Hàm khôi phục giao diện cho hàng đã mở khóa
    function restoreUnlockedRowAppearance(row) {
        row.style.color = '';
        row.style.fontWeight = '';
        
        const lockButton = row.querySelector('.btn.lock');
        const editButton = row.querySelector('.btn.gear');
        
        if (lockButton) {
            lockButton.disabled = false;
            lockButton.style.opacity = '1';
            lockButton.style.cursor = 'pointer';
        }
        
        if (editButton) {
            editButton.disabled = false;
            editButton.style.opacity = '1';
            editButton.style.cursor = 'pointer';
        }
    }
});