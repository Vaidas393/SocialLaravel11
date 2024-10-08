<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;
    // Explicitly define the table name
    protected $table = 'subcategories';

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
