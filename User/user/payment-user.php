<!DOCTYPE html>  
<html lang="en">  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <title>Trang Thanh Toán</title>  
    <link rel="stylesheet" href="../styles/payment.css">
    <link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon">   
    <style>  
        .payment-method {  
            cursor: pointer;  
            margin-bottom: 20px;  
            display: flex;  
            align-items: center;  
        }  
        
        .payment-method img {  
            width: 50px; 
            margin-right: 10px;  
        }  
        
        .payment-info {  
            display: none;  
            margin-top: 10px;  
            padding: 10px;  
            border: 1px solid #ddd;  
            border-radius: 5px;  
        }  

        .payment-method.selected {
            background-color: #d4edda; 
            border: 2px solid #28a745; 
            border-radius: 5px; 
            position: relative; 
            transition: background-color 0.3s ease, border 0.3s ease; 
        }

        .payment-method.selected::after {
            content: "✔"; 
            position: absolute;
            top: 10px; 
            right: 10px; 
            font-size: 20px; 
            color: #28a745; 
            font-weight: bold;
        }
        header {  
            display: flex;  
            align-items: center; 
            justify-content: center; 
            position: relative; 
            height: 60px; 
            background-color: green;
        }  

        .header-title {  
            position: absolute;
            left: 50%; 
            transform: translateX(-50%);
            color: white;  
            text-align: center;  
        }  

        .logo {  
            position: absolute; 
            left: 20px; 
        }  
    </style>  
</head>  
<body>  
    <header>  
        <img class="logo" src="../img/seafruits-logo.png" alt="seafruits">  
        <h3 class="header-title">TRANG THANH TOÁN CỦA SEA FRUIT</h3>  
        <section style="margin-top: 50px;">  
            <nav aria-label="breadcrumb">  
                <div class="breadcrumb">  
                    <div>  
                        <a href="../index.html" target="_blank" style="text-decoration: none; color:#ccc">Trang chủ</a>  
                    </div>  
                </div>  
            </nav>  
        </section> 
    </header>

    <section class="payment-custom container">  
        <div class="payment-custom__content row">  
            <div class="payment-custom__content__left col-6">  
                <h3>Thông tin người nhận</h3>  
                <form id="payment-form">  
                  
                    <label for="payment--receiver"><i class="fas fa-user"></i>Họ tên</label>  
                    <input type="text" id="payment--receiver" required placeholder="Tên người nhận hàng">  
                    
                 
                    <label for="payment--phone"><i class="fas fa-phone-volume"></i>Điện thoại</label>  
                    <input type="tel" id="payment--phone" required pattern="(84|0[3|5|7|8|9])+([0-9]{8})\b" placeholder="Số điện thoại người nhận hàng">  
                    
                
                    <label for="payment--adr"><i class="far fa-address-card"></i>Địa chỉ</label>  
                    <input type="text" id="payment--adr" required placeholder="Địa chỉ nhận hàng">  

                    <input type="checkbox" id="payment--defaul">  
                    <label for="payment--defaul"> Sử dụng thông tin mặc định <i class="far fa-question-circle">  
                        <div class="more-info">Thông tin về họ tên, số điện thoại, địa chỉ mà bạn lưu trong tài khoản (nếu có)</div>  
                    </i></label>  
                    
               
                    <label for="payment--note"><i class="far fa-comment"></i>Ghi chú</label>  
                    <textarea type="text" name="user-note" id="payment--note" rows="3" placeholder="Ghi yêu cầu của bạn tại đây."></textarea>  

                    <div>
                        <button type="button" onclick="validateForm()" style="text-decoration: none; color:black; border:3px solid black; border-radius: 5px;">Xác nhận</button>
                    </div>  
                </form>  
            </div>  

            <div class="payment-custom__content__right col-6">  
                <h3>Phương thức thanh toán</h3>  
                <label>Chọn phương thức:</label>  
                <div class="payment-info" id="cod-info">  
                    <h4>Thông tin thanh toán COD:</h4>  
                    <p>Chúng tôi sẽ thu tiền mặt khi giao hàng.</p>  
                </div>  

                <div class="payment-method" onclick="toggleInfo('card-info')">  
                    <img src="https://bizweb.dktcdn.net/100/421/124/themes/811860/assets/cart_payment_2.svg?1617678628801" alt="Thẻ tín dụng"> 
                    <img src="https://bizweb.dktcdn.net/100/421/124/themes/811860/assets/cart_payment_1.svg?1617678628801" alt="ghi no">   
                    <span>Thẻ tín dụng / Ghi nợ</span>
                </div>  
                <div class="payment-info" id="card-info">  
                    <h4>Thông tin thẻ tín dụng:</h4>  
                    <p>Phương thức này hiện không được hỗ trợ.</p>  
                </div>  

                <div class="payment-method" onclick="toggleInfo('bank-info')">  
                    <img src="https://bizweb.dktcdn.net/100/421/124/themes/811860/assets/cart_payment_3.svg?1617678628801" alt="Chuyển khoản ngân hàng">  
                    <span>Chuyển khoản ngân hàng</span>  
                </div>  
                <div class="payment-info" id="bank-info">  
                    <h4>Thông tin tài khoản ngân hàng:</h4>  
                    <p>STK: 04172537401</p>  
                    <p>Tên tài khoản: CHÂU UY VỦ</p>  
                    <p>Ngân hàng: TP Bank</p>
                    <p>Chi phí vận chuyển và thời gian vận chuyển sẽ được nhân viên gọi điện xác nhận!
                        Thông tin chi tiết đơn hàng sẽ được chúng tôi gửi về email của bạn!
                        Lưu ý:
                        SAU KHI CHUYỂN KHOẢN XONG, NHÂN VIÊN CỦA CHÚNG TÔI SẼ GỌI CHO BẠN ĐỂ XÁC NHẬN. NẾU KHÔNG NHẬN ĐƯỢC CUỘC GỌI QUÁ 15 PHÚT, XIN HÃY GỌI HOTLINE:0123456789</p>  
                </div>  

                <div class="payment-method" onclick="toggleInfo('online-info')">  
                    <img src="https://bizweb.dktcdn.net/100/421/124/themes/811860/assets/cart_payment_4.svg?1617678628801" alt="Thanh toán trực tuyến">  
                    <span>Thanh toán khi nhận hàng</span>  
                </div>  
                <div class="payment-info" id="online-info">  
                    <h4>Thông tin thanh toán trực tuyến:</h4>  
                    <p>Quý khách chỉ phải thanh toán khi nhận được hàng - Chi phí vận chuyển và thời gian vận chuyển sẽ được nhân viên gọi điện xác nhận!
                        Thông tin chi tiết đơn hàng sẽ được chúng tôi gửi về email của bạn!
                        Để đảm bảo giải quyết các vấn đề phát sinh về đơn hàng một cách minh bạch, quý khách vui lòng quay lại video khi mở hàng.
                        Trong trường hợp shop gửi thiếu hàng, hỏng hàng, sai hàng quý khách vui lòng phản hồi và gửi lại video cho shop để kiểm chứng, cửa hàng sẽ tiến hành bù hoàn sau khi đã xác nhận.
                        Trường hợp không có video bóc hàng shop xin TỪ CHỐI giải quyết.</p>  
                </div>  
            </div>  
        </div>  
    </section> 

    <footer>  
        <div class="text">  
            Copyright by us<b>&#8482;</b>  
        </div>  
    </footer>  

    <script>  
        function toggleInfo(infoId) {  
    const infoSections = document.querySelectorAll('.payment-info');  
    const paymentMethods = document.querySelectorAll('.payment-method');


    infoSections.forEach(section => {  
        section.style.display = section.id === infoId ? (section.style.display === 'block' ? 'none' : 'block') : 'none';  
    });

  
    paymentMethods.forEach(method => method.classList.remove('selected'));

  
    const selectedMethod = document.querySelector(`[onclick="toggleInfo('${infoId}')"]`);  
    if (selectedMethod) {  
        selectedMethod.classList.toggle('selected');  
    }
}

function validateForm() {  
    const name = document.getElementById('payment--receiver').value;  
    const phone = document.getElementById('payment--phone').value;  
    const address = document.getElementById('payment--adr').value;  
    
    if (!name || !phone || !address) {  
        alert('Vui lòng nhập đầy đủ thông tin trước khi xác nhận.');  
    } else {  
        window.location.href = 'thanks.html';  
    }  
}
    </script>
</body>  
</html>
