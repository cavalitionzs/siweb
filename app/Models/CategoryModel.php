<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table         = 'book_category';
    protected $primaryKey    = 'book_category_id';
    protected $useTimestamps = true;
}
