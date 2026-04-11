<?php namespace App\Models;
use CodeIgniter\Model;

class Order_model extends Model {
    protected $table = 'orders';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'total_amount', 'payment', 'change_amount', 'order_date'];
}