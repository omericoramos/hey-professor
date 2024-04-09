<?php

declare(strict_types=1);

use App\Models\User;

function user(): ?User
{
    if (Auth()->check()) {

        return Auth()->user();
    }

    return null;
}
