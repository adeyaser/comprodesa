<?php if(!empty($news)): ?>
    <?php foreach($news as $n): ?>
        <div class="col-lg-4 col-md-6 news-item">
            <div class="news-card card h-100 <?= $n['is_external'] ? 'border-warning' : '' ?>" style="<?= $n['is_external'] ? 'background-color: #fffdf5;' : '' ?>">
                <?php 
                    $imgSrc = 'https://placehold.co/800x400?text=No+Image';
                    if (!empty($n['thumbnail'])) {
                        $imgSrc = $n['is_external'] ? $n['thumbnail'] : base_url('uploads/news/' . $n['thumbnail']);
                    }
                ?>
                <img src="<?= $imgSrc ?>" class="card-img-top shadow-sm" alt="<?= $n['title'] ?>" style="height: 200px; object-fit: cover;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="badge bg-light text-primary border border-primary"><?= $n['category_name'] ?></span>
                        <?php if($n['is_external']): ?>
                            <span class="badge bg-warning text-dark px-2 py-1"><i class="bi bi-globe me-1"></i> <?= $n['source_name'] ?></span>
                        <?php endif; ?>
                    </div>
                    <h5 class="fw-bold mb-3"><a href="<?= base_url('news/' . $n['slug']) ?>" class="text-dark text-decoration-none hover-primary"><?= $n['title'] ?></a></h5>
                    <p class="small text-secondary mb-3"><?= substr(strip_tags($n['content']), 0, 120) ?>...</p>
                    <div class="d-flex justify-content-between align-items-center pt-3 border-top mt-auto">
                        <span class="small text-muted"><i class="bi bi-calendar3 me-1"></i> <?= date('d M Y', strtotime($n['created_at'])) ?></span>
                        <a href="<?= base_url('news/' . $n['slug']) ?>" class="small fw-bold text-primary text-decoration-none">Baca Selengkapnya <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
