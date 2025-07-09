<?php namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\CoffeeModel;

class Coffees extends ResourceController
{
    protected $modelName = CoffeeModel::class;
    protected $format    = 'json';

    /**
     * GET /api/coffees
     */
    public function index()
    {
        $coffees = $this->model->orderBy('id', 'DESC')->findAll();

        // Tambahkan image_url jika ada gambar
        foreach ($coffees as &$coffee) {
            if ($coffee['image']) {
                $coffee['image_url'] = base_url('uploads/' . $coffee['image']);
            }
        }

        return $this->respond($coffees);
    }

    /**
     * GET /api/coffees/{id}
     */
    public function show($id = null)
    {
        $coffee = $this->model->find($id);
        if (! $coffee) {
            return $this->failNotFound("Coffee ID {$id} tidak ditemukan");
        }

        if ($coffee['image']) {
            $coffee['image_url'] = base_url('uploads/' . $coffee['image']);
        }

        return $this->respond($coffee);
    }

    /**
     * POST /api/coffees
     */
    public function create()
    {
        try {
            $rules = [
                'name'        => 'required',
                'price'       => 'required|decimal',
                'image'       => 'uploaded[image]|is_image[image]|max_size[image,2048]',
            ];

            if (! $this->validate($rules)) {
                return $this->failValidationErrors($this->validator->getErrors());
            }

            $file = $this->request->getFile('image');
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads', $newName); // FCPATH = public/

            $data = [
                'name'        => $this->request->getPost('name'),
                'description' => $this->request->getPost('description') ?? null,
                'price'       => $this->request->getPost('price'),
                'image'       => $newName,
            ];

            $id = $this->model->insert($data);
            if (! $id) {
                return $this->failServerError('Gagal menyimpan data');
            }

            $coffee = $this->model->find($id);
            $coffee['image_url'] = base_url('uploads/' . $coffee['image']);

            return $this->respondCreated($coffee);

        } catch (\Throwable $e) {
            log_message('error', $e->getMessage());
            return $this->failServerError('Internal Server Error: '.$e->getMessage());
        }
    }

    /**
     * PUT /api/coffees/{id}
     */
    public function update($id = null)
{
    $coffee = $this->model->find($id);
    if (!$coffee) {
        return $this->failNotFound("Coffee ID {$id} tidak ditemukan");
    }

    $rules = [
        'name'  => 'if_exist|required|min_length[3]',
        'price' => 'if_exist|required|numeric',
        'image' => 'if_exist|uploaded[image]|max_size[image,2048]|is_image[image]'
    ];

    if (!$this->validate($rules)) {
        return $this->fail($this->validator->getErrors());
    }

    $data = [
        'name'        => $this->request->getVar('name'),
        'description' => $this->request->getVar('description'),
        'price'       => $this->request->getVar('price'),
        'category'    => $this->request->getVar('category'),
    ];
    
    $data = array_filter($data, fn($value) => !is_null($value));

    $img = $this->request->getFile('image');

    if ($img && $img->isValid() && !$img->hasMoved()) {
        if ($coffee['image'] && file_exists(FCPATH . 'uploads/' . $coffee['image'])) {
            unlink(FCPATH . 'uploads/' . $coffee['image']);
        }

        $newName = $img->getRandomName();
        $img->move(FCPATH . 'uploads', $newName);
        $data['image'] = $newName;
    }

    if (empty($data)) {
         return $this->fail('Tidak ada data untuk diperbarui.', 400);
    }
    
    $this->model->update($id, $data);

    $response = [
        'status'   => 200,
        'error'    => null,
        'messages' => [
            'success' => 'Produk berhasil diperbarui'
        ],
        'data' => $this->model->find($id)
    ];

    return $this->respond($response);
}

    /**
     * DELETE /api/coffees/{id}
     */
    public function delete($id = null)
    {
        try {
            $coffee = $this->model->find($id);
            if (! $coffee) {
                return $this->failNotFound("Coffee ID {$id} tidak ditemukan");
            }

            // Hapus gambar jika ada
            if ($coffee['image']) {
                $path = FCPATH . 'uploads/' . $coffee['image'];
                if (file_exists($path)) {
                    unlink($path);
                }
            }

            $this->model->delete($id);
            return $this->respondDeleted([
                'id'      => $id,
                'message' => 'Coffee berhasil dihapus'
            ]);

        } catch (\Throwable $e) {
            log_message('error', $e->getMessage());
            return $this->failServerError('Internal Server Error: '.$e->getMessage());
        }
    }
}
