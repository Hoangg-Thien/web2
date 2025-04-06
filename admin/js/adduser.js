$(document).ready(function () {
    $('.btn.green1').click(function () {
        $('#ModalKP').modal('show');
    });

    $('#addUserCancelBtn').click(function () {
        $('#ModalKP').modal('hide');
    });

    $('#addUserSaveBtn').click(function () {
        var userData = {
            username: $('#username').val(),
            password: $('#password').val(),
            fullname: $('#fullname').val(),
            phone: $('#phone').val(),
            address: $('#address').val(),
            district: $('#district').val(),
            city: $('#city').val(),
            email: $('#email').val(),
            role: $('#role').val()
        };

        if (!userData.username || !userData.password || !userData.fullname || !userData.email) {
            alert('Vui lòng điền đầy đủ thông tin');
            return;
        }

        $.ajax({
            url: '../pages/ad_register.php',
            type: 'POST',
            data: userData,
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    alert(response.message);
                    $('#ModalKP').modal('hide');
                    location.reload();
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                alert('Đã xảy ra lỗi: ' + error);
            }
        });
    });
});
