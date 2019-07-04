<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class User extends Eloquent
{
    /**
     * The database table name.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The model fields, it should match those in the table.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'email_verified'
    ];

    public function userVerification()
    {
        return $this->hasMany('UserVerification', 'user_id');
    }

    public function userGroupLink()
    {
        return $this->hasMany('UserGroupLink', 'user_id');
    }
}