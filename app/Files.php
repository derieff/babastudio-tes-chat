<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Files extends Model
{
    // protected $table = 'files';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'message_id', 'title', 'file',
    ];
}
