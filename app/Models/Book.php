<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['rack_id', 'isbn', 'title', 'author', 'publisher', 'publication_year', 'pages', 'description', 'stock', 'cover_image'];

    protected static function booted()
    {
        static::creating(function ($book) {
            // Ambil data buku terakhir untuk mendapatkan nomor urut
            $lastBook = static::orderBy('id', 'desc')->first();
            $number = $lastBook ? $lastBook->id + 1 : 1; // Jika $lastBook ada (sudah ada buku): $number = $lastBook->id + 1 (nomor urut = id terakhir + 1).
            // Jika $lastBook null (belum ada buku): $number = 1.
            $book->book_code = 'BOK-'.str_pad($number, 4, '0', STR_PAD_LEFT);
        });
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'book_category', 'book_id', 'category_id');
    }

    public function rack(): BelongsTo
    {
        return $this->belongsTo(Rack::class);
    }

    public function loanDetails(): HasMany
    {
        return $this->hasMany(LoanDetail::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
