<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class Role extends Eloquent
{
    /**
     * The database table name.
     *
     * @var string
     */
    protected $table = 'role';

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
        'alias',
        'name'
    ];

    public function roleCategoryLink()
    {
        return $this->hasMany('RoleCategoryLink', 'role_id');
    }
}
