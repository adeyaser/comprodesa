<?= $this->extend('layout/frontend') ?>

<?= $this->section('content') ?>

<!-- Hero Section -->
<div class="hero-section text-center">
    <div class="container-fluid px-4">
        <h1 class="display-4 fw-bold mb-4">Selamat Datang di Website Resmi<br>Desa <?= $config['village_name'] ?></h1>
        <p class="lead mb-5 mx-auto" style="max-width: 700px;"><?= $config['village_vision'] ?></p>
        <div class="d-flex justify-content-center gap-3">
            <a href="#news" class="btn btn-primary btn-lg rounded-pill px-4 shadow">Berita Terbaru</a>
            <a href="#tourism" class="btn btn-outline-light btn-lg rounded-pill px-4">Jelajahi Wisata</a>
        </div>
    </div>
</div>

<!-- Info Desa -->
<section class="py-5 bg-white">
    <div class="container-fluid px-4">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <!-- Use an actual image if allowing upload, or a placeholder -->
                <img src="https://images.unsplash.com/photo-1596422846543-75c6fc197f07?auto=format&fit=crop&q=80&w=1000" class="img-fluid rounded-4 shadow-lg" alt="Pemandangan Desa <?= $config['village_name'] ?>" loading="lazy">
            </div>
            <div class="col-lg-6">
                <h5 class="text-primary fw-bold text-uppercase mb-3">Tentang Desa Kami</h5>
                <h2 class="fw-bold mb-4 display-6">Membangun Desa yang Maju dan Sejahtera</h2>
                <div class="text-secondary mb-4 lh-lg">
                    <?= substr($config['village_history'], 0, 400) ?>...
                </div>
                <div class="row g-4 mb-4">
                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 bg-primary bg-opacity-10 p-3 rounded-circle text-primary">
                                <i class="bi bi-people-fill fs-4"></i>
                            </div>
                            <div class="ms-3">
                                <h5 class="mb-0 fw-bold">Pelayanan</h5>
                                <small class="text-muted">Prima & Cepat</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 bg-success bg-opacity-10 p-3 rounded-circle text-success">
                                <i class="bi bi-tree-fill fs-4"></i>
                            </div>
                            <div class="ms-3">
                                <h5 class="mb-0 fw-bold">Lingkungan</h5>
                                <small class="text-muted">Asri & Nyaman</small>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="<?= base_url('profile') ?>" class="btn btn-outline-primary rounded-pill px-4">Lihat Profil Lengkap <i class="bi bi-arrow-right ms-2"></i></a>
            </div>
        </div>
    </div>
</section>

<!-- Berita Terbaru -->
<section id="news" class="py-5 bg-light">
    <div class="container-fluid px-4">
        <div class="text-center mb-5">
            <h2 class="section-title center mx-auto">Berita & Pengumuman</h2>
            <p class="text-secondary">Informasi terbaru seputar kegiatan dan perkembangan desa.</p>
        </div>
        
        <div class="row g-4">
            <?php if(empty($latest_news)): ?>
                <div class="col-12 text-center text-muted py-5">Belum ada berita terbaru.</div>
            <?php else: ?>
                <?php foreach($latest_news as $news): ?>
                <div class="col-md-4">
                    <div class="news-card card h-100 bg-white">
                        <img src="<?= !empty($news['thumbnail']) ? base_url('uploads/news/' . $news['thumbnail']) : 'https://placehold.co/800x400?text=No+Image' ?>" class="card-img-top" alt="<?= $news['title'] ?>" loading="lazy">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center text-muted small mb-3">
                                <i class="bi bi-calendar3 me-2"></i> <?= date('d M Y', strtotime($news['created_at'])) ?>
                                <span class="mx-2">•</span>
                                <i class="bi bi-tag me-2"></i> <?= $news['category_name'] ?>
                            </div>
                            <h5 class="card-title fw-bold mb-3"><a href="<?= base_url('news/' . $news['slug']) ?>" class="text-dark text-decoration-none"><?= $news['title'] ?></a></h5>
                            <p class="card-text text-secondary small mb-4"><?= substr(strip_tags($news['content']), 0, 100) ?>...</p>
                            <a href="<?= base_url('news/' . $news['slug']) ?>" class="fw-bold text-primary text-decoration-none small">Baca Selengkapnya <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        <div class="text-center mt-5">
            <a href="<?= base_url('news') ?>" class="btn btn-primary btn-lg rounded-pill px-5 shadow-sm">Lihat Semua Berita</a>
        </div>
    </div>
</section>

<!-- Wisata Footer Highlight -->
<section id="tourism" class="py-5 bg-white">
    <div class="container-fluid px-4">
        <div class="row align-items-center">
            <div class="col-lg-5 mb-4 mb-lg-0">
                <h5 class="text-warning fw-bold text-uppercase mb-2">Destinasi Wisata</h5>
                <h2 class="fw-bold mb-4 display-6">Jelajahi Keindahan Alam Desa Kami</h2>
                <p class="text-secondary mb-4 lh-lg">Temukan spot-spot menarik yang menyuguhkan pemandangan alam memukau dan pengalaman tak terlupakan. Desa kami memiliki potensi wisata yang siap memanjakan mata Anda.</p>
                <a href="<?= base_url('tourism') ?>" class="btn btn-dark rounded-pill px-4">Lihat Destinasi <i class="bi bi-camera-fill ms-2"></i></a>
            </div>
            <div class="col-lg-7">
                <div class="row g-3">
                    <?php if(!empty($featured_tourism)): ?>
                        <?php foreach($featured_tourism as $spot): ?>
                        <div class="col-md-6">
                            <div class="tourism-card position-relative rounded-4 overflow-hidden shadow-sm" style="height: 250px;">
                                <img src="<?= !empty($spot['thumbnail']) ? base_url('uploads/tourism/' . $spot['thumbnail']) : 'https://placehold.co/600x400?text=No+Image' ?>" class="w-100 h-100 object-fit-cover" alt="<?= $spot['name'] ?>" loading="lazy">
                                <div class="position-absolute bottom-0 start-0 w-100 p-4 bg-gradient-dark text-white" style="background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);">
                                    <h5 class="fw-bold mb-1"><?= $spot['name'] ?></h5>
                                    <small><i class="bi bi-geo-alt me-1"></i> <?= $spot['location'] ?></small>
                                </div>
                                <a href="<?= base_url('tourism/' . $spot['slug']) ?>" class="stretched-link"></a>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12 text-center p-5 bg-light rounded text-muted">Belum ada data wisata.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
