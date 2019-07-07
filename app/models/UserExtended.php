<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class UserExtended extends Eloquent
{
    /**
     * The database table name.
     *
     * @var string
     */
    protected $table = 'user_extended';

    /**
     * The model fields, it should match those in the table.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'profile_image'
    ];

    public function user()
    {
        return $this->belongsTo('User');
    }
}