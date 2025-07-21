<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Edit Makanan: <?= esc($food['name']) ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <h1 class="text-3xl font-bold mb-6">Form Edit Produk Makanan</h1>
    
    <?= $this->include('foods/_form') ?>
<?= $this->endSection() ?>