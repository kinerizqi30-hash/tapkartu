<?php
$file_json = 'profil.json';

// Inisialisasi data default jika file belum ada
if (!file_exists($file_json)) {
    $profil_default = [
        "nama" => "Muhammad Rizqi",
        "role" => "Global Institute",
        "bio_line1" => "Mahasiswa Global Institute",
        "bio_line2" => "Kasir Finance & Marketing",
        "whatsapp" => "6289525935034",
        "instagram" => "rizqi067",
        "tiktok" => "kinerizqi",
        "website" => "https://mitrarating.com",
        "email" => "kinerizqi30@gmail.com",
        "foto" => "https://cdn.phototourl.com/member/2026-10-22-7ac54029-1946-4d0f-8af2-59a64d05371d.jpg"
    ];
    file_put_contents($file_json, json_encode($profil_default, JSON_PRETTY_PRINT));
}

// Proses simpan data ketika form edit dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $profil_baru = [
        "nama" => $_POST['nama'],
        "role" => $_POST['role'],
        "bio_line1" => $_POST['bio_line1'],
        "bio_line2" => $_POST['bio_line2'],
        "whatsapp" => $_POST['whatsapp'],
        "instagram" => $_POST['instagram'],
        "tiktok" => $_POST['tiktok'],
        "website" => $_POST['website'],
        "email" => $_POST['email'],
        "foto" => $_POST['foto']
    ];

    file_put_contents($file_json, json_encode($profil_baru, JSON_PRETTY_PRINT));
    header("Location: index.php");
    exit;
}

// Ambil data terbaru
$profil = json_decode(file_get_contents($file_json), true);
$is_edit_mode = isset($_GET['edit']) && $_GET['edit'] === 'true';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?php echo $profil['nama']; ?> - Kartu Nama Digital</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
            -webkit-tap-highlight-color: transparent;
        }

        body {
            background: #0f172a;
            color: #f8fafc;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 16px;
            position: relative;
            overflow-x: hidden;
        }

        .bg-glow-1 {
            position: fixed;
            top: -10%;
            left: -10%;
            width: 320px;
            height: 320px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.35) 0%, rgba(0, 0, 0, 0) 70%);
            border-radius: 50%;
            filter: blur(50px);
            z-index: 0;
            pointer-events: none;
        }

        .bg-glow-2 {
            position: fixed;
            bottom: -10%;
            right: -10%;
            width: 320px;
            height: 320px;
            background: radial-gradient(circle, rgba(168, 85, 247, 0.3) 0%, rgba(0, 0, 0, 0) 70%);
            border-radius: 50%;
            filter: blur(50px);
            z-index: 0;
            pointer-events: none;
        }

        .container {
            width: 100%;
            max-width: 410px;
            background: rgba(30, 41, 59, 0.65);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 28px;
            padding: 32px 22px 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            text-align: center;
            position: relative;
            z-index: 1;
            margin: auto;
        }

        .top-share-btn,
        .top-edit-btn {
            position: absolute;
            top: 20px;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #cbd5e1;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            text-decoration: none;
        }

        .top-share-btn {
            right: 20px;
        }

        .top-edit-btn {
            right: 66px;
            color: #38bdf8;
        }

        .profile-img-container {
            position: relative;
            width: 108px;
            height: 108px;
            margin: 0 auto 18px;
        }

        .profile-img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid rgba(255, 255, 255, 0.2);
            background: #1e293b;
        }

        .name-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            margin-bottom: 6px;
        }

        .name {
            font-size: 22px;
            font-weight: 700;
            color: #ffffff;
        }

        .verified-badge {
            color: #38bdf8;
            font-size: 16px;
        }

        .role-tag {
            display: inline-block;
            background: rgba(99, 102, 241, 0.15);
            border: 1px solid rgba(99, 102, 241, 0.3);
            color: #818cf8;
            font-size: 11px;
            font-weight: 600;
            padding: 4px 12px;
            border-radius: 20px;
            margin-bottom: 12px;
            text-transform: uppercase;
        }

        .bio {
            font-size: 13.5px;
            color: #94a3b8;
            margin-bottom: 22px;
            line-height: 1.5;
        }

        .quick-actions {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin-bottom: 22px;
        }

        .action-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            padding: 12px 8px;
            border-radius: 16px;
            color: #e2e8f0;
            text-decoration: none;
            font-size: 11px;
            font-weight: 500;
            cursor: pointer;
        }

        .links-container {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .link-btn {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 14px 18px;
            border-radius: 16px;
            color: #ffffff;
            text-decoration: none;
            font-weight: 600;
            font-size: 14.5px;
            cursor: pointer;
        }

        .link-btn .left-content {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .icon-box {
            width: 36px;
            height: 36px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .wa-bg {
            background: rgba(37, 211, 102, 0.15);
            color: #25d366;
        }

        .ig-bg {
            background: rgba(225, 48, 108, 0.15);
            color: #e1306c;
        }

        .tt-bg {
            background: rgba(255, 255, 255, 0.12);
            color: #ffffff;
        }

        .web-bg {
            background: rgba(56, 189, 248, 0.15);
            color: #38bdf8;
        }

        .mail-bg {
            background: rgba(250, 204, 21, 0.15);
            color: #facc15;
        }

        /* Form Edit Styling */
        .form-group {
            margin-bottom: 14px;
            text-align: left;
        }

        .form-group label {
            display: block;
            font-size: 12px;
            color: #94a3b8;
            margin-bottom: 4px;
            font-weight: 500;
        }

        .form-control {
            width: 100%;
            padding: 10px 14px;
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 12px;
            color: #fff;
            font-size: 13.5px;
        }

        .form-control:focus {
            outline: none;
            border-color: #6366f1;
        }

        .btn-submit {
            width: 100%;
            padding: 12px;
            background: #6366f1;
            border: none;
            border-radius: 12px;
            color: #fff;
            font-weight: 600;
            cursor: pointer;
            margin-top: 10px;
        }

        .btn-cancel {
            display: block;
            text-align: center;
            color: #94a3b8;
            text-decoration: none;
            font-size: 13px;
            margin-top: 10px;
        }

        .footer {
            margin-top: 26px;
            padding-top: 16px;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
            font-size: 12px;
            color: #64748b;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .toast {
            position: fixed;
            bottom: 24px;
            left: 50%;
            transform: translateX(-50%) translateY(100px);
            background: #1e293b;
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #f8fafc;
            padding: 10px 20px;
            border-radius: 30px;
            font-size: 13px;
            opacity: 0;
            transition: all 0.3s ease;
            z-index: 1000;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .toast.show {
            transform: translateX(-50%) translateY(0);
            opacity: 1;
        }
    </style>
</head>

<body>

    <div class="bg-glow-1"></div>
    <div class="bg-glow-2"></div>

    <div class="container">
        <?php if ($is_edit_mode): ?>
            <!-- FORM EDIT PROFIL -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h2 style="font-size: 18px; color: #fff;">Edit Profil</h2>
                <a href="index.php" style="color: #94a3b8; font-size: 13px; text-decoration: none;"><i class="fa-solid fa-xmark"></i> Batal</a>
            </div>

            <form action="index.php" method="POST">
                <input type="hidden" name="update_profile" value="1">

                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control" value="<?php echo htmlspecialchars($profil['nama']); ?>" required>
                </div>
                <div class="form-group">
                    <label>Role / Instansi</label>
                    <input type="text" name="role" class="form-control" value="<?php echo htmlspecialchars($profil['role']); ?>" required>
                </div>
                <div class="form-group">
                    <label>Bio Baris 1</label>
                    <input type="text" name="bio_line1" class="form-control" value="<?php echo htmlspecialchars($profil['bio_line1']); ?>">
                </div>
                <div class="form-group">
                    <label>Bio Baris 2</label>
                    <input type="text" name="bio_line2" class="form-control" value="<?php echo htmlspecialchars($profil['bio_line2']); ?>">
                </div>
                <div class="form-group">
                    <label>WhatsApp (format: 628xxx)</label>
                    <input type="text" name="whatsapp" class="form-control" value="<?php echo htmlspecialchars($profil['whatsapp']); ?>" required>
                </div>
                <div class="form-group">
                    <label>Username Instagram</label>
                    <input type="text" name="instagram" class="form-control" value="<?php echo htmlspecialchars($profil['instagram']); ?>" required>
                </div>
                <div class="form-group">
                    <label>Username TikTok</label>
                    <input type="text" name="tiktok" class="form-control" value="<?php echo htmlspecialchars($profil['tiktok']); ?>" required>
                </div>
                <div class="form-group">
                    <label>Website URL</label>
                    <input type="text" name="website" class="form-control" value="<?php echo htmlspecialchars($profil['website']); ?>">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($profil['email']); ?>" required>
                </div>
                <div class="form-group">
                    <label>URL Foto Profil</label>
                    <input type="text" name="foto" class="form-control" value="<?php echo htmlspecialchars($profil['foto']); ?>">
                </div>

                <button type="submit" class="btn-submit">Simpan Perubahan</button>
            </form>

        <?php else: ?>
            <!-- TAMPILAN KARTU NAMA UTAMA -->
            <a href="index.php?edit=true" class="top-edit-btn" title="Edit Profil">
                <i class="fa-solid fa-pen-to-square"></i>
            </a>
            <button class="top-share-btn" onclick="copyProfileLink()" title="Bagikan Profil">
                <i class="fa-solid fa-share-nodes"></i>
            </button>

            <!-- Foto Profil -->
            <div class="profile-img-container">
                <img src="<?php echo $profil['foto']; ?>" alt="<?php echo $profil['nama']; ?>" class="profile-img"
                    onerror="this.src='https://placehold.co/128x128/6366f1/ffffff?text=MR'">
            </div>

            <!-- Nama & Verified Badge -->
            <div class="name-wrapper">
                <h1 class="name"><?php echo $profil['nama']; ?></h1>
                <i class="fa-solid fa-circle-check verified-badge" title="Terverifikasi"></i>
            </div>

            <div class="role-tag"><?php echo $profil['role']; ?></div>

            <!-- Bio Profil -->
            <p class="bio">
                <?php echo $profil['bio_line1']; ?><br>
                <span style="color: #cbd5e1; font-weight: 500;"><?php echo $profil['bio_line2']; ?></span>
            </p>

            <!-- Akses Cepat (Quick Actions) -->
            <div class="quick-actions">
                <a href="https://wa.me/<?php echo $profil['whatsapp']; ?>" target="_blank" class="action-item">
                    <i class="fa-brands fa-whatsapp" style="color: #25d366;"></i>
                    <span>Chat WA</span>
                </a>
                <a href="tel:<?php echo $profil['whatsapp']; ?>" class="action-item">
                    <i class="fa-solid fa-phone" style="color: #38bdf8;"></i>
                    <span>Telepon</span>
                </a>
                <div class="action-item" onclick="copyEmail()">
                    <i class="fa-solid fa-copy" style="color: #facc15;"></i>
                    <span>Salin Email</span>
                </div>
            </div>

            <!-- Daftar Tautan Utama -->
            <div class="links-container">
                <a href="https://wa.me/<?php echo $profil['whatsapp']; ?>" target="_blank" class="link-btn">
                    <div class="left-content">
                        <div class="icon-box wa-bg"><i class="fa-brands fa-whatsapp"></i></div>
                        <span>WhatsApp Kami</span>
                    </div>
                    <i class="fa-solid fa-chevron-right arrow-icon"></i>
                </a>

                <a href="https://www.instagram.com/<?php echo $profil['instagram']; ?>" target="_blank" class="link-btn">
                    <div class="left-content">
                        <div class="icon-box ig-bg"><i class="fa-brands fa-instagram"></i></div>
                        <span>Instagram</span>
                    </div>
                    <i class="fa-solid fa-chevron-right arrow-icon"></i>
                </a>

                <a href="https://tiktok.com/@<?php echo $profil['tiktok']; ?>" target="_blank" class="link-btn">
                    <div class="left-content">
                        <div class="icon-box tt-bg"><i class="fa-brands fa-tiktok"></i></div>
                        <span>TikTok</span>
                    </div>
                    <i class="fa-solid fa-chevron-right arrow-icon"></i>
                </a>

                <a href="<?php echo $profil['website']; ?>" target="_blank" class="link-btn">
                    <div class="left-content">
                        <div class="icon-box web-bg"><i class="fa-solid fa-globe"></i></div>
                        <span>Website Resmi</span>
                    </div>
                    <i class="fa-solid fa-chevron-right arrow-icon"></i>
                </a>

                <div class="link-btn" onclick="openEmail()">
                    <div class="left-content">
                        <div class="icon-box mail-bg"><i class="fa-solid fa-envelope"></i></div>
                        <span>Kirim Email</span>
                    </div>
                    <i class="fa-solid fa-chevron-right arrow-icon"></i>
                </div>
            </div>

            <!-- Footer -->
            <div class="footer">
                <span>&copy; 2026 Kartu Nama Digital</span>
                <span style="font-weight: 600; color: #818cf8;">Rizqi Profile</span>
            </div>
        <?php endif; ?>
    </div>

    <!-- Toast Notification -->
    <div id="toast" class="toast">
        <i class="fa-solid fa-circle-check" style="color: #4ade80;"></i>
        <span id="toast-msg">Notifikasi</span>
    </div>

    <!-- SCRIPT JAVASCRIPT -->
    <script>
        const EMAIL_ADDRESS = "<?php echo $profil['email']; ?>";

        function openEmail() {
            let start = Date.now();
            window.location.href = "mailto:" + EMAIL_ADDRESS;
            setTimeout(function() {
                if (Date.now() - start < 1000) {
                    window.open(`https://mail.google.com/mail/?view=cm&fs=1&to=${EMAIL_ADDRESS}`, '_blank');
                }
            }, 500);
        }

        function copyEmail() {
            navigator.clipboard.writeText(EMAIL_ADDRESS).then(() => {
                showToast("Email berhasil disalin ke papan klip!");
            }).catch(() => {
                showToast("Email: " + EMAIL_ADDRESS);
            });
        }

        function copyProfileLink() {
            if (navigator.share) {
                navigator.share({
                    title: '<?php echo $profil['nama']; ?> - Kartu Nama Digital',
                    url: window.location.href
                }).catch(() => {});
            } else {
                navigator.clipboard.writeText(window.location.href).then(() => {
                    showToast("Tautan profil berhasil disalin!");
                });
            }
        }

        function showToast(message) {
            const toast = document.getElementById("toast");
            const toastMsg = document.getElementById("toast-msg");
            toastMsg.innerText = message;
            toast.classList.add("show");
            setTimeout(() => {
                toast.classList.remove("show");
            }, 2500);
        }
    </script>
</body>

</html>