document.addEventListener('DOMContentLoaded', function() {
    const editButtons = document.querySelectorAll('.btn-outline-warning');
    
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const row = this.closest('tr');
            const billId = row.querySelector('td:first-child').textContent;
            
            // Gọi API để lấy thông tin chi tiết hóa đơn
            fetch(`api/getOrderDetail.php?bill_id=${billId}`)
                .then(response => response.json())
                .then(result => {
                    if (!result.success) {
                        alert(result.message);
                        return;
                    }
                    
                    const data = result.data;
                    
                    // Điền thông tin vào modal
                    document.querySelector('#ModalUP input[name="bill_id"]').value = data.bill_id;
                    document.querySelector('#ModalUP input[name="customer_name"]').value = data.fullname;
                    document.querySelector('#ModalUP input[name="address"]').value = data.address;
                    document.querySelector('#ModalUP input[name="total_amount"]').value = data.total_amount;
                    document.querySelector('#ModalUP input[name="status"]').value = data.status;
                    
                    // Hiển thị modal
                    $('#ModalUP').modal('show');
                })
                .catch(error => {
                    console.error('Lỗi:', error);
                    alert('Có lỗi xảy ra khi lấy thông tin hóa đơn');
                });
        });
    });

    document.querySelector('#saveBtn').addEventListener('click', function() {
        $('#ModalUP').modal('hide');
    });
});