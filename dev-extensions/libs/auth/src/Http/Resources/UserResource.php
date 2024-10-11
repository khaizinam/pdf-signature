<?php

namespace Dev\Auth\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'avatar' => $this->avatar_url,
            'dob' => $this->dob,
            'gender' => $this->gender,
            'description' => $this->description,
            'fullName' => $this->name,
            'username' => $this->name,
            'role' => 'admin',
            'roles' => null,
            'permissions' => null,
            'departments' => null
        ];
    }
}
