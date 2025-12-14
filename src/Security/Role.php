<?php

namespace App\Security;

enum Role: string
{
    case ADMIN = 'ROLE_ADMIN';
    case CONTENT_MANAGER = 'ROLE_CONTENT_MANAGER';
    case USER = 'ROLE_USER';
}
