<?php

namespace App\Traits;

use App\Scopes\UserScope;

trait Tenantable
{
    protected static function bootTenantable()
    {
        static::addGlobalScope(new UserScope);

        static::creating(function ($model) {
            if (auth()->check()) {
                $model->user_id = auth()->id();
            }
        });
    }
}