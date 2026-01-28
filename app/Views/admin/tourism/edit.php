<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="mb-0 fw-bold"><i class="bi bi-pencil-square me-2"></i><?= $title ?></h5>
        <a href="<?= base_url('admin/tourism') ?>" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i><?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row">
        <!-- Edit Form -->
        <div class="col-md-7">
            <div class="card p-4 shadow-sm border-0 mb-4 h-100">
                <form action="<?= base_url('admin/tourism/update/' . $spot['id']) ?>" method="POST">
                    <?= csrf_field() ?>
                    <h6 class="fw-bold text-primary mb-4">Detail Destinasi</h6>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase">Nama Destinasi</label>
                        <input type="text" class="form-control" name="name" value="<?= $spot['name'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase">Lokasi</label>
                        <input type="text" class="form-control" name="location" value="<?= $spot['location'] ?>" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-uppercase">Deskripsi</label>
                        <textarea class="form-control" name="description" id="editor" rows="10"><?= $spot['description'] ?></textarea>
                    </div>
                    <div class="text-end mt-auto">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-save me-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Gallery Management -->
        <div class="col-md-5">
            <div class="card p-4 shadow-sm border-0 h-100">
                <h6 class="fw-bold text-primary mb-4">Galeri Foto</h6>
                
                <form action="<?= base_url('admin/tourism/gallery/upload/' . $spot['id']) ?>" method="POST" enctype="multipart/form-data" class="mb-4 bg-light p-3 rounded border">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Tambah Foto</label>
                        <input type="file" class="form-control form-control-sm" name="gallery_files[]" multiple required>
                        <small class="text-muted">Pilih satu atau lebih gambar (PNG, JPG).</small>
                    </div>
                    <button type="submit" class="btn btn-sm btn-info w-100"><i class="bi bi-cloud-upload me-1"></i> Unggah Galeri</button>
                </form>

                <div class="row g-3 overflow-auto" style="max-height: 400px;">
                    <?php if(empty($gallery)): ?>
                        <div class="col-12 py-4 text-center text-muted small">Belum ada foto dalam galeri.</div>
                    <?php else: ?>
                        <?php foreach($gallery as $img): ?>
                            <div class="col-4 position-relative gallery-item">
                                <img src="<?= base_url('uploads/gallery/' . $img['image']) ?>" class="img-fluid rounded border shadow-sm" style="height: 80px; width: 100%; object-fit: cover;">
                                <a href="<?= base_url('admin/tourism/gallery/delete/' . $img['id']) ?>" 
                                   class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 p-0 rounded-circle" 
                                   style="width: 20px; height: 20px; font-size: 10px;"
                                   onclick="return confirm('Hapus foto ini dari galeri?')">
                                   <i class="bi bi-x"></i>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
