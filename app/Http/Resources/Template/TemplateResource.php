<?php

namespace App\Http\Resources\Template;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TemplateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [];
        $data['id'] = $this->id;
        $data['template'] = $this->template;
        
        return $data;
    }
}
