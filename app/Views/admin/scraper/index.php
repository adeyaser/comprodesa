<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="alert alert-info border-0 shadow-sm d-flex align-items-center">
            <i class="bi bi-robot fs-3 me-3"></i>
            <div>
                <h6 class="fw-bold mb-1">Fitur Auto-Scraping (Cron Job)</h6>
                <p class="mb-0 small text-dark opacity-75">
                    Gunakan URL berikut pada panel hosting Anda (Cron Job) untuk menjalankan penarikan berita secara otomatis setiap jam:
                    <br>
                    <code class="bg-white px-2 py-1 rounded border mt-1 d-inline-block">wget -q -O - "<?= base_url('cron/scrape?key=kalibaru_scrape_2026') ?>" > /dev/null 2>&1</code>
                </p>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-primary">Daftar Sumber Scraping</h5>
                <div>
                    <a href="<?= base_url('admin/scraper/refresh') ?>" class="btn btn-warning btn-sm me-2">
                        <i class="bi bi-arrow-clockwise me-1"></i> Paksa Re-Scrape (Clear Cache)
                    </a>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addSourceModal">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Sumber
                    </button>
                </div>
            </div>
            <div class="card-body">
                <?php if(session()->getFlashdata('success')): ?>
                    <div class="alert alert-success border-0 shadow-sm mb-4"><?= session()->getFlashdata('success') ?></div>
                <?php endif; ?>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Sumber</th>
                                <th>URL</th>
                                <th>Tipe</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($sources as $s): ?>
                            <tr>
                                <td class="fw-bold"><?= $s['source_name'] ?></td>
                                <td class="text-truncate" style="max-width: 300px;">
                                    <a href="<?= $s['url'] ?>" target="_blank" class="text-decoration-none small text-muted">
                                        <?= $s['url'] ?> <i class="bi bi-box-arrow-up-right ms-1"></i>
                                    </a>
                                </td>
                                <td>
                                    <span class="badge bg-secondary opacity-75"><?= ucfirst($s['type']) ?></span>
                                </td>
                                <td>
                                    <?php if($s['status'] == 'active'): ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Non-Aktif</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= base_url('admin/scraper/toggle/'.$s['id']) ?>" class="btn btn-<?= $s['status'] == 'active' ? 'outline-warning' : 'outline-success' ?>" title="Toggle Status">
                                            <i class="bi bi-power"></i>
                                        </a>
                                        <a href="<?= base_url('admin/scraper/delete/'.$s['id']) ?>" class="btn btn-outline-danger" onclick="return confirm('Hapus sumber ini?')" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Add Source -->
<div class="modal fade" id="addSourceModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Tambah Sumber Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('admin/scraper/create') ?>" method="POST">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nama Sumber</label>
                        <input type="text" name="source_name" class="form-control" required placeholder="Contoh: Radar Bekasi">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">URL Scraping</label>
                        <input type="url" name="url" class="form-control" required placeholder="https://...">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Tipe Sumber</label>
                        <select name="type" class="form-select">
                            <option value="portal">Portal Berita</option>
                            <option value="govt">Pemerintah</option>
                            <option value="other">Lainnya</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4">Simpan Sumber</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
