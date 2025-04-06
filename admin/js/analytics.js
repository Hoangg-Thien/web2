document.addEventListener('DOMContentLoaded', function() {
    // Thiết lập giá trị mặc định cho ngày bắt đầu và kết thúc
    const today = new Date();
    const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
    
    document.getElementById('filter__date').valueAsDate = firstDay;
    document.getElementById('filter__dateout').valueAsDate = today;
    
    // Xử lý sự kiện submit form
    document.getElementById('filter-form').addEventListener('submit', function(e) {
        e.preventDefault();
        fetchStatistics();
    });
    
    // Tự động tải dữ liệu khi trang được tải
    fetchStatistics();
    
    function fetchStatistics() {
        const startDate = document.getElementById('filter__date').value;
        const endDate = document.getElementById('filter__dateout').value;
        
        if (!startDate || !endDate) {
            alert('Vui lòng chọn khoảng thời gian');
            return;
        }
        
        if (new Date(startDate) > new Date(endDate)) {
            alert('Ngày bắt đầu không được lớn hơn ngày kết thúc');
            return;
        }
        
        // Hiển thị vùng tổng quan
        document.getElementById('stats-overview').style.display = 'block';
        document.getElementById('summary-text').textContent = 'Đang tải dữ liệu...';
        
        // Hiển thị trạng thái đang tải trong bảng
        document.getElementById('top-customers-data').innerHTML = '<tr><td colspan="4" class="text-center">Đang tải dữ liệu...</td></tr>';
        document.getElementById('top-products-data').innerHTML = '<tr><td colspan="5" class="text-center">Đang tải dữ liệu...</td></tr>';
        
        // Gửi yêu cầu đến server
        const formData = new FormData();
        formData.append('start_date', startDate);
        formData.append('end_date', endDate);
        
        fetch('../pages/analyze_data.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayStatistics(data);
            } else {
                console.error('Lỗi:', data.error);
                alert('Có lỗi xảy ra khi tải dữ liệu');
            }
        })
        .catch(error => {
            console.error('Lỗi:', error);
            alert('Có lỗi xảy ra khi kết nối đến server');
        });
    }
    
    function displayStatistics(data) {
        // Hiển thị thông tin tổng quan
        const summaryText = `Từ ${formatDate(data.date_range.start)} đến ${formatDate(data.date_range.end)}: ${data.total_orders} đơn hàng, ${data.total_customers} khách hàng, tổng doanh thu ${formatCurrency(data.total_revenue)}`;
        document.getElementById('summary-text').textContent = summaryText;
        
        // Hiển thị danh sách 5 khách hàng có mức mua hàng cao nhất
        displayTopCustomers(data.customers);
        
        // Hiển thị danh sách sản phẩm bán chạy
        displayTopProducts(data.products);
        
        // Cập nhật biểu đồ
        updateChart(data);
    }
    
    function displayTopCustomers(customers) {
        const tableBody = document.getElementById('top-customers-data');
        let html = '';
        let totalAmount = 0;
        
        // Sắp xếp khách hàng theo tổng tiền mua giảm dần
        customers.sort((a, b) => b.total_amount - a.total_amount);
        
        if (customers.length === 0) {
            html = '<tr><td colspan="4" class="text-center">Không có dữ liệu</td></tr>';
        } else {
            customers.forEach(customer => {
                // Hiển thị các đơn hàng của khách hàng
                let orderLinks = '';
                customer.order_links.forEach(order => {
                    orderLinks += `<a href="${order.url}" target="_blank" class="btn btn-sm btn-info mr-1 mb-1">${order.id}</a> `;
                });
                
                html += `
                <tr>
                    <td>${customer.customer_name}</td>
                    <td>${customer.order_count}</td>
                    <td>${formatCurrency(customer.total_amount)}</td>
                    <td>${orderLinks}</td>
                </tr>`;
                
                totalAmount += customer.total_amount;
            });
        }
        
        tableBody.innerHTML = html;
        document.getElementById('total-amount').textContent = formatCurrency(totalAmount);
    }
    
    function displayTopProducts(products) {
        const tableBody = document.getElementById('top-products-data');
        let html = '';
        
        if (products.length === 0) {
            html = '<tr><td colspan="5" class="text-center">Không có dữ liệu</td></tr>';
        } else {
            // Hiển thị tối đa 10 sản phẩm bán chạy nhất
            const displayProducts = products.slice(0, 10);
            
            displayProducts.forEach(product => {
                // Hiển thị các đơn hàng chứa sản phẩm
                let orderLinks = '';
                product.order_links.forEach(order => {
                    orderLinks += `<a href="${order.url}" target="_blank" class="btn btn-sm btn-info mr-1 mb-1">${order.id}</a> `;
                });
                
                html += `
                <tr>
                    <td>${product.product_id}</td>
                    <td>${product.product_name}</td>
                    <td>${product.quantity_sold}</td>
                    <td>${formatCurrency(product.total_amount)}</td>
                    <td>${orderLinks}</td>
                </tr>`;
            });
        }
        
        tableBody.innerHTML = html;
    }
    
    function updateChart(data) {
        // Lấy dữ liệu cho biểu đồ (giả lập dữ liệu theo tháng)
        const ctx = document.getElementById('barChartDemo').getContext('2d');
        
        // Nếu đã có biểu đồ, hủy nó để tạo biểu đồ mới
        if (window.barChart) {
            window.barChart.destroy();
        }
        
        // Tạo biểu đồ mới
        window.barChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Doanh thu'],
                datasets: [{
                    label: 'Tổng doanh thu',
                    data: [data.total_revenue],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Doanh thu (VNĐ)'
                        }
                    }
                }
            }
        });
    }
    
    // Hàm hỗ trợ định dạng tiền tệ
    function formatCurrency(amount) {
        return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(amount);
    }
    
    // Hàm hỗ trợ định dạng ngày
    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('vi-VN');
    }
}); 