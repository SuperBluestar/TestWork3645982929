<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $role = "guest";
        if ($this->isAdmin()) {
          $role = "admin";
        } else if ($this->isEditor()) {
          $role = "editor";
        }
        return [
          'id' => $this->id,
          'name' => $this->name,
          'email' => $this->email,
          'role' => $role,
          'token' => $this->token,
          'emailVerified' => $this->email_verified_at,
        ];
    }
}
