<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Dashboard Utama
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="text-center">
        <h1 class="text-4xl font-bold mb-4">Selamat Datang di Panel Admin</h1>
        <p class="text-lg text-slate-600 mb-10">Silakan pilih data yang ingin Anda kelola.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <a href="/coffees" class="block p-8 bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300">
            <div class="text-center">
                <div class="text-5xl mb-4">☕️</div>
                <h2 class="text-2xl font-bold text-slate-800">Kelola Kopi</h2>
                <p class="text-slate-500 mt-2">Tambah, edit, atau hapus produk minuman kopi.</p>
            </div>
        </a>

        <a href="/foods" class="block p-8 bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300">
            <div class="text-center">
                <div class="text-5xl mb-4">🍔</div>
                <h2 class="text-2xl font-bold text-slate-800">Kelola Makanan</h2>
                <p class="text-slate-500 mt-2">Tambah, edit, atau hapus produk makanan.</p>
            </div>
        </a>
    </div>
<?= $this->endSection() ?>