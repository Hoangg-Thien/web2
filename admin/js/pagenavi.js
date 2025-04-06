let products = [];
let currentPage = 1;
const itemsPerPage = 10;

function fetchAllProducts() {
    fetch('get_all_products.php')
        .then(response => response.json())
        .then(data => {
            products = data;
            displayProducts(currentPage);
        })
        .catch(error => {
            console.error("Lỗi khi lấy danh sách sản phẩm:", error);
            alert("Không thể tải sản phẩm từ máy chủ.");
        });
}

// Hiển thị sản phẩm
function displayProducts(page) {
    const productTable = document.getElementById("productTable");
    productTable.innerHTML = "";

    let start = (page - 1) * itemsPerPage;
    let end = start + itemsPerPage;
    let paginatedItems = products.slice(start, end);

    paginatedItems.forEach(product => {
        let row = `
            <tr>
                <td><input type="checkbox"></td>
                <td>${product.product_id}</td>
                <td>${product.product_name}</td>
                <td><img src="../img/${product.product_image}" alt="${product.product_name}" width="50"></td>
                <td><span class="${product.product_status === 'Còn hàng' ? 'available' : 'out-of-stock'}">${product.product_status}</span></td>
                <td>${product.product_price}</td>
                <td>${product.product_type}</td>
                <td>
                    <button class="btn btn-outline-danger btn-sm trash" title="Xóa" onclick="deleteProduct('${product.product_id}')"><i class="fas fa-trash-alt"></i></button>
                    <button class="btn btn-outline-warning btn-sm edit" title="Sửa" onclick="editProduct('${product.product_id}')"><i class="fa fa-edit"></i></button>
                </td>
            </tr>`;
        productTable.innerHTML += row;
    });

    setupPagination();
}

// Xóa sản phẩm
function deleteProduct(productId) {
    const product = products.find(p => p.product_id === productId);
    if (!product) {
        alert("Sản phẩm không tồn tại.");
        return;
    }

    $('#ModalRM .modal-body').html(`
        <div class="alert alert-warning">
            <strong>Cảnh báo!</strong>
        </div>
        <p>Bạn có chắc chắn muốn xóa sản phẩm:</p>
        <h4><strong>${product.product_name}</strong></h4>
        <small>Mã sản phẩm: ${product.product_id}</small>
    `);

    $('#ModalRM').modal('show');

    $('#confirmDelete').off('click').on('click', function() {
        const index = products.findIndex(p => p.product_id === productId);
        if (index !== -1) {
            products.splice(index, 1); // Xóa khỏi danh sách tạm
        }

        $('#ModalRM').modal('hide');
        displayProducts(currentPage);
    });
}

// Sửa sản phẩm
function editProduct(productId) {
    fetch(`get_product.php?id=${productId}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert(data.error);
                return;
            }

            document.getElementById("product-code").value = data.product_id;
            document.getElementById("product-name").value = data.product_name;
            document.getElementById("product-price").value = data.product_price;
            document.getElementById("product-status").value = data.product_status;
            document.getElementById("product-type").value = data.product_type;
            document.getElementById("product-image").src = `../img/${data.product_image}`;

            $("#editModal").modal("show");
        })
        .catch(error => {
            console.error("Lỗi khi lấy thông tin sản phẩm:", error);
            alert("Có lỗi xảy ra khi tải dữ liệu sản phẩm.");
        });
}

// Phân trang
function setupPagination() {
    const pagination = document.getElementById("pagination");
    const totalPages = Math.ceil(products.length / itemsPerPage);

    pagination.innerHTML = "";

    pagination.innerHTML += `
        <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
            <a class="page-link" href="#" aria-label="Lùi" onclick="changePage(${currentPage - 1})">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>`;

    for (let i = 1; i <= totalPages; i++) {
        pagination.innerHTML += `
            <li class="page-item ${currentPage === i ? 'active' : ''}">
                <a class="page-link" href="#" onclick="changePage(${i})">${i}</a>
            </li>`;
    }

    pagination.innerHTML += `
        <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
            <a class="page-link" href="#" aria-label="Tiếp" onclick="changePage(${currentPage + 1})">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>`;
}

function changePage(page) {
    const totalPages = Math.ceil(products.length / itemsPerPage);
    if (page < 1 || page > totalPages) return;
    currentPage = page;
    displayProducts(currentPage);
}

// Gọi khi trang tải xong
document.addEventListener("DOMContentLoaded", fetchAllProducts);
