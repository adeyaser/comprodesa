<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Portal Desa</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            max-width: 400px;
            width: 100%;
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .login-header {
            background: linear-gradient(135deg, #0d6efd 0%, #0099ff 100%);
            color: white;
            padding: 30px;
            border-radius: 15px 15px 0 0;
            text-align: center;
        }
        .login-body {
            padding: 30px;
        }
        .btn-login {
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
        }
        /* Style for Turnstile */
        .cf-turnstile {
            margin-bottom: 1.5rem;
            display: flex;
            justify-content: center;
        }
    </style>
    <!-- Cloudflare Turnstile Script -->
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
</head>
<body>

<div class="login-card card">
    <div class="login-header">
        <h3 class="mb-0">Portal Desa</h3>
        <p class="mb-0 opacity-75">Control Panel Login</p>
    </div>
    <div class="login-body">
        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('/login') ?>" method="POST">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label for="username" class="form-label text-secondary small text-uppercase fw-bold">Username</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-secondary"><i class="fas fa-user"></i></span>
                    <input type="text" class="form-control bg-light border-start-0" id="username" name="username" required placeholder="Masukkan username">
                </div>
            </div>
            <div class="mb-4">
                <label for="password" class="form-label text-secondary small text-uppercase fw-bold">Password</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-secondary"><i class="fas fa-lock"></i></span>
                    <input type="password" class="form-control bg-light border-start-0" id="password" name="password" required placeholder="Masukkan password">
                </div>
            </div>

            <!-- Cloudflare Turnstile Widget -->
            <div class="cf-turnstile" data-sitekey="<?= env('turnstile.site_key') ?>" data-theme="light"></div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-login">Login Sekarang</button>
            </div>
        </form>
    </div>
    <div class="card-footer text-center py-3 border-0 bg-transparent">
        <p class="mb-0 text-secondary small">&copy; <?= date('Y') ?> Portal Desa Modern</p>
    </div>
</div>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
