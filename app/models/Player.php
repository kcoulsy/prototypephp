<?php

namespace Model;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Player extends Eloquent
{
    /**
     * The database table name.
     *
     * @var string
     */
    protected $table = 'players';

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
        'id',
        'name',
        'rank_index',
        'player_class',
        'officer_note',
        'note'
    ];
}
