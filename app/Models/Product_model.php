<?php 

namespace App\Models; // IMPORTANTE: Dapat ari gid ini sa pinaka-babaw

use CodeIgniter\Model;

class Product_model extends Model {
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $allowedFields = ['product_name', 'category', 'price', 'stock'];
}