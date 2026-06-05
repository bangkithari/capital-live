<?php

namespace Tests\Feature;

use App\Models\Menu;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MenuTreeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_admin_menu_tree_is_not_empty_and_contains_route_backed_items(): void
    {
        $user = User::query()->whereKey('000001')->firstOrFail();

        $menuTree = Menu::getMenuTree($user);

        $this->assertNotEmpty($menuTree);
        $this->assertTrue($menuTree->contains(fn (Menu $menu) => $menu->code === 'dashboard'));
        $this->assertTrue($menuTree->contains(fn (Menu $menu) => $menu->code === 'settings'));

        $dashboard = $menuTree->firstWhere('code', 'dashboard');

        $this->assertSame('dashboard', $dashboard?->route_name);
        $this->assertSame('/dashboard', $dashboard?->resolved_url);

        $settings = $menuTree->firstWhere('code', 'settings');
        $this->assertNotNull($settings);
        $this->assertTrue($settings->activeChildren->contains(fn (Menu $menu) => $menu->code === 'user_mgmt'));
        $this->assertTrue($settings->activeChildren->contains(fn (Menu $menu) => $menu->code === 'role_access'));
    }

    public function test_orphan_menu_entries_are_deactivated_during_seed(): void
    {
        $this->assertSame(0, (int) Menu::query()->where('code', 'sales_summary')->value('is_active'));
        $this->assertSame(0, (int) Menu::query()->where('code', 'hold_premi_report')->value('is_active'));
        $this->assertSame(0, (int) Menu::query()->where('code', 'submission')->value('is_active'));
        $this->assertSame(0, (int) Menu::query()->where('code', 'approval')->value('is_active'));
        $this->assertSame(0, (int) Menu::query()->where('code', 'cashback')->value('is_active'));
    }
}
