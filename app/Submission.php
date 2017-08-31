<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    /**
     * Don't guard filling of any attributes.
     *
     * @var array
     */
    protected $guarded = [];

    public function content()
    {
        return $this->morphTo();
    }
}
