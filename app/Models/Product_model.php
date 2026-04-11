<?php 
namespace App\Models;

use CodeIgniter\Model;

class Product_model extends Model {
    protected $table = 'products';
    protected $primaryKey = 'id';
    // Dapat mag-match ini sa ginapasa sang Controller
    protected $allowedFields = ['product_name', 'category', 'price', 'stock'];
}