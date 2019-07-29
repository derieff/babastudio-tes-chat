<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    // protected $table = 'messages';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'text', 'file_id',
    ];
}
