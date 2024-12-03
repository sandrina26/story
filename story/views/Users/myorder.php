<?php
// Memulai sesi
session_start();

$username = $_SESSION['username'];
$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="stylehome.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .nav-tabs .nav-link.active {
            background-color: #f8f9fa;
            border-color: #dee2e6 #dee2e6 #fff;
            color: #495057;
        }

        .card {
            border: 1px solid #dee2e6;
            border-radius: 8px;
        }

        .card img {
            max-height: 120px;
            object-fit: cover;
        }

        .text-success {
            font-size: 0.9rem;
        }

        .badge {
            font-size: 0.8rem;
            border-radius: 0.3rem;
        }

        .text-end h5 {
            font-weight: bold;
        }

        button {
            margin-right: 5px;
        }

        .select-all-container {
            margin-bottom: 10px;
        }

        .modal-body {
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="images/logo.png" alt="Story Logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="home.html">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="wishlist.html">Wishlist</a></li>
                    <li class="nav-item"><a class="nav-link" href="sale.html">Sale</a></li>
                    <li class="nav-item"><a class="nav-link active" href="myorder.html">My Order</a></li>
                    <li class="nav-item"><a class="nav-link" href="style.html">Style</a></li>
                    <li class="nav-item"><a class="nav-link" href="shop.html">Shop</a></li>
                </ul>
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search entire store here...">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
                <a href="profil.html" class="btn btn-outline-secondary ms-2"><i class="bi bi-person"></i></a>
                <a href="chat.html" class="btn btn-outline-secondary ms-2"><i class="bi bi-chat-dots"></i></a>
            </div>
        </div>
    </nav>

    <div class="container my-4">
        <!-- Select All Checkbox 1-->
        <div class="select-all-container">
            <input type="checkbox" id="select-all"> <strong>Select All</strong>
        </div>

        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" href="#">My Order</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Packed</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Sent</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Canceled</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Return</a>
            </li>
        </ul>

        <div class="my-4">
            <!-- First Item -->
            <div class="card mb-3 p-3 product-card">
                <div class="row align-items-center">
                    <div class="col-md-1 text-center">
                        <input type="checkbox" class="form-check-input product-checkbox" data-id="1" data-name="Women's wedding dress Lampung customs" data-price="300000" />
                    </div>
                    <div class="col-md-2 position-relative">
                        <span class="badge bg-light text-dark position-absolute top-0 start-0 px-2 py-1">Butik Indah</span>
                        <img src="images/adatlampung.jpg" class="img-fluid rounded mt-3" alt="Lampung Wedding Dress">
                    </div>
                    <div class="col-md-6">
                        <h5>Women's wedding dress Lampung customs</h5>
                        <p class="text-muted">IDR 300.000 / Day + 20% (deposit)</p>
                        <p class="text-success">Stock 48 | All Size</p>
                        <div class="d-flex align-items-center">
                            <input type="number" class="form-control w-auto me-2" value="3" min="1">
                            <input type="number" class="form-control w-auto" value="1" min="1">
                        </div>
                    </div>
                    <div class="col-md-3 text-end">
                        <h5>IDR 300.000</h5>
                        <button class="btn btn-outline-secondary btn-sm">Edit</button>
                        <button class="btn btn-outline-danger btn-sm">Delete</button>
                    </div>
                </div>
            </div>

            <!-- Second Item -->
            <div class="card mb-3 p-3 product-card">
                <div class="row align-items-center">
                    <div class="col-md-1 text-center">
                        <input type="checkbox" class="form-check-input product-checkbox" data-id="2" data-name="Women's wedding dress Sundanese customs" data-price="648000" />
                    </div>
                    <div class="col-md-2 position-relative">
                        <span class="badge bg-light text-dark position-absolute top-0 start-0 px-2 py-1">Wedding Dress</span>
                        <img src="images/adatsunda.jpg" class="img-fluid rounded mt-3" alt="Padang Wedding Dress">
                    </div>
                    <div class="col-md-6">
                        <h5>Women's wedding dress Sundanese customs</h5>
                        <p class="text-muted">IDR 270.000 / Day + 20% (deposit)</p>
                        <p class="text-success">Stock 10 | All Size</p>
                        <div class="d-flex align-items-center">
                            <input type="number" class="form-control w-auto me-2" value="2" min="1">
                            <input type="number" class="form-control w-auto" value="1" min="1">
                        </div>
                    </div>
                    <div class="col-md-3 text-end">
                        <h5>IDR 648.000</h5>
                        <button class="btn btn-outline-secondary btn-sm">Edit</button>
                        <button class="btn btn-outline-danger btn-sm">Delete</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total and Checkout -->
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div>
                <strong>Total: </strong>
                <span id="total-price">IDR 0</span>
            </div>
            <button id="checkout-btn" class="btn btn-primary" disabled>Checkout</button>
        </div>
    </div>

    <!-- Modal Checkout -->
    <div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="checkoutModalLabel">Checkout Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="modal-product-details">
                        <!-- Product details will be added dynamically -->
                    </div>
                    <hr>
                    <div class="mt-4">
                        <p><strong>Delivery:</strong> 19 Juni 2024</p>
                        <p><strong>Address:</strong> Diana Sarah (+62) 823-4687-28<br>Dago, Kab. Bandung, Jawa Barat, ID 40723</p>
                    </div>
                    <div class="mt-3">
                        <label for="voucher-code" class="form-label">Voucher Diskon (40%)</label>
                    </div>
                    <div class="mt-4">
                        <h5>Payment Method</h5>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="paymentMethod" id="payment-method2" value="virtual-account">
                            <label class="form-check-label" for="payment-method2">Virtual Account</label>
                        </div>

                        <!-- Dropdown untuk memilih bank -->
                        <div id="virtual-account-container" class="mt-3" style="display:none;">
                            <label for="payment-bank" class="form-label">Select Bank</label>
                            <select class="form-select" id="payment-bank">
                                <option value="mandiri">Bank Mandiri</option>
                                <option value="bri">Bank BRI</option>
                                <option value="bca">Bank BCA</option>
                                <option value="bni">Bank BNI</option>
                                <option value="cimb">CIMB Niaga</option>
                                <option value="btn">Bank BTN</option>
                            </select>
                            <p id="virtual-account-number" class="mt-2"></p>
                        </div>
                    </div>                   
                    <hr>
                    <div class="d-flex justify-content-between">
                        <div>Subtotal</div>
                        <div id="subtotal">IDR 0</div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div>Deposit</div>
                        <div id="deposit">IDR 150.000</div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div>Diskon 40% <span style="color: red;"></span></div>
                        <div id="discount" class="text-danger">-IDR 0</div>
                    </div>                                      
                    <hr>
                    <div class="d-flex justify-content-between">
                        <div><strong>Total Pembayaran</strong></div>
                        <div id="total-payment">IDR 0</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Pay</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // JavaScript to handle calculations and updates
        document.addEventListener('DOMContentLoaded', function () {
            const checkboxes = document.querySelectorAll('.product-checkbox');
            const selectAllCheckbox = document.getElementById('select-all');
            const checkoutBtn = document.getElementById('checkout-btn');
            const modalProductDetails = document.getElementById('modal-product-details');

            // Handle select all checkbox
            selectAllCheckbox.addEventListener('change', () => {
                checkboxes.forEach(checkbox => {
                    checkbox.checked = selectAllCheckbox.checked;
                });
                calculateTotal();
            });

            // Handle individual product checkboxes
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', calculateTotal);
            });

            // Handle checkout button click
            checkoutBtn.addEventListener('click', () => {
                const modal = new bootstrap.Modal(document.getElementById('checkoutModal'));
                modal.show();
            });

            // Function to calculate total
            function calculateTotal() {
                let total = 0;
                const selectedItems = [];
                checkboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        const price = parseInt(checkbox.getAttribute('data-price'));
                        const quantity = parseInt(checkbox.closest('.product-card').querySelector('input[type="number"]').value);
                        const subtotalForItem = price * quantity;
                        selectedItems.push({
                            name: checkbox.getAttribute('data-name'),
                            price: price,
                            subtotal: subtotalForItem
                        });
                        total += subtotalForItem;
                    }
                });

                // Diskon 40%
                const discount = total * 0.40;
                const deposit = 150000; // Deposit tetap
                const totalPayment = total + deposit - discount;

                // Update total harga di halaman
                document.getElementById('total-price').textContent = `IDR ${total.toLocaleString()}`;

                // Update modal checkout
                modalProductDetails.innerHTML = '';
                selectedItems.forEach(item => {
                    const div = document.createElement('div');
                    div.innerHTML = `<p>${item.name}: IDR ${item.subtotal.toLocaleString()}</p>`;
                    modalProductDetails.appendChild(div);
                });

                // Update subtotal, deposit, diskon, dan total pembayaran
                document.getElementById('subtotal').textContent = `IDR ${total.toLocaleString()}`;
                document.getElementById('deposit').textContent = `IDR ${deposit.toLocaleString()}`;
                document.getElementById('discount').textContent = `IDR -${discount.toLocaleString()}`;
                document.getElementById('total-payment').textContent = `IDR ${totalPayment.toLocaleString()}`;

                // Enable or disable checkout button
                checkoutBtn.disabled = total === 0;
            }
        });
        document.addEventListener('DOMContentLoaded', function () {
            const paymentMethodRadios = document.querySelectorAll('input[name="paymentMethod"]');
            const virtualAccountContainer = document.getElementById('virtual-account-container');
            const paymentBankSelect = document.getElementById('payment-bank');
            const virtualAccountNumberElement = document.getElementById('virtual-account-number');

            // Fungsi untuk memperbarui nomor virtual account berdasarkan bank yang dipilih
            function updateVirtualAccountNumber() {
                const selectedBank = paymentBankSelect.value;
                let virtualAccountNumber = '';

                switch (selectedBank) {
                    case 'mandiri':
                        virtualAccountNumber = '700123456789';
                        break;
                    case 'bri':
                        virtualAccountNumber = '100987654321';
                        break;
                    case 'bca':
                        virtualAccountNumber = '100112233445';
                        break;
                    case 'bni':
                        virtualAccountNumber = '200556677889';
                        break;
                    case 'cimb':
                        virtualAccountNumber = '300665544332';
                        break;
                    case 'btn':
                        virtualAccountNumber = '400998877665';
                        break;
                    default:
                        virtualAccountNumber = '';
                }

                // Update nomor virtual account
                virtualAccountNumberElement.textContent = `Virtual Account Number: ${virtualAccountNumber}`;
            }

            // Menangani perubahan metode pembayaran
            paymentMethodRadios.forEach(radio => {
                radio.addEventListener('change', function () {
                    if (this.value === 'virtual-account') {
                        virtualAccountContainer.style.display = 'block';  // Tampilkan dropdown bank
                        updateVirtualAccountNumber(); // Perbarui nomor virtual account
                    } else {
                        virtualAccountContainer.style.display = 'none';  // Sembunyikan dropdown bank jika bukan virtual account
                    }
                });
            });

            // Menangani perubahan pilihan bank
            paymentBankSelect.addEventListener('change', updateVirtualAccountNumber);
        });
    </script>
</body>
</html>
