<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class Foods extends ResourceController
{
    protected $modelName = 'App\Models\FoodModel';
    protected $format    = 'json';

    public function index()
    {
        $foods = $this->model->orderBy('id', 'DESC')->findAll();

        foreach ($foods as &$food) {
            if ($food['image']) {
                $food['image_url'] = base_url('uploads/' . $food['image']);
            }
        }

        return $this->respond($foods);
    }

    public function show($id = null)
    {
        $food = $this->model->find($id);
        if (!$food) {
            return $this->failNotFound("Food ID {$id} tidak ditemukan");
        }

        if ($food['image']) {
            $food['image_url'] = base_url('uploads/' . $food['image']);
        }

        return $this->respond($food);
    }

    public function create()
    {
        $rules = [
            'name'  => 'required|min_length[3]',
            'price' => 'required|numeric',
            'image' => 'uploaded[image]|max_size[image,2048]|is_image[image]'
        ];

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
        }
        
        $file = $this->request->getFile('image');
        $newName = $file->getRandomName();
        $file->move(FCPATH . 'uploads', $newName);

        $data = [
            'name'        => $this->request->getVar('name'),
            'description' => $this->request->getVar('description'),
            'price'       => $this->request->getVar('price'),
            'image'       => $newName,
        ];

        $id = $this->model->insert($data);
        if (!$id) {
            return $this->failServerError('Gagal menyimpan data makanan.');
        }

        $newFood = $this->model->find($id);
        if ($newFood['image']) {
            $newFood['image_url'] = base_url('uploads/' . $newFood['image']);
        }

        return $this->respondCreated($newFood);
    }

    public function update($id = null)
    {
        $food = $this->model->find($id);
        if (!$food) {
            return $this->failNotFound("Food ID {$id} tidak ditemukan");
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
        ];
        
        $data = array_filter($data, fn($value) => !is_null($value));

        $img = $this->request->getFile('image');

        if ($img && $img->isValid() && !$img->hasMoved()) {
            if ($food['image'] && file_exists(FCPATH . 'uploads/' . $food['image'])) {
                unlink(FCPATH . 'uploads/' . $food['image']);
            }

            $newName = $img->getRandomName();
            $img->move(FCPATH . 'uploads', $newName);
            $data['image'] = $newName;
        }

        if (empty($data)) {
             return $this->fail('Tidak ada data untuk diperbarui.', 400);
        }
        
        $this->model->update($id, $data);

        $updatedFood = $this->model->find($id);
        if ($updatedFood['image']) {
            $updatedFood['image_url'] = base_url('uploads/' . $updatedFood['image']);
        }
        
        return $this->respond($updatedFood);
    }

    public function delete($id = null)
    {
        $food = $this->model->find($id);
        if (!$food) {
            return $this->failNotFound("Food ID {$id} tidak ditemukan");
        }

        if ($food['image']) {
            $path = FCPATH . 'uploads/' . $food['image'];
            if (file_exists($path)) {
                unlink($path);
            }
        }

        $this->model->delete($id);
        
        return $this->respondDeleted([
            'id'      => $id,
            'message' => 'Makanan berhasil dihapus'
        ]);
    }
}