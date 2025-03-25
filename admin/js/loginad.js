function daoNutDN() {
    var u = document.getElementById("un").value;
    var p = document.getElementById("mk").value;
    document.getElementById("btndangnhap").disabled = !(u.length > 0 && p.length > 0);
}

function daoTT() {
    var mk = document.getElementById("mk");
    mk.type = (mk.type === "password") ? "text" : "password";
}

var attempt = 3;

function validate() {
    var username = document.getElementById("un").value;
    var password = document.getElementById("mk").value;
  if (username == "admin" && password == "admin123") {
    alert("Đăng nhập thành công!");
    window.location.replace("/web2/admin/pages/usermanage.html"); 
  return false;
   } else {
    alert("Mật khẩu sai! Vui lòng nhập lại");
  if (attempt === 0) {
    document.getElementById("un").disabled = true;
    document.getElementById("mk").disabled = true;
    document.getElementById("btndangnhap").disabled = true;
    }
  return false;
    }
}