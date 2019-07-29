<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    // protected $table = 'messages';

    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'last_update';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'text', 'file_id',
    ];
}
