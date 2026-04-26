<?php 
namespace App\Models;

use CodeIgniter\Model;

class Product_model extends Model {
    protected $table = 'products';
    protected $primaryKey = 'id';
    
    // Gindugang naton ang 'image' sa allowedFields
    protected $allowedFields = ['product_name', 'category', 'price', 'stock', 'image'];
}