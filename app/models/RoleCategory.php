<?php

namespace Model;

use Illuminate\Database\Eloquent\Model as Eloquent;

class RoleCategory extends Eloquent
{
    /**
     * The database table name.
     *
     * @var string
     */
    protected $table = 'role_category';

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

    public function roleCategoryLink()
    {
        return $this->hasMany('Model\RoleCategorylink', 'role_id');
    }
}
