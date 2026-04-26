<?php 
namespace App\Controllers;

use App\Models\Product_model; 

class Products extends BaseController {

    // 1. READ: Listahan sang produkto
    public function index() {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('/'));
        }
        
        $model = new Product_model();
        
        $all_products = $model->findAll();
        
        $low_count = 0;
        foreach($all_products as $p) {
            if($p['stock'] <= 5 && $p['stock'] > 0) {
                $low_count++;
            }
        }

        $data = [
            'products'  => $all_products,
            'low_count' => $low_count,
            'title'     => 'Riverside | Inventory'
        ];
        
        return view('products_list', $data); 
    }

    // 2. CREATE: Form sa pag-add
    public function add() {
        $data['title'] = 'Riverside | Add New Item';
        return view('add_product_view', $data);
    }

    // 3. CREATE: I-save sa Database (FIXED to Original Name)
    public function store() {
        $model = new Product_model();
        
        $file = $this->request->getFile('product_image');
        $imageName = 'no-image.png'; 

        if ($file && $file->isValid() && !$file->hasMoved()) {
            // FIX: Gamita ang getName() para makuha ang original filename (e.g. matcha.jpg)
            $imageName = $file->getName(); 
            
            // I-move sa PUBLIC folder
            $file->move(FCPATH . 'assets/img/products/', $imageName);
        }

        $data = [
            'product_name' => $this->request->getPost('product_name'), 
            'category'     => $this->request->getPost('category'),
            'price'        => $this->request->getPost('price'),
            'stock'        => $this->request->getPost('stock'),
            'image'        => $imageName 
        ];

        $model->insert($data);
        return redirect()->to(base_url('products'))->with('status', 'Item Added!');
    }

    // 4. UPDATE: Form para sa pag-edit
    public function edit($id = null) {
        $model = new Product_model();
        $data = [
            'product' => $model->find($id),
            'title'   => 'Edit Product | Riverside' 
        ];

        if (empty($data['product'])) {
            return redirect()->to(base_url('products'));
        }

        return view('products_edit', $data);
    }

    // 5. UPDATE: I-save ang gin-edit
    public function update($id = null) {
        $model = new Product_model();

        $data = [
            'product_name' => $this->request->getPost('product_name'),
            'category'     => $this->request->getPost('category'),
            'price'        => $this->request->getPost('price'),
            'stock'        => $this->request->getPost('stock'),
        ];

        $file = $this->request->getFile('product_image');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            // FIX: getName() man ang gamiton diri para consistent
            $imageName = $file->getName(); 
            $file->move(FCPATH . 'assets/img/products/', $imageName);
            $data['image'] = $imageName;
        }

        $model->update($id, $data);
        return redirect()->to(base_url('products'))->with('status', 'Product updated successfully!');
    }

    // 6. DELETE: Pag-papas sang item
    public function delete($id = null) {
        $model = new Product_model();
        $model->delete($id);
        return redirect()->to(base_url('products'))->with('status', 'Product deleted!');
    }
}