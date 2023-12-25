<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Comment extends Model
{
    use HasFactory;


    protected $fillable = [
        'title',
        'content',
        'approved',
        'user_id',
        'article_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];



    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function getContentAttribute($value)
    {
        return str_replace('<script>', '',str_replace('</script>', '', $value));
    }

}
