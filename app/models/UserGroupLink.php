<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class UserGroupLink extends Eloquent
{
    /**
     * The database table name.
     *
     * @var string
     */
    protected $table = 'user_group_link';

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
        'group_id'
    ];

    public function userGroup()
    {
        return $this->belongsTo('UserGroup', 'group_id');
    }

    public function user()
    {
        return $this->belongsTo('User');
    }
}