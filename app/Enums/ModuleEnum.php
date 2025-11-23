<?php

namespace App\Enums;

enum ModuleEnum: string
{
    //----------------------
    // System Admin Modules
    //----------------------
    case USER = 'user';
    case ADMIN = 'admin';
    case SETTING= 'setting';
    case ASSOCIATION= 'association';
    case REAL_STATE = 'real_state';
    case ASSOCIATION_MODEL = 'association_model';
    case UNIT = 'unit';
    case ROLE = 'role';
    case ACTIVITY_LOG = 'activity_log';
    case LEGAL_OWNERSHIP = 'legal_ownership';
    case CONTRACT = "contract";
    case VOTE = "vote";
    case MEETING = "meeting";
    case COURTCASE = "courtCase";

    
    public function lang(): string
    {
        return trns($this->value);
    }

    public function permissions(): array
    {
        return [
            'create_' . $this->value,
            'read_' . $this->value,
            'update_' . $this->value,
            'delete_' . $this->value
        ];
    }
}
