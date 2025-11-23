<?php

namespace App\Enums;

enum AssociationManagerEnum: string
{
    //----------------------
    // System Admin Modules
    //----------------------

    case USER = 'user';
    case MANAGER= 'manager';
    case OWNER= 'owner';
    public function lang(): string
{
    return trns($this->value);
}

}
