<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= (isset($title) ? $title . ' - ' : '') . $config['village_name'] ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #0d6efd;
            --secondary-color: #6c757d;
            --dark-color: #212529;
            --light-bg: #f8f9fa;
        }
        body { font-family: 'Inter', sans-serif; color: #333; }
        .navbar { transition: all 0.3s ease; box-shadow: 0 2px 10px rgba(0,0,0,.05); background: #fff !important; }
        .navbar-brand img { height: 40px; }
        .nav-link { font-weight: 500; font-size: 0.95rem; color: #444 !important; padding-left: 15px; padding-right: 15px; }
        .nav-link:hover, .nav-link.active { color: var(--primary-color) !important; }
        
        .hero-section { background: linear-gradient(135deg, rgba(13, 110, 253, 0.4) 0%, rgba(0, 153, 255, 0.3) 100%), url('https://images.unsplash.com/photo-1500382017468-9049fed747ef?auto=format&fit=crop&q=80&w=2000'); background-size: cover; background-position: center; color: white; padding: 120px 0; }
        
        .section-title { position: relative; padding-bottom: 20px; margin-bottom: 40px; font-weight: 700; }
        .section-title::after { content: ''; position: absolute; bottom: 0; left: 0; width: 60px; height: 3px; background: var(--primary-color); }
        .section-title.center::after { left: 50%; transform: translateX(-50%); }
        
        .news-card, .tourism-card { border: none; border-radius: 12px; transition: transform 0.3s, box-shadow 0.3s; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,.05); }
        .news-card:hover, .tourism-card:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,.1); }
        .card-img-top { height: 200px; object-fit: cover; }
        
        footer { background: #1a1e21; color: #adb5bd; padding: 60px 0 20px; }
        footer a { color: #adb5bd; text-decoration: none; }
        footer a:hover { color: #fff; }
        footer .footer-title { color: #fff; font-weight: 700; margin-bottom: 25px; }
        @media (max-width: 768px) {
            .hero-section { padding: 80px 0; text-align: center; }
            .section-title { font-size: 1.75rem; }
            .display-4 { font-size: 2.5rem; }
            .navbar-brand span { font-size: 1rem; }
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container-fluid px-4">
        <a class="navbar-brand d-flex align-items-center" href="<?= base_url() ?>">
            <?php if($config['village_logo']): ?>
                <img src="<?= base_url('uploads/logo/' . $config['village_logo']) ?>" alt="Logo" class="me-2">
            <?php endif; ?>
            <span class="fw-bold text-primary">DESA <?= strtoupper($config['village_name']) ?></span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <?php $uri = service('uri'); ?>
                <li class="nav-item"><a class="nav-link <?= ($uri->getSegment(1) == '') ? 'active' : '' ?>" href="<?= base_url() ?>">Home</a></li>
                <li class="nav-item"><a class="nav-link <?= ($uri->getSegment(1) == 'profile') ? 'active' : '' ?>" href="<?= base_url('profile') ?>">Profil</a></li>
                <li class="nav-item"><a class="nav-link <?= ($uri->getSegment(1) == 'news') ? 'active' : '' ?>" href="<?= base_url('news') ?>">Berita</a></li>
                <li class="nav-item"><a class="nav-link <?= ($uri->getSegment(1) == 'tourism') ? 'active' : '' ?>" href="<?= base_url('tourism') ?>">Wisata</a></li>
                <li class="nav-item"><a class="nav-link <?= ($uri->getSegment(1) == 'services') ? 'active' : '' ?>" href="<?= base_url('services') ?>">Layanan</a></li>
            </ul>
        </div>
    </div>
</nav>

<?= $this->renderSection('content') ?>

<footer>
    <div class="container-fluid px-4">
        <div class="row g-4 mb-5">
            <div class="col-lg-4">
                <h5 class="footer-title">Desa <?= $config['village_name'] ?></h5>
                <p class="small mb-4"><?= substr($config['village_history'], 0, 150) ?>...</p>
                <div class="d-flex gap-3">
                    <a href="#"><i class="bi bi-facebook fs-5"></i></a>
                    <a href="#"><i class="bi bi-instagram fs-5"></i></a>
                    <a href="#"><i class="bi bi-youtube fs-5"></i></a>
                </div>
            </div>
            <div class="col-lg-2 ms-lg-auto">
                <h6 class="footer-title small text-uppercase">Tautan Cepat</h6>
                <ul class="list-unstyled">
                    <li><a href="<?= base_url('profile') ?>">Profil Desa</a></li>
                    <li><a href="<?= base_url('news') ?>">Berita Terbaru</a></li>
                    <li><a href="<?= base_url('tourism') ?>">Wisata Lokal</a></li>
                    <li><a href="<?= base_url('services') ?>">Layanan Publik</a></li>
                </ul>
            </div>
            <div class="col-lg-4">
                <h6 class="footer-title small text-uppercase">Hubungi Kami</h6>
                <ul class="list-unstyled">
                    <li class="mb-2 small"><i class="bi bi-geo-alt me-2 text-primary"></i> <?= $config['village_address'] ?></li>
                    <li class="mb-2 small"><i class="bi bi-telephone me-2 text-primary"></i> <?= $config['village_phone'] ?></li>
                    <li class="mb-2 small"><i class="bi bi-envelope me-2 text-primary"></i> <?= $config['village_email'] ?></li>
                </ul>
            </div>
        </div>
        <hr class="border-secondary opacity-25">
        <div class="text-center py-3 small opacity-50">
            &copy; <?= date('Y') ?> Portal Resmi Desa <?= $config['village_name'] ?>. All rights reserved.
        </div>
    </div>
</footer>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
