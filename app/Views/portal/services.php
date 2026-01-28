<?= $this->extend('layout/frontend') ?>

<?= $this->section('content') ?>
<section class="py-5 bg-light border-bottom">
    <div class="container-fluid py-4">
        <h1 class="fw-bold mb-0">Layanan Desa</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Layanan</li>
            </ol>
        </nav>
    </div>
</section>

<section class="py-5 bg-white">
    <div class="container py-4">
        <div class="text-center mb-5">
            <h2 class="section-title center mx-auto">Layanan Publik Terpadu</h2>
            <p class="text-secondary col-lg-7 mx-auto">Kami berkomitmen memberikan pelayanan terbaik bagi seluruh warga desa dengan transparan, cepat, dan mudah diakses.</p>
        </div>

        <div class="row g-4">
            <?php if(empty($services)): ?>
                <div class="col-12 text-center py-5">
                    <p class="text-muted">Layanan belum tersedia.</p>
                </div>
            <?php else: ?>
                <?php foreach($services as $s): ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="card p-4 border-0 shadow-sm h-100 bg-light rounded-4">
                            <div class="mb-4 text-primary bg-white shadow-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="<?= $s['icon'] ?> fs-3"></i>
                            </div>
                            <h5 class="fw-bold mb-3"><?= $s['name'] ?></h5>
                            <p class="text-secondary small mb-0 lh-base"><?= $s['description'] ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        <div class="mt-5 pt-5 text-center">
            <div class="card p-5 border-0 bg-primary bg-opacity-10 rounded-4">
                <h4 class="fw-bold mb-3">Butuh bantuan lebih lanjut?</h4>
                <p class="text-secondary mb-4">Tim administrasi kami siap membantu Anda setiap hari kerja pukul 08:00 - 16:00 WIB.</p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="mailto:<?= $config['village_email'] ?>" class="btn btn-primary px-4 rounded-pill"><i class="bi bi-envelope me-2"></i> Kirim Email</a>
                    <a href="https://wa.me/<?= $config['village_phone'] ?>" class="btn btn-success px-4 rounded-pill"><i class="bi bi-whatsapp me-2"></i> Hubungi via WhatsApp</a>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
