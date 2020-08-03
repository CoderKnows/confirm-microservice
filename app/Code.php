<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Code
 * @package App
 *
 * @property integer $id
 * @property string $code
 * @property boolean $is_active
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property integer object_id
 */
class Code extends Model
{
    /** @var int время жизни кода в секундах */
    const LIFETIME = 300;

    protected $connection = 'pgsql';
    protected $table = 'confirm_code';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    public function object()
    {
        return $this->belongsTo(Confirm::class, 'object_id', 'id');
    }
}
