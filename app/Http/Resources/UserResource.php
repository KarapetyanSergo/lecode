<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'description' => $this->description,
            'instagram_link' => $this->instagram_link,
            'facebook_link' => $this->facebook_link,
            'telegram_link' => $this->telegram_link,
            'linkedin_link' => $this->linkedin_link,
            'opensea_link' => $this->opensea_link,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
