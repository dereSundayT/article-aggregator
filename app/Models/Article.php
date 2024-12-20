<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Article extends Model
{
    use HasFactory;
    //
    protected $fillable = [
        'title',
        'description',
        'content',
        'keywords',
        'image_url',
        'published_at',
        'source_id',
        'category_id',
        'author_id'
    ];

    public function source(): BelongsTo
    {
        return $this->belongsTo(Source::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    public function getPublishedAtAttribute($value): string
    {
        return date('M d, Y', strtotime($value));
    }
}
