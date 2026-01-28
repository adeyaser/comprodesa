<?= $this->extend('layout/frontend') ?>

<?= $this->section('content') ?>
<section class="bg-light py-5 position-relative">
    <div class="container-fluid px-4 py-4 text-center position-relative z-1">
        <h1 class="fw-bold mb-3"><?= $spot['name'] ?></h1>
        <p class="text-secondary mb-0"><i class="bi bi-geo-alt-fill me-1"></i> <?= $spot['location'] ?></p>
    </div>
</section>

<section class="py-5 bg-white">
    <div class="container-fluid px-4">
        <div class="row g-5">
            <div class="col-lg-7">
                <h5 class="fw-bold mb-4">Deskripsi Wisata</h5>
                <div class="lh-lg text-secondary">
                    <?= nl2br($spot['description']) ?>
                </div>
            </div>
            
            <div class="col-lg-5">
                <h5 class="fw-bold mb-4">Galeri Foto</h5>
                <div class="row g-3">
                    <?php if(empty($gallery)): ?>
                        <div class="col-12 text-center py-4 bg-light rounded-4">
                            <p class="text-muted small mb-0">Foto galeri belum tersedia.</p>
                        </div>
                    <?php else: ?>
                        <?php foreach($gallery as $img): ?>
                            <div class="col-6">
                                <a href="<?= base_url('uploads/tourism/' . $img['image']) ?>" target="_blank">
                                    <img src="<?= base_url('uploads/tourism/' . $img['image']) ?>" class="img-fluid rounded-4 shadow-sm border" alt="Gallery" style="height: 150px; width: 100%; object-fit: cover;">
                                </a>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                
                <div class="card bg-primary bg-opacity-10 border-0 p-4 rounded-4 mt-5">
                    <h6 class="fw-bold text-primary mb-3">Ingin Berkunjung?</h6>
                    <p class="small text-secondary mb-4">Pastikan Anda mengikuti protokol kesehatan dan menjaga kebersihan selama berada di destinasi wisata desa kami.</p>
                    <a href="https://www.google.com/maps/search/<?= urlencode($spot['name'] . ' ' . $spot['location']) ?>" target="_blank" class="btn btn-primary rounded-pill btn-sm fw-bold">Petunjuk Arah <i class="bi bi-map ms-1"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
