const products = [
    { id: "F001", name: "Chuối Chín Nam Mỹ", image: "../img/trai-chuoi.jpg", status: "Còn hàng", price: "160.000đ/kg", type: "Trái Cây Nhập Khẩu" },
    { id: "F002", name: "Kiwi", image: "../img/trai-kiwi.jpg", status: "Còn hàng", price: "160.000đ/kg", type: "Trái Cây Nhập Khẩu" },
    { id: "F003", name: "Lựu Ai Cập", image: "../img/trai-luu.jpg", status: "Hết hàng", price: "160.000đ/kg", type: "Trái Cây Nhập Khẩu" },
    { id: "F004", name: "Mận Đỏ An Phước", image: "../img/trai-man-do.jpg", status: "Hết hàng", price: "45.000đ/kg", type: "Trái Cây Việt" },
    { id: "F005", name: "Mãng Cầu Xiêm", image: "../img/trai-mang-cau.jpg", status: "Còn hàng", price: "45.000đ/kg", type: "Trái Cây Ngon" },
    { id: "F006", name: "Nho Mỹ", image: "../img/trai-nho-My.webp", status: "Hết hàng", price: "160.000đ/kg", type: "Trái Cây Nhập Khẩu" },
    { id: "F007", name: "Ổi Xá Lị", image: "../img/trai-oi.jpg", status: "Còn hàng", price: "45.000đ/kg", type: "Trái Cây Việt" },
    { id: "F008", name: "Thanh Long Ruột Đỏ", image: "../img/trai-thanh-long-do.jpg", status: "Còn hàng", price: "45.000đ/kg", type: "Trái Cây Việt" },
    { id: "F009", name: "Bòn Bon", image: "../img/trai-bon-bon.jpg", status: "Hết hàng", price: "45.000đ/kg", type: "Trái Cây Việt" },
    { id: "F010", name: "Quýt Đường", image: "../img/trai-quyt.jpg", status: "Còn hàng", price: "45.000đ/kg", type: "Trái Cây Việt" },
    { id: "F011", name: "Dưa hấu Long An", image: "../img/trai-dua-hau.webp", status: "Còn hàng", price: "45.000đ/kg", type: "Trái Cây Ngon" },
    { id: "F012", name: "Chôm chôm", image: "../img/trai-chom-chom.jpg", status: "Hết hàng", price: "45.000đ/kg", type: "Trái Cây Ngon" },
    { id: "F013", name: "Xoài cát", image: "../img/trai-xoai.jpg", status: "Hết hàng", price: "45.000đ/kg", type: "Trái Cây Ngon" },
    { id: "F014", name: "Dâu tây Đà Lạt", image: "../img/dau-tay.jpg", status: "Còn hàng", price: "45.000đ/kg", type: "Trái Cây Việt" },
    { id: "F015", name: "Mận Hà Nội", image: "../img/man-Ha-Noi.jpg", status: "Còn hàng", price: "45.000đ/kg", type: "Trái Cây Việt" },
    { id: "F016", name: "Bưởi da xanh", image: "../img/hinh-trai-buoi.jpg", status: "Hết hàng", price: "45.000đ/kg", type: "Trái Cây Việt" },
    { id: "F017", name: "Táo Envy", image: "../img/trai-tao.webp", status: "Hết hàng", price: "160.000đ/kg", type: "Trái Cây Nhập Khẩu" },
    { id: "F018", name: "Cherry Úc", image: "../img/trai-cherry-Uc.webp", status: "Còn hàng", price: "160.000đ/kg", type: "Trái Cây Nhập Khẩu" }
];
let currentPage = 1;
const itemsPerPage = 10;
const totalPages = Math.ceil(products.length / itemsPerPage);

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
            <td>${product.id}</td>
            <td>${product.name}</td>
            <td><img src="${product.image}" alt="${product.name}" width="50"></td>
            <td><span class="${product.status === 'Còn hàng' ? 'available' : 'out-of-stock'}">${product.status}</span></td>
            <td>${product.price}</td>
            <td>${product.type}</td>
            <td>
                <button class="btn btn-outline-danger btn-sm trash" title="Xóa" onclick="deleteProduct('${product.id}')"><i class="fas fa-trash-alt"></i></button>
                <button class="btn btn-outline-warning btn-sm edit" title="Sửa" data-id="${product.id}" onclick="editProduct('${product.id}')"><i class="fa fa-edit"></i></button>
            </td>
        </tr>`;
    productTable.innerHTML += row;
});

setupPagination();
}
function editProduct(productId) {
// Hiển thị thông tin sản phẩm vào modal chỉnh sửa
const product = products.find(p => p.id === productId);
document.getElementById("product-code").value = product.id;
document.getElementById("product-name").value = product.name;
document.getElementById("product-price").value = product.price;
document.getElementById("product-status").value = product.status;
document.getElementById("product-type").value = product.type;
document.getElementById("product-image").src = product.image;

// Hiển thị modal
$("#editModal").modal("show");
}

function deleteProduct(productId) {
// Tìm sản phẩm dựa trên ID
const product = products.find(p => p.id === productId);
if (!product) {
    alert("Sản phẩm không tồn tại.");
    return;
}

// Cập nhật nội dung modal với thông tin sản phẩm
$('#ModalRM .modal-body').html(`
    <div class="alert alert-warning">
        <strong>Cảnh báo!</strong>
    </div>
    <p>Bạn có chắc chắn muốn xóa sản phẩm:</p>
    <h4><strong>${product.name}</strong></h4>
    <small>Mã sản phẩm: ${product.id}</small>
`);

// Hiển thị modal
$('#ModalRM').modal('show');

// Xử lý sự kiện khi người dùng nhấn nút xác nhận
$('#confirmDelete').off('click').on('click', function() {
    // Xóa sản phẩm khỏi danh sách
    const productIndex = products.findIndex(p => p.id === productId);
    if (productIndex !== -1) {
        products.splice(productIndex, 1); // Xóa sản phẩm khỏi mảng
        alert(`Sản phẩm ${product.name} đã được xóa.`);
    }

    // Đóng modal
    $('#ModalRM').modal('hide');

    // Làm mới danh sách sản phẩm
    displayProducts(currentPage);
});
}


function setupPagination() {
const pagination = document.getElementById("pagination");
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
if (page < 1 || page > totalPages) return;
currentPage = page;
displayProducts(currentPage);
}

displayProducts(currentPage);


