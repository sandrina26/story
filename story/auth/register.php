<?php
include "../database/configdb.php"; // Pastikan Anda telah mengonfigurasi koneksi database
// Cek apakah form telah disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hash password menggunakan md5
    $hashed_password = md5($password);

    // Query untuk memeriksa apakah email atau username sudah ada di database
    $sql_check_user = "SELECT * FROM user WHERE email = ? OR username = ?";
    $stmt_check = $conn->prepare($sql_check_user);
    $stmt_check->bind_param("ss", $email, $username);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        $existing_user = $result_check->fetch_assoc();
        if ($existing_user['email'] === $email) {
            $error_message = "Email telah terdaftar!";
        } elseif ($existing_user['username'] === $username) {
            $error_message = "Username sudah terdaftar!";
        }
    } else {
        // Query untuk menyimpan data user baru
        $sql_insert = "INSERT INTO user (email, username, password, role) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql_insert);
        $role = 'user'; // Mengatur role secara default sebagai 'user'
        $stmt->bind_param("ssss", $email, $username, $hashed_password, $role);

        if ($stmt->execute()) {
            // Redirect ke halaman login setelah berhasil daftar
            header("Location: login.php");
            exit();
        } else {
            $error_message = "Terjadi kesalahan, coba lagi!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Page</title>
    <link rel="stylesheet" href="../CSS/stylelogin.css">
</head>

<body>
    <div class="container">
        <div class="signup-form">
            <img src="../images/logo.png" alt="Story Logo" class="logo">
            <h1 style="color: black;">Sign up</h1>

            <form action="register.php" method="POST">
                <label for="email">Enter email</label>
                <input type="email" id="email" name="email" placeholder="Email" required><br>

                <label for="username">Enter Username</label>
                <input type="text" id="username" name="username" placeholder="Username" required><br>

                <label for="password">Enter Password</label>
                <input type="password" id="password" name="password" placeholder="Password" required><br>

                <button type="submit" class="signup-button">Sign up</button>

                <p class="login-link">Already have an account? <a href="login.php" style="color: rgb(0, 140, 255)">Log In</a></p>

                <?php
                // Menampilkan pesan error jika ada
                if (isset($error_message)) {
                    echo "<p style='color:red;'>$error_message</p>";
                }
                ?>
            </form>
        </div>
        <div class="illustration">
            <img src="../images/gambarlogo.png" alt="Illustration" width="1000" height="600">
        </div>
    </div>
</body>

</html>

<?php
// Menutup koneksi
$conn->close();
?>