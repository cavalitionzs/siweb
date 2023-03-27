<?php

namespace App\Models;

use CodeIgniter\Model;

class BookModel extends Model
{
    protected $table         = 'book';
    protected $primaryKey    = 'book_id';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'title', 'slug', 'author', 'release_year', 'price', 'discount', 'stock', 'cover', 'book_category_id', 'updated_at', 'created_at', 'deleted_at'
    ];

    // public function getBook($slug = null)
    // {
    //     $this->table('book')
    //         ->join('book_category', 'book.book_category_id = book_category.book_category_id');
    //     return $this->get()->getResultArray();
    // }

    public function getBook($slug = false)
    {
        $query = $this->table('book')
            ->join('book_category', 'book_category_id')
            ->where('deleted_at is null');

        if ($slug == false)
            return $query->get()->getResultArray();
        return $query->where(['slug' => $slug])->first();
    }

    // public function getBook($slug = null)
    // {
    //     if ($slug === null) {
    //         $this->join('book_category', 'book.book_category_id = book_category.book_category_id');
    //     } else {
    //         $this->join('book_category', 'book.book_category_id = book_category.book_category_id');
    //         $this->where(['slug' => $slug]);
    //     }
    //     // return $this->get()->getResultArray();
    //     return $this->first();
    // }
}
