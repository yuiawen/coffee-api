<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Manajemen Makanan
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-slate-800">Manajemen Produk Makanan</h1>
            <p class="text-slate-500 mt-1">Kelola semua produk makanan Anda di sini.</p>
        </div>
        <a href="/foods/new" class="flex items-center gap-2 py-2 px-4 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" /></svg>
            Tambah Produk
        </a>
    </div>

    <?php if (session()->has('message')) : ?>
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <p><?= session('message') ?></p>
        </div>
    <?php endif ?>

    <div class="bg-white p-6 rounded-xl shadow-lg">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-slate-700">Daftar Produk</h2>
            <form action="/foods" method="get" class="relative">
                <input type="text" name="q" value="<?= esc($keyword ?? '') ?>" placeholder="Cari produk..." class="pl-10 pr-4 py-2 border border-slate-300 rounded-lg w-64 focus:ring-blue-500 focus:border-blue-500">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" /></svg>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-slate-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Gambar</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Harga</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    <?php if (!empty($foods)): ?>
                        <?php foreach ($foods as $food): ?>
                            <tr class="hover:bg-slate-50">
                                <td class="px-6 py-4">
                                    <img src="<?= base_url('uploads/' . $food['image']) ?>" alt="<?= esc($food['name']) ?>" class="h-12 w-12 rounded-lg object-cover">
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-semibold text-slate-800"><?= esc($food['name']) ?></div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-slate-800">Rp <?= number_format($food['price'], 0, ',', '.') ?></div>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium">
                                    <div class="flex items-center gap-4">
                                        <a href="/foods/<?= $food['id'] ?>/edit" class="text-blue-600 hover:text-blue-800 flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" /><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" /></svg>
                                            Edit
                                        </a>
                                        <form action="/foods/<?= $food['id'] ?>" method="post" onsubmit="return confirm('Apakah Anda yakin?');">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="text-red-600 hover:text-red-800 flex items-center gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-slate-500">
                                <?php if ($keyword): ?>
                                    Produk "<?= esc($keyword) ?>" tidak ditemukan.
                                <?php else: ?>
                                    Belum ada produk.
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <div class="mt-6">
            <?= $pager->links('foods', 'default_full') ?>
        </div>
    </div>
<?= $this->endSection() ?>