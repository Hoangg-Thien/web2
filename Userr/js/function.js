
    document.getElementById("decrease").addEventListener("click", function () {
        let quantityInput = document.getElementById("quantity");
        let currentValue = parseInt(quantityInput.value);
        if (currentValue > 1) {  
            quantityInput.value = currentValue - 1;
        }
    });

    document.getElementById("increase").addEventListener("click", function () {
        let quantityInput = document.getElementById("quantity");
        let currentValue = parseInt(quantityInput.value);
        quantityInput.value = currentValue + 1;
    });

    document.getElementById("quantity").addEventListener("input", function () {
        let quantityInput = document.getElementById("quantity");
        let value = parseInt(quantityInput.value);
        if (isNaN(value) || value < 1) { 
            quantityInput.value = 1;
        }
    });
    
    document.querySelector(".add-to-cart").addEventListener("click", function() {
        document.getElementById("success-message").style.display = "block";
        setTimeout(function() {
            document.getElementById("success-message").style.display = "none";
        }, 10000); 
    });