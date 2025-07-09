<?php namespace App\Models;

use CodeIgniter\Model;

class CoffeeModel extends Model
{
    protected $table         = 'coffees';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['name','description','price','image'];
    protected $useTimestamps = true;
}
