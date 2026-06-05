<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Menu API Controller
 *
 * Retrieve navigation menu items. Menus are stored in the database
 * and support hierarchical parent-child relationships.
 */
#[Group('Menus')]
class MenuApiController extends Controller
{
    /**
     * List all menus
     *
     * Returns a flat list of all menu items ordered by their display order.
     */
    public function index(): AnonymousResourceCollection
    {
        $menus = Menu::orderBy('sort_order')->get();

        return \App\Http\Resources\MenuResource::collection($menus);
    }

    /**
     * Get menu tree
     *
     * Returns the full menu hierarchy as a nested tree structure.
     * Only includes active menus and their active children.
     * Ideal for rendering sidebar navigation dynamically.
     */
    public function tree(): JsonResponse
    {
        $tree = Menu::getMenuTree();

        return response()->json([
            'data' => $tree,
        ]);
    }
}
