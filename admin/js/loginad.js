function daoNutDN() {
    var u = document.getElementById("user").value;
    var p = document.getElementById("pass").value;
    document.getElementById("login").disabled = !(u.length > 0 && p.length > 0);
}

function daoTT() {
    var mk = document.getElementById("pass");
    mk.type = (mk.type === "password") ? "text" : "password";
}

var attempt = 3;

function validate() {
    var username = document.getElementById("user").value;
    var password = document.getElementById("pass").value;
  if (username == "admin" && password == "admin123"){
    alert("Đăng nhập thành công!");
    window.location.replace("/web2/admin/pages/usermanage.php"); 
  return false;
   } else {
    alert("Thông tin sai! Vui lòng kiểm tra lại");
  if (attempt === 0) {
    document.getElementById("user").disabled = true;
    document.getElementById("pass").disabled = true;
    document.getElementById("login").disabled = true;
    }
  return false;
    }
}