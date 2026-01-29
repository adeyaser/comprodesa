<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="mb-0 fw-bold"><i class="bi bi-newspaper me-2"></i><?= $title ?></h5>
        <a href="<?= base_url('admin/news/create') ?>" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Tulis Berita
        </a>
    </div>

    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i><?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card p-0 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4" style="width: 80px;">Thumbnail</th>
                        <th>Judul Berita</th>
                        <th>Kategori</th>
                        <th>Tanggal Post</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($news)): ?>
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">Belum ada berita yang diterbitkan.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($news as $n): ?>
                        <tr>
                            <td class="ps-4">
                                <?php 
                                    $thumb = !empty($n['thumbnail']) ? ($n['is_external'] ? $n['thumbnail'] : base_url('uploads/news/' . $n['thumbnail'])) : 'https://placehold.co/600x400?text=No+Image';
                                ?>
                                <img src="<?= $thumb ?>" alt="Thumb" class="rounded shadow-sm" style="width: 60px; height: 60px; object-fit: cover;">
                            </td>
                            <td>
                                <div class="fw-bold mb-1"><?= $n['title'] ?></div>
                                <div class="d-flex gap-2">
                                    <span class="badge bg-light text-primary border border-primary small"><?= $n['category_name'] ?></span>
                                    <?php if($n['is_external']): ?>
                                        <span class="badge bg-warning text-dark small"><i class="bi bi-globe me-1"></i> <?= $n['source_name'] ?></span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <small class="text-muted d-block"><?= date('d/m/Y', strtotime($n['created_at'])) ?></small>
                                <small class="text-secondary"><?= date('H:i', strtotime($n['created_at'])) ?> WIB</small>
                            </td>
                            <td class="text-center pe-4">
                                <a href="<?= base_url('admin/news/edit/' . $n['id']) ?>" class="btn btn-sm btn-outline-info me-1" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="<?= base_url('admin/news/delete/' . $n['id']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus berita ini?')" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
