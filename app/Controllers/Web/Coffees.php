<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;
use App\Models\CoffeeModel;

class Coffees extends BaseController
{
    public function index()
    {
        $model = new CoffeeModel();
        $keyword = $this->request->getGet('q');

        if ($keyword) {
            $model->like('name', $keyword)->orLike('description', $keyword);
        }

        $data = [
            'coffees' => $model->orderBy('id', 'DESC')->paginate(5, 'coffees'),
            'pager'   => $model->pager,
            'session' => session(),
            'keyword' => $keyword
        ];

        return view('coffees/index', $data);
    }

    public function new()
    {
        return view('coffees/new');
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

        $model = new CoffeeModel();
        $model->insert($data);

        return redirect()->to('/coffees')->with('message', 'Produk berhasil ditambahkan.');
    }

    public function edit($id = null)
    {
        $model = new CoffeeModel();
        $data['coffee'] = $model->find($id);

        if (!$data['coffee']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Kopi tidak ditemukan: ' . $id);
        }

        return view('coffees/edit', $data);
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

        $model = new CoffeeModel();
        $coffee = $model->find($id);
        
        $data = [
            'name'        => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'price'       => $this->request->getPost('price'),
        ];
        
        $img = $this->request->getFile('image');

        if ($img && $img->isValid()) {
            if ($coffee['image'] && file_exists(FCPATH . 'uploads/' . $coffee['image'])) {
                unlink(FCPATH . 'uploads/' . $coffee['image']);
            }
            $newName = $img->getRandomName();
            $img->move(FCPATH . 'uploads', $newName);
            $data['image'] = $newName;
        }

        $model->update($id, $data);

        return redirect()->to('/coffees')->with('message', 'Produk berhasil diperbarui.');
    }

    public function delete($id = null)
    {
        $model = new CoffeeModel();
        $coffee = $model->find($id);
        
        if ($coffee) {
            if ($coffee['image'] && file_exists(FCPATH . 'uploads/' . $coffee['image'])) {
                unlink(FCPATH . 'uploads/' . $coffee['image']);
            }
            $model->delete($id);
            return redirect()->to('/coffees')->with('message', 'Produk berhasil dihapus.');
        }

        return redirect()->to('/coffees')->with('error', 'Produk tidak ditemukan.');
    }
}