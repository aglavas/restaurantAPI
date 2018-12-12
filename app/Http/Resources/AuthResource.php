<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
                'id' => $this->id,
                'name' => $this->name,
                'email' => $this->email,
                'entity_type' => $this->entity_type,
                'token' => $this->createToken(env('APP_NAME'))->accessToken
        ];
    }
}
