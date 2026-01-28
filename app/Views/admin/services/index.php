<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="mb-0 fw-bold"><i class="bi bi-gear-wide-connected me-2"></i><?= $title ?></h5>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addServiceModal">
            <i class="bi bi-plus-lg me-1"></i> Tambah Layanan
        </button>
    </div>

    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i><?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row g-4">
        <?php if(empty($services)): ?>
            <div class="col-12 text-center py-5">
                <div class="card p-5 border-0 bg-light">
                    <i class="bi bi-gear text-muted fs-1 mb-3"></i>
                    <h5>Belum ada layanan desa</h5>
                    <p class="text-muted">Tambahkan informasi layanan publik yang disediakan desa.</p>
                </div>
            </div>
        <?php else: ?>
            <?php foreach($services as $s): ?>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm panel-card">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="p-3 bg-light rounded text-primary me-3">
                                    <i class="<?= $s['icon'] ?> fs-3"></i>
                                </div>
                                <h5 class="fw-bold mb-0"><?= $s['name'] ?></h5>
                            </div>
                            <p class="text-secondary small mb-4"><?= $s['description'] ?></p>
                            <div class="d-flex justify-content-end gap-1">
                                <button type="button" class="btn btn-sm btn-light text-primary" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editServiceModal<?= $s['id'] ?>">
                                    <i class="bi bi-pencil-square me-1"></i> Edit
                                </button>
                                <a href="<?= base_url('admin/services/delete/' . $s['id']) ?>" 
                                   class="btn btn-sm btn-light text-danger" 
                                   onclick="return confirm('Hapus layanan ini?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Edit Modal -->
                <div class="modal fade" id="editServiceModal<?= $s['id'] ?>" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content border-0 shadow">
                            <form action="<?= base_url('admin/services/update/' . $s['id']) ?>" method="POST">
                                <?= csrf_field() ?>
                                <div class="modal-header border-0 bg-light">
                                    <h6 class="modal-title fw-bold">Edit Layanan</h6>
                                    <button type="button" class="btn-close" data-bs-toggle="modal" data-bs-target="#editServiceModal<?= $s['id'] ?>"></button>
                                </div>
                                <div class="modal-body p-4">
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold">Nama Layanan</label>
                                        <input type="text" class="form-control" name="name" value="<?= $s['name'] ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold">Icon (Bootstrap Icon Class)</label>
                                        <input type="text" class="form-control cursor-pointer" name="icon" value="<?= $s['icon'] ?>" placeholder="Klik untuk pilih ikon..." readonly onclick="openIconPicker(this)" required>
                                        <small class="text-muted">Klik input di atas untuk memilih ikon.</small>
                                    </div>
                                    <div class="mb-0">
                                        <label class="form-label small fw-bold">Deskripsi Singkat</label>
                                        <textarea class="form-control" name="description" rows="3" required><?= $s['description'] ?></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer border-0">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addServiceModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <form action="<?= base_url('admin/services/store') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-header border-0 bg-light">
                    <h6 class="modal-title fw-bold">Tambah Layanan Baru</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nama Layanan</label>
                        <input type="text" class="form-control" name="name" placeholder="Masukkan nama layanan..." required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Icon (Bootstrap Icon Class)</label>
                        <input type="text" class="form-control cursor-pointer" name="icon" placeholder="Klik untuk pilih ikon..." readonly onclick="openIconPicker(this)" required>
                        <small class="text-muted">Klik input di atas untuk memilih ikon.</small>
                    </div>
                    <div class="mb-0">
                        <label class="form-label small fw-bold">Deskripsi Singkat</label>
                        <textarea class="form-control" name="description" rows="3" placeholder="Jelaskan secara singkat tentang layanan ini..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4">Tambah Layanan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Icon Picker Modal -->
<div class="modal fade" id="iconPickerModal" tabindex="-1" style="z-index: 1060;">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 bg-light">
                <h6 class="modal-title fw-bold">Pilih Ikon Layanan</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="input-group mb-3 sticky-top bg-white pt-2" style="top: -1.5rem;">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control bg-light border-start-0" id="iconSearch" placeholder="Cari ikon...">
                </div>
                <div class="row g-3" id="iconGrid">
                    <!-- Icons will be populated here -->
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    const icons = [
        // Bootstrap Icons
        'bi bi-gear', 'bi bi-gear-fill', 'bi bi-tools', 'bi bi-person', 'bi bi-people', 'bi bi-people-fill',
        'bi bi-house', 'bi bi-building', 'bi bi-hospital', 'bi bi-heart-pulse', 'bi bi-file-text',
        'bi bi-file-earmark-text', 'bi bi-envelope', 'bi bi-telephone', 'bi bi-geo-alt', 'bi bi-map',
        'bi bi-cash', 'bi bi-cash-coin', 'bi bi-wallet', 'bi bi-credit-card', 'bi bi-bank',
        'bi bi-shop', 'bi bi-cart', 'bi bi-basket', 'bi bi-truck', 'bi bi-box-seam',
        'bi bi-book', 'bi bi-journal-text', 'bi bi-pencil', 'bi bi-pen', 'bi bi-brush',
        'bi bi-camera', 'bi bi-image', 'bi bi-music-note', 'bi bi-film', 'bi bi-play-circle',
        'bi bi-laptop', 'bi bi-phone', 'bi bi-printer', 'bi bi-wifi', 'bi bi-globe',
        'bi bi-shield-check', 'bi bi-lock', 'bi bi-key', 'bi bi-info-circle', 'bi bi-question-circle',
        'bi bi-exclamation-circle', 'bi bi-check-circle', 'bi bi-x-circle', 'bi bi-arrow-right',
        'bi bi-clock', 'bi bi-calendar', 'bi bi-calendar-event', 'bi bi-calendar-check',
        'bi bi-person-badge', 'bi bi-person-vcard', 'bi bi-megaphone', 'bi bi-broadcast',
        
        // Font Awesome Solid
        'fas fa-user', 'fas fa-users', 'fas fa-home', 'fas fa-building', 'fas fa-city',
        'fas fa-hospital', 'fas fa-heartbeat', 'fas fa-user-md', 'fas fa-ambulance',
        'fas fa-file', 'fas fa-file-alt', 'fas fa-file-contract', 'fas fa-file-invoice',
        'fas fa-envelope', 'fas fa-phone', 'fas fa-map-marker-alt', 'fas fa-globe',
        'fas fa-money-bill', 'fas fa-coins', 'fas fa-wallet', 'fas fa-credit-card',
        'fas fa-store', 'fas fa-shopping-cart', 'fas fa-box', 'fas fa-shipping-fast',
        'fas fa-book', 'fas fa-graduation-cap', 'fas fa-pencil-alt', 'fas fa-edit',
        'fas fa-camera', 'fas fa-image', 'fas fa-video', 'fas fa-music',
        'fas fa-laptop', 'fas fa-mobile-alt', 'fas fa-print', 'fas fa-wifi',
        'fas fa-shield-alt', 'fas fa-lock', 'fas fa-key', 'fas fa-id-card',
        'fas fa-comments', 'fas fa-bullhorn', 'fas fa-calendar-alt', 'fas fa-clock',
        'fas fa-wrench', 'fas fa-cog', 'fas fa-cogs', 'fas fa-hammer',
        'fas fa-hand-holding-heart', 'fas fa-hands-helping', 'fas fa-leaf', 'fas fa-tree',
        'fas fa-award', 'fas fa-balance-scale', 'fas fa-gavel', 'fas fa-university',
        'fas fa-bus', 'fas fa-car', 'fas fa-bicycle', 'fas fa-walking',
        'fas fa-utensils', 'fas fa-coffee', 'fas fa-bed', 'fas fa-shower',

        // Font Awesome Brands
        'fab fa-facebook', 'fab fa-twitter', 'fab fa-instagram', 'fab fa-youtube',
        'fab fa-whatsapp', 'fab fa-telegram', 'fab fa-linkedin', 'fab fa-github',
        'fab fa-google', 'fab fa-apple', 'fab fa-android', 'fab fa-windows'
    ];

    let currentInputId = null;
    const iconModal = new bootstrap.Modal(document.getElementById('iconPickerModal'));

    function openIconPicker(input) {
        currentInputId = input;
        iconModal.show();
    }

    function selectIcon(iconClass) {
        if (currentInputId) {
            currentInputId.value = iconClass;
        }
        iconModal.hide();
    }

    // Populate icons
    const iconGrid = document.getElementById('iconGrid');
    icons.forEach(icon => {
        const col = document.createElement('div');
        col.className = 'col-6 col-md-3 col-lg-2';
        col.innerHTML = `
            <button type="button" class="btn btn-outline-light text-dark border w-100 p-3 h-100 d-flex flex-column align-items-center justify-content-center gap-2 icon-btn" onclick="selectIcon('${icon}')">
                <i class="${icon} fs-4"></i>
                <span class="small text-muted text-break text-center" style="font-size: 0.7rem;">${icon}</span>
            </button>
        `;
        iconGrid.appendChild(col);
    });

    // Search functionality
    document.getElementById('iconSearch').addEventListener('keyup', function() {
        const searchText = this.value.toLowerCase();
        const buttons = iconGrid.querySelectorAll('.col-6');
        
        buttons.forEach(btn => {
            const iconName = btn.querySelector('span').innerText.toLowerCase();
            if (iconName.includes(searchText)) {
                btn.style.display = 'block';
            } else {
                btn.style.display = 'none';
            }
        });
    });
</script>
<?= $this->endSection() ?>
