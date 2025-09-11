<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: login.html");
  exit;
}

$username = htmlspecialchars($_SESSION['user_id']);

// Koneksi database PDO
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

// Ambil data keranjang user
$stmt = $pdo->prepare("SELECT * FROM cart WHERE user_id = ?");
$stmt->execute([$username]);
$cartItems = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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
  <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400..700&family=Comic+Relief:wght@400;700&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Oswald:wght@200..700&family=TASA+Explorer:wght@400..800&family=Winky+Rough:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
</head>

<body class="fade-in">
  <div class="full" style="background-color: white;">
    <div class="main-wrapper">
      <nav class="navbar navbar-checkout">
        <div class="logo">
          <a href="index.php">by Glng</a>
        </div>
        <div class="back-cart">
          <i
            class="fa-solid fa-cart-shopping checkout"
            onclick="bukaHalamanCheckout()"
            title="Checkout"></i>
        </div>
      </nav>
    </div>
  </div>
  <div class="main-wrapper">
    <div class="shopping-checkout">
      <p>Shopping Checkout</p>
    </div>
    <div class="main-container">
      <div id="alamatList" class="main-checkout address-send">
        <p class="title">YOUR ADDRESS</p>
        <div class="checkout-active" style="border-bottom: none;">
          <div class="header-address-send">
            <div class="user_id">
              <p id="user_name" style="margin-bottom: 0;">
                Cust,&nbsp;<?= htmlspecialchars($username) ?>
              </p>
              <p id="user_phone" style="margin: 0;"></p>
            </div>
            <div class="address-empty">
              <p id="user_address">Change Your Address.</p>
            </div>
            <div class="change-address">
              <div id="utamafix" style="background: none; border: 1px solid transparent; color: transparent; padding: 1px 6px; margin: auto;">Utama</div>
              <a id="showUbah" class="change-address">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-pen-icon lucide-square-pen">
                  <path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                  <path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z" />
                </svg>
              </a>
            </div>
          </div>
        </div>
      </div>
      <div id="myUbah" class="address-change">
        <div class="page-address">
          <div class="top-address">
            <p class="title">YOUR ADDRESS</p>
          </div>
          <div class="page-add">
            <div id="hasilDiv" class="show-address">
              <div class="title-address">
                <div class="d-flex" style="gap: 10px;">
                  <div id="resultNamaDiv"></div>
                  <p>|</p>
                  <div style="color: rgba(0, 0, 0, 0.5);" id="resultTelpDiv"></div>
                </div>
                <div class="margin-p-0">
                  <div id="resultStreetDiv"></div>
                  <div id="resultProvDiv"></div>
                  <div style="color: rgba(0, 0, 0, 0.5); font-size: 0.8rem; margin-bottom: 1pc;" id="resultDetailDiv"></div>
                </div>
                <div class="d-flex" style="gap: 5px;">
                  <div id="utama" style="background: none; border: 1px solid rgba(0, 0, 0, 0.5); padding: 1px 6px; display: none;">Utama</div>
                  <div id="home" style="background: none; border: 1px solid rgba(0, 0, 0, 0.5); padding: 1px 6px; display: none;">Rumah</div>
                  <div id="office" style="background: none; border: 1px solid rgba(0, 0, 0, 0.5); padding: 1px 6px; display: none;">Kantor</div>
                </div>
              </div>
            </div>
            <div id="btnUtama"></div>
            <div id="btnRumah"></div>
            <div id="btnKantor"></div>
            <div class="mid-address">
              <div class="btn-new-address">
                <a id="showNew" href=""><i class="fa-solid fa-plus"></i> Add New Address</a>
              </div>
            </div>
          </div>
          <div class="bottom-address">
            <div class="flex-row-end bottom-address-bottom">
              <button id="closeChange">Cancel</button>
              <button id="confirmBtnLast">Confirm</button>
            </div>
          </div>
        </div>
      </div>
      <div id="myNew" class="new-address">
        <div class="page-address">
          <div class="top" style="border-bottom: 1px solid rgba(0, 0, 0, 0.1)">
            <p class="title">NEW ADDRESS</p>
          </div>
          <div class="page-add">
            <div class="mid-address-add">
              <div class="flex-row-add-new-address">
                <label for="">
                  <input type="text" class="input-nama" placeholder="FULL NAME">
                </label>
                <label for="">
                  <input type="text" class="input-telp" placeholder="PHONE NUMBER">
                </label>
              </div>
              <div class="address-class">
                <label class="address-class" for="">
                  <input type="text" class="inputProv" id="inputAlamat" placeholder="PROVINCE, CITY, DISTRICT, POSTAL CODE" readonly>
                </label>
              </div>
              <div class="dropdown-container">
                <div class="tb-dropdown">
                  <p class="tb-prov">PROVINCE</p>
                  <p class="tb-kot">CITY</p>
                  <p class="tb-kec">SUBDISCTRICT</p>
                  <p class="tb-pos">WARD</p>
                </div>
                <div class="provinsi" id="listProvinsi"></div>
                <div class="kota" id="listKota"></div>
                <div class="kecamatan" id="listKecamatan"></div>
                <div class="kelurahan" id="listKelurahan"></div>
              </div>
              <div class="address-street">
                <label for="">
                  <input id="alamat" class="inputStreet" type="text" placeholder="STREET, BUILDING, HOUSE NUMBER" oninput="pindahLokasi()" disabled>
                </label>
              </div>
              <div class="address-detail">
                <label for="">
                  <textarea type="text" class="inputDetail" placeholder="Additional Details (e.g., Block/Unit No., Landmark)"></textarea>
                </label>
              </div>
              <div class="address-maps">
                <iframe
                  src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126763.23482773276!2d106.6894302835709!3d-6.229728469999983!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f3e52b04f2b7%3A0x301576d14febc30!2sJakarta!5e0!3m2!1sid!2sid!4v1691403654985!5m2!1sid!2sid"
                  width="460"
                  id="map"
                  height="200"
                  style="border:0;"
                  allowfullscreen=""
                  loading="lazy"
                  referrerpolicy="no-referrer-when-downgrade">
                </iframe>
                <div id="lock"></div>
              </div>
              <div class="mark">
                <div class="margin-left-1pc">
                  <p>Label As</p>
                  <button class="select-button" onclick="selectButtonTable(this, 'Rumah'); toggleHome()">Home</button>
                  <button class="select-button" onclick="selectButtonTable(this, 'Kantor'); toggleOffice()">Office</button>
                  <p id="warning" style="color: red; font-size: 0.8rem; display: none;">Lengkapi Data Anda!!</p>
                </div>
              </div>
              <div class=" allocate">
                <div class="margin-left-1pc">
                  <label for="checkbox">
                    <input class="allocate" id="checkbox" style="margin-right: 10px;" type="checkbox" onclick="toggleUtama(this)">Set as personal address
                  </label>
                </div>
              </div>
            </div>
          </div>
          <div class="bottom">
            <div class="flex-row-end bottom-address">
              <button id="closeNew">Cancel</button>
              <button id="confirmBtn" style="margin-right: 2pc;">Confirm</button>
            </div>
          </div>
        </div>
      </div>
      <div class="container product-ordered">
        <div>
          <p class="margin title">Product Order</p>
        </div>
        <nav class="navbar-checkout">
          <p>Product Your Order</p>
          <p>Unit Price</p>
          <p>Quantity</p>
          <p>Total</p>
        </nav>
        <?php if (count($cartItems) === 0): ?>
        <?php else: ?>
          <?php foreach ($cartItems as $item):
            $subtotal = $item['price'] * $item['qty'];
            $brandClass = strtolower($item['brand']);
          ?>
            <div class="checkout-active" style="border-bottom: none;">
              <div class="flex-row-checkout">
                <div class="cart-item <?= $brandClass ?>">
                  <div class="cart-image" style="background-image:url('<?= $item['image_url'] ?>');"></div>
                  <div class="size">
                    <p>YOUR SIZE:</p>
                    <?= htmlspecialchars($item['size']) ?>
                  </div>
                  <p class="title margin-0">
                    <?= htmlspecialchars($item['product_name']) ?>
                  </p>
                </div>
                <p class="price margin-0">
                  $<?= number_format($item['price'], 2) ?>
                  USD
                </p>
                <label style="cursor: default;">
                  <input
                    type="number"
                    class="qty-input margin-0"
                    value="<?= $item['qty'] ?>"
                    min="1"
                    max="100"
                    data-id="<?= $item['id'] ?>"
                    style="background-color: transparent;"
                    disabled />
                </label>
                <p class="total-price margin-0">
                  $<?= number_format($subtotal, 2) ?>
                  USD
                </p>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
      <div class="voucher">
        <div class="space-around">
          <p>Voucher</p>
          <p>Status
            <i id="statusIcon" class="fa-solid fa-check check success error"></i>
          </p>
        </div>
        <p id="hasil"></p>
        <div class="input-code-voucher">
          <p class="title">Enter Your Code</p>
          <div class="d-flex-voucher">
            <label for="">
              <input id="kodeInput" class="input-voucher" type="text" placeholder="INPUT YOUR CODE">
            </label>
            <label for="">
              <input onclick="cekKode()" class="btn-voucher" type="button" value="CLAIM">
            </label>
          </div>
          <div class="discount">
            <p id="diskonInfo">$0 USD</p>
          </div>
          <div class="d-flex total-discount">
            <p>Total:</p>
            <p id="totalKeseluruhan">$0 USD</p>
          </div>
        </div>
      </div>
      <div class="payment-method ">

        <!-- Tampilan pilihan sekarang -->
        <div class="flex-between container">
          <p class="title">Payment Method</p>
          <div class="right-group">
            <p id="output">No payment method selected yet.</p>
            <p id="paymentShake" onclick="toggleList()" style="cursor: pointer;">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-credit-card-icon lucide-credit-card">
                <rect width="20" height="14" x="2" y="5" rx="2" />
                <line x1="2" x2="22" y1="10" y2="10" />
              </svg>
            </p>
          </div>
        </div>

        <!-- Pilihan metode pembayaran -->
        <div class="btn-payment" id="listSelector" style="display: none;">
          <div class="coloumn">
            <p>Select :</p>
            <div class="row">
              <button class="select-button" style="cursor: pointer;" onclick="selectButton(this, 'COD'); toggleCOD()">COD</button>
              <button class="select-button" style="cursor: pointer;" onclick="selectButton(this, 'Transfer Bank'); toggleTF()">BANK TRANSFER</button>
              <button class="select-button" style="cursor: pointer;" onclick="selectButton(this, 'Bayar Tunai di Mitra/Agen'); toggleMITRA()">CASH PAYMENT VIA AGENT</button>
            </div>
          </div>
        </div>

        <!-- Info pilihan yang tampil setelah dipilih -->
        <div class="payment-detail" id="paymentDetail">
          <div class="select" id="cod" style="display: none;">
            <div class="select">
              <p class="title">COD</p>
              <p>Cash On Delivery</p>
            </div>
          </div>
          <div class="select" id="tf" style="display: none;">
            <div class="select">
              <p class="title">Transfer Bank</p>
              <div class="coloumn bank">
                <label><input type="checkbox" name="bank" value="Bank BCA" onchange="selectOnlyOne(this)"> Bank BCA</label>
                <label><input type="checkbox" name="bank" value="Bank Mandiri" onchange="selectOnlyOne(this)"> Bank Mandiri</label>
                <label><input type="checkbox" name="bank" value="Bank BNI" onchange="selectOnlyOne(this)"> Bank BNI</label>
                <label><input type="checkbox" name="bank" value="Bank BRI" onchange="selectOnlyOne(this)"> Bank BRI</label>
                <label><input type="checkbox" name="bank" value="Bank Lainnya" onchange="selectOnlyOne(this)"> Bank Lainnya</label>
              </div>
            </div>
          </div>
          <div class="select" id="mitra" style="display: none;">
            <div class="select">
              <p class="title">Mitra/Agen</p>
              <div class="coloumn mitra">
                <label><input type="checkbox" name="mitra" value="Alfamart" onchange="selectOnlyOne(this)">Alfamart</label>
                <label><input type="checkbox" name="mitra" value="Alfamidi" onchange="selectOnlyOne(this)">Alfamidi</label>
                <label><input type="checkbox" name="mitra" value="Indomaret" onchange="selectOnlyOne(this)">Indomaret</label>
              </div>
            </div>
          </div>
        </div>
        <div class="totalYBill">
          <div class="d-flex-coloumn-pesanan-create">
            <div class="sub-total">
              <p>Subtotal Pesanan</p>
              <p id="totalSebelumDiskon">$0.00 USD</p>
            </div>
            <div class="sub-send">
              <p>Subtotal Pengiriman</p>
              <p id="shippingFee">$7.00 USD</p>
            </div>
            <div id="fee" class="fee">
              <p>Biaya Layanan</p>
              <p id="serviceFee">$1.00 USD</p>
            </div>
            <div id="totalyTotal" class="totalyTotal">
              <p>Total Pembayaran</p>
              <p>$0.00 USD</p>
            </div>
          </div>
        </div>
        <div class="make-an-order">
          <div class="right">
            <a href="#" id="makeOrderBtn">Make An Order</a>
          </div>
        </div>
      </div>
    </div>
    <div class="checkout-bottom">
      <div class="col-1">
        <div class="col-1-1">
          <p class="title">by Glng</p>
        </div>
        <div class="col-1-2">
          <p>ABOUT</p>
          <P>PRODUCT</P>
          <P>BLOG</P>
          <P>SHOP</P>
          <P>CONTACT</P>
        </div>
      </div>
      <div class="col-2">
        <P>Fashion inspired by art & fantasy. Crafted with elegance for your daily style.</P>
      </div>
      <div class="col-3">
        <div class="col-3-1">
          <p>Leksana Capital</p>
          <p>©2025. All right reserved</p>
        </div>
        <div class="col-3-2">
          <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/72/Logo_dana_blue.svg/512px-Logo_dana_blue.svg.png" alt="" width="77">
          <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e1/QRIS_logo.svg/384px-QRIS_logo.svg.png" alt="" width="131">
          <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/eb/Logo_ovo_purple.svg/512px-Logo_ovo_purple.svg.png" alt="" width="65">
        </div>
      </div>
    </div>
  </div>
  <script>
    let paymentMethod = null;
    let selectedMain = null; // tombol utama (COD / Bank / Mitra)

    // fungsi tombol metode utama
    function selectButton(btn, method) {
      selectedMain = method;
      console.log("Selected main:", selectedMain);

      // hapus class 'selected' dari semua tombol
      document.querySelectorAll('.select-button').forEach(b => b.classList.remove('selected'));

      // beri class 'selected' ke tombol yang diklik
      btn.classList.add('selected');

      // reset paymentMethod dulu
      paymentMethod = null;

      // jalankan toggle sesuai metode
      if (method === 'COD') {
        toggleCOD();
        paymentMethod = "COD"; // COD langsung valid
        document.getElementById("output").textContent = "Metode pembayaran: COD";
      } else if (method === 'Transfer Bank') {
        toggleTF();
        document.getElementById("output").textContent = "Pilih Bank untuk Transfer";
      } else if (method === 'Bayar Tunai di Mitra/Agen') {
        toggleMITRA();
        document.getElementById("output").textContent = "Pilih Agen/Mitra untuk Pembayaran Tunai";
      }
    }

    function selectOnlyOne(checkbox) {
      const name = checkbox.name;

      // pastikan hanya satu checkbox aktif dalam grup
      document.querySelectorAll(`input[name="${name}"]`).forEach(cb => {
        if (cb !== checkbox) cb.checked = false;
      });

      // set paymentMethod sesuai pilihan
      if (name === "bank") {
        paymentMethod = "Bank Transfer - " + checkbox.value;
      } else if (name === "mitra") {
        paymentMethod = "Cash via Agent - " + checkbox.value;
      }

      console.log("Metode pembayaran dipilih:", paymentMethod);
      document.getElementById("output").textContent = "Metode pembayaran: " + paymentMethod;
    }


    // handle tombol make-an-order
    const tombol = document.querySelectorAll('.make-an-order a');

    tombol.forEach(btn => {
      btn.addEventListener('click', e => {
        e.preventDefault();

        // logika AND
        if (!selectedMain || !paymentMethod) {
          const icon = document.getElementById("paymentShake");
          if (icon) {
            icon.classList.add('shake');
            setTimeout(() => icon.classList.remove('shake'), 500);
          }
          console.log("Harus pilih metode utama DAN detail (kalau ada).");
          return;
        }

        // hapus class clicked dari semua tombol
        tombol.forEach(b => b.classList.remove('clicked'));
        btn.classList.add('clicked');

        console.log("Proceed order with:", paymentMethod);
        // lanjutkan fetch order di sini
      });
    });


    //

    //discount group
    let appliedDiscount = null;

    const totalDisplays = [
      document.getElementById("totalKeseluruhan"),
    ];

    // daftar kode valid
    const kodeValid = {
      "ABC123": {
        type: "percent",
        value: 10
      }, // diskon 10%
      "FREE2025": {
        type: "fixed",
        value: 50
      }, // potongan $50
      "DISKON50": {
        type: "percent",
        value: 50
      }, // diskon 50%
    };

    function updateTotal() {
      let total = 0;

      // hitung subtotal item
      document.querySelectorAll('.checkout-active').forEach(div => {
        const priceText = div.querySelector('.price')?.textContent || '$0';
        const price = parseFloat(priceText.replace(/[^0-9.]/g, '')) || 0;
        const qtyInput = div.querySelector('.qty-input');
        const qty = qtyInput ? parseInt(qtyInput.value) || 1 : 1;
        const subtotal = price * qty;
        total += subtotal;

        const subtotalEl = div.querySelector('[data-subtotal]');
        if (subtotalEl) subtotalEl.textContent = subtotal.toFixed(2) + ' USD';
      });

      // subtotal sebelum diskon
      const totalSebelumDiskonEl = document.getElementById("totalSebelumDiskon");
      if (totalSebelumDiskonEl) totalSebelumDiskonEl.textContent = `$${total.toFixed(2)} USD`;

      // terapkan diskon
      const diskonInfo = document.getElementById("diskonInfo");
      let potongan = 0;
      if (appliedDiscount) {
        if (appliedDiscount.type === "percent") potongan = total * appliedDiscount.value / 100;
        else if (appliedDiscount.type === "fixed") potongan = appliedDiscount.value;
        total -= potongan;
        if (total < 0) total = 0;

        if (diskonInfo) {
          diskonInfo.textContent = appliedDiscount.type === "percent" ?
            `Diskon: ${appliedDiscount.value}% (-$${potongan.toFixed(2)})` :
            `Diskon: Potongan $${potongan.toFixed(2)}`;
        }
      } else if (diskonInfo) diskonInfo.textContent = "";

      // ambil subtotal pengiriman
      const shippingFeeEl = document.getElementById("shippingFee");
      let shippingFee = 0;
      if (shippingFeeEl) shippingFee = parseFloat(shippingFeeEl.textContent.replace(/[^0-9.]/g, '')) || 0;

      // ambil serviceFee hanya kalau fee tampil
      const feeContainer = document.getElementById("fee");
      let serviceFee = 0;
      if (feeContainer) {
        const displayStyle = window.getComputedStyle(feeContainer).display;
        if (displayStyle !== "none") {
          const serviceFeeEl = document.getElementById("serviceFee");
          serviceFee = parseFloat(serviceFeeEl.textContent.replace(/[^0-9.]/g, '')) || 0;
        }
      }

      // update totalDisplays (subtotal setelah diskon, tanpa shipping/fee)
      totalDisplays.forEach(el => {
        if (el) el.textContent = `$${total.toFixed(2)} USD`;
      });

      // update totalyTotal (final pembayaran)
      const totalyTotalEl = document.getElementById("totalyTotal");
      if (totalyTotalEl) {
        const finalTotal = total + shippingFee + serviceFee;
        totalyTotalEl.querySelector('p:last-child').textContent = `$${finalTotal.toFixed(2)} USD`;
      }
    }

    function cekKode() {
      const input = document.getElementById("kodeInput").value.trim();
      const hasil = document.getElementById("hasil");
      const icon = document.getElementById("statusIcon");

      if (kodeValid[input]) {
        appliedDiscount = kodeValid[input];
        hasil.className = "success";
        icon.className = "fa-solid fa-check check success";
      } else {
        appliedDiscount = null;
        hasil.className = "error";
        icon.className = "fa-solid fa-check check error";
      }

      updateTotal();
    }

    function ubahKeMobile() {
      if (window.innerWidth <= 768) {
        const el = document.getElementById("showUbah");
        if (el.tagName.toLowerCase() !== "i") {
          el.outerHTML = '<i id="showUbah" class="fa-solid fa-angle-right"' +
            'style = "color: black; padding: 10px; margin: auto 10pc;"></i>';
        }
      }
    }

    ubahKeMobile();
    window.addEventListener("resize", ubahKeMobile);

    function bukaHalamanCheckout() {
      // Ambil data alamat dari checkout
      const namaDivEl = document.getElementById('resultNamaDiv');
      const telpDivEl = document.getElementById('resultTelpDiv');
      const streetDivEl = document.getElementById('resultStreetDiv');
      const provDivEl = document.getElementById('resultProvDiv');

      const namaDiv = namaDivEl ? namaDivEl.textContent.trim() : '';
      const telpDiv = telpDivEl ? telpDivEl.textContent.trim() : '';
      const streetDiv = streetDivEl ? streetDivEl.textContent.trim() : '';
      const provDiv = provDivEl ? provDivEl.textContent.trim() : '';

      // Simpan alamat ke localStorage
      localStorage.setItem("alamat_nama", namaDiv);
      localStorage.setItem("alamat_telp", telpDiv);
      localStorage.setItem("alamat_street", streetDiv);
      localStorage.setItem("alamat_prov", provDiv);
      localStorage.setItem("checkoutAktif", "true");

      // Simpan cart items dari checkout (misal ada div .checkout-active)
      const cartItems = [];
      document.querySelectorAll('.checkout-active').forEach(div => {
        const qtyInput = div.querySelector('.qty-input');
        cartItems.push({
          id: div.dataset.id,
          qty: qtyInput ? parseInt(qtyInput.value) || 1 : 1
        });
      });
      localStorage.setItem("cart_items", JSON.stringify(cartItems));

      // Redirect ke cart.php
      window.location.href = "cart.php";
    }


    function toggleUtama(checkbox) {
      const div = document.getElementById('utama');
      if (checkbox.checked) {
        div.style.display = "block";
      } else {
        div.style.display = "none";
      }
    }

    function toggleHome() {
      document.getElementById('home').style.display = "block";
      document.getElementById('office').style.display = "none";
    }

    function toggleOffice() {
      document.getElementById('office').style.display = "block";
      document.getElementById('home').style.display = "none";
    }

    function toggleList() {
      const list = document.getElementById("list");
      if (list) {
        list.style.display =
          list.style.display === "flex" ? "none" : "flex";
      }
    }

    function toggleList() {
      const list = document.getElementById("listSelector");
      if (list) {
        const current = window.getComputedStyle(list).display;
        if (current === "none") {
          list.style.display = "flex"; // tampilkan div
        }
        // jika sudah tampil, klik berikutnya tidak lakukan apa-apa
      }
    }

    function clearCheckboxes(containerId) {
      const checkboxes = document.querySelectorAll(`#${containerId} input[type="checkbox"]`);
      checkboxes.forEach(cb => cb.checked = false);
    }

    function toggleCOD() {
      document.getElementById('cod').style.display = "block";
      document.getElementById('tf').style.display = "none";
      document.getElementById('mitra').style.display = "none";
      clearCheckboxes('tf');
      clearCheckboxes('mitra');
      document.getElementById('listSelector').style.display = "flex";
      document.getElementById('fee').style.display = "none"; // fee disembunyikan
      setTimeout(updateTotal, 0);
    }

    function toggleTF() {
      const fee = document.getElementById('fee');
      document.getElementById('cod').style.display = "none";
      document.getElementById('tf').style.display = "block";
      document.getElementById('mitra').style.display = "none";
      clearCheckboxes('mitra');
      document.getElementById('listSelector').style.display = "flex";
      if (fee) {
        fee.style.display = "flex";
        fee.style.justifyContent = "space-between";
      }
      setTimeout(updateTotal, 0);
    }

    function toggleMITRA() {
      const fee = document.getElementById('fee');
      document.getElementById('cod').style.display = "none";
      document.getElementById('tf').style.display = "none";
      document.getElementById('mitra').style.display = "block";
      clearCheckboxes('tf');
      document.getElementById('listSelector').style.display = "flex";
      if (fee) {
        fee.style.display = "flex";
        fee.style.justifyContent = "space-between";
      }
      setTimeout(updateTotal, 0);
    }

    let dataWilayah = [];

    fetch("wilayah.json")
      .then(response => {
        if (!response.ok) throw new Error("Gagal load data wilayah");
        return response.json();
      })
      .then(data => {
        dataWilayah = data;
        isiProvinsi();
      })
      .catch(err => console.error(err));

    function setSelected(selectedDiv) {
      const parent = selectedDiv.parentElement;
      [...parent.children].forEach(div => div.classList.remove('selected'));
      selectedDiv.classList.add('selected');
    }

    function showOnly(divToShow) {
      // sembunyikan semua
      document.querySelector('.provinsi').style.display = 'none';
      document.querySelector('.kota').style.display = 'none';
      document.querySelector('.kecamatan').style.display = 'none';
      document.querySelector('.kelurahan').style.display = 'none';

      // tampilkan yang diinginkan
      document.querySelector(divToShow).style.display = 'flex';
    }

    // saat load halaman
    function isiProvinsi() {
      const provDiv = document.getElementById("listProvinsi");
      provDiv.innerHTML = "";

      showOnly('.provinsi'); // hanya provinsi yang tampil saat awal

      // ambil data provinsi unik dan buat div clickable-nya
      const provinsiUnik = [...new Set(dataWilayah.map(w => w.provinsi))];
      provinsiUnik.forEach(prov => {
        const div = document.createElement("div");
        div.textContent = prov;
        div.style.cursor = "pointer";
        div.addEventListener("click", () => {
          setSelected(div);
          pilihProvinsi(prov);
        });
        provDiv.appendChild(div);
      });

      // kosongkan isi div lainnya
      document.getElementById("listkota").innerHTML = "";
      document.getElementById("listKecamatan").innerHTML = "";
      document.getElementById("listKelurahan").innerHTML = "";
      document.getElementById("inputAlamat").value = "";
    }

    // Pasang event listener ini hanya sekali, di luar fungsi isiProvinsi:
    document.getElementById('inputAlamat').addEventListener('click', () => {
      // Tampilkan dropdown container
      document.querySelector('.dropdown-container').style.display = 'block';

      // Tampilkan div provinsi dan sembunyikan yang lain
      document.querySelector('.provinsi').style.display = 'flex';
      document.querySelector('p.tb-prov').style.borderBottom = '1px solid white';
      document.querySelector('p.tb-kot').style.borderBottom = '1px solid transparent';
      document.querySelector('p.tb-kec').style.borderBottom = '1px solid transparent';
      document.querySelector('p.tb-pos').style.borderBottom = '1px solid transparent';
      document.querySelector('.kota').style.display = 'none';
      document.querySelector('.kecamatan').style.display = 'none';
      document.querySelector('.kelurahan').style.display = 'none';

      // Reset isi div dan input
      document.getElementById('listProvinsi').innerHTML = "";
      document.getElementById('listKota').innerHTML = "";
      document.getElementById('listKecamatan').innerHTML = "";
      document.getElementById('listKelurahan').innerHTML = "";
      document.getElementById('inputAlamat').value = "";

      isiProvinsi();
    });




    function pilihProvinsi(prov) {
      const kotaDiv = document.getElementById("listKota");
      kotaDiv.innerHTML = "";

      showOnly('.kota'); // tampilkan kota, sembunyikan lainnya
      document.querySelector('p.tb-prov').style.borderBottom = '1px solid transparent';
      document.querySelector('p.tb-kot').style.borderBottom = '1px solid white';
      document.querySelector('p.tb-kec').style.borderBottom = '1px solid transparent';
      document.querySelector('p.tb-pos').style.borderBottom = '1px solid transparent';


      const kotaUnik = [...new Set(dataWilayah.filter(w => w.provinsi === prov).map(w => w.kota))];
      kotaUnik.forEach(kota => {
        const div = document.createElement("div");
        div.textContent = kota;
        div.style.cursor = "pointer";
        div.addEventListener("click", () => {
          setSelected(div);
          pilihKota(prov, kota);
        });
        kotaDiv.appendChild(div);
      });

      document.getElementById("listKecamatan").innerHTML = "";
      document.getElementById("listKelurahan").innerHTML = "";
      document.getElementById("inputAlamat").value = prov;
    }

    function pilihKota(prov, kota) {
      const kecDiv = document.getElementById("listKecamatan");
      kecDiv.innerHTML = "";

      showOnly('.kecamatan'); // tampilkan kecamatan, sembunyikan lainnya
      document.querySelector('p.tb-prov').style.borderBottom = '1px solid transparent';
      document.querySelector('p.tb-kot').style.borderBottom = '1px solid transparent';
      document.querySelector('p.tb-kec').style.borderBottom = '1px solid white';
      document.querySelector('p.tb-pos').style.borderBottom = '1px solid transparent';


      const kecUnik = [...new Set(dataWilayah.filter(w => w.provinsi === prov && w.kota === kota).map(w => w.kecamatan))];
      kecUnik.forEach(kec => {
        const div = document.createElement("div");
        div.textContent = kec;
        div.style.cursor = "pointer";
        div.addEventListener("click", () => {
          setSelected(div);
          pilihKecamatan(prov, kota, kec);
        });
        kecDiv.appendChild(div);
      });

      document.getElementById("listKelurahan").innerHTML = "";
      document.getElementById("inputAlamat").value = `${prov}, ${kota}`;
    }

    function pilihKecamatan(prov, kota, kec) {
      const kelDiv = document.getElementById("listKelurahan");
      kelDiv.innerHTML = "";

      showOnly('.kelurahan'); // tampilkan kelurahan, sembunyikan lainnya
      document.querySelector('p.tb-prov').style.borderBottom = '1px solid transparent';
      document.querySelector('p.tb-kot').style.borderBottom = '1px solid transparent';
      document.querySelector('p.tb-kec').style.borderBottom = '1px solid transparent';
      document.querySelector('p.tb-pos').style.borderBottom = '1px solid white';


      const kelUnik = [...new Set(dataWilayah.filter(w => w.provinsi === prov && w.kota === kota && w.kecamatan === kec).map(w => w.kelurahan))];
      kelUnik.forEach(kel => {
        const div = document.createElement("div");
        div.textContent = kel;
        div.style.cursor = "pointer";
        div.addEventListener("click", () => {
          setSelected(div);
          pilihKelurahan(prov, kota, kec, kel);
        });
        kelDiv.appendChild(div);
      });

      document.getElementById("inputAlamat").value = `${prov}, ${kota}, ${kec}`;
    }

    function pilihKelurahan(prov, kota, kec, kel) {
      const lokasi = dataWilayah.find(w => w.provinsi === prov && w.kota === kota && w.kecamatan === kec && w.kelurahan === kel);
      if (lokasi) {
        document.getElementById("inputAlamat").value = `${prov}, ${kota}, ${kec}, ${kel}, ${lokasi.kode_pos}`;
      } else {
        document.getElementById("inputAlamat").value = `${prov}, ${kota}, ${kec}, ${kel}`;
      }

      inputAlamat.dispatchEvent(new Event('input'));

      // Tutup semua dropdown setelah input terisi lengkap
      document.querySelector('.provinsi').style.display = 'none';
      document.querySelector('.kota').style.display = 'none';
      document.querySelector('.kecamatan').style.display = 'none';
      document.querySelector('.kelurahan').style.display = 'none';
      document.querySelector('.dropdown-container').style.display = 'none';
    }

    //maps
    let timer;

    function pindahLokasi() {
      clearTimeout(timer); // reset jika masih mengetik
      timer = setTimeout(() => {
        let alamat = document.getElementById("alamat").value;
        if (alamat.trim() !== "") {
          let url = "https://www.google.com/maps?q=" + encodeURIComponent(alamat) + "&output=embed";
          document.getElementById("map").src = url;
        }
      }, 800); // delay 0.8 detik biar nggak nge-load tiap huruf
    }

    document.getElementById("showUbah").addEventListener("click", function(event) {
      event.preventDefault();
      document.getElementById("myUbah").style.display = "block";
      document.getElementById("showUbah").style.display = "none";
    });

    document.getElementById("closeChange").addEventListener("click", function(event) {
      event.preventDefault();
      document.getElementById("myUbah").style.display = "none";
      document.getElementById("showUbah").style.display = "inline";
    });

    document.getElementById("showNew").addEventListener("click", function(event) {
      event.preventDefault();
      document.getElementById("myNew").style.display = "block";
      document.getElementById("showNew").style.display = "none";
    });

    document.getElementById("closeNew").addEventListener("click", function(event) {
      event.preventDefault();
      document.getElementById("myNew").style.display = "none";
      document.getElementById("showNew").style.display = "inline";
    });

    document.addEventListener("DOMContentLoaded", () => {
      const inputAlamat = document.getElementById("inputAlamat");
      const alamat = document.getElementById("alamat");

      function updateAlamatStatus() {
        if (inputAlamat.value.trim() !== "") {
          alamat.disabled = false;
        } else {
          alamat.disabled = true;
          alamat.value = "";
        }
      }

      // Panggil saat halaman pertama kali dimuat
      updateAlamatStatus();

      // Pasang event listener untuk inputAlamat
      inputAlamat.addEventListener("input", updateAlamatStatus);
    });

    const checkbox = document.getElementById('checkbox');
    const btnRumah = document.getElementById('btnRumah');
    const btnKantor = document.getElementById('btnKantor');
    const btnUtama = document.getElementById('btnUtama');
    const confirmBtn = document.getElementById('confirmBtn');

    function cekKondisi() {
      btnRumah.style.display = 'none';
      btnKantor.style.display = 'none';
      btnUtama.style.display = 'none';

      if (!checkbox.checked) return;

      if (btnRumah.classList.contains('active')) btnRumah.style.display = 'inline-block';
      if (btnKantor.classList.contains('active')) btnKantor.style.display = 'inline-block';

      if (btnRumah.classList.contains('active') || btnKantor.classList.contains('active')) btnUtama.style.display = 'inline-block';
    }

    function selectButtonTable(btn) {
      // hapus class active dari semua tombol
      document.querySelectorAll('.select-button').forEach(b => b.classList.remove('active'));

      // beri class active pada tombol yang diklik
      btn.classList.add('active');
    }

    checkbox.addEventListener('change', cekKondisi);


    btnRumah.addEventListener('click', () => selectButton(btnRumah, 'Rumah'));
    btnKantor.addEventListener('click', () => selectButton(btnKantor, 'Kantor'));

    btnRumah.addEventListener('click', () => {
      btnRumah.classList.add('active');
      btnKantor.classList.remove('active');
      cekKondisi();
    });

    btnKantor.addEventListener('click', () => {
      btnKantor.classList.add('active');
      btnRumah.classList.remove('active');
      cekKondisi();
    });

    confirmBtn.addEventListener('click', () => {

      if (!btnRumah.classList.contains('active') && !btnKantor.classList.contains('active')) {
        btnRumah.classList.add('active');
      }

      cekKondisi();
    });

    // Fungsi untuk pasang event listener reset outline merah saat user input
    function pasangResetOutline(selector) {
      document.querySelectorAll(selector).forEach(input => {
        input.addEventListener('input', () => {
          input.style.backgroundColor = 'transparent';
        });
      });
    }

    // Pasang reset outline untuk input wajib
    pasangResetOutline('.input-nama');
    pasangResetOutline('.input-telp');
    pasangResetOutline('.inputStreet');
    pasangResetOutline('.inputProv');


    document.getElementById('confirmBtn').addEventListener('click', () => {
      const activeBtn = document.querySelector('.select-button.active');
      const checkbox = document.querySelector('input.allocate'); // pastikan ambil elemen input dengan class allocate
      const warning = document.getElementById('warning');


      if (!(activeBtn && checkbox.checked)) {
        warning.style.display = 'block';
        return;
      } else {
        warning.style.display = 'none';
      }

      const showNew = document.getElementById("showNew");
      const myNew = document.getElementById("myNew"); // form Add New Address

      // Tampilkan tombol selalu
      if (showNew) {
        showNew.style.display = "inline"; // atau "block"
      }

      // Klik tombol → tampilkan form myNew
      showNew.addEventListener("click", (e) => {
        e.preventDefault(); // cegah reload karena href=""
        if (myNew) myNew.style.display = "flex"; // atau "block"
      });

      // Ambil semua input nama
      const inputsNama = document.querySelectorAll('.input-nama');
      const valuesNama = Array.from(inputsNama).map(input => input.value.trim());

      // Ambil semua input telp
      const inputsTelp = document.querySelectorAll('.input-telp');
      const valuesTelp = Array.from(inputsTelp).map(input => input.value.trim());

      // Ambil semua input street
      const inputsStreet = document.querySelectorAll('.inputStreet');
      const valuesStreet = Array.from(inputsStreet).map(input => input.value.trim());

      // Ambil semua input provinsi
      const inputsProv = document.querySelectorAll('.inputProv');
      const valuesProv = Array.from(inputsProv).map(input => input.value.trim());

      const inputsDetail = document.querySelectorAll('.inputDetail');
      const valuesDetail = Array.from(inputsDetail).map(input => input.value.trim()).filter(v => v);

      let isValid = true; // flag validasi

      // Fungsi cek dan beri outline merah kalau kosong
      function cekInput(inputs, values) {
        inputs.forEach((input, i) => {
          if (values[i] === '') {
            input.style.border = '1px solid red';
            input.style.background = 'rgba(255, 0, 0, 0.01)';
            isValid = false;
          } else {
            input.style.border = '';
            input.style.background = '';
          }
        });
      }

      cekInput(inputsNama, valuesNama);
      cekInput(inputsTelp, valuesTelp);
      cekInput(inputsStreet, valuesStreet);
      cekInput(inputsProv, valuesProv);

      if (!isValid) {
        return;
      }


      // Ambil elemen hasil
      const resultNamaDiv = document.getElementById('resultNamaDiv');
      const resultTelpDiv = document.getElementById('resultTelpDiv');
      const resultStreetDiv = document.getElementById('resultStreetDiv');
      const resultProvDiv = document.getElementById('resultProvDiv');
      const resultDetailDiv = document.getElementById('resultDetailDiv');
      const hasilDiv = document.getElementById('hasilDiv');

      // Kosongkan hasil sebelumnya
      resultNamaDiv.innerHTML = '';
      resultTelpDiv.innerHTML = '';
      resultStreetDiv.innerHTML = '';
      resultProvDiv.innerHTML = '';
      resultDetailDiv.innerHTML = '';

      // Tampilkan hasil input
      valuesNama.forEach(val => {
        const p = document.createElement('p');
        p.textContent = val;
        resultNamaDiv.appendChild(p);
      });
      valuesTelp.forEach(val => {
        const p = document.createElement('p');
        p.textContent = val;
        resultTelpDiv.appendChild(p);
      });
      valuesStreet.forEach(val => {
        const p = document.createElement('p');
        p.textContent = val;
        resultStreetDiv.appendChild(p);
      });
      valuesProv.forEach(val => {
        const p = document.createElement('p');
        p.textContent = val;
        resultProvDiv.appendChild(p);
      });
      valuesDetail.forEach(val => {
        const p = document.createElement('p');
        p.textContent = val;
        resultDetailDiv.appendChild(p);
      });

      // Tampilkan div hasil
      hasilDiv.style.display = 'block';

      // Manipulasi UI lain
      document.getElementById("myNew").style.display = "none";
      document.getElementById("myUbah").style.display = "flex";

      const payload = {
        nama: valuesNama,
        telp: valuesTelp,
        street: valuesStreet,
        prov: valuesProv,
        detail: valuesDetail
      };
    });

    document.getElementById('confirmBtnLast').addEventListener('click', () => {
      const namaDiv = document.getElementById('resultNamaDiv').textContent.trim();
      const telpDiv = document.getElementById('resultTelpDiv').textContent.trim();
      const streetDiv = document.getElementById('resultStreetDiv').textContent.trim();
      const provDiv = document.getElementById('resultProvDiv').textContent.trim();
      const divUtama = document.getElementById('utamafix');

      const userName = document.getElementById('user_name');
      const userPhone = document.getElementById('user_phone');
      const userAddress = document.getElementById('user_address');

      // Kalau ada data semua
      if (namaDiv && telpDiv && streetDiv && provDiv) {
        // Styling
        divUtama.style.border = "1px solid rgba(0, 0, 0, 0.5)";
        divUtama.style.color = "black";

        // Set teks
        userName.textContent = `Cust, ${namaDiv}`;
        userPhone.textContent = telpDiv;
        userAddress.textContent = `${streetDiv}, ${provDiv}`;
        userAddress.classList.remove('address-empty');

        // Tanggal daftar (format YYYY-MM-DD)
        const today = new Date();
        const tanggalDaftar = today.getFullYear() + '-' +
          String(today.getMonth() + 1).padStart(2, '0') + '-' +
          String(today.getDate()).padStart(2, '0');

        // Kirim ke PHP
        fetch('simpan_alamat.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `nama_lengkap=${encodeURIComponent(namaDiv)}&no_telp=${encodeURIComponent(telpDiv)}&street=${encodeURIComponent(streetDiv + ', ' + provDiv)}&tanggal_daftar=${encodeURIComponent(tanggalDaftar)}`
          })
          .then(res => res.text())
          .then(res => console.log(res))
          .catch(err => console.error(err));

        // Ubah tampilan
        document.getElementById("myUbah").style.display = "none";
        document.getElementById("showUbah").style.display = "";
      }
    });

    fetch("ambil_alamat.php")
      .then(res => res.json())
      .then(data => {
        const showUbah = document.getElementById("showUbah");
        const myNew = document.getElementById("myNew");
        const myUbah = document.getElementById("myUbah"); // elemen tambahan
        const closeNew = document.getElementById("closeNew");

        // sembunyikan awalnya
        if (myNew) myNew.style.display = "none";
        if (myUbah) myUbah.style.display = "none";

        if (!data.error && data.length > 0) {
          const alamat = data[0];

          // Isi data user
          document.getElementById("user_name").textContent = `Cust, ${alamat.nama_lengkap}`;
          document.getElementById("user_phone").textContent = alamat.no_telp;
          document.getElementById("user_address").textContent = alamat.street;

          // Tanda Utama
          const utamaDiv = document.getElementById("utamafix");
          utamaDiv.style.cssText = "background: transparent; border: 1px solid black; color: black; padding: 1px 6px;";
          utamaDiv.textContent = "Main";

          // Ganti showUbah → showNew dan klik → tampilkan myNew
          if (showUbah) {
            showUbah.id = "showNew";
            showUbah.addEventListener("click", () => {
              if (myNew) myNew.style.display = "inline";
              if (myUbah) myUbah.style.display = "inline";
            });
          }

          // closeNew → tutup myNew dan myUbah
          if (closeNew) {
            closeNew.addEventListener("click", () => {
              if (myNew) myNew.style.display = "none";
              if (myUbah) myUbah.style.display = "none";
            });
          }

        } else {
          // Data kosong atau error → showUbah tetap
          if (showUbah) showUbah.style.display = "inline";
          document.getElementById("user_address").textContent = data.error || "Change Your Address.";
        }
      })
      .catch(err => {
        console.error("Gagal ambil alamat:", err);
        document.getElementById("user_address").textContent = "Gagal memuat data.";
      });

    function setupToggle(showBtnId, modalId, closeBtnId, displayMode = "block") {
      const showBtn = document.getElementById(showBtnId);
      const modal = document.getElementById(modalId);
      const closeBtn = document.getElementById(closeBtnId);

      if (!showBtn || !modal || !closeBtn) return;

      showBtn.addEventListener("click", (e) => {
        e.preventDefault();
        modal.style.display = displayMode;
        showBtn.style.display = "none";
      });

      closeBtn.addEventListener("click", (e) => {
        e.preventDefault();
        modal.style.display = "none";
        showBtn.style.display = "inline";
      });
    }

    // ===========================
    // Submit Order KE DataBase
    // ===========================

    //

    // ===================
    // Button Make Order
    // ===================
    const shippingFee = 5; // contoh ongkir
    const serviceFeeCOD = 0;
    const serviceFeeOthers = 2;

    // Ambil total pembayaran dari cart nyata
    function calculateCartSubtotal() {
      let subtotal = 0;

      document.querySelectorAll('.checkout-active').forEach(item => {
        const priceText = item.querySelector('.price')?.textContent || '$0';
        const price = parseFloat(priceText.replace(/[^0-9.]/g, '')) || 0;
        const qtyInput = item.querySelector('.qty-input');
        const qty = qtyInput ? parseInt(qtyInput.value) || 1 : 1;
        subtotal += price * qty;
      });

      return subtotal;
    }

    document.addEventListener("DOMContentLoaded", function() {

      // Ambil semua item di cart
      const cartItems = Array.from(document.querySelectorAll('.cart-item')).map(div => {
        const classes = Array.from(div.classList).filter(c => c !== 'cart-item');
        const brand = classes[0] || "Unknown"; // nama brand dari class
        const price = parseFloat(div.querySelector('.price')?.textContent.replace(/[^0-9.]/g, '')) || 0;
        const qty = parseInt(div.querySelector('.qty-input')?.value) || 1;
        return {
          brand,
          price,
          qty
        };
      });


      document.getElementById("makeOrderBtn").addEventListener("click", function(e) {
        if (!paymentMethod) {
          e.preventDefault(); // cegah order

          // ambil icon dari parent lain
          const icon = document.getElementById("paymentShake");
          icon.classList.add('shake');

          // hapus class shake setelah animasi selesai
          setTimeout(() => icon.classList.remove('shake'), 500);

          return;
        }

        e.preventDefault();

        // Proses order seperti biasa
        const totalyTotalEl = document.getElementById("totalyTotal");
        let totally = 0;
        if (totalyTotalEl) {
          totally = parseFloat(
            totalyTotalEl.querySelector('p:last-child').textContent.replace(/[^0-9.]/g, '')
          ) || 0;
        }

        fetch("submit_order.php", {
            method: "POST",
            headers: {
              "Content-Type": "application/json"
            },
            body: JSON.stringify({
              payment_method: paymentMethod,
              totally: totally,
              items: cartItems
            })
          })
          .then(res => res.json())
          .then(data => {
            if (data.success) window.location.href = "index.php";
            else console.error("Gagal:", data.message);
          })
          .catch(err => console.error(err));
      });

    });

    //


    // cukup sekali dipanggil
    setupToggle("showUbahCopy", "myUbahCopy", "closeChangeCopy", "block");
    updateTotal();
  </script>
</body>

</html>