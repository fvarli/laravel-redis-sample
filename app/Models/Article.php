<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    /**
     * Summary of user method
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    /**
     * Summary of categories method
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories(){
        return $this->belongsToMany(Category::class);
    }
}
