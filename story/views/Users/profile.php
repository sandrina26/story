<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php"); // Redirect ke halaman login jika belum login
    exit();
}

include '../../database/configdb.php';

// Ambil data pengguna dari database berdasarkan id_user yang ada di sesi
$id_user = $_SESSION['id_user'];
$sql = "SELECT username, email, alamat, no_telp, foto_profil, birthday FROM user WHERE id_user = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_user);
$stmt->execute();
$result = $stmt->get_result();
$user_data = $result->fetch_assoc();

// Jika data pengguna tidak ditemukan, redirect ke halaman login
if (!$user_data) {
    header("Location: login.php");
    exit();
}

// Data pengguna
$username = $user_data['username'];
$email = $user_data['email'];
$alamat = $user_data['alamat'];
$no_telp = $user_data['no_telp'];
$foto_profil = $user_data['foto_profil'];
$birthday = $user_data['birthday'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];
    $no_telp = $_POST['no_telp'];
    $birthday = $_POST['birthday'];

    // Update data pengguna
    $sql_update = "UPDATE user SET username = ?, email = ?, alamat = ?, no_telp = ?, birthday = ? WHERE id_user = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("sssssi", $username, $email, $alamat, $no_telp, $birthday, $id_user);
    
    if ($stmt_update->execute()) {
        // Redirect setelah berhasil memperbarui
        echo "<script>alert('Update Profil Berhasil!'); window.location.href = 'profile.php';</script>";
    } else {
        echo "Error: " . $stmt_update->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../CSS/stylehome.css?ver=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .settings-container {
            display: flex;
            padding: 2rem;
        }

        .settings-menu {
            width: 25%;
            border-right: 1px solid #dee2e6;
            padding-right: 1.5rem;
        }

        .settings-menu a {
            display: flex;
            align-items: center;
            padding: 0.75rem 0;
            color: black;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .settings-menu a:hover {
            background-color: #f8f9fa;
        }

        .settings-menu a i {
            margin-right: 0.5rem;
        }

        .settings-menu a.active {
            font-weight: bold;
            color: #ffc107;
        }

        .settings-content {
            flex-grow: 1;
            padding-left: 2rem;
        }

        .profile-avatar {
            text-align: center;
        }

        .profile-avatar img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            margin-bottom: 1rem;
            object-fit: cover;
        }

        .profile-avatar button {
            display: block;
            margin: 0 auto 0.5rem;
        }

        .profile-avatar a {
            color: red;
            font-size: 0.9rem;
        }

        .alert-success {
            display: none;
            margin-top: 1rem;
            font-size: 0.9rem;
        }

        #avatarInput {
            display: none;
        }
    </style>
</head>
<body>
    <!-- Nav -->
    <?php include '../components/navUser.php'; ?>

    <div class="container mt-5">
        <div class="settings-container">
            <!-- Menu Kiri -->
            <div class="settings-menu">
                <h5>Account</h5>
                <a href="profil.php" class="active"><i class="bi bi-person"></i> Profil</a>
                <a href="nontifikasi.html"><i class="bi bi-bell"></i> Notification settings</a>
                <a href="passwordprofile.php"><i class="bi bi-shield-lock"></i> Password & Security</a>
                <a href="logout.php" class="text-danger"><i class="bi bi-box-arrow-right"></i> Log out</a>
            </div>

            <!-- Konten Kanan -->
            <div class="settings-content">
                <h5>Edit your profile</h5>
                <form id="profileForm" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="fullName" class="form-label">Full name</label>
                        <input type="text" class="form-control" id="fullName" name="username" value="<?php echo htmlspecialchars($username); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="birthday" class="form-label">Birthday</label>
                        <input type="date" class="form-control" id="birthday" name="birthday" value="<?php echo htmlspecialchars($birthday); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="no_telp" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="no_telp" name="no_telp" value="<?php echo htmlspecialchars($no_telp); ?>" placeholder="Enter your phone number">
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Address</label>
                        <textarea id="alamat" name="alamat" class="form-control" rows="3" placeholder="Type your address"><?php echo htmlspecialchars($alamat); ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>

            <!-- Avatar -->
            <div class="profile-avatar">
                <img id="avatarImage" src="../../images/<?php echo htmlspecialchars($foto_profil); ?>" alt="Avatar">
                <input type="file" id="avatarInput" accept="image/*" style="display:none;">
                <button class="btn btn-outline-secondary btn-sm" id="changeAvatarButton"><i class="bi bi-camera"></i> Change avatar</button>
                <a href="#" id="deleteAvatar">Delete Avatar</a>
            </div>
        </div>
    </div>

    <script>
        // Fungsi untuk menampilkan gambar baru saat pengguna memilih file
        document.getElementById('changeAvatarButton').addEventListener('click', function() {
            document.getElementById('avatarInput').click();
        });

        document.getElementById('avatarInput').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('avatarImage').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });

        // Fungsi untuk menghapus avatar
        document.getElementById('deleteAvatar').addEventListener('click', function(event) {
            event.preventDefault();
            // Set avatar ke gambar default
            document.getElementById('avatarImage').src = 'images/default-avatar.jpg';
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
