<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Tambah Makanan Baru
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <h1 class="text-3xl font-bold mb-6">Form Tambah Produk Makanan</h1>
    
    <?= $this->include('foods/_form') ?>
<?= $this->endSection() ?>