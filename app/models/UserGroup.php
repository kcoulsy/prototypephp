<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class UserGroup extends Eloquent
{
    /**
     * The database table name.
     *
     * @var string
     */
    protected $table = 'user_group';

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
        'name'
    ];

    public function userGroupLink()
    {
        return $this->hasMany('UserGroupLink', 'group_id');
    }
}