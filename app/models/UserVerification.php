<?php

namespace Model;

use Illuminate\Database\Eloquent\Model as Eloquent;

class UserVerification extends Eloquent
{
    /**
     * The database table name.
     *
     * @var string
     */
    protected $table = 'user_verification';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The model fields, it should match those in the table.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'verification_code'
    ];

    public function user()
    {
        return $this->belongsTo('Model\User');
    }
}