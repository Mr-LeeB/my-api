<?php

namespace Apiato\Core\Exceptions\Handlers;

use Illuminate\Foundation\Exceptions\Handler as LaravelExceptionHandler;
use Throwable;

/**
 * Class ExceptionsHandler
 *
 * @author  Mahmoud Zalt  <mahmoud@zalt.me>
 */
class ExceptionsHandler extends LaravelExceptionHandler
{
    /**
     * Get the default context variables for logging.
     *
     * @return array
     */
    protected function context()
    {
        try {
            return array_filter([
                'url' => request()->fullUrl(),
                'user-id' => auth()->id(),
                'user-name' => auth()->user()->name ?? null,
                'user-email' => auth()->user()->email ?? null,
                'user-roles' => auth()->user()->getRoleNames() ?? null,
                'user-permissions' => auth()->user()->getPermissionNames() ?? null,
                'user-abilities' => auth()->user()->getAbilities() ?? null,
                'user-abilities-ids' => auth()->user()->getAbilities()->pluck('id') ?? null,
                'user-abilities-names' => auth()->user()->getAbilities()->pluck('name') ?? null,
                'user-abilities-actions' => auth()->user()->getAbilities()->pluck('action') ?? null,
                'user-abilities-roles' => auth()->user()->getAbilities()->pluck('roles') ?? null,
                'user-abilities-permissions' => auth()->user()->getAbilities()->pluck('permissions') ?? null,
                'user-abilities-roles-names' => auth()->user()->getAbilities()->pluck('roles')->pluck('name') ?? null,
                'user-abilities-permissions-names' => auth()->user()->getAbilities()->pluck('permissions')->pluck('name') ?? null,
                'user-abilities-roles-ids' => auth()->user()->getAbilities()->pluck('roles')->pluck('id') ?? null,
                'user-abilities-permissions-ids' => auth()->user()->getAbilities()->pluck('permissions')->pluck('id') ?? null,
                'user-abilities-roles-actions' => auth()->user()->getAbilities()->pluck('roles')->pluck('action') ?? null,
                'user-abilities-permissions-actions' => auth()->user()->getAbilities()->pluck('permissions')->pluck('action') ?? null,
            ]);
        } catch (Throwable $e) {
            return [];
        }
    }
}
