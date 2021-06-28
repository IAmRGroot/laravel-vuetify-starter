<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Auth\User
 */
class UserResource extends JsonResource
{
    public const RELATIONS = [
        'permissions',
    ];

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'permissions' => $this->whenLoaded('permissions', $this->permissions->pluck('name')),
        ];
    }
}
