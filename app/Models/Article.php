<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Scout\Searchable;

class Article extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'journal_id', 'author_id', 'title', 'slug',
        'abstract', 'keywords', 'file_path',
        'status', 'published_at'
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function journal()
    {
        return $this->belongsTo(Journal::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function reviews()
    {
        return $this->hasMany(ArticleReview::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function toSearchableArray()
    {
        return [
            'title'    => $this->title,
            'abstract' => $this->abstract,
            'keywords' => $this->keywords,
        ];
    }
}