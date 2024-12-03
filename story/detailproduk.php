<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk - Story Tradition Style</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/./CSS/stylehome.css">
    <style>
        .size-option.active {
            background-color: #28a745;
            color: white;
            border-color: #28a745;
        }

        .size-option {
            transition: all 0.3s ease;
        }

        .size-option:hover {
            background-color: #f8f9fa;
            border-color: #28a745;
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
                    <li class="nav-item"><a class="nav-link active" href="homeuser.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="wishlist.php">Wishlist</a></li>
                    <li class="nav-item"><a class="nav-link" href="sale.html">Sale</a></li>
                    <li class="nav-item"><a class="nav-link" href="myorder.php">My Order</a></li>
                    <li class="nav-item"><a class="nav-link" href="style.php">Style</a></li>
                    <li class="nav-item"><a class="nav-link" href="shop.php">Shop</a></li>
                </ul>
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search entire store here...">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
                <a href="#" class="btn btn-outline-secondary ms-2"><i class="bi bi-person"></i></a>
                <a href="#" class="btn btn-outline-secondary ms-2"><i class="bi bi-chat-dots"></i></a>
            </div>
        </div>
    </nav>

    <!-- Product Details -->
    <div class="container my-5">
        <div class="row g-5">
            <!-- Product Image -->
            <div class="col-md-6">
                <img src="images/adatlampung.jpg" alt="Women's Wedding Dress Lampung Customs" class="img-fluid rounded shadow">
            </div>
            
            <!-- Product Description -->
            <div class="col-md-6">
                <h1 class="product-title">Women's Wedding Dress Lampung Customs</h1>
                <p class="price text-danger fw-bold">IDR 300.000</p>
                <div class="rating mb-3">
                    <span class="text-warning">&#9733;&#9733;&#9733;&#9733;&#9734;</span>
                    <span>(432 Reviews)</span>
                </div>
                <p class="description">
                    Lampung women’s traditional wedding clothes reflect local culture and beauty, with the Siger crown symbolizing wisdom. Bright kebayas are decorated with gold embroidery, combined with Tapis cloth and shawls, as well as gold jewelry such as necklaces and bracelets. This clothing exudes luxury and deep philosophical meaning, reflecting the status and wisdom of Lampung culture.
                </p>
                <hr>
                <h5>Product Details</h5>
                <ul class="list-unstyled">
                    <li><strong>Fit:</strong> Regular</li>
                    <li><strong>Inner Lining:</strong> No</li>
                    <li><strong>Sheer Level:</strong> Not Sheer</li>
                    <li><strong>Stretchability:</strong> None</li>
                </ul>
                <hr>
                <h5>Size Guide</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Size</th>
                            <th>Bust</th>
                            <th>Waist</th>
                            <th>Hips</th>
                            <th>Length</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td>All Size</td><td>84</td><td>68</td><td>90</td><td>137</td></tr>
                    </tbody>
                </table>
                <button class="btn btn-success w-100 mt-3" data-bs-toggle="modal" data-bs-target="#rentModal">RENT THIS</button>
            </div>
        </div>
    </div>

    <!-- Rent Modal -->
    <div class="modal fade" id="rentModal" tabindex="-1" aria-labelledby="rentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rentModalLabel">Rent Wedding Dress</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Size Selection -->
                    <div class="mb-3">
                        <label for="sizeSelection" class="form-label">Choose Size</label>
                        <div id="sizeSelection" class="d-flex gap-2">
                            <button class="btn btn-outline-secondary size-option" data-size="All Size">All Size</button>
                        </div>
                    </div>

                    <!-- Rental Dates -->
                    <div class="mb-3">
                        <label for="rentalDates" class="form-label">Select Rental Dates</label>
                        <input type="date" id="rentalStartDate" class="form-control mb-2" placeholder="Start Date">
                        <input type="date" id="rentalEndDate" class="form-control" placeholder="End Date">
                    </div>

                    <!-- Address Input -->
                    <div class="mb-3">
                        <label for="rentalAddress" class="form-label">Address</label>
                        <input type="text" id="rentalAddress" class="form-control" placeholder="Enter your address">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <!-- Tombol Next dengan navigasi -->
                    <button type="button" class="btn btn-primary" onclick="location.href='myorder.html';">Next</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Logic for selecting size
        document.querySelectorAll('.size-option').forEach(button => {
            button.addEventListener('click', () => {
                // Remove active class from all buttons
                document.querySelectorAll('.size-option').forEach(btn => btn.classList.remove('active'));
                // Add active class to the clicked button
                button.classList.add('active');
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
