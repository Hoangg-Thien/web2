document.addEventListener('DOMContentLoaded', function() {
    // Xử lý cập nhật trạng thái đơn hàng
    const statusFlow = {
        'pending': ['shipping', 'cancelled'],
        'shipping': ['completed', 'cancelled'],
        'completed': [],
        'cancelled': []
    };
    
    // Biến để theo dõi trạng thái hiện tại của đơn hàng đang chỉnh sửa
    let currentOrderStatus = '';
    
    // Khi mở modal chỉnh sửa
    $('.edit').on('click', function() {
        const row = $(this).closest('tr');
        const statusCell = row.find('.status');
        
        // Xác định trạng thái hiện tại
        if (statusCell.hasClass('pending')) currentOrderStatus = 'pending';
        else if (statusCell.hasClass('shipping')) currentOrderStatus = 'shipping';
        else if (statusCell.hasClass('completed')) currentOrderStatus = 'completed';
        else if (statusCell.hasClass('canceled')) currentOrderStatus = 'cancelled';
        
        // Cập nhật dropdown trạng thái
        updateStatusDropdown(currentOrderStatus);
        
        // Đặt trạng thái hiện tại cho dropdown
        $('#orderStatusSelect').val(currentOrderStatus);
    });
    
    // Hàm cập nhật dropdown trạng thái
    function updateStatusDropdown(status) {
        const select = $('#orderStatusSelect');
        select.empty();
        
        // Thêm trạng thái hiện tại
        select.append(`<option value="${status}">${getStatusName(status)}</option>`);
        
        // Thêm các trạng thái có thể chuyển đến
        if (statusFlow[status]) {
            statusFlow[status].forEach(nextStatus => {
                select.append(`<option value="${nextStatus}">${getStatusName(nextStatus)}</option>`);
            });
        }
    }
    
    // Hàm lấy tên hiển thị của trạng thái
    function getStatusName(status) {
        switch(status) {
            case 'pending': return 'Chưa xử lí';
            case 'shipping': return 'Đang giao';
            case 'completed': return 'Giao thành công';
            case 'cancelled': return 'Đã hủy';
            default: return '';
        }
    }
    
    // Xử lý bộ lọc
    // 1. Bộ lọc trạng thái
    $('#statusFilter').on('change', function() {
        filterOrders();
    });
    
    // 2. Bộ lọc quận
    $('#districtSort').on('change', function() {
        sortDistricts();
    });
    
    // 3. Bộ lọc thời gian
    $('form').on('submit', function(e) {
        e.preventDefault();
        filterByDate();
    });
    
    // Hàm lọc theo trạng thái
    function filterOrders() {
        const status = $('#statusFilter').val();
        const rows = $('tbody tr');
        
        if (status === 'all') {
            rows.show();
        } else {
            rows.hide();
            rows.each(function() {
                const statusSpan = $(this).find('.status');
                if (statusSpan.hasClass(status)) {
                    $(this).show();
                }
            });
        }
    }
    
      // Thêm sự kiện cho bộ lọc địa điểm
      $('#locationFilter').on('change', function() {
        filterByLocation();
    });
    
    // Hàm lọc theo địa điểm
    function filterByLocation() {
        const location = $('#locationFilter').val();
        const rows = $('tbody tr');
        
        if (location === 'all') {
            rows.show();
        } else {
            rows.hide();
            rows.each(function() {
                const address = $(this).find('td:nth-child(3)').text();
                // Lọc theo tỉnh/thành phố được chọn
                if (address.includes(location)) {
                    $(this).show();
                }
            });
        }
    }
    
    // Xử lý phối hợp nhiều bộ lọc
    function applyAllFilters() {
        // Lưu trạng thái hiển thị ban đầu
        $('tbody tr').data('statusFilter', true);
        $('tbody tr').data('locationFilter', true);
        $('tbody tr').data('dateFilter', true);
        
        // Áp dụng bộ lọc trạng thái
        const status = $('#statusFilter').val();
        if (status !== 'all') {
            $('tbody tr').each(function() {
                const statusSpan = $(this).find('.status');
                if ((status === 'cancelled' && statusSpan.hasClass('canceled')) || 
                    statusSpan.hasClass(status)) {
                    $(this).data('statusFilter', true);
                } else {
                    $(this).data('statusFilter', false);
                }
            });
        }
        
        // Áp dụng bộ lọc địa điểm
        const location = $('#locationFilter').val();
        if (location !== 'all') {
            $('tbody tr').each(function() {
                const address = $(this).find('td:nth-child(3)').text();
                if (address.includes(location)) {
                    $(this).data('locationFilter', true);
                } else {
                    $(this).data('locationFilter', false);
                }
            });
        }
        
        // Hiển thị/ẩn dựa trên kết hợp các bộ lọc
        $('tbody tr').each(function() {
            if ($(this).data('statusFilter') && $(this).data('locationFilter') && $(this).data('dateFilter')) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }
    
    // Cập nhật các sự kiện để sử dụng hàm kết hợp lọc
    $('#statusFilter, #locationFilter').on('change', function() {
        applyAllFilters();
    });
    
    // Cập nhật form lọc theo ngày để sử dụng hàm kết hợp lọc
    $('form').on('submit', function(e) {
        e.preventDefault();
        
        const startDate = new Date($('#datein').val());
        const endDate = new Date($('#dateout').val());
        
        if (isNaN(startDate.getTime()) || isNaN(endDate.getTime())) {
            alert('Vui lòng chọn khoảng thời gian hợp lệ');
            return;
        }
        
        $('tbody tr').each(function() {
            const dateText = $(this).find('td:nth-child(7)').text().split('\n')[0];
            const parts = dateText.split('/');
            const orderDate = new Date(parts[2], parts[1] - 1, parts[0]);
            
            if (orderDate >= startDate && orderDate <= endDate) {
                $(this).data('dateFilter', true);
            } else {
                $(this).data('dateFilter', false);
            }
        });
        
        applyAllFilters();
    });
    
});