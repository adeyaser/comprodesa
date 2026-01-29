<?= $this->extend('layout/frontend') ?>

<?= $this->section('content') ?>

<!-- Breadcrumbs -->
<nav class="bg-white border-bottom py-2 shadow-sm sticky-top" style="top: 72px; z-index: 1020;">
    <div class="container-fluid px-4">
        <ol class="breadcrumb mb-0 small" itemscope itemtype="https://schema.org/BreadcrumbList">
            <li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <a href="<?= base_url() ?>" class="text-decoration-none" itemprop="item">
                    <span itemprop="name">Beranda</span>
                </a>
                <meta itemprop="position" content="1" />
            </li>
            <li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <a href="<?= base_url('news') ?>" class="text-decoration-none" itemprop="item">
                    <span itemprop="name">Berita</span>
                </a>
                <meta itemprop="position" content="2" />
            </li>
            <li class="breadcrumb-item active" aria-current="page" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <span itemprop="name"><?= $news['title'] ?></span>
                <meta itemprop="position" content="3" />
            </li>
        </ol>
    </div>
</nav>

<!-- Header Image -->
<div class="bg-light py-5 position-relative" style="background: url('<?= base_url('uploads/news/' . $news['thumbnail']) ?>') no-repeat center center; background-size: cover;">
    <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50"></div>
    <div class="container-fluid px-4 position-relative z-1 text-white text-center py-5">
        <span class="badge bg-primary mb-3"><?= $news['category_name'] ?></span>
        <h1 class="fw-bold display-5 mb-3"><?= $news['title'] ?></h1>
        <div class="small opacity-75">
            <i class="bi bi-calendar3 me-2"></i> <?= date('d F Y', strtotime($news['created_at'])) ?>
            <span class="mx-3">•</span>
            <i class="bi bi-person me-2"></i> Admin
        </div>
    </div>
</div>

<section class="py-5">
    <div class="container-fluid px-4">
        <div class="row g-5">
            <div class="col-lg-8">
                <article class="bg-white p-4 p-md-5 rounded shadow-sm">
                    <div class="content-body lh-lg mb-5">
                        <?= $news['content'] ?>
                    </div>

                    <div class="border-top pt-4 mt-5">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="fw-bold mb-0">Bagikan:</h6>
                            <div class="d-flex gap-2">
                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?= current_url() ?>" target="_blank" class="btn btn-sm btn-outline-primary"><i class="bi bi-facebook"></i></a>
                                <a href="https://twitter.com/intent/tweet?url=<?= current_url() ?>&text=<?= urlencode($news['title']) ?>" target="_blank" class="btn btn-sm btn-outline-info"><i class="bi bi-twitter"></i></a>
                                <a href="https://api.whatsapp.com/send?text=<?= urlencode($news['title'] . ' ' . current_url()) ?>" target="_blank" class="btn btn-sm btn-outline-success"><i class="bi bi-whatsapp"></i></a>
                            </div>
                        </div>
                    </div>
                </article>

                <div class="mt-5 text-center">
                    <a href="<?= base_url('news') ?>" class="btn btn-outline-secondary rounded-pill px-4"><i class="bi bi-arrow-left me-2"></i> Kembali ke Berita</a>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card p-4 border-0 bg-light rounded-4 sticky-top" style="top: 100px;">
                    <h5 class="fw-bold mb-4">Berita Terbaru</h5>
                    <ul class="list-unstyled mb-0">
                        <?php foreach($recent_news as $rn): ?>
                            <li class="mb-3 pb-3 border-bottom">
                                <a href="<?= base_url('news/' . $rn['slug']) ?>" class="text-dark text-decoration-none fw-bold small d-block mb-1 lh-sm"><?= $rn['title'] ?></a>
                                <span class="smaller text-muted d-block"><?= date('d M Y', strtotime($rn['created_at'])) ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <a href="<?= base_url('news') ?>" class="btn btn-primary w-100 mt-4 rounded-pill">Semua Berita <i class="bi bi-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
