document.querySelector('.input-submit').addEventListener('click', function (e) {
    e.preventDefault(); 

    const username = document.getElementById('user').value.trim();
    const password = document.getElementById('password').value;

    const user = JSON.parse(localStorage.getItem(username));

    const notificationDiv = document.createElement('div'); 
    notificationDiv.style.marginTop = "15px";
    notificationDiv.style.fontWeight = "bold";
    notificationDiv.style.padding = "10px";
    notificationDiv.style.borderRadius = "10px";
    notificationDiv.style.textAlign = "center";

    if (!user) {

        notificationDiv.style.backgroundColor = "#f8d7da";
        notificationDiv.style.color = "#721c24";
        notificationDiv.textContent = "Tên đăng nhập không tồn tại!";
    } else if (user.password !== password) {

        notificationDiv.style.backgroundColor = "#f8d7da";
        notificationDiv.style.color = "#721c24";
        notificationDiv.textContent = "Mật khẩu không chính xác!";
    } else {
    
        notificationDiv.style.backgroundColor = "#d4edda";
        notificationDiv.style.color = "#155724";
        notificationDiv.textContent = `Đăng nhập thành công! Chào mừng, ${user.fullname}`;

        window.location.href = "../index.html"; 
    }

  
    const container = document.querySelector('.login_container');
    container.appendChild(notificationDiv);


    setTimeout(() => {
        notificationDiv.remove();
    }, 5000);
});
