document.getElementById('registration-form').addEventListener('submit', function (e) {
    e.preventDefault(); 

    const fullname = document.getElementById('fullname').value.trim();
    const username = document.getElementById('username').value.trim();
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    const phone = document.getElementById('phone').value.trim();
    const address = document.getElementById('address').value.trim();

    const notification = document.getElementById('notification');


    if (!fullname || !username || !email || !password || !confirmPassword || !phone || !address) {
        notification.textContent = 'Vui lòng điền đầy đủ thông tin!';
        notification.className = 'error';
        notification.classList.remove('hidden');
        return;
    }

    if (password.length < 6) {
        notification.textContent = 'Mật khẩu phải có ít nhất 6 ký tự!';
        notification.className = 'error';
        notification.classList.remove('hidden');
        return;
    }

    if (password !== confirmPassword) {
        notification.textContent = 'Mật khẩu xác nhận không khớp!';
        notification.className = 'error';
        notification.classList.remove('hidden');
        return;
    }

    if (!/^\d{10}$/.test(phone)) {
        notification.textContent = 'Số điện thoại không hợp lệ!';
        notification.className = 'error';
        notification.classList.remove('hidden');
        return;
    }

    for (let i = 0; i < localStorage.length; i++) {
        const key = localStorage.key(i);
        const existingUser = JSON.parse(localStorage.getItem(key));

        if (existingUser.username === username) {
            notification.textContent = 'Tên đăng nhập đã tồn tại!';
            notification.className = 'error';
            notification.classList.remove('hidden');
            return;
        }

        if (existingUser.email === email) {
            notification.textContent = 'Email đã được sử dụng!';
            notification.className = 'error';
            notification.classList.remove('hidden');
            return;
        }
    }

   
    const user = {
        fullname,
        username,
        email,
        password,
        phone,
        address,
    };

   
    localStorage.setItem(username, JSON.stringify(user));


    notification.textContent = "Đăng ký thành công! Đang chuyển hướng...";
    notification.className = "success";
    notification.classList.remove("hidden");
    window.location.href = "../user/login-user.html";
});
