<div class="bg-white p-8 rounded-xl shadow-md">

    <?php if (session()->has('errors')) : ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-6" role="alert">
            <strong class="font-bold">Terjadi Kesalahan!</strong>
            <ul class="mt-2 list-disc list-inside">
                <?php foreach (session('errors') as $error) : ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    <?php endif ?>

    <form action="<?= isset($food) ? "/foods/{$food['id']}" : '/foods' ?>" method="post" enctype="multipart/form-data">
        
        <?php if (isset($food)) : ?>
            <input type="hidden" name="_method" value="PUT">
        <?php endif; ?>

        <div class="space-y-6">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nama Makanan</label>
                <input type="text" id="name" name="name" value="<?= old('name', $food['name'] ?? '') ?>" 
                       class="mt-1 block w-full px-3 py-2 bg-white border border-slate-300 rounded-md text-sm shadow-sm placeholder-slate-400
                              focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500" required>
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea id="description" name="description" rows="4"
                          class="mt-1 block w-full px-3 py-2 bg-white border border-slate-300 rounded-md text-sm shadow-sm placeholder-slate-400
                                 focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500"><?= old('description', $food['description'] ?? '') ?></textarea>
            </div>

            <div>
                <label for="price" class="block text-sm font-medium text-gray-700">Harga (Rp)</label>
                <input type="number" id="price" name="price" value="<?= old('price', $food['price'] ?? '') ?>" 
                       class="mt-1 block w-full px-3 py-2 bg-white border border-slate-300 rounded-md text-sm shadow-sm placeholder-slate-400
                              focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500" required>
            </div>

            <div>
                <label for="image" class="block text-sm font-medium text-gray-700">Gambar Makanan</label>
                <?php if (isset($food) && $food['image']) : ?>
                    <img src="<?= base_url('uploads/' . $food['image']) ?>" width="100" alt="Current Image" class="mt-2 mb-2 rounded-md">
                    <small class="text-slate-500">Upload gambar baru untuk mengganti.</small>
                <?php endif; ?>
                <input type="file" id="image" name="image"
                       class="mt-2 block w-full text-sm text-slate-500
                              file:mr-4 file:py-2 file:px-4
                              file:rounded-full file:border-0
                              file:text-sm file:font-semibold
                              file:bg-sky-50 file:text-sky-700
                              hover:file:bg-sky-100">
            </div>
        </div>

        <div class="mt-8 flex justify-end gap-4">
            <a href="/foods" class="py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Batal
            </a>
            <button type="submit" class="py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-sky-600 hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500">
                <?= isset($food) ? 'Perbarui Produk' : 'Tambah Produk' ?>
            </button>
        </div>
    </form>
</div>