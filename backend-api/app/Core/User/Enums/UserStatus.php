<?php

namespace App\Core\User\Enums;

enum UserStatus: string{
    
    case Active = 'active';
    case Inactive = 'inactive';
    case Suspended = 'suspended';
    case Archived = 'archive';


}

