<?php
    date_default_timezone_set('Asia/Jakarta');
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];

        $data_pengguna = "=========================\n" .
                        "Nama: $name\n" .
                        "Email: $email\n" .
                        "Telepon: $phone\n" .
                        "Waktu Edit: " . date("Y-m-d H:i:s") . "\n" .
                        "=========================\n\n";

        file_put_contents("data_user.txt", $data_pengguna, FILE_APPEND);

        if (isset($_FILES['profile-pic']) && $_FILES['profile-pic']['error'] === UPLOAD_ERR_OK) {
            
            $file_name = $_FILES['profile-pic']['name'];
            $file_tmp = $_FILES['profile-pic']['tmp_name'];
            
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            
            $allowed_ext = array("jpg", "png");

            if (in_array($file_ext, $allowed_ext)) {
                $upload_dir = "uploads/";
                
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }

                $target_file = $upload_dir . basename($file_name);

                if (move_uploaded_file($file_tmp, $target_file)) {
                    echo "<script>alert('Data dan foto berhasil disimpan!'); window.location.href='../profile.html';</script>";
                } else {
                    echo "<script>alert('Gagal memindahkan file foto ke direktori tujuan.'); window.history.back();</script>";
                }
            } else {
                echo "<script>alert('Gagal! Hanya file dengan ekstensi .jpg atau .png yang diperbolehkan.'); window.history.back();</script>";
            }
        } else {
            echo "<script>alert('Data profil berhasil diupdate (tanpa mengubah foto).'); window.location.href='profile.html';</script>";
        }
    } else {
        echo "Akses ditolak.";
    }
?>