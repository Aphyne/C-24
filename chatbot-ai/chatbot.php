<?php
session_start();
if (!isset($_SESSION["jabatan"])) {
    echo "<script>location='../login/index.php'</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Poli Klinik | Chatbot AI</title>
    <link href="../assets/css/styles.css" rel="stylesheet" />
    <link href="../assets/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <script src="../assets/js/all.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* NAVBAR */
        .sb-topnav.navbar {
            background: linear-gradient(90deg, #5459AC 70%, #6fc3d0 100%) !important;
            box-shadow: 0 4px 18px rgba(84,89,172,0.12);
            border-bottom: none;
            min-height: 62px;
        }
        .sb-topnav .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            letter-spacing: 1px;
            color: #fff !important;
            text-shadow: 0 2px 8px rgba(84,89,172,0.10);
        }
        .sb-topnav .navbar-nav .nav-link,
        .sb-topnav .navbar-nav .dropdown-toggle {
            color: #fff !important;
            font-weight: 500;
            font-size: 1.1rem;
            transition: color 0.2s;
        }
        .sb-topnav .navbar-nav .nav-link:hover,
        .sb-topnav .navbar-nav .dropdown-toggle:hover {
            color:rgb(255, 255, 255) !important;
        }
        .sb-topnav .form-control {
            border-radius: 8px;
            border: none;
            box-shadow: 0 2px 8px rgba(84,89,172,0.08);
        }
        .sb-topnav .btn-light {
            background: #fff;
            color: #5459AC;
            border-radius: 8px;
            border: none;
            transition: background 0.2s, color 0.2s;
        }
        .sb-topnav .btn-light:hover {
            background:rgb(255, 255, 255);
            color: #222;
        }

        /* SIDEBAR */
        .sb-sidenav {
            background: linear-gradient(135deg, #5459AC 50%, rgb(111,195,208) 100%) !important;
            color: #fff;
            box-shadow: 2px 0 18px rgba(84,89,172,0.10);
        }
        .sb-sidenav .sb-sidenav-menu-heading {
            color: #fff;
            font-weight: 700;
            letter-spacing: 1px;
            margin-top: 18px;
            margin-bottom: 8px;
        }
        .sb-sidenav .nav-link {
            color: #fff !important;
            font-weight: 500;
            border-radius: 8px;
            margin-bottom: 4px;
            transition: background 0.18s, color 0.18s, transform 0.18s;
            padding: 10px 18px;
            position: relative;
        }
        .sb-sidenav .nav-link.active,
        .sb-sidenav .nav-link:hover,
        .sb-sidenav .nav-link:focus {
            background: rgba(255,255,255,0.13) !important;
            color: #fff !important;
            transform: translateX(4px) scale(1.04);
            box-shadow: 0 2px 12px rgba(84,89,172,0.10);
        }
        .sb-sidenav .sb-nav-link-icon {
            color: #fff !important;
            margin-right: 10px;
            font-size: 1.1rem;
            transition: color 0.18s;
        }
        .sb-sidenav .nav-link.active .sb-nav-link-icon,
        .sb-sidenav .nav-link:hover .sb-nav-link-icon {
            color:rgb(255, 255, 255) !important;
        }
        .sb-sidenav .sb-sidenav-collapse-arrow {
            color: #fff;
        }
        .sb-sidenav .collapse .nav-link {
            background: rgba(255,255,255,0.08) !important;
            color: #fff !important;
            margin-left: 12px;
        }
        .sb-sidenav .collapse .nav-link:hover {
            background: rgba(0,255,202,0.13) !important;
            color: #fff !important;
        }
        .sb-sidenav .sb-sidenav-menu-nested .nav-link {
            font-size: 1rem;
            padding-left: 32px;
        }
        .sb-sidenav .sb-sidenav-menu-heading {
            margin-left: 8px;
        }
        .sb-sidenav::-webkit-scrollbar {
            width: 7px;
            background: transparent;
        }
        .sb-sidenav::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.18);
            border-radius: 8px;
        }
        @media (max-width: 991px) {
            .sb-sidenav {
                background:linear-gradient(135deg, #5459AC 30%, rgb(111,195,208) 100%) !important;
            }
        }

        /* --- SUMMARY BOX MODERN STYLE --- */
        body, .summary-box, .summary-box * {
            font-family: 'Poppins', Arial, sans-serif !important;
        }

        .summary-box {
            background: #fff;
            border-radius: 18px;
            padding: 20px 18px 16px 18px;
            display: flex;
            flex-direction: column;
            min-height: 150px;
            position: relative;
            border: none;
            border: 2px solid transparent;
            transition: all 0.3s ease;
            height: 100%;
            justify-content: space-between;
            cursor: pointer;
        }
        .summary-box:hover {
            transform: translateY(-3px);
            border-color: rgba(8,131,149,0.15);
        }
        .summary-box .summary-title {
            color: #088395;
            font-size: 0.95rem;
            font-weight: 700;
            margin-bottom: 12px;
            letter-spacing: 0.2px;
            line-height: 1.3;
            padding-right: 50px;
            word-wrap: break-word;
        }
        .summary-box .summary-value {
            font-size: 1.6rem;
            font-weight: 800;
            color: #222;
            margin-bottom: 12px;
            line-height: 1.1;
            letter-spacing: 1px;
            margin-top: auto;
            display: flex;
            align-items: baseline;
            justify-content: flex-start;
        }
        
        .summary-value .currency {
            font-size: 1.2rem;
            margin-right: 4px;
            color: #666;
            font-weight: 600;
        }
        .summary-box .summary-icon {
            position: absolute;
            top: 18px;
            right: 18px;
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: linear-gradient(135deg, #6fc3d0 0%, #5459AC 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            color: #fff;
            box-shadow: 0 2px 8px rgba(8,131,149,0.10);
            transition: transform 0.3s ease;
        }
        .summary-box:hover .summary-icon {
            transform: scale(1.1);
        }
        .summary-box .summary-badge {
            margin-top: 0;
            font-size: 0.9rem;
            font-weight: 500;
            border-radius: 8px;
            padding: 8px 12px;
            text-align: center;
            width: 100%;
            display: block;
            letter-spacing: 0.1px;
        }
        .summary-box .badge-green {
            background: #e6f7ec;
            color: #1ca97a;
        }
        .summary-box .badge-red {
            background: #fdeaea;
            color: #e74c3c;
        }
        .summary-box .badge-blue {
            background: #e6f0fa;
            color: #5459AC;
        }
        .summary-box .badge-orange {
            background: #fffbe6;
            color: #ffc107;
        }
        @media (max-width: 767px) {
            .summary-box { min-height: 90px; padding: 10px 6px 8px 6px; }
            .summary-box .summary-value { font-size: 1.2rem; }
            .summary-box .summary-icon { width: 22px; height: 22px; font-size: 0.85rem; }
        }

        /* SHADOW CUSTOM UNTUK SEMUA CARD */
        .shadow-custom {
            box-shadow: 0 4px 24px rgba(8,131,149,0.08) !important;
        }
        .summary-box,
        .insight-card,
        .review-card,
        .card,
        .review-mini-card,
        .service-card,
        .demografi-card {
            box-shadow: 0 4px 24px rgba(8,131,149,0.08) !important;
        }
        
        /* Override untuk hover effects */
        .summary-box:hover,
        .insight-card:hover,
        .service-card:hover {
            box-shadow: 0 8px 32px rgba(8,131,149,0.13) !important;
        }

        /* Custom style khusus chatbot area */
        #chatbot-gemini-header {
            background: linear-gradient(90deg, #5459AC 70%, #6fc3d0 100%);
            color: #fff;
            padding: 22px 0 18px 0;
            border-top-left-radius: 18px;
            border-top-right-radius: 18px;
            font-weight: bold;
            text-align: center;
            font-size: 22px;
            letter-spacing: 1px;
            margin-bottom: 0;
        }
        #chatbot-gemini-messages {
            min-height: 400px;
            max-height: 60vh;
            overflow-y: auto;
            background: #f8f9fa;
            padding: 24px 20px 18px 20px;
            border-left: 1px solid #eee;
            border-right: 1px solid #eee;
        }
        #chatbot-gemini-input {
            display: flex;
            border-top: 1px solid #eee;
            background: #fff;
            padding: 16px 18px;
            border-radius: 0 0 18px 18px;
            box-shadow: 0 4px 24px rgba(8,131,149,0.03);
        }
        #chatbot-gemini-input input {
            flex: 1;
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 12px;
            outline: none;
            font-size: 16px;
        }
        #chatbot-gemini-input button {
            border: none;
            background: #5459AC;
            color: #fff;
            padding: 0 28px;
            margin-left: 10px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            font-size: 16px;
            transition: background 0.2s;
        }
        #chatbot-gemini-input button:hover {
            background: #6fc3d0;
        }
    </style>
</head>
<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-primary">
        <a class="navbar-brand font-weight-bold text-center" href="../index.php">Apothecary</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
                <div class="input-group-append">
                    <button class="btn btn-light" type="button"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ml-auto ml-md-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="../login/logout.php">Logout</a>
                </div>
            </li>
        </ul>
    </nav>

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Apothecary</div>
                        <a class="nav-link " href="../index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <!-- SIDEBAR -->
                        <?php if ($_SESSION["jabatan"] == 'admin') : ?>
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#data-master" aria-expanded="false" aria-controls="data-master">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Data Master
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="data-master" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="../data-master/data-pasien/pasien.php">Data Pasien</a>
                                    <a class="nav-link" href="../data-master/data-dokter/dokter.php">Data Dokter</a>
                                    <a class="nav-link" href="../data-master/data-obat/obat.php">Data Obat</a>
                                    <a class="nav-link" href="../data-master/data-staff/staff.php">Data Staff</a>
                                </nav>
                            </div>
                            <a class="nav-link active" href="../chatbot-ai/chatbot.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-clipboard-list"></i></div>
                                Chatbot AI
                            </a>
                            <a class="nav-link" href="../data-pemeriksaan/pemeriksaan.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-address-book"></i></div>
                                Data Pemeriksaan
                            </a>
                            <a class="nav-link" href="keuntungan/keuntungan.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-scroll"></i></div>
                                Keuntungan
                            </a>
                            <a class="nav-link" href="../data-pembayaran/pembayaran.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-shopping-cart"></i></div>
                                Pengeluaran
                            </a>
                            <div class="sb-sidenav-menu-heading">Admin</div>
                            <a class="nav-link" href="../user.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Data User
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content" class="bg-white text-dark">
            <main>
                <div class="container-fluid py-4" style="min-height: 90vh;">
                    <h1 class="mt-4 font-weight-bold" style="color:#5459AC;">Chatbot Gemini AI</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="../index.php" class="text-decoration-none">Dashboard</a></li>
                        <li class="breadcrumb-item active">Chatbot AI</li>
                    </ol>
                    <div id="chatbot-gemini-header" style="margin-bottom:0;">
                        Chatbot Gemini AI
                    </div>
                    <div id="chatbot-gemini-messages" style="min-height:400px; max-height:60vh; margin-bottom:0;"></div>
                    <form id="chatbot-gemini-input" style="border-radius:0 0 18px 18px; box-shadow:0 4px 24px rgba(8,131,149,0.03);">
                        <input type="text" id="chatbot-gemini-user-input" placeholder="Tulis pertanyaan..." autocomplete="off" />
                        <button type="submit">Kirim</button>
                    </form>
                </div>
            </main>
            <footer class="py-4 bg-dark mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted font-weight-bold">Copyright &copy; Apothecary - 2025</div>
                    </div>
                </div>
        <!-- jQuery & Chatbot Script -->
        <script src="../assets/js/jquery-3.5.1.slim.min.js"></script>
        <script>
        $(function() {
            function appendMessage(sender, text) {
                var msgHtml = '<div style="margin-bottom:12px;"><span style="font-weight:bold;color:'+(sender==='AI'?'#5459AC':'#222')+';">'+sender+': </span>'+text+'</div>';
                $('#chatbot-gemini-messages').append(msgHtml);
                $('#chatbot-gemini-messages').scrollTop($('#chatbot-gemini-messages')[0].scrollHeight);
            }
            function removeTyping() {
                var $msgs = $('#chatbot-gemini-messages').children();
                if ($msgs.length > 0 && $msgs.last().text().includes('Sedang mengetik')) $msgs.last().remove();
            }
            $('#chatbot-gemini-input').on('submit', function(e) {
                e.preventDefault();
                var userMsg = $('#chatbot-gemini-user-input').val().trim();
                if (!userMsg) return;
                appendMessage('Anda', $('<div>').text(userMsg).html());
                $('#chatbot-gemini-user-input').val('');
                appendMessage('AI', '<span style="color:#aaa;">Sedang mengetik...</span>');
                $.ajax({
                    url: 'chatbot_api.php',
                    method: 'POST',
                    data: { message: userMsg },
                    success: function(res) {
                        removeTyping();
                        if (res && res.trim()) {
                            appendMessage('AI', $('<div>').text(res).html());
                        } else {
                            appendMessage('AI', '<span style="color:red;">Tidak ada respons dari AI.</span>');
                        }
                    },
                    error: function(xhr) {
                        removeTyping();
                        var msg = '<span style="color:red;">Terjadi kesalahan koneksi.</span>';
                        if (xhr && xhr.responseText) {
                            msg += '<br>' + $('<div>').text(xhr.responseText).html();
                        }
                        appendMessage('AI', msg);
                    }
                });
            });
        });
        </script>
    <!-- tes -->