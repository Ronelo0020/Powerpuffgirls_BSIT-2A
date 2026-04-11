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
        $data = [
            'products' => $model->findAll(),
            'title'    => 'Riverside | Inventory'
        ];
        return view('products_list', $data); 
    }

    // 2. CREATE: Form sa pag-add
    public function add() {
        $data['title'] = 'Riverside | Add New Item';
        return view('add_product_view', $data);
    }

    // 3. CREATE: I-save sa Database (FIXED KEY)
    public function store() {
        $model = new Product_model();
        $data = [
            // Gincatch ang 'product_name' para mag-match sa HTML name attribute
            'product_name' => $this->request->getPost('product_name'), 
            'category'     => $this->request->getPost('category'),
            'price'        => $this->request->getPost('price'),
            'stock'        => $this->request->getPost('stock'),
        ];

        if ($model->insert($data)) {
            return redirect()->to(base_url('products'))->with('status', 'New item added successfully!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to save product.');
        }
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
        
        $model->update($id, $data);
        return redirect()->to(base_url('products'))->with('status', 'Product updated!');
    }

    // 6. DELETE: Pag-papas sang item
    public function delete($id = null) {
        $model = new Product_model();
        $model->delete($id);
        return redirect()->to(base_url('products'))->with('status', 'Product deleted!');
    }
}