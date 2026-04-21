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
    
    // Kunin lahat ng products
    $all_products = $model->findAll();
    
    // Bilangin kung ilan ang low stock (5 pababa pero hindi 0)
    // Para mag-match ito sa dashboard alert mo
    $low_count = 0;
    foreach($all_products as $p) {
        if($p['stock'] <= 5 && $p['stock'] > 0) {
            $low_count++;
        }
    }

    $data = [
        'products'  => $all_products,
        'low_count' => $low_count, // Ito ang bilang na dapat pumasok sa dashboard
        'title'     => 'Riverside | Inventory'
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
    $model = new \App\Models\Product_model(); // Siguraduhin na tama ang namespace ng model mo

    // 1. Kunin muna ang mga basic data galing sa form
    $data = [
        'product_name' => $this->request->getPost('product_name'),
        'category'     => $this->request->getPost('category'),
        'price'        => $this->request->getPost('price'),
        'stock'        => $this->request->getPost('stock'),
    ];

    // 2. Handle ang image upload
    $file = $this->request->getFile('product_image');

    // I-check kung may valid na file na in-upload
    if ($file && $file->isValid() && !$file->hasMoved()) {
        // Kunin ang original name (hal. "Cappuccino.jpg")
        $imageName = $file->getName(); 
        
        // Ilipat ang file sa tamang folder: public/assets/img/products/
        $file->move(FCPATH . 'assets/img/products/', $imageName);
        
        // Idagdag ang image name sa $data array para ma-save sa database
        $data['image'] = $imageName;
    }

    // 3. I-update ang database gamit ang kumpletong $data
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