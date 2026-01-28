<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="mb-0 fw-bold"><i class="bi bi-map me-2"></i><?= $title ?></h5>
        <a href="<?= base_url('admin/tourism/create') ?>" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Tambah Wisata
        </a>
    </div>

    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i><?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row g-4">
        <?php if(empty($spots)): ?>
            <div class="col-12 text-center py-5">
                <div class="card p-5 border-0 bg-light">
                    <i class="bi bi-geo-alt text-muted fs-1 mb-3"></i>
                    <h5>Belum ada destinasi wisata</h5>
                    <p class="text-muted">Mulai tambahkan potensi wisata desa Anda.</p>
                </div>
            </div>
        <?php else: ?>
            <?php foreach($spots as $s): ?>
                <div class="col-md-4">
                    <div class="card h-100 overflow-hidden border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="fw-bold mb-1"><?= $s['name'] ?></h5>
                            <p class="text-muted small mb-3"><i class="bi bi-geo-alt-fill me-1"></i><?= $s['location'] ?></p>
                            <p class="small text-secondary mb-4"><?= substr(strip_tags($s['description']), 0, 100) ?>...</p>
                            <div class="d-flex justify-content-between align-items-center border-top pt-3 mt-auto">
                                <span class="badge bg-light text-dark"><i class="bi bi-images me-1"></i> Galeri</span>
                                <div>
                                    <a href="<?= base_url('admin/tourism/edit/' . $s['id']) ?>" class="btn btn-sm btn-light text-primary me-1">
                                        <i class="bi bi-pencil-square me-1"></i> Edit
                                    </a>
                                    <a href="<?= base_url('admin/tourism/delete/' . $s['id']) ?>" class="btn btn-sm btn-light text-danger" onclick="return confirm('Hapus destinasi ini?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>
