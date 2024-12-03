<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sale - Story Tradition Style</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./CSS/stylehome.css">
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
                    <li class="nav-item"><a class="nav-link" href="homeuser.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="wishlist.php">Wishlist</a></li>
                    <li class="nav-item"><a class="nav-link active" href="sale.php">Sale</a></li>
                    <li class="nav-item"><a class="nav-link" href="myorder.php">My Order</a></li>
                    <li class="nav-item"><a class="nav-link" href="style.php">Style</a></li>
                    <li class="nav-item"><a class="nav-link" href="shop.php">Shop</a></li>
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

    <div class="container mt-5">
        <div class="row">
            <div class="col-12 text-center">
                <img src="images/holiday.png" alt="Holiday Sale" class="img-fluid rounded">
                <!-- <h2 class="mt-3">Up To <strong>60% Off</strong> Holiday Bit</h2> -->
            </div>
        </div>

        <div class="row mt-5 text-center">
            <div class="col-md-4">
                <div class="card shadow-sm p-3 bg-light">
                    <img src="images/grup.png" alt="Group Collection" class="img-fluid mb-3">
                    <h5 class="fw-bold">40% OFF</h5>
                    <p>GROUP COLLECTION</p>
                    <a href="#" class="btn btn-primary">Go to Collection →</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm p-3 bg-light">
                    <img src="images/couple.png" alt="Couple Collection" class="img-fluid mb-3">
                    <h5 class="fw-bold">60% OFF</h5>
                    <p>COUPLE COLLECTION</p>
                    <a href="#" class="btn btn-primary">Go to Collection →</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm p-3 bg-light">
                    <img src="images/kids.png" alt="Kids Collection" class="img-fluid mb-3">
                    <h5 class="fw-bold">30% OFF</h5>
                    <p>KIDS COLLECTION</p>
                    <a href="#" class="btn btn-primary">Go to Collection →</a>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <h3 class="text-center mb-4">Best Deals</h3>
            <div class="col-md-3">
                <div class="card h-100">
                    <img src="images/adatlampung.jpg" class="card-img-top" alt="Lampung Dress">
                    <div class="card-body">
                        <h5 class="card-title">Women's wedding dress Lampung customs</h5>
                        <p class="card-text">IDR 300.000 / Day</p>
                        <button class="btn btn-primary">+ Add</button>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100">
                    <img src="images/adatbali.jpg" class="card-img-top" alt="Bali Dress">
                    <div class="card-body">
                        <h5 class="card-title">Couple's wedding dress Balinese customs</h5>
                        <p class="card-text">IDR 800.000 / Day</p>
                        <button class="btn btn-primary">+ Add</button>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100">
                    <img src="images/adatsunda.jpg" class="card-img-top" alt="Sunda Dress">
                    <div class="card-body">
                        <h5 class="card-title">Women's wedding dress Sundanese customs</h5>
                        <p class="card-text">IDR 250.000 / Day</p>
                        <button class="btn btn-primary">+ Add</button>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100">
                    <img src="images/adatdayakkids.jpg" class="card-img-top" alt="Dayak Kids Dress">
                    <div class="card-body">
                        <h5 class="card-title">Girls' clothes Dayak customs</h5>
                        <p class="card-text">IDR 200.000 / Day</p>
                        <button class="btn btn-primary">+ Add</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
