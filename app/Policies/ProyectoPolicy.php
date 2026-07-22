<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Proyecto;

class ProyectoPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Proyecto $proyecto): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function update(User $user, Proyecto $proyecto): bool
    {
        return false;
    }

    public function delete(User $user, Proyecto $proyecto): bool
    {
        return false;
    }

    public function alimentar(User $user, Proyecto $proyecto): bool
    {
        return $proyecto->esLider($user);
    }

    public function gestionarLideres(User $user, Proyecto $proyecto): bool
    {
        return $user->role === 'admin';
    }
}
