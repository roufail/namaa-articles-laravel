<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'meta_data',
        'excerpt',
        'approved',
        'user_id',
    ];


    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeApproved($art)
    {
        return $art->where('approved', 1);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function approvedcomments()
    {
        return $this->hasMany(Comment::class)->where('approved', 1);
    }


    protected function content(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => 'sss',
        );
    }

    public function getContentAttribute($value)
    {
        return str_replace('<script>', '',str_replace('</script>', '', $value));
    }

}
