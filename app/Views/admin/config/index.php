<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i><?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i><?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-12">
            <div class="card p-4">
                <form action="<?= base_url('admin/config/update') ?>" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id" value="<?= $config['id'] ?>">
                    
                    <div class="row g-4">
                        <div class="col-md-6 border-end">
                            <h6 class="fw-bold text-primary mb-4"><i class="bi bi-info-circle me-2"></i>Informasi Dasar</h6>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold small text-uppercase">Nama Desa</label>
                                <input type="text" class="form-control" name="village_name" value="<?= $config['village_name'] ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold small text-uppercase">Nama Sistem Aplikasi</label>
                                <input type="text" class="form-control" name="app_name" value="<?= $config['app_name'] ?? 'CMS DESA' ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold small text-uppercase">Logo Desa</label>
                                <div class="d-flex align-items-center gap-3 mb-2">
                                    <?php if($config['village_logo']): ?>
                                        <img src="<?= base_url('uploads/logo/' . $config['village_logo']) ?>" alt="Logo" class="rounded border p-1" style="width: 80px; height: 80px; object-fit: contain;">
                                    <?php else: ?>
                                        <div class="bg-light rounded border d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                            <i class="bi bi-image text-muted fs-3"></i>
                                        </div>
                                    <?php endif; ?>
                                    <div>
                                        <input type="file" class="form-control form-control-sm" name="village_logo">
                                        <small class="text-muted">Format: PNG, JPG (Maks. 2MB)</small>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold small text-uppercase">Alamat Lengkap</label>
                                <textarea class="form-control" name="village_address" rows="3" required><?= $config['village_address'] ?></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold small text-uppercase">Nomor Telepon</label>
                                    <input type="text" class="form-control" name="village_phone" value="<?= $config['village_phone'] ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold small text-uppercase">Email Desa</label>
                                    <input type="email" class="form-control" name="village_email" value="<?= $config['village_email'] ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h6 class="fw-bold text-primary mb-4"><i class="bi bi-journal-text me-2"></i>Profil & Deskripsi</h6>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold small text-uppercase">Sejarah Desa</label>
                                <textarea class="form-control" name="village_history" rows="4"><?= $config['village_history'] ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold small text-uppercase">Visi</label>
                                <textarea class="form-control" name="village_vision" rows="2"><?= $config['village_vision'] ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold small text-uppercase">Misi</label>
                                <textarea class="form-control" name="village_mission" rows="3"><?= $config['village_mission'] ?></textarea>
                                <small class="text-muted">Pisahkan setiap poin misi (jika ada).</small>
                            </div>
                        </div>
                    </div>

                    <div class="row g-4 mt-2">
                        <div class="col-md-12 border-top pt-4">
                            <h6 class="fw-bold text-success mb-4"><i class="bi bi-search me-2"></i>SEO & Google Maps</h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold small text-uppercase">Meta Description (SEO)</label>
                                    <textarea class="form-control" name="meta_description" rows="3" placeholder="Deskripsi singkat untuk hasil pencarian Google..."><?= $config['meta_description'] ?? '' ?></textarea>
                                    <small class="text-muted">Disarankan antara 150-160 karakter.</small>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold small text-uppercase">Meta Keywords (SEO)</label>
                                    <input type="text" class="form-control" name="meta_keywords" value="<?= $config['meta_keywords'] ?? '' ?>" placeholder="contoh: desa, wisata, layanan, banyuwangi">
                                    <small class="text-muted">Pisahkan dengan tanda koma.</small>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-bold small text-uppercase">Google Maps Embed Code</label>
                                    <textarea class="form-control" name="google_maps" rows="3" placeholder='Tempel kode <iframe> dari Google Maps di sini...'><?= $config['google_maps'] ?? '' ?></textarea>
                                    <small class="text-muted">Buka Google Maps, klik Bagikan > Sematkan peta > Salin HTML.</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-top text-end">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-save me-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
