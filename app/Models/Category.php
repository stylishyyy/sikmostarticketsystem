<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'is_active'];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    // Dodana veza prema potkategorijama
    public function subcategories()
    {
        return $this->hasMany(Subcategory::class);
    }
}