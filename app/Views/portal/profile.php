<?= $this->extend('layout/frontend') ?>

<?= $this->section('content') ?>
<!-- Profile Header -->
<section class="bg-light py-5">
    <div class="container-fluid px-4 text-center">
        <h1 class="fw-bold mb-3"><?= $title ?></h1>
        <p class="text-secondary mb-0">Mengenal lebih dekat Desa <?= $config['village_name'] ?></p>
    </div>
</section>

<section class="py-5">
    <div class="container-fluid px-4">
        <div class="row g-5">
            <div class="col-lg-8">
                <!-- Sejarah -->
                <div class="mb-5">
                    <h3 class="fw-bold mb-4">Sejarah Desa</h3>
                    <div class="lh-lg text-secondary">
                        <?= nl2br($config['village_history']) ?>
                    </div>
                </div>

                <!-- Visi & Misi -->
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="card p-4 bg-primary bg-opacity-10 border-0 rounded-4 h-100">
                            <h5 class="fw-bold text-primary mb-3"><i class="bi bi-eye-fill me-2"></i> Visi</h5>
                            <p class="mb-0 text-secondary"><?= $config['village_vision'] ?></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card p-4 bg-success bg-opacity-10 border-0 rounded-4 h-100">
                            <h5 class="fw-bold text-success mb-3"><i class="bi bi-bullseye me-2"></i> Misi</h5>
                            <div class="text-secondary">
                                <?= nl2br($config['village_mission']) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-primary text-white p-3 fw-bold border-0">Informasi Kontak</div>
                    <div class="card-body p-4">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-3 d-flex">
                                <i class="bi bi-geo-alt-fill text-primary me-3 mt-1"></i>
                                <div>
                                    <h6 class="fw-bold mb-1 small text-uppercase">Alamat</h6>
                                    <p class="small text-muted mb-0"><?= $config['village_address'] ?></p>
                                </div>
                            </li>
                            <li class="mb-3 d-flex">
                                <i class="bi bi-telephone-fill text-primary me-3 mt-1"></i>
                                <div>
                                    <h6 class="fw-bold mb-1 small text-uppercase">Telepon</h6>
                                    <p class="small text-muted mb-0"><?= $config['village_phone'] ?></p>
                                </div>
                            </li>
                            <li class="d-flex">
                                <i class="bi bi-envelope-fill text-primary me-3 mt-1"></i>
                                <div>
                                    <h6 class="fw-bold mb-1 small text-uppercase">Email</h6>
                                    <p class="small text-muted mb-0"><?= $config['village_email'] ?></p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Google Maps -->
                <?php if (!empty($config['google_maps'])): ?>
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden mt-4">
                    <div class="card-header bg-success text-white p-3 fw-bold border-0">Lokasi Desa</div>
                    <div class="card-body p-0">
                        <div class="ratio ratio-4x3">
                            <?= $config['google_maps'] ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
