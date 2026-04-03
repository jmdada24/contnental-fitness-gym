<?php

namespace App\Core\Membership\Enums;

enum MembershipStatus: string
{
    case Active = 'active';
    case Expired = 'expired';
    case Inactive = 'inactive';
    case PendingActivation = 'pending_activation';
    case NoMembership = 'no_membership';
    case Archived = 'archived';
}


