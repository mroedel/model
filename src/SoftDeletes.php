<?php

namespace Roedel\Model;

use Illuminate\Database\Eloquent\SoftDeletes as LaravelSoftDeletes;

trait SoftDeletes
{

    use LaravelSoftDeletes;

    /**
     * Check if soft deletes are currently enabled on this model
     *
     * @return bool
     */
    public function isForceDelete()
    {
        return $this->forceDeleting;
    }

}
