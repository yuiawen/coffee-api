<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Edit Kopi: <?= esc($coffee['name']) ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <h1 class="text-3xl font-bold mb-6">Form Edit Produk Kopi</h1>
    
    <?= $this->include('coffees/_form') ?>
<?= $this->endSection() ?>