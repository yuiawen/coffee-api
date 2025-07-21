<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Tambah Kopi Baru
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <h1 class="text-3xl font-bold mb-6">Form Tambah Produk Kopi</h1>
    
    <?= $this->include('coffees/_form') ?>
<?= $this->endSection() ?>