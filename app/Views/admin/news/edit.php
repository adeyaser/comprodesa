<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="mb-0 fw-bold"><i class="bi bi-pencil me-2"></i><?= $title ?></h5>
        <a href="<?= base_url('admin/news') ?>" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i><?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card p-4">
        <form action="<?= base_url('admin/news/update/' . $news['id']) ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="row g-4">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase">Judul Berita</label>
                        <input type="text" class="form-control form-control-lg" name="title" value="<?= $news['title'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase">Isi Berita</label>
                        <textarea class="form-control" name="content" id="editor" rows="15"><?= $news['content'] ?></textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-light border-0 p-3 mb-4">
                        <h6 class="fw-bold small text-uppercase mb-3">Pengaturan Publikasi</h6>
                        
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Kategori</label>
                            <select class="form-select" name="category_id" required>
                                <?php foreach($categories as $c): ?>
                                    <option value="<?= $c['id'] ?>" <?= $news['category_id'] == $c['id'] ? 'selected' : '' ?>><?= $c['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Thumbnail</label>
                            <div class="mb-2">
                                <img src="<?= base_url('uploads/news/' . $news['thumbnail']) ?>" alt="Current Thumb" class="img-fluid rounded border">
                                <small class="text-muted d-block mt-1">Thumbnail saat ini</small>
                            </div>
                            <input type="file" class="form-control" name="thumbnail" accept="image/*">
                            <small class="text-muted">Biarkan kosong jika tidak ingin mengubah thumbnail.</small>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-2"></i>Simpan Perubahan
                            </button>
                            <a href="<?= base_url('admin/news') ?>" class="btn btn-light text-secondary">Batal</a>
                        </div>
                    </div>
                    
                    <div class="card border-0 bg-light p-3">
                        <h6 class="fw-bold small text-uppercase mb-2 text-muted">Informasi</h6>
                        <p class="mb-1 small"><strong>Dibuat:</strong> <?= date('d M Y H:i', strtotime($news['created_at'])) ?></p>
                        <p class="mb-0 small"><strong>Update:</strong> <?= date('d M Y H:i', strtotime($news['updated_at'])) ?></p>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
