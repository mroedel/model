<?php

namespace Roedel\Model;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Request;

class Revision extends Eloquent
{
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'system_revisions';

    /**
     * The attributes for mass-assignment.
     *
     * @var array
     */
    protected $fillable = [
        'revisionable_type',
        'revisionable_id',
        'user_id',
        'key',
        'old_value',
        'new_value',
        'ip_address'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The fields that converted to \Carbon\Carbon.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        /**
         * Attach to the 'creating' Model Event to provide the IP-Address
         * for the `id` field (provided by $model->getKeyName())
         */
        static::creating(/**
         * @param $model
         */
            function ($model) {
                $model->ip_address = Request::getClientIp();
            });
    }

    public function getIpAddressAttribute($value)
    {
        return inet_ntop($value);
    }

    public function setIpAddressAttribute($value)
    {
        $this->attributes['ip_address'] = inet_pton($value);
    }

    /**
     * Get the model the action as been taken on.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function revisionable()
    {
        return $this->morphTo();
    }
}
