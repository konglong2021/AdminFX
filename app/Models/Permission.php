<?php

namespace App\Models;

use Spatie\Permission\Guard;
use Spatie\Permission\Models\Permission as PermissionBase;

class Permission extends PermissionBase
{
    public $FixGuardName;
    protected function getDefaultGuardName(): string
    {
        return $this->FixGuardName ? $this->FixGuardName :  Guard::getDefaultName($this);
    }
}
