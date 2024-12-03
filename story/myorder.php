<?php
session_start();

// Memeriksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php?redirect=myorder.php");
    exit();
}

$username = $_SESSION['username'];

// Menampilkan produk dalam keranjang
if (isset($_SESSION['cart'])) {
    $cart = $_SESSION['cart'];
} else {
    $cart = [];
}

// Simulasi data produk berdasarkan ID
$products = [
    1 => ['name' => "Women's Wedding Dress Lampung", 'price' => 300000, 'image' => "images/adatlampung.jpg"],
    // Produk lain bisa ditambahkan di sini
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Order - Story Tradition Style</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./CSS/stylehome.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }

        .order-card {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            margin-bottom: 20px;
            padding: 20px;
            background-color: #fff;
        }

        .order-card img {
            width: 100px;
            height: auto;
            border-radius: 8px;
            margin-right: 15px;
        }

        .order-card .order-details {
            flex-grow: 1;
        }

        .order-card h5 {
            font-size: 18px;
            font-weight: 600;
        }

        .order-card p {
            margin: 5px 0;
            font-size: 14px;
        }

        .order-card .price {
            font-size: 16px;
            font-weight: bold;
            color: #f39c12;
        }

        .order-card .form-check-input {
            margin-top: 6px;
        }

        .summary-box {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            background-color: #fafafa;
        }

        .summary-box h5 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .summary-box .total {
            font-size: 20px;
            font-weight: 700;
            color: #2c3e50;
        }

        .payment-method {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            background-color: #fff;
            margin-top: 30px;
        }

        .payment-method h5 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .list-group-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px;
        }

        .list-group-item button {
            padding: 6px 12px;
            font-size: 12px;
            border-radius: 5px;
        }

        .order-button {
            width: 100%;
            background-color: #f39c12;
            color: white;
            font-size: 16px;
            border: none;
            padding: 12px;
            border-radius: 8px;
            cursor: pointer;
        }

        .order-button:hover {
            background-color: #e67e22;
        }

        .modal-body {
            font-size: 14px;
        }

 /* Styling untuk kategori status */
        .status-box-container {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-top: 30px;
        }

        .status-box {
            padding:5px 15px;;
            border: 2px solid #ddd;
            border-radius: 8px;
            text-align: center;
            cursor: pointer;
            width: 500px;
            transition: all 0.3s ease;
        }

        .status-box:hover {
            transform: scale(1.05);
        }

        .status-title {
            font-size: 20px;
            font-weight: bold;
        }

        .status-description {
            font-size: 14px;
            color: #555;
        }

        /* Border aktif saat dipilih */
        .selected {
            border-color: #000;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        /* Warna untuk kategori */
        .packed {
            background-color: #4CAF50; /* Green for Packed */
            color: white;
        }

        .sent {
            background-color: #2196F3; /* Blue for Sent */
            color: white;
        }

        .canceled {
            background-color: #f44336; /* Red for Canceled */
            color: white;
        }

        .returned {
            background-color: #FF9800; /* Orange for Returned */
            color: white;
        }

        .delivery-method-options {
            margin-top: 20px;
        }

        .delivery-method-options input[type="radio"] {
            margin-right: 10px;
        }

        .delivery-method-options label {
            font-size: 16px;
            font-weight: 600;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="images/logo.png" alt="Story Logo">
            </a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="home.html">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="wishlist.html">Wishlist</a></li>
                    <li class="nav-item"><a class="nav-link" href="sale.html">Sale</a></li>
                    <li class="nav-item"><a class="nav-link active" href="myorder.html">My Order</a></li>
                    <li class="nav-item"><a class="nav-link" href="style.html">Style</a></li>
                </ul>
            </div>
        </div>
    </nav>
    
        <!-- Category Section Above Recommendation -->
        <div class="container my-5">
            <h3 class="text-center"></h3>
    
            <!-- Kategori Status -->
            <div class="status-box-container">
                <div class="status-box packed" onclick="selectStatus(this)">
                    Packed
                </div>
    
                <div class="status-box sent" onclick="selectStatus(this)">
                    Sent
                </div>
    
                <div class="status-box canceled" onclick="selectStatus(this)">
                    Canceled
                </div>
    
                <div class="status-box returned" onclick="selectStatus(this)">
                    Returned
                </div>
            </div>
        </div>

    <div class="container my-5">
        <h3 class="mb-4">My Orders</h3>
        <div class="row">
            <!-- Order List -->
            <div class="col-lg-8">
                <div class="order-card d-flex align-items-start">
                    <input type="checkbox" class="form-check-input me-3" onclick="calculateTotal(this, 300000)">
                    <img src="images/adatlampung.jpg" alt="Lampung Wedding Dress">
                    <div class="order-details">
                        <h5>Women's wedding dress Lampung customs</h5>
                        <p class="text-muted">IDR 300,000 / Day</p>
                        <p class="text-success">Stock 48</p>
                        <div class="d-flex align-items-center">
                            <select class="form-select form-select-sm me-2" style="width: auto;" onchange="calculateTotal(this)">
                                <option value="3">3 Days</option>
                                <option value="5">5 Days</option>
                            </select>
                            <input type="number" class="form-control form-control-sm" value="1" style="width: 60px;">
                        </div>
                    </div>
                    <p class="text-end align-self-center price">IDR 1,080,000</p>
                </div>
            </div>

            <!-- Summary Section -->
            <div class="col-lg-4">
                <div class="summary-box">
                    <h5>Summary</h5>
                    <div class="delivery-method-options">
                        <label>
                            <input type="radio" name="delivery-method" value="Instan" checked onclick="updateDeliveryMethod(this)"> Instan
                        </label>
                        <label>
                            <input type="radio" name="delivery-method" value="Cargo" onclick="updateDeliveryMethod(this)"> Cargo
                        </label>
                    </div>
                    <p><strong>Delivery:</strong> <span id="delivery-method"></span></p>
                    <p><strong>Address:</strong> <input type="text" id="delivery-address" placeholder="Enter address" class="form-control form-control-sm"></p>
                    <p><strong>Subtotal:</strong> <span id="subtotal">IDR 0</span></p>
                    <p><strong>Total:</strong> <span id="total">IDR 0</span></p>
                    <button class="order-button" data-bs-toggle="modal" data-bs-target="#checkoutModal">Checkout</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Checkout -->
    <div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="checkoutModalLabel">Order Summary</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Delivery:</strong> <span id="modal-delivery-method">Instan</span></p>
                    <p><strong>Address:</strong> <span id="modal-delivery-address"></span></p>
                    <p><strong>Subtotal:</strong> <span id="modal-subtotal">IDR 0</span></p>
                    <p><strong>Total:</strong> <span id="modal-total">IDR 0</span></p>

                    <h6 class="mt-3">Payment Method</h6>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Bank Mandiri
                            <button class="btn btn-outline-primary btn-sm">Copy</button>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Bank BCA
                            <button class="btn btn-outline-primary btn-sm">Copy</button>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Bank BRI
                            <button class="btn btn-outline-primary btn-sm">Copy</button>
                        </li>
                    </ul>
                    <p class="mt-3"><strong>Status:</strong> <span class="status-tag status-pending">Pending</span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Confirm Payment</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        let currentSubtotal = 0;
        let currentTotal = 0;
    
        // Fungsi untuk menghitung total dan subtotal saat checkbox dicentang atau tidak
        function calculateTotal(checkbox, pricePerDay = 300000) {
            const days = parseInt(checkbox.closest('.order-card').querySelector('select').value); // Mendapatkan jumlah hari
            const itemTotal = pricePerDay * days; // Menghitung total harga untuk item berdasarkan jumlah hari
            const isChecked = checkbox.checked; // Mengetahui apakah checkbox dicentang
    
            if (isChecked) {
                currentSubtotal += itemTotal;
                currentTotal += itemTotal;
            } else {
                currentSubtotal -= itemTotal;
                currentTotal -= itemTotal;
            }
    
            if (currentSubtotal < 0) currentSubtotal = 0;
            if (currentTotal < 0) currentTotal = 0;
    
            document.getElementById('subtotal').innerText = `IDR ${currentSubtotal.toLocaleString()}`;
            document.getElementById('total').innerText = `IDR ${currentTotal.toLocaleString()}`;
        }
    
        // Update metode pengiriman berdasarkan pilihan radio
        function updateDeliveryMethod(radio) {
            const deliveryMethod = radio.value;
            document.getElementById('delivery-method').innerText = deliveryMethod;
        }
    
        // Update modal ketika tombol checkout ditekan
        document.querySelector('.order-button').addEventListener('click', function () {
            const deliveryMethod = document.getElementById('delivery-method').innerText;
            const deliveryAddress = document.getElementById('delivery-address').value;
            const subtotal = currentSubtotal;
            const total = currentTotal;
    
            // Update modal dengan data yang sesuai
            document.getElementById('modal-delivery-method').innerText = deliveryMethod;
            document.getElementById('modal-delivery-address').innerText = deliveryAddress;
            document.getElementById('modal-subtotal').innerText = `IDR ${subtotal.toLocaleString()}`;
            document.getElementById('modal-total').innerText = `IDR ${total.toLocaleString()}`;
        });
    </script>   
</body>
</html>
