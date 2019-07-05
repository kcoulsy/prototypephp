<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class RoleCategoryLink extends Eloquent
{
    /**
     * The database table name.
     *
     * @var string
     */
    protected $table = 'role_category_link';

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
        'category_id'
    ];

    public function roleCategory()
    {
        return $this->belongsTo('RoleCategory', 'id');
    }

    public function role()
    {
        return $this->belongsTo('Role');
    }
}
