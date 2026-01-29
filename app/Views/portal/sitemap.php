<?= '<?xml version="1.0" encoding="UTF-8"?>' ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc><?= base_url() ?></loc>
        <priority>1.0</priority>
    </url>
    <url>
        <loc><?= base_url('profile') ?></loc>
        <priority>0.8</priority>
    </url>
    <url>
        <loc><?= base_url('services') ?></loc>
        <priority>0.8</priority>
    </url>
    <url>
        <loc><?= base_url('news') ?></loc>
        <priority>0.9</priority>
    </url>
    <url>
        <loc><?= base_url('tourism') ?></loc>
        <priority>0.9</priority>
    </url>

    <?php foreach ($news as $n): ?>
    <url>
        <loc><?= base_url('news/' . $n['slug']) ?></loc>
        <lastmod><?= date('Y-m-d', strtotime($n['updated_at'] ?? $n['created_at'])) ?></lastmod>
        <priority>0.7</priority>
    </url>
    <?php endforeach; ?>

    <?php foreach ($tourism as $t): ?>
    <url>
        <loc><?= base_url('tourism/' . $t['slug']) ?></loc>
        <priority>0.7</priority>
    </url>
    <?php endforeach; ?>
</urlset>
