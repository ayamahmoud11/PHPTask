<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Ignore
 */
class UserScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        if (Auth::check() && !Auth::user()->hasRole('admin')) {
            $builder->where('user_id', Auth::id());
        }
    }
}