<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'category_id', 'subcategory_id', 'asset_id', 'title', 'description',
        'priority', 'status', 'attachment_path', 'assigned_to', 
        'completed_at', 'admin_notes', 'due_at' 
    ];

    protected $casts = [
        'due_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Dodana veza prema potkategoriji
    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function assignedWorker()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function isOverdue(): bool
    {
        if ($this->status === 'rijeseno' || !$this->due_at) {
            return false;
        }
        return now()->greaterThan($this->due_at);
    }
}