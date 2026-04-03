<?php

namespace App\Interfaces\Http\Resources\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthenticatedUserResource extends JsonResource{


    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'status' => $this->status?->value ?? 'active',
            'roles' => $this->getRoleNames()->values()->all(),
            'must_change_password' => (bool) $this->must_change_password,
            'created_by_admin' => (bool) $this->created_by_admin,


        ];
    }

}