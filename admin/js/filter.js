document.addEventListener('DOMContentLoaded', function() {
    // Xử lý cập nhật trạng thái đơn hàng
    const statusFlow = {
        'pending': ['confirmed', 'cancelled'],
        'confirmed': ['completed', 'cancelled'],
        'completed': [],
        'cancelled': []
    };
    
    // Biến để theo dõi trạng thái hiện tại của đơn hàng đang chỉnh sửa
    let currentOrderStatus = '';
    
    // Xử lý lọc theo tình trạng đơn hàng
    const statusFilter = document.getElementById('statusFilter');
    
    if (statusFilter) {
        statusFilter.addEventListener('change', function() {
            const selectedStatus = this.value;
            const tableRows = document.querySelectorAll('table tbody tr');
            
            tableRows.forEach(row => {
                const statusCell = row.querySelector('td:nth-child(6) span');
                if (!statusCell) return;
                
                let rowStatus = '';
                if (statusCell.classList.contains('pending')) {
                    rowStatus = 'pending';
                } else if (statusCell.classList.contains('completed')) {
                    rowStatus = 'completed';
                } else if (statusCell.classList.contains('cancelled')) {
                    rowStatus = 'cancelled';
                } else if (statusCell.classList.contains('shipping') || statusCell.classList.contains('confirmed')) {
                    rowStatus = 'confirmed';
                }
                
                console.log('Status:', rowStatus, 'Selected:', selectedStatus);
                
                if (selectedStatus === 'all' || rowStatus === selectedStatus) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
    
    function getStatusValue(statusText) {
        switch(statusText) {
            case 'Chưa xác nhận': return 'pending';
            case 'Đã xác nhận': return 'confirmed';
            case 'Giao thành công': return 'completed';
            case 'Đã hủy': return 'cancelled';
            default: return '';
        }
    }
    
    // Xử lý khi click vào nút chỉnh sửa đơn hàng
    const editButtons = document.querySelectorAll('.edit');
    
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const row = this.closest('tr');
            const statusCell = row.querySelector('td:nth-child(6) span');
            
            if (statusCell) {
                currentOrderStatus = getStatusValue(statusCell.textContent.trim());
                
                // Cập nhật các trạng thái có thể chuyển đổi trong modal
                updateAvailableStatuses(currentOrderStatus);
            }
        });
    });
    
    // Cập nhật các trạng thái có thể chuyển đổi
    function updateAvailableStatuses(status) {
        // Lấy element chứa trạng thái trong modal
        const statusInput = document.querySelector('#ModalUP input[name="status"]');
        
        if (statusInput) {
            // Tạo một select thay thế input
            const selectElement = document.createElement('select');
            selectElement.name = 'status';
            selectElement.className = 'form-control';
            
            // Thêm trạng thái hiện tại
            const currentOption = document.createElement('option');
            currentOption.value = status;
            currentOption.textContent = getStatusText(status);
            currentOption.selected = true;
            selectElement.appendChild(currentOption);
            
            // Thêm các trạng thái có thể chuyển đổi
            if (statusFlow[status]) {
                statusFlow[status].forEach(nextStatus => {
                    const option = document.createElement('option');
                    option.value = nextStatus;
                    option.textContent = getStatusText(nextStatus);
                    selectElement.appendChild(option);
                });
            }
            
            // Thay thế input bằng select
            statusInput.parentNode.replaceChild(selectElement, statusInput);
        }
    }
    
    // Hàm chuyển đổi giá trị status sang text tiếng Việt
    function getStatusText(status) {
        switch(status) {
            case 'pending': return 'Chưa xác nhận';
            case 'confirmed': return 'Đã xác nhận';
            case 'completed': return 'Giao thành công';
            case 'cancelled': return 'Đã hủy';
            default: return '';
        }
    }
    
    // Xử lý lưu trạng thái
    const saveBtn = document.getElementById('saveBtn');
    if (saveBtn) {
        saveBtn.addEventListener('click', function() {
            const statusSelect = document.querySelector('#ModalUP select[name="status"]');
            if (statusSelect) {
                const newStatus = statusSelect.value;
                const orderId = document.querySelector('#ModalUP input[name="bill_id"]').value;
                
                // Cập nhật UI
                const tableRows = document.querySelectorAll('table tbody tr');
                tableRows.forEach(row => {
                    const idCell = row.querySelector('td:first-child');
                    if (idCell && idCell.textContent.trim() === orderId) {
                        const statusCell = row.querySelector('td:nth-child(6) span');
                        if (statusCell) {
                            statusCell.textContent = getStatusText(newStatus);
                            
                            statusCell.className = 'status ' + newStatus;
                        }
                    }
                });
                
                // Ở đây có thể thêm code để gửi dữ liệu lên server
                console.log('Cập nhật trạng thái đơn hàng ' + orderId + ' thành ' + getStatusText(newStatus));
            }
        });
    }
})