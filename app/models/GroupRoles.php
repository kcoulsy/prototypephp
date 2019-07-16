<?php

namespace Model;

use Illuminate\Database\Eloquent\Model as Eloquent;

class GroupRoles extends Eloquent
{
    /**
     * The database table name.
     *
     * @var string
     */
    protected $table = 'group_roles';

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
        'role_id',
        'group_id'
    ];
}
