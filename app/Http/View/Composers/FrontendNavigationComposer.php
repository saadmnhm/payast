<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\NavigationMenu;
use App\Models\CatalogCategory;

class FrontendNavigationComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view): void
    {
        $view->with('navigationMenus', NavigationMenu::getActiveMenus());
        $view->with('catalogCategories', CatalogCategory::where('is_active', true)
            ->whereNull('parent_id')
            ->with(['children' => function($query) {
                $query->where('is_active', true)->orderBy('order');
            }])
            ->orderBy('order')
            ->get());
    }
}
