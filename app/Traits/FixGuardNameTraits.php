<?php

namespace App\Traits;

use Spatie\Permission\Guard;

trait FixGuardNameTraits
{
    public $FixGuardName;
    protected function getDefaultGuardName(): string
    {
        return $this->FixGuardName ? $this->FixGuardName :  Guard::getDefaultName($this);
    }
}
