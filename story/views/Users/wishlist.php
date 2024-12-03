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
    <title>Wishlist</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../CSS/stylehome.css?ver=1.0">
    <style>
        .wishlist-item {
            position: relative;
            border: 1px solid #ddd;
            border-radius: 5px;
            overflow: hidden;
            margin-bottom: 1rem;
            padding: 1rem;
            text-align: center;
        }

        .wishlist-item img {
            width: 100%;
            height: auto;
            object-fit: cover; /* Membuat gambar memenuhi area container dengan proporsional */
            border-radius: 5px;
        }

        .wishlist-title {
            font-size: 16px;
            font-weight: bold;
            margin-top: 10px;
        }

        .wishlist-price {
            font-size: 14px;
            color: #777;
            margin-bottom: 10px;
        }

        .wishlist-item .fav-icon,
        .wishlist-item .add-icon {
            position: absolute;
            font-size: 1.5rem;
            cursor: pointer;
        }

        .wishlist-item .fav-icon {
            top: 10px;
            right: 10px;
            color: #ccc; /* Warna default untuk unliked */
        }

        .wishlist-item .add-icon {
            bottom: 10px;
            right: 10px;
            color: #007bff;
        }

        .add-new-collection {
            text-align: center;
            border: 1px dashed #ccc;
            padding: 1rem;
            border-radius: 5px;
            cursor: pointer;
            background-color: #f8f9fa;
        }

        .add-new-collection i {
            font-size: 2rem;
            color: #007bff;
        }

        /* Responsif */
        @media (max-width: 768px) {
            .wishlist-item {
                margin-bottom: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Nav -->
    <?php include '../components/navUser.php'; ?>

    <div class="container wishlist-container">
        <div class="row">
            <!-- Wishlist items -->
            <?php
            // Fetch and display wishlist items from the database
            $wishlist_items = array(
                array(
                    'image' => '../../images/adatlampung.jpg',
                    'title' => 'Women\'s wedding dress Lampung customs',
                    'price' => 'IDR 300.000 / Day'
                ),
                array(
                    'image' => '../../images/adatbali.jpg',
                    'title' => 'Couple\'s wedding dress Balinese customs',
                    'price' => 'IDR 800.000 / Day'
                )
            );

            foreach ($wishlist_items as $item) {
                echo '
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="wishlist-item">
                        <img src="' . $item['image'] . '" alt="' . $item['title'] . '">
                        <i class="bi bi-heart-fill fav-icon unliked" onclick="toggleFavorite(this)"></i>
                        <h5 class="wishlist-title">' . $item['title'] . '</h5>
                        <p class="wishlist-price">' . $item['price'] . '</p>
                        <i class="bi bi-plus-circle-fill add-icon"></i>
                    </div>
                </div>
                ';
            }
            ?>

            <!-- Add New Collection -->
            <div class="col-6 col-md-4 col-lg-3">
                <div class="add-new-collection">
                    <i class="bi bi-plus-lg"></i>
                    <p>Add New Collection</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleFavorite(icon) {
            icon.classList.toggle('unliked');
            if (icon.classList.contains('unliked')) {
                icon.style.color = '#ccc'; // Gray for unliked
            } else {
                icon.style.color = 'red'; // Red for liked
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
