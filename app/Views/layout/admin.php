<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> - Portal Desa</title>

    <!-- Favicon -->
    <?php if(!empty($villageConfig['village_logo'])): ?>
        <link rel="icon" type="image/png" href="<?= base_url('uploads/logo/' . $villageConfig['village_logo']) ?>">
    <?php endif; ?>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f6f9; }
        .sidebar { width: 250px; height: 100vh; position: fixed; background: #343a40; color: #fff; transition: all 0.3s; z-index: 1000; overflow-y: auto; }
        .sidebar .nav-link { color: rgba(255,255,255,.8); padding: 12px 20px; border-radius: 0; margin-bottom: 2px; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background: rgba(255,255,255,.1); color: #fff; }
        .sidebar .sidebar-heading { padding: 20px; font-size: 1.2rem; font-weight: bold; background: rgba(0,0,0,.1); }
        .main-content { margin-left: 250px; padding: 0; transition: all 0.3s; min-height: 100vh; }
        .content-body { padding: 20px; }
        .top-navbar { position: sticky; top: 0; z-index: 100; background: #fff; box-shadow: 0 2px 10px rgba(0,0,0,.05); padding: 10px 20px; }
        .card { border: none; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,.04); }
        
        @media (max-width: 768px) {
            .sidebar { margin-left: -250px; }
            .sidebar.active { margin-left: 0; }
            .main-content { margin-left: 0; }
            .sidebar-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 999; }
            .sidebar-overlay.active { display: block; }
        }
    </style>
</head>
<body>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<div class="sidebar" id="sidebar">
    <div class="sidebar-heading text-center d-flex justify-content-between align-items-center">
        <span><i class="bi bi-house-door-fill me-2"></i> <?= $villageConfig['app_name'] ?? 'CMS DESA' ?></span>
        <button class="btn btn-link text-white d-md-none p-0" id="sidebarClose"><i class="bi bi-x-lg"></i></button>
    </div>
    <div class="nav flex-column">
        <a href="<?= base_url('admin/dashboard') ?>" class="nav-link <?= current_url() == base_url('admin/dashboard') ? 'active' : '' ?>">
            <i class="bi bi-speedometer2 me-2"></i> Dashboard
        </a>
        <div class="px-3 mt-3 mb-1 text-uppercase small opacity-50 fw-bold">Konten Samping</div>
        <a href="<?= base_url('admin/news') ?>" class="nav-link">
            <i class="bi bi-newspaper me-2"></i> Berita Desa
        </a>
        <a href="<?= base_url('admin/tourism') ?>" class="nav-link">
            <i class="bi bi-map me-2"></i> Wisata
        </a>
        <a href="<?= base_url('admin/services') ?>" class="nav-link">
            <i class="bi bi-gear-wide-connected me-2"></i> Layanan
        </a>
        <div class="px-3 mt-3 mb-1 text-uppercase small opacity-50 fw-bold">Pengaturan</div>
        <a href="<?= base_url('admin/config') ?>" class="nav-link <?= strpos(current_url(), 'admin/config') !== false ? 'active' : '' ?>">
            <i class="bi bi-sliders me-2"></i> Profil Desa
        </a>
        <a href="<?= base_url('admin/scraper') ?>" class="nav-link <?= strpos(current_url(), 'admin/scraper') !== false ? 'active' : '' ?>">
            <i class="bi bi-robot me-2"></i> Auto Scraping
        </a>
        <a href="<?= base_url('logout') ?>" class="nav-link text-danger mt-auto">
            <i class="bi bi-box-arrow-right me-2"></i> Logout
        </a>
    </div>
</div>

<div class="main-content">
    <div class="top-navbar d-flex justify-content-between align-items-center mb-0">
        <div class="d-flex align-items-center">
            <button class="btn btn-light d-md-none me-3" id="sidebarToggle"><i class="bi bi-list fs-4"></i></button>
            <h5 class="mb-0 fw-bold text-truncate" style="max-width: 250px;"><?= $title ?></h5>
        </div>
        <div class="dropdown">
            <a class="text-decoration-none text-dark dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                <i class="bi bi-person-circle me-1"></i> <span class="d-none d-md-inline"><?= $user ?></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                <li><a class="dropdown-item" href="<?= base_url('logout') ?>"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
            </ul>
        </div>
    </div>

    <div class="content-body">
        <?= $this->renderSection('content') ?>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarClose = document.getElementById('sidebarClose');

        function toggleSidebar() {
            sidebar.classList.toggle('active');
            sidebarOverlay.classList.toggle('active');
        }

        if(sidebarToggle) sidebarToggle.addEventListener('click', toggleSidebar);
        if(sidebarClose) sidebarClose.addEventListener('click', toggleSidebar);
        if(sidebarOverlay) sidebarOverlay.addEventListener('click', toggleSidebar);
    });
</script>

<!-- TinyMCE -->
<script src="https://cdn.tiny.cloud/1/uq9m2x4nadwo1ao9z1zsu9nccp2isn74pmh4uurx6qw73lna/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#editor',
        height: 500,
        menubar: false,
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
    });
</script>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?= $this->renderSection('scripts') ?>
</body>
</html>
