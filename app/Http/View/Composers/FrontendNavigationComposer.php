<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\NavigationMenu;

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
    }
}
