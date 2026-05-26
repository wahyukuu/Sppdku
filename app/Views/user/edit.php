<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="premium-card" style="max-width: 600px; margin: 0 auto;">
    <div class="mb-4">
        <a href="<?= base_url('user') ?>" class="btn btn-sm btn-outline-secondary mb-3" style="border-radius: 8px;">
            <i data-lucide="arrow-left" class="me-1"></i> Kembali
        </a>
        <h5 class="m-0 font-display" style="font-weight: 700; color:#1e293b;">Edit Profil User</h5>
        <p class="text-muted m-0" style="font-size: 13px;">Perbarui data akun pengguna sistem di bawah.</p>
    </div>

    <form action="<?= base_url('user/update/' . $user['id_user']) ?>" method="POST">
        <div class="mb-3">
            <label for="nama" class="form-label" style="font-weight:600; font-size:13px; color:#475569;">Nama Lengkap</label>
            <input type="text" name="nama" id="nama" class="form-control form-control-premium" value="<?= esc($user['nama']) ?>" required autocomplete="off">
        </div>

        <div class="mb-3">
            <label for="username" class="form-label" style="font-weight:600; font-size:13px; color:#475569;">Username</label>
            <input type="text" name="username" id="username" class="form-control form-control-premium" value="<?= esc($user['username']) ?>" required autocomplete="off">
        </div>

        <div class="mb-3">
            <label for="password" class="form-label" style="font-weight:600; font-size:13px; color:#475569;">Kata Sandi Baru (Password)</label>
            <input type="password" name="password" id="password" class="form-control form-control-premium" placeholder="Kosongkan jika tidak ingin merubah sandi...">
            <small class="text-muted" style="font-size: 11px;">Biarkan kolom ini kosong jika Anda tidak ingin memperbarui kata sandi pengguna.</small>
        </div>

        <div class="mb-4">
            <label for="role" class="form-label" style="font-weight:600; font-size:13px; color:#475569;">Hak Akses / Peran</label>
            <select name="role" id="role" class="form-select form-control-premium" required>
                <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>User Biasa (Hanya SPT & SPD)</option>
                <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Administrator (Akses Penuh)</option>
            </select>
        </div>

        <button type="submit" class="btn btn-premium-primary w-100 py-2.5" style="border-radius: 12px; font-weight:600;">
            <i data-lucide="save" class="me-2"></i> Perbarui Data Pengguna
        </button>
    </form>
</div>
<?= $this->endSection() ?>
