<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: login.html");
  exit;
}

$user_id = $_SESSION['user_id'];

// Koneksi DB
$host = 'localhost';
$db   = 'db_etalase';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
  $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
  die("Koneksi DB gagal: " . $e->getMessage());
}

// Ambil data keranjang dari DB ke user
$stmt = $pdo->prepare("SELECT * FROM cart WHERE user_id = ?");
$stmt->execute([$user_id]);
$cartItems = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Checkout</title>
  <link rel="stylesheet" href="style.css" />
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
</head>

<body class="fade-in">

  <!--loading btn hapus style-->
  <style>
    .loader-1 {
      width: 100px;
      height: 20px;
      background:
        linear-gradient(#000 0 0) 0/0% no-repeat #ddd;
      animation: l1 0.7s infinite linear;
      display: flex;
      border-radius: 4px;
    }

    @keyframes l1 {
      100% {
        background-size: 100%
      }
    }

    .loader-2 {
      width: 100px;
      height: 20px;
      background:
        linear-gradient(#000 0 0) left/20px 20px no-repeat #ddd;
      animation: l2 1.2s infinite linear;
    }

    @keyframes l2 {
      50% {
        background-position: right
      }
    }

    .btn-batal.loading svg {
      display: none;
    }

    .btn-hapus-semua.loading .btn-text {
      display: none;
      margin: 0;
    }

    .btn-hapus-semua.loading {
      border: none;
    }

    .btn-hapus-semua .btn-text {
      font-size: 16px;
      margin: 0;
      font-weight: 600;
    }
  </style>
  <!-------------------------->

  <div class="full backEtalase">
    <div class="main-wrapper">
      <div class="d-flex border-bottom">
        <i id="backtophp" class="fa-solid fa-arrow-left arrow-animate"></i>
        <a href="index.php" class="margin-back">Back to Etalase</a>
      </div>
    </div>
  </div>
  <div class="full">
    <div class="main-wrapper">
      <nav class="navbarnav">
        <p style="margin: auto 0;" class="total-keseluruhan" id="totalKeseluruhan">Total: $0.00 USD</p>
        <div class="flex-row-end navbar-head">
          <button class="btn-hapus-semua" id="btnHapusSemua" title="Delete All">
            <span class="btn-text">Hapus Semua</span> </button>
          <i
            class="fa-solid fa-store store"
            onclick="window.location.href='index.php'"
            title="Back To Etalase">
          </i>
        </div>
      </nav>
    </div>
  </div>
  <div class="main-wrapper">
    <div class="shopping-cart">
      <p>Shopping Cart</p>
    </div>
    <div class="main-container">
      <div class="page-checkout">
        <div class="cart-table" style="background-color: white;">
          <nav class="navbar-cart">
            <p>Product</p>
            <p>Unit Price</p>
            <p>Quantity</p>
            <p>Total</p>
            <p>Action</p>
          </nav>
          <div class="mid-checkout">
            <?php if (count($cartItems) === 0): ?>
              <div class="page-empty">
                <div class="empty">
                  <p>There Is Nothing Here ...</p>
                </div>
              </div>
            <?php else: ?>
              <div id="container-checkout">
                <?php
                $total = 0;
                foreach ($cartItems as $index => $item):
                  $subtotal = $item['price'] * $item['qty'];
                  $total += $subtotal;
                  $brandClass = strtolower($item['brand']);
                ?>
                  <div class="checkout-active" data-id="<?= $item['id'] ?>">
                    <div class="flex-row-cart">
                      <div class="cart-item <?= $brandClass ?>">
                        <div class="cart-image" style="background-image:url('<?= $item['image_url'] ?>');"></div>
                        <p class="title"><?= htmlspecialchars($item['product_name']) ?></p>
                        <button class="btn-size">
                          <?= htmlspecialchars($item['size']) ?>
                          <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down-icon">
                            <path d="m6 9 6 6 6-6" />
                          </svg>
                        </button>

                        <div class="size-dropdown-content">
                          <?php
                          $sizes = ["36", "36 2/3", "37 1/3", "38", "38 2/3", "39 1/3", "40"];
                          foreach ($sizes as $sizeOption) {
                            echo "<button data-size='$sizeOption'>$sizeOption</button>";
                          }
                          ?>
                        </div>
                      </div>
                      <p class="price margin-0">$<?= number_format($item['price'], 2) ?> USD</p>
                      <div class="number-input">
                        <button class="plus">
                          <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="14"
                            height="14"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="lucide lucide-plus-icon lucide-plus">
                            <path d="M5 12h14" />
                            <path d="M12 5v14" />
                          </svg>
                        </button>
                        <input type="number" class="qty-input margin-0" value="<?= $item['qty'] ?>" min="1" max="99" data-id="<?= $item['id'] ?>">
                        <button class="minus">
                          <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="14"
                            height="14"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="lucide lucide-minus-icon lucide-minus">
                            <path d="M5 12h14" />
                          </svg>
                        </button>
                      </div>
                      <p class="total-price margin-0">$<?= number_format($subtotal, 2) ?> USD</p>
                      <div class="row">
                        <button class="btn-batal" data-id="<?= htmlspecialchars($item['product_name']) ?>" title="Hapus" onclick="hapusItem(this)">
                          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash2-icon lucide-trash-2">
                            <path d="M10 11v6" />
                            <path d="M14 11v6" />
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                            <path d="M3 6h18" />
                            <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                          </svg>
                        </button>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
    <div class="navbar-bottom d-flex space-between">
      <p style="margin: auto 0;" class="total-price" id="totalKeseluruhanCopy">Total: $0.00 USD</p>
      <div class="flex-row-end navbar-head">
        <button class="btn-checkout" id="btnCheckoutCopy" type="button" title="Checkout">
          Checkout
        </button>
      </div>
    </div>
    <button class="btn-checkout" id="btnCheckout" type="button" title="Checkout">
      Update Cart
    </button>
    <div class="cart-bottom">
      <div class="col-1">
        <p>Leksana Capital</p>
        <p>©2025. All right reserved</p>
      </div>
      <div class="col-2">
        <button>Facebook</button>
        <button>Intagram</button>
        <button>Twitter</button>
        <button>LinkedIn</button>
      </div>
      <div class="col-3">
        <p>Jl. Indraloka 4</p>
        <p>Bekasi, Indonesia</p>
      </div>
    </div>
  </div>

  <script>
    // ========================
    // Loading btn delete item
    // ========================
    function hapusItem(btn) {
      // tambahkan class loading
      btn.classList.add("loading");

      // buat loader
      const loader = document.createElement("span");
      loader.classList.add("loader-1");
      btn.appendChild(loader);

      // simulasi proses hapus (misal AJAX)
      setTimeout(() => {
        // hapus loader
        loader.remove();
        btn.classList.remove("loading");

        // aksi setelah selesai hapus, misal:
        const itemName = btn.getAttribute("data-id");
      }, 700); // 1.5 detik
    }

    //

    // =======================
    // dropdown size content
    // =======================

    document.querySelectorAll(".cart-item").forEach(cartItem => {
      const btnSize = cartItem.querySelector(".btn-size");
      const dropdown = cartItem.querySelector(".size-dropdown-content");

      // Toggle dropdown
      btnSize.addEventListener("click", e => {
        e.stopPropagation();
        dropdown.classList.toggle("show");
      });

      // Pilih size
      dropdown.querySelectorAll("button").forEach(option => {
        option.addEventListener("click", () => {
          btnSize.childNodes[0].nodeValue = option.textContent + " ";
          dropdown.classList.remove("show");

          // Optional: update ke DB via AJAX
          const cartId = <?= json_encode($item['id']) ?>;
          fetch('update_size.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `id=${cartId}&size=${option.textContent}`
          });
        });
      });
    });

    // Klik di luar dropdown → tutup semua
    window.addEventListener("click", () => {
      document.querySelectorAll(".size-dropdown-content").forEach(dd => dd.classList.remove("show"));
    });


    // =====================
    // Fungsi update total
    // =====================
    const totalDisplays = [
      document.getElementById("totalKeseluruhan"),
      document.getElementById("totalKeseluruhanCopy")
    ];

    function updateTotal() {
      let total = 0;

      document.querySelectorAll('.checkout-active').forEach(div => {
        const priceText = div.querySelector('.price')?.textContent || '$0';
        const price = parseFloat(priceText.replace(/[^0-9.]/g, '')) || 0;
        const qtyInput = div.querySelector('.qty-input');
        const qty = qtyInput ? parseInt(qtyInput.value) || 1 : 1;
        const subtotal = price * qty;

        total += subtotal;

        const subtotalEl = div.querySelector('.total-price');
        if (subtotalEl) subtotalEl.textContent = '$' + subtotal.toFixed(2) + ' USD';
      });

      totalDisplays.forEach(el => {
        if (el) el.textContent = '$' + total.toFixed(2) + ' USD';
      });
    }

    // =====================
    // Bind tombol plus/minus dan input manual
    // =====================
    document.querySelectorAll('.checkout-active').forEach(div => {
      const qtyInput = div.querySelector('.qty-input');
      const btnMinus = div.querySelector('.minus');
      const btnPlus = div.querySelector('.plus');

      // tombol minus
      btnMinus?.addEventListener('click', () => {
        if (parseInt(qtyInput.value) > parseInt(qtyInput.min)) {
          qtyInput.value = parseInt(qtyInput.value) - 1;
          updateTotal();
          updateServer(qtyInput);
        }
      });

      // tombol plus
      btnPlus?.addEventListener('click', () => {
        if (parseInt(qtyInput.value) < parseInt(qtyInput.max)) {
          qtyInput.value = parseInt(qtyInput.value) + 1;
          updateTotal();
          updateServer(qtyInput);
        }
      });

      // input manual
      qtyInput.addEventListener('input', () => {
        let val = parseInt(qtyInput.value);
        if (isNaN(val) || val < parseInt(qtyInput.min)) qtyInput.value = qtyInput.min;
        if (val > parseInt(qtyInput.max)) qtyInput.value = qtyInput.max;
        updateTotal();
        updateServer(qtyInput);
      });
    });

    // =====================
    // Update server untuk quantity
    // =====================
    function updateServer(input) {
      const id = input.dataset.id;
      const qty = parseInt(input.value);

      fetch('update_cart.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            id,
            qty
          })
        })
        .then(res => res.json())
        .then(data => {
          if (!data.success) console.warn("Server error:", data.message);
        })
        .catch(() => alert('Terjadi kesalahan update quantity'));
    }

    // =====================
    // Bind tombol hapus item
    // =====================
    document.querySelectorAll('.btn-batal').forEach(btn => {
      btn.addEventListener('click', e => {
        const id = btn.dataset.id;

        fetch('hapus_cart.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify({
              id
            })
          })
          .then(res => res.json())
          .then(data => {
            if (data.success) {
              setTimeout(() => {
                const div = btn.closest('.checkout-active');
                if (div) div.remove();
                updateTotal();
                checkEmptyCart();
              }, 700);
            } else {
              alert('Gagal menghapus item');
            }
          })
          .catch(() => alert('Terjadi kesalahan hapus item'));
      });
    });

    // =====================
    // Tombol hapus semua
    // =====================
    document.getElementById('btnHapusSemua')?.addEventListener('click', function() {
      const btn = this;

      // cek apakah tabel cart kosong
      if (document.querySelectorAll('.checkout-active').length === 0) {
        return;
      }

      // tambahkan class loading
      btn.classList.add("loading");

      // buat loader di tombol
      const loader = document.createElement("span");
      loader.classList.add("loader-2");
      btn.appendChild(loader);

      // delay sebelum fetch (opsional, bisa langsung fetch juga)
      setTimeout(() => {
        fetch('hapus_semua_cart.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify({})
          })
          .then(res => res.json())
          .then(data => {
            if (data.success) {
              // hapus semua elemen checkout-active
              document.querySelectorAll('.checkout-active').forEach(div => div.remove());
              updateTotal();
              checkEmptyCart();
            } else {
              alert('Gagal menghapus semua item');
            }
          })
          .catch(err => {
            console.error(err);
            alert('Terjadi kesalahan');
          })
          .finally(() => {
            // hapus loader & restore tombol
            loader.remove();
            btn.classList.remove("loading");
          });
      }, 1200);
    }, {
      once: true
    }); // event listener hanya dijalankan sekali



    // =====================
    // Cek apakah cart kosong
    // =====================
    function checkEmptyCart() {
      const midCheckout = document.querySelector('.mid-checkout');
      const totalDisplay = document.getElementById("totalKeseluruhan");
      if (document.querySelectorAll('.checkout-active').length === 0) {
        if (midCheckout) {
          midCheckout.innerHTML = `
        <div class="page-empty">
          <div class="empty"><p>There Is Nothing Here ...</p></div>
        </div>`;
        }
        if (totalDisplay) totalDisplay.textContent = '$0.00 USD';

        // Disable tombol checkout
        ["btnCheckout", "btnCheckoutCopy"].forEach(id => {
          const btn = document.getElementById(id);
          if (btn) {
            btn.disabled = true;
            btn.style.opacity = "0.5";
            btn.style.pointerEvents = "none";
          }
        });
      }
    }

    // =====================
    // Tombol checkout
    // =====================
    ["btnCheckout", "btnCheckoutCopy"].forEach(id => {
      const btn = document.getElementById(id);
      if (btn) {
        btn.addEventListener('click', () => {
          if (document.querySelectorAll('.checkout-active').length > 0) {
            window.location.href = 'checkout.php';
          }
        });
      }
    });

    // =====================
    // Tombol kembali ke index.php
    // =====================
    document.getElementById("backtophp")?.addEventListener("click", () => {
      window.location.href = "index.php";
    });

    // =====================
    // Inisialisasi awal
    // =====================
    updateTotal();
  </script>
</body>

</html>