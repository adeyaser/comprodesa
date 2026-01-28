<?= $this->extend('layout/frontend') ?>

<?= $this->section('content') ?>
<section class="py-5 bg-light border-bottom">
    <div class="container-fluid py-4">
        <h1 class="fw-bold mb-0">Destinasi Wisata</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Wisata</li>
            </ol>
        </nav>
    </div>
</section>

<section class="py-5 bg-white">
    <div class="container py-4">
        <div class="row g-4 mb-5">
            <?php if(empty($spots)): ?>
                <div class="col-12 text-center py-5">
                    <p class="text-muted">Belum ada destinasi wisata yang tersedia.</p>
                </div>
            <?php else: ?>
                <?php foreach($spots as $s): ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="tourism-card card h-100 position-relative shadow-sm border-0">
                            <div style="height: 200px; overflow: hidden;">
                                <img src="<?= !empty($s['thumbnail']) ? base_url('uploads/tourism/' . $s['thumbnail']) : 'https://placehold.co/800x400?text=No+Image' ?>" class="card-img-top h-100 w-100" style="object-fit: cover;" alt="<?= $s['name'] ?>">
                            </div>
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-2"><?= $s['name'] ?></h5>
                                <p class="small text-muted mb-3"><i class="bi bi-geo-alt me-1"></i> <?= $s['location'] ?></p>
                                <p class="small text-secondary mb-4"><?= substr(strip_tags($s['description']), 0, 150) ?>...</p>
                                <a href="<?= base_url('tourism/' . $s['slug']) ?>" class="btn btn-outline-primary btn-sm rounded-pill px-3">Lihat Detail <i class="bi bi-arrow-right ms-1"></i></a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
