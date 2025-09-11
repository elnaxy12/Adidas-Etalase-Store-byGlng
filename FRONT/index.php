<?php
session_start();
// Contoh username dari session
$username = $_SESSION['username'] ?? 'guest';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Shop</title>
    <link rel="stylesheet" href="index.css">

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Caveat:wght@400..700&family=Comic+Relief:wght@400;700&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Oswald:wght@200..700&display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Caveat:wght@400..700&family=Comic+Relief:wght@400;700&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Oswald:wght@200..700&family=Winky+Rough:ital,wght@0,300..900;1,300..900&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400..700&family=Comic+Relief:wght@400;700&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Oswald:wght@200..700&family=TASA+Explorer:wght@400..800&family=Winky+Rough:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">

</head>

<body>
    <div class="loader-main" id="loaderMain">
        <div class="loader"></div>
    </div>
    <div id="startBox" class="btn-start">
        <div class="col">
            <p>"Begin Your Journey in Style. Only with byGlng."</p>
            <button id="startBtn">Start</button>
        </div>
    </div>
    <div class="overlay" id="overlay">
        <div class="loader"></div>
    </div>
    <script>
        const loaderMain = document.getElementById("loaderMain");

        // tampilkan loader beberapa detik lalu hilang
        function showLoader(duration = 3000) { // durasi 3 detik default
            loaderMain.style.display = "block"; // pastikan muncul
            loaderMain.style.opacity = "1";

            setTimeout(() => {
                loaderMain.style.opacity = "0"; // fade out
                setTimeout(() => {
                    loaderMain.style.display = "none"; // sembunyikan setelah fade
                }, 500); // cocokkan dengan durasi transition
            }, duration);
        }

        // jalankan loader saat halaman dimuat
        showLoader(3000);

        const startBtn = document.getElementById("startBtn");
        const startBox = document.getElementById("startBox");
        const overlay = document.getElementById("overlay");

        startBtn.addEventListener("click", function() {
            // delay sebelum fadeOutDown
            setTimeout(() => {
                startBox.classList.add("fadeOutDown");

                // hilangkan teks setelah animasi
                setTimeout(() => {
                    startBox.style.display = "none";
                }, 800); // sesuai durasi transition fadeOutDown

                // tampilkan overlay setelah animasi mulai
                overlay.style.display = "block";
                setTimeout(() => {
                    overlay.classList.add("show");
                }, 50);

                // redirect ke page-etalase.php setelah 3 detik
                setTimeout(() => {
                    window.location.href = "page-etalase.php";
                }, 5000);

            }, 500); // delay awal 0.5 detik
        });
    </script>
</body>

</html>