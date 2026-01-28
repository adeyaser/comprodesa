<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="mb-0 fw-bold"><i class="bi bi-plus-lg me-2"></i><?= $title ?></h5>
        <a href="<?= base_url('admin/tourism') ?>" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="card p-4 shadow-sm border-0">
        <form action="<?= base_url('admin/tourism/store') ?>" method="POST">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label fw-bold small text-uppercase">Nama Destinasi</label>
                <input type="text" class="form-control" name="name" placeholder="Contoh: Pantai Mutiara" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold small text-uppercase">Lokasi / Alamat</label>
                <input type="text" class="form-control" name="location" placeholder="Masukkan alamat atau titik lokasi..." required>
            </div>
            <div class="mb-4">
                <label class="form-label fw-bold small text-uppercase">Deskripsi Wisata</label>
                <textarea class="form-control" name="description" id="editor" rows="8" placeholder="Ceritakan tentang daya tarik wisata ini..."></textarea>
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-save me-2"></i>Simpan Destinasi
                </button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
