<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;
use App\Models\FoodModel;

class Foods extends BaseController
{
    public function index()
    {
        $model = new FoodModel();
        $keyword = $this->request->getGet('q');

        if ($keyword) {
            $model->like('name', $keyword)->orLike('description', $keyword);
        }

        $data = [
            'foods'   => $model->orderBy('id', 'DESC')->paginate(5, 'foods'),
            'pager'   => $model->pager,
            'session' => session(),
            'keyword' => $keyword
        ];

        return view('foods/index', $data);
    }

    public function new()
    {
        return view('foods/new');
    }

    public function create()
    {
        $rules = [
            'name'  => 'required|min_length[3]',
            'price' => 'required|numeric',
            'image' => 'uploaded[image]|max_size[image,2048]|is_image[image]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $file = $this->request->getFile('image');
        $newName = $file->getRandomName();
        $file->move(FCPATH . 'uploads', $newName);

        $data = [
            'name'        => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'price'       => $this->request->getPost('price'),
            'image'       => $newName,
        ];

        $model = new FoodModel();
        $model->insert($data);

        return redirect()->to('/foods')->with('message', 'Produk berhasil ditambahkan.');
    }

    public function edit($id = null)
    {
        $model = new FoodModel();
        $data['food'] = $model->find($id);

        if (!$data['food']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Makanan tidak ditemukan: ' . $id);
        }

        return view('foods/edit', $data);
    }

    public function update($id = null)
    {
        $rules = [
            'name'  => 'required|min_length[3]',
            'price' => 'required|numeric',
            'image' => 'if_exist|uploaded[image]|max_size[image,2048]|is_image[image]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new FoodModel();
        $food = $model->find($id);
        
        $data = [
            'name'        => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'price'       => $this->request->getPost('price'),
        ];
        
        $img = $this->request->getFile('image');

        if ($img && $img->isValid()) {
            if ($food['image'] && file_exists(FCPATH . 'uploads/' . $food['image'])) {
                unlink(FCPATH . 'uploads/' . $food['image']);
            }
            $newName = $img->getRandomName();
            $img->move(FCPATH . 'uploads', $newName);
            $data['image'] = $newName;
        }

        $model->update($id, $data);

        return redirect()->to('/foods')->with('message', 'Produk berhasil diperbarui.');
    }

    public function delete($id = null)
    {
        $model = new FoodModel();
        $food = $model->find($id);
        
        if ($food) {
            if ($food['image'] && file_exists(FCPATH . 'uploads/' . $food['image'])) {
                unlink(FCPATH . 'uploads/' . $food['image']);
            }
            $model->delete($id);
            return redirect()->to('/foods')->with('message', 'Produk berhasil dihapus.');
        }

        return redirect()->to('/foods')->with('error', 'Produk tidak ditemukan.');
    }
}