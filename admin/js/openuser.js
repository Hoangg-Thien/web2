   // Lấy tất cả các nút xóa
   const deleteButtons = document.querySelectorAll('.btn.delete');
        
   deleteButtons.forEach(button => {
       button.addEventListener('click', function(event) {
           event.preventDefault();

           // Xác định hàng chứa nút xóa
           const rowToDelete = this.closest('tr');
           const userName = rowToDelete.querySelector('td').innerText; // Giả định tên người dùng nằm ở ô đầu tiên

           // Cập nhật nội dung modal với tên người dùng
           $('#ModalRM .modal-body').html(`
            Bạn có chắc chắn muốn mở khóa người dùng <strong>${userName}</strong> này không?
        `);

           // Hiển thị modal
           $('#ModalRM').modal('show');

           // Xử lý khi người dùng xác nhận xóa
           document.getElementById('confirmDelete').onclick = function() {

               // Ẩn modal sau khi xác nhận
               $('#ModalRM').modal('hide');
           };
       });
   });