<?= $this->extend('layout/frontend') ?>

<?= $this->section('content') ?>
<!-- Header Image -->
<div class="bg-light py-5 position-relative" style="background: url('<?= base_url('uploads/news/' . $news['thumbnail']) ?>') no-repeat center center; background-size: cover;">
    <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50"></div>
    <div class="container-fluid px-4 position-relative z-1 text-white text-center py-5">
        <span class="badge bg-primary mb-3"><?= $news['category_name'] ?></span>
        <h1 class="fw-bold display-5 mb-3"><?= $news['title'] ?></h1>
        <div class="small opacity-75">
            <i class="bi bi-calendar3 me-2"></i> <?= date('d F Y', strtotime($news['created_at'])) ?>
            <span class="mx-3">•</span>
            <i class="bi bi-person me-2"></i> Admin
        </div>
    </div>
</div>

<section class="py-5">
    <div class="container-fluid px-4">
        <div class="row g-5">
            <div class="col-lg-8">
                <article class="bg-white p-4 p-md-5 rounded shadow-sm">
                    <div class="content-body lh-lg mb-5">
                        <?= $news['content'] ?>
                    </div>

                    <div class="border-top pt-4 mt-5">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="fw-bold mb-0">Bagikan:</h6>
                            <div class="d-flex gap-2">
                                <a href="#" class="btn btn-sm btn-outline-primary"><i class="bi bi-facebook"></i></a>
                                <a href="#" class="btn btn-sm btn-outline-info"><i class="bi bi-twitter"></i></a>
                                <a href="#" class="btn btn-sm btn-outline-success"><i class="bi bi-whatsapp"></i></a>
                            </div>
                        </div>
                    </div>
                </article>

                <div class="mt-5 text-center">
                    <a href="<?= base_url('news') ?>" class="btn btn-outline-secondary rounded-pill px-4"><i class="bi bi-arrow-left me-2"></i> Kembali ke Berita</a>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card p-4 border-0 bg-light rounded-4 sticky-top" style="top: 100px;">
                    <h5 class="fw-bold mb-4">Berita Terbaru</h5>
                    <ul class="list-unstyled mb-0">
                        <?php foreach($recent_news as $rn): ?>
                            <li class="mb-3 pb-3 border-bottom">
                                <a href="<?= base_url('news/' . $rn['slug']) ?>" class="text-dark text-decoration-none fw-bold small d-block mb-1 lh-sm"><?= $rn['title'] ?></a>
                                <span class="smaller text-muted d-block"><?= date('d M Y', strtotime($rn['created_at'])) ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <a href="<?= base_url('news') ?>" class="btn btn-primary w-100 mt-4 rounded-pill">Semua Berita <i class="bi bi-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
