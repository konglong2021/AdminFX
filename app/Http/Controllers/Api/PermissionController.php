<?php

namespace App\Http\Controllers\Api;

use App\Repositories\PermissionRepository;
use App\Traits\BaseResourceTraits;

class PermissionController  extends  BaseApiController
{
    use BaseResourceTraits;

    public function repository()
    {
        return PermissionRepository::class;
    }
    public function updatePermission()
    {
        \Artisan::call('router:permission');
        return $this->JsonOK("OK");
    }
}
