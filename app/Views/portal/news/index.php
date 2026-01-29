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
            <li class="breadcrumb-item active" aria-current="page" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <span itemprop="name">Berita</span>
                <meta itemprop="position" content="2" />
            </li>
        </ol>
    </div>
</nav>

<style>
    .news-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 1px solid rgba(0,0,0,0.08);
    }
    .news-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 1rem 3rem rgba(0,0,0,0.1) !important;
    }
    .hover-primary:hover {
        color: var(--bs-primary) !important;
    }
    #news-container .news-item {
        animation: fadeIn 0.5s ease-in-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<!-- News Header -->
<div class="bg-light py-5 text-center">
    <div class="container-fluid px-4">
        <h1 class="fw-bold mb-3"><?= $title ?></h1>
        <p class="text-secondary mb-0">Indeks berita dan pengumuman terbaru desa.</p>
    </div>
</div>

<section class="py-5">
    <div class="container-fluid px-4">
        <div class="row g-4 mb-5" id="news-container">
            <?php if(empty($news)): ?>
                <div class="col-12 text-center py-5">
                    <p class="text-muted">Belum ada berita yang tersedia.</p>
                </div>
            <?php else: ?>
                <?= view('portal/news/_list_items', ['news' => $news]) ?>
            <?php endif; ?>
        </div>
        
        <div id="load-more-loader" class="text-center py-4 d-none">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2 text-muted small">Memuat berita lainnya...</p>
        </div>

        <div id="no-more-news" class="text-center py-4 d-none">
            <p class="text-muted small">Tidak ada berita lagi untuk ditampilkan.</p>
        </div>
        
        <div class="mt-5 d-flex justify-content-center" id="pagination-wrapper">
            <?= $pager->links('news', 'default_full') ?>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let nextPage = 2;
    let isLoading = false;
    let hasMore = <?= ($pager->getPageCount() > 1) ? 'true' : 'false' ?>;
    const container = document.getElementById('news-container');
    const loader = document.getElementById('load-more-loader');
    const noMore = document.getElementById('no-more-news');
    const paginationWrapper = document.getElementById('pagination-wrapper');

    // Sembunyikan pagination standar jika JS aktif (opsional, tapi bagus untuk auto-scroll)
    if (hasMore) {
        paginationWrapper.classList.add('d-none');
    }

    window.onscroll = function() {
        if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight - 500) {
            if (!isLoading && hasMore) {
                loadMoreNews();
            }
        }
    };

    function loadMoreNews() {
        isLoading = true;
        loader.classList.remove('d-none');

        const url = new URL(window.location.href);
        url.searchParams.set('page', nextPage);

        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            if (html.trim() === '') {
                hasMore = false;
                loader.classList.add('d-none');
                noMore.classList.remove('d-none');
            } else {
                container.insertAdjacentHTML('beforeend', html);
                nextPage++;
                isLoading = false;
                loader.classList.add('d-none');
            }
        })
        .catch(error => {
            console.error('Error loading more news:', error);
            isLoading = false;
            loader.classList.add('d-none');
        });
    }
});
</script>
<?= $this->endSection() ?>
