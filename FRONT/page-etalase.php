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
    <link rel="stylesheet" href="page-etalase.css">

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

<body id="overlay" class="fadeIn">
    <div id="navbar" class="full-navbar">
        <div class="col1">
            <p>"Style meets savings—shop the latest collection now!"</p>
        </div>
        <div class="col2">
            <div class="col1">
                <a href="#">byGlng</a>
            </div>
            <div class="col2">
                <a href="#">MEN</a>
                <a href="#">WOMAN</a>
                <a href="#">KIDS</a>
                <a href="#">BACK TO SCHOOL</a>
                <a href="#">SALE</a>
                <a href="#">NEW & TRENDING</a>
            </div>
            <div class="col3">
                <label for="#">
                    <input type="text" placeholder="SEARCH">
                    <button>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search-icon lucide-search">
                            <path d="m21 21-4.34-4.34" />
                            <circle cx="11" cy="11" r="8" />
                        </svg>
                    </button>
                </label>
                <a href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-icon lucide-user">
                        <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                    </svg>
                </a>
                <a href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-heart-icon lucide-heart">
                        <path d="M2 9.5a5.5 5.5 0 0 1 9.591-3.676.56.56 0 0 0 .818 0A5.49 5.49 0 0 1 22 9.5c0 2.29-1.5 4-3 5.5l-5.492 5.313a2 2 0 0 1-3 .019L5 15c-1.5-1.5-3-3.2-3-5.5" />
                    </svg>
                </a>
                <a href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-baggage-claim-icon lucide-baggage-claim">
                        <path d="M22 18H6a2 2 0 0 1-2-2V7a2 2 0 0 0-2-2" />
                        <path d="M17 14V4a2 2 0 0 0-2-2h-1a2 2 0 0 0-2 2v10" />
                        <rect width="13" height="8" x="8" y="6" rx="1" />
                        <circle cx="18" cy="20" r="2" />
                        <circle cx="9" cy="20" r="2" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
    <div class="full-banner">
        <div class="banner">
            <div class="main-wrapper">
                <div class="col1">
                    <p>WE ARE SO BACK</p>
                    <p style="font-weight: 100;">Set the tone this school year with timeless adidas apparel and footwear.</p>
                </div>
                <div class="col2">
                    <button>SHOP MEN</button>
                    <button>SHOP WOMEN</button>
                    <button>SHOP KIDS</button>
                </div>
            </div>
        </div>
    </div>
    <div class="main-wrapper">
        <div class="container-slide">
            <button class="btn-slider btn-prev">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-left-icon lucide-chevron-left">
                    <path d="m15 18-6-6 6-6" />
                </svg>
            </button>
            <div id="slider" class="etalase-slide">
                <div class="slide">
                    <div class="prototype">
                        <button class="appreciate">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-heart-icon lucide-heart">
                                <path d="M2 9.5a5.5 5.5 0 0 1 9.591-3.676.56.56 0 0 0 .818 0A5.49 5.49 0 0 1 22 9.5c0 2.29-1.5 4-3 5.5l-5.492 5.313a2 2 0 0 1-3 .019L5 15c-1.5-1.5-3-3.2-3-5.5" />
                            </svg>
                        </button>
                        <button class="appreciate">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-heart-icon lucide-heart">
                                <path d="M2 9.5a5.5 5.5 0 0 1 9.591-3.676.56.56 0 0 0 .818 0A5.49 5.49 0 0 1 22 9.5c0 2.29-1.5 4-3 5.5l-5.492 5.313a2 2 0 0 1-3 .019L5 15c-1.5-1.5-3-3.2-3-5.5" />
                            </svg>
                        </button>
                        <img src="https://assets.adidas.com/images/w_600,f_auto,q_auto/606f418a01a14c419ac35e7c84a5e2d2_9366/Samba_OG_Shoes_Brown_JR0891_00_plp_standard.jpg" alt="">
                    </div>
                    <p class="price">$100</p>
                    <p class="title-product">SAMBA OG SHOES</p>
                    <P class="badge-product">ORIGINALS</P>
                </div>
                <div class="slide">
                    <div class="prototype">
                        <button class="appreciate">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-heart-icon lucide-heart">
                                <path d="M2 9.5a5.5 5.5 0 0 1 9.591-3.676.56.56 0 0 0 .818 0A5.49 5.49 0 0 1 22 9.5c0 2.29-1.5 4-3 5.5l-5.492 5.313a2 2 0 0 1-3 .019L5 15c-1.5-1.5-3-3.2-3-5.5" />
                            </svg>
                        </button>
                        <img src="https://assets.adidas.com/images/w_600,f_auto,q_auto/9da93feaffd84fa5baf15e0b9727687a_9366/Swift_Run_1.0_Shoes_Grey_JR6898_00_plp_standard.jpg" alt="">
                    </div>
                    <p class="price">$60</p>
                    <p class="title-product">SWIFT RUN 1.0 SHOES</p>
                    <P class="badge-product">SPORTSWEAR</P>
                </div>
                <div class="slide">
                    <div class="prototype">
                        <button class="appreciate">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-heart-icon lucide-heart">
                                <path d="M2 9.5a5.5 5.5 0 0 1 9.591-3.676.56.56 0 0 0 .818 0A5.49 5.49 0 0 1 22 9.5c0 2.29-1.5 4-3 5.5l-5.492 5.313a2 2 0 0 1-3 .019L5 15c-1.5-1.5-3-3.2-3-5.5" />
                            </svg>
                        </button>
                        <img src="https://assets.adidas.com/images/w_600,f_auto,q_auto/e694f6e9261b48d6b255ca8a1388d3d5_9366/ULTRABOOST_1.0_SHOES_White_JR1987_HM1.jpg" alt="">
                    </div>
                    <p class="price">$135</p>
                    <p class="title-product">ULTRABOOST 1.0 SHOES</p>
                    <P class="badge-product">SPORTSWEAR</P>
                </div>
                <div class="slide">
                    <div class="prototype">
                        <button class="appreciate">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-heart-icon lucide-heart">
                                <path d="M2 9.5a5.5 5.5 0 0 1 9.591-3.676.56.56 0 0 0 .818 0A5.49 5.49 0 0 1 22 9.5c0 2.29-1.5 4-3 5.5l-5.492 5.313a2 2 0 0 1-3 .019L5 15c-1.5-1.5-3-3.2-3-5.5" />
                            </svg>
                        </button>
                        <img src="https://assets.adidas.com/images/w_600,f_auto,q_auto/911ec048adc4471f938af50867c2ad85_9366/Gazelle_Indoor_Shoes_Red_JI2063_00_plp_standard.jpg" alt="">
                    </div>
                    <p class="price">$120</p>
                    <p class="title-product">GAZELLA INDOOR SHOES</p>
                    <P class="badge-product">ORIGINALS</P>
                </div>
                <div class="slide">
                    <div class="prototype">
                        <button class="appreciate">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-heart-icon lucide-heart">
                                <path d="M2 9.5a5.5 5.5 0 0 1 9.591-3.676.56.56 0 0 0 .818 0A5.49 5.49 0 0 1 22 9.5c0 2.29-1.5 4-3 5.5l-5.492 5.313a2 2 0 0 1-3 .019L5 15c-1.5-1.5-3-3.2-3-5.5" />
                            </svg>
                        </button>
                        <img src="https://assets.adidas.com/images/w_600,f_auto,q_auto/ed03f2b031b04884a8481cec1ccca4e2_9366/Adizero_EVO_SL_Shoes_Black_JP7149_00_plp_standard.jpg" alt="">
                    </div>
                    <p class="price">$150</p>
                    <p class="title-product">ADIZERO EVO SL SHOES</p>
                    <P class="badge-product">PERFORMANCE</P>
                </div>
                <div class="slide">
                    <div class="prototype">
                        <button class="appreciate">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-heart-icon lucide-heart">
                                <path d="M2 9.5a5.5 5.5 0 0 1 9.591-3.676.56.56 0 0 0 .818 0A5.49 5.49 0 0 1 22 9.5c0 2.29-1.5 4-3 5.5l-5.492 5.313a2 2 0 0 1-3 .019L5 15c-1.5-1.5-3-3.2-3-5.5" />
                            </svg>
                        </button>
                        <img src="https://assets.adidas.com/images/w_600,f_auto,q_auto/ee99b4b9bde74f30a933a8bf011911ae_9366/Samba_OG_Shoes_Black_B75807_00_plp_standard.jpg" alt="">
                    </div>
                    <p class="price">$100</p>
                    <p class="title-product">SAMBA OG SHOES</p>
                    <P class="badge-product">ORIGINALS</P>
                </div>
                <div class="slide">
                    <div class="prototype">
                        <button class="appreciate">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-heart-icon lucide-heart">
                                <path d="M2 9.5a5.5 5.5 0 0 1 9.591-3.676.56.56 0 0 0 .818 0A5.49 5.49 0 0 1 22 9.5c0 2.29-1.5 4-3 5.5l-5.492 5.313a2 2 0 0 1-3 .019L5 15c-1.5-1.5-3-3.2-3-5.5" />
                            </svg>
                        </button>
                        <img src="https://assets.adidas.com/images/w_600,f_auto,q_auto/f0ca2dd8bdb84a2ab11faacb8802c4dc_9366/Ultraboost_1.0_Shoes_White_HQ4202_HM1.jpg" alt="">
                    </div>
                    <p class="price">$135</p>
                    <p class="title-product">ULTRABOOST 1.0 SHOES</p>
                    <P class="badge-product">SPORTSWEAR</P>
                </div>
                <div class="slide">
                    <div class="prototype">
                        <button class="appreciate">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-heart-icon lucide-heart">
                                <path d="M2 9.5a5.5 5.5 0 0 1 9.591-3.676.56.56 0 0 0 .818 0A5.49 5.49 0 0 1 22 9.5c0 2.29-1.5 4-3 5.5l-5.492 5.313a2 2 0 0 1-3 .019L5 15c-1.5-1.5-3-3.2-3-5.5" />
                            </svg>
                        </button>
                        <img src="https://assets.adidas.com/images/w_600,f_auto,q_auto/507b9464089e4c818536b4613435aebf_9366/Samba_OG_Shoes_Blue_ID2056_00_plp_standard.jpg" alt="">
                    </div>
                    <p class="price">$135</p>
                    <p class="title-product">ULTRABOOST 1.0 SHOES</p>
                    <P class="badge-product">SPORTSWEAR</P>
                </div>
            </div>
            <button class="btn-slider btn-next">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right-icon lucide-chevron-right">
                    <path d="m9 18 6-6-6-6" />
                </svg>
            </button>
        </div>
    </div>

    <script>
        // =======================
        // animasi fadeIn
        // =======================
        window.addEventListener("DOMContentLoaded", () => {
            const overlay = document.getElementById("overlay");

            // pastikan elemen terlihat
            overlay.style.display = "block";

            // jalankan fadeIn
            setTimeout(() => {
                overlay.classList.add("show");
            }, 1000); // delay kecil supaya transition bekerja
        });

        //

        // ===============================
        // animasi fadeUp kalo scrollDown
        // ===============================

        let lastScroll = 0;
        const navbar = document.getElementById("navbar");

        window.addEventListener("scroll", () => {
            const currentScroll = window.scrollY;

            if (currentScroll > lastScroll && currentScroll > 50) {
                // scroll down → hide navbar
                navbar.classList.add("hide");
            } else {
                // scroll up → show navbar
                navbar.classList.remove("hide");
            }

            lastScroll = currentScroll;
        });

        //

        // ================
        // etalase-slide
        // ================

        const slider = document.getElementById("slider");
        const btnNext = document.querySelector(".btn-next");
        const btnPrev = document.querySelector(".btn-prev");

        let currentIndex = 0;
        const cardWidth = 310; // 200px + margin
        const visibleCards = 4;
        const totalCards = slider.children.length;

        function updateButtons() {
            btnPrev.classList.toggle("hidden", currentIndex === 0);
            btnNext.classList.toggle("hidden", currentIndex >= totalCards - visibleCards);
        }

        btnNext.addEventListener("click", () => {
            if (currentIndex < totalCards - visibleCards) {
                currentIndex++;
                slider.style.transform = `translateX(${-cardWidth * currentIndex}px)`;
                updateButtons();
            }
        });

        btnPrev.addEventListener("click", () => {
            if (currentIndex > 0) {
                currentIndex--;
                slider.style.transform = `translateX(${-cardWidth * currentIndex}px)`;
                updateButtons();
            }
        });

        // set awal
        updateButtons();
    </script>
</body>

</html>