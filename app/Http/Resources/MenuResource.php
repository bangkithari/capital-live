<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Menu API Resource
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string|null $url
 * @property string|null $route_name
 * @property string|null $icon
 * @property int $sort_order
 * @property bool $is_active
 */
class MenuResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'slug' => $this->slug,
            'url' => $this->url,
            'route_name' => $this->route_name,
            'resolved_url' => $this->resolved_url,
            'controller' => $this->controller,
            'action' => $this->action,
            'param' => $this->param,
            'icon' => $this->icon,
            'parent_id' => $this->parent_id,
            'sort_order' => $this->sort_order,
            'order' => $this->order,
            'is_active' => $this->is_active,
            'menu_type' => $this->menu_type,
            'stored_procedure' => $this->stored_procedure,
            'params_json' => $this->params_json,
            'children' => MenuResource::collection($this->whenLoaded('children')),
        ];
    }
}
