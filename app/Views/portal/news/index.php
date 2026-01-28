<?= $this->extend('layout/frontend') ?>

<?= $this->section('content') ?>
<!-- News Header -->
<div class="bg-light py-5 text-center">
    <div class="container-fluid px-4">
        <h1 class="fw-bold mb-3"><?= $title ?></h1>
        <p class="text-secondary mb-0">Indeks berita dan pengumuman terbaru desa.</p>
    </div>
</div>

<section class="py-5">
    <div class="container-fluid px-4">
        <!-- External News Section -->
        <?php if(!empty($external_news)): ?>
        <div class="mb-5">
            <h4 class="fw-bold mb-4 border-start border-4 border-warning ps-3">Berita Terkini (Live dari Sumber Eksternal)</h4>
            <div class="row g-4">
                <?php foreach($external_news as $ex): ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100 border-0 shadow-sm" style="background: #fff8e1;">
                            <?php if(!empty($ex['thumbnail'])): ?>
                                <div style="height: 180px; overflow: hidden;">
                                    <img src="<?= $ex['thumbnail'] ?>" class="card-img-top" alt="<?= $ex['title'] ?>" style="object-fit: cover; height: 100%; width: 100%;">
                                </div>
                            <?php endif; ?>
                            <div class="card-body">
                                 <div class="d-flex justify-content-between mb-2">
                                    <span class="badge bg-warning text-dark"><?= $ex['source'] ?></span>
                                    <small class="text-muted"><?= date('H:i', strtotime($ex['date'])) ?></small>
                                 </div>
                                <h6 class="fw-bold"><a href="<?= $ex['url'] ?>" target="_blank" class="text-dark text-decoration-none"><?= $ex['title'] ?> <i class="bi bi-box-arrow-up-right small ms-1"></i></a></h6>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <hr class="mb-5 text-secondary opacity-25">
        <?php endif; ?>

        <div class="row g-4 mb-5">
            <?php if(empty($news)): ?>
                <div class="col-12 text-center py-5">
                    <p class="text-muted">Belum ada berita yang tersedia.</p>
                </div>
            <?php else: ?>
                <?php foreach($news as $n): ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="news-card card h-100">
                            <img src="<?= !empty($n['thumbnail']) ? base_url('uploads/news/' . $n['thumbnail']) : 'https://placehold.co/800x400?text=No+Image' ?>" class="card-img-top" alt="<?= $n['title'] ?>">
                            <div class="card-body p-4">
                                <span class="badge bg-light text-primary mb-2 border border-primary"><?= $n['category_name'] ?></span>
                                <h5 class="fw-bold mb-3"><a href="<?= base_url('news/' . $n['slug']) ?>" class="text-dark text-decoration-none"><?= $n['title'] ?></a></h5>
                                <p class="small text-secondary mb-3"><?= substr(strip_tags($n['content']), 0, 120) ?>...</p>
                                <div class="d-flex justify-content-between align-items-center pt-3 border-top mt-auto">
                                    <span class="small text-muted"><i class="bi bi-calendar3 me-1"></i> <?= date('d M Y', strtotime($n['created_at'])) ?></span>
                                    <a href="<?= base_url('news/' . $n['slug']) ?>" class="small fw-bold text-primary text-decoration-none">Baca Selengkapnya <i class="bi bi-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        <div class="mt-5 d-flex justify-content-center">
            <?= $pager->links('news', 'default_full') ?>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
