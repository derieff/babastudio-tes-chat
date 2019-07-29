<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Files extends Model
{
    // protected $table = 'files';

    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'last_update';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'message_id', 'title', 'file',
    ];
}
