<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row g-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase small mb-1">Berita Desa</h6>
                            <h2 class="mb-0">12</h2>
                        </div>
                        <i class="bi bi-newspaper fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase small mb-1">Destinasi Wisata</h6>
                            <h2 class="mb-0">5</h2>
                        </div>
                        <i class="bi bi-map fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase small mb-1">Layanan Desa</h6>
                            <h2 class="mb-0">8</h2>
                        </div>
                        <i class="bi bi-gear-wide-connected fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase small mb-1">Pengunjung Hari Ini</h6>
                            <h2 class="mb-0">124</h2>
                        </div>
                        <i class="bi bi-people fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-8">
            <div class="card p-4">
                <h6 class="fw-bold mb-4">Berita Terbaru</h6>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Pembangunan Jalan Desa Tahap I...</td>
                                <td><span class="badge bg-light text-primary border border-primary">Warta Desa</span></td>
                                <td>24 Jan 2026</td>
                                <td><span class="text-success"><i class="bi bi-check-circle-fill me-1"></i>Publish</span></td>
                            </tr>
                            <tr>
                                <td>Penyaluran BLT Dana Desa Sester...</td>
                                <td><span class="badge bg-light text-info border border-info">Pengumuman</span></td>
                                <td>22 Jan 2026</td>
                                <td><span class="text-success"><i class="bi bi-check-circle-fill me-1"></i>Publish</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-4 h-100">
                <h6 class="fw-bold mb-4">Aktivitas Terakhir</h6>
                <ul class="list-unstyled mb-0">
                    <li class="mb-3 d-flex border-bottom pb-2">
                        <div class="me-3 p-2 bg-light rounded text-primary"><i class="bi bi-person-plus"></i></div>
                        <div>
                            <p class="mb-0 small fw-bold">Login Berhasil</p>
                            <span class="text-muted smaller">Admin baru saja login</span>
                        </div>
                    </li>
                    <li class="mb-3 d-flex border-bottom pb-2">
                        <div class="me-3 p-2 bg-light rounded text-success"><i class="bi bi-pencil-square"></i></div>
                        <div>
                            <p class="mb-0 small fw-bold">Update Berita</p>
                            <span class="text-muted smaller">Pembangunan Jalan Desa Tahap I</span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
