<?php

use Illuminate\Database\Eloquent\Builder;

trait Multitenantable
{
    protected static function bootMultitenantable(): void
    {
        // static::creating(function ($model) {
        //     $model->user_id = auth()->id();
        // });

        // if (!auth()->user()->hasRole(['Developer', 'Admin'])) {
        static::addGlobalScope('access_by_coordinator_id', function (Builder $builder) {
            $builder->where('coordinator_id', auth()->id());
        });
        // }
    }
}
