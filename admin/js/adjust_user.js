$(document).ready(function () {
    $("#toggleSidebar").click(function () {
        $("#sidebar").toggleClass("active");
    });

    $(document).click(function (event) {
        if (!$(event.target).closest('#sidebar, #toggleSidebar').length && $('#sidebar').hasClass('active')) {
            $("#sidebar").removeClass("active");
        }
    });

    $(".gear").click(function() {
        var row = $(this).closest("tr");
        var username = row.find("td:eq(0)").text();
        
        $.ajax({
            url: "get_user_pro_dis.php",
            type: "POST",
            data: {
                username: username
            },
            dataType: "json",
            success: function(data) {
                $("#edit_username").val(username);
                $("#edit_fullname").val(data.fullname);
                $("#edit_address").val(data.user_address);
                $("#edit_email").val(data.user_email);
                $("#edit_phone").val(data.phone);
                $("#edit_role").val(data.user_role);
                $("#edit_status").val(data.user_status);
                $("#edit_district").val(data.district);
                $("#edit_city").val(data.city);
                
                $("#ModalUP").modal("show");
            },
            error: function(xhr, status, error) {
                alert("Lỗi: " + error);
            }
        });
    });

    $("#saveBtn").click(function() {
        var username = $("#edit_username").val();
        var fullname = $("#edit_fullname").val();
        var address = $("#edit_address").val();
        var email = $("#edit_email").val();
        var phone = $("#edit_phone").val();
        var role = $("#edit_role").val();
        var status = $("#edit_status").val();
        var district = $("#edit_district").val();
        var city = $("#edit_city").val();

        $.ajax({
            url: "update_user.php",
            type: "POST",
            data: {
                username: username,
                fullname: fullname,
                address: address,
                email: email,
                phone: phone,
                role: role,
                status: status,
                district: district,
                city: city
            },
            success: function(response) {
                alert("Cập nhật thành công");
                location.reload();
            },
            error: function(xhr, status, error) {
                alert("Lỗi: " + error);
            }
        });
    });

    $(".lock").click(function() {
        var row = $(this).closest("tr");
        var username = row.find("td:eq(0)").text();
        var status = row.find("td:eq(6)").text().trim();
        
        $("#ModalRL .modal-body").html("Bạn có chắc chắn muốn khóa người dùng <strong>" + username + "</strong> không?");
        $("#ModalRL").modal("show");
        
        $("#ModalRL").data("username", username);
    });

    $("#ModalRL #saveBtn").click(function() {
        var username = $("#ModalRL").data("username");
        
        $.ajax({
            url: "lock_user.php",
            type: "POST",
            data: {
                username: username,
                action: "lock"
            },
            success: function(response) {
                alert("Đã khóa người dùng thành công");
                location.reload();
            },
            error: function(xhr, status, error) {
                alert("Lỗi: " + error);
            }
        });
    });

    $(".delete").click(function() {
        var row = $(this).closest("tr");
        var username = row.find("td:eq(0)").text();
        var status = row.find("td:eq(6)").text().trim();
        
        if(status === "hoạt động" || status === "Hoạt động") {
            alert("Người dùng này đang hoạt động, không thể mở khóa");
            return;
        }
        
        $("#ModalRM .modal-body").html("Bạn có chắc chắn muốn mở khóa người dùng <strong>" + username + "</strong> không?");
        $("#ModalRM").modal("show");
        
        $("#ModalRM").data("username", username);
    });

    $("#confirmDelete").click(function() {
        var username = $("#ModalRM").data("username");
        
        $.ajax({
            url: "lock_user.php",
            type: "POST",
            data: {
                username: username,
                action: "unlock"
            },
            success: function(response) {
                alert("Đã mở khóa người dùng thành công");
                location.reload();
            },
            error: function(xhr, status, error) {
                alert("Lỗi: " + error);
            }
        });
    });

    $(".green1").click(function() {
        $("#ModalKP").modal("show");
    });

    $("#addUserSaveBtn").click(function() {
        var username = $("#username").val();
        var password = $("#password").val();
        var fullname = $("#fullname").val();
        var phone = $("#phone").val();
        var address = $("#address").val();
        var district = $("#district").val();
        var city = $("#city").val();
        var email = $("#email").val();
        var role = $("#role").val();
        
        $.ajax({
            url: "add_user.php",
            type: "POST",
            data: {
                username: username,
                password: password,
                fullname: fullname,
                phone: phone,
                address: address,
                district: district,
                city: city,
                email: email,
                role: role
            },
            success: function(response) {
                alert("Thêm người dùng mới thành công");
                location.reload();
            },
            error: function(xhr, status, error) {
                alert("Lỗi: " + error);
            }
        });
    });
});