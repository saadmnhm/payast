<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\NavigationMenu;

class NavigationMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create parent menu - Mécanique
        $mecanique = NavigationMenu::create([
            'title' => 'Mécanique',
            'url' => '#',
            'icon' => 'wrench',
            'order' => 1,
            'is_active' => true,
            'is_dropdown' => true,
            'target' => '_self',
        ]);

        // Create child menus for Mécanique
        NavigationMenu::create([
            'title' => 'Réparation Moteur',
            'url' => '/mecanique/reparation-moteur',
            'icon' => 'gear',
            'parent_id' => $mecanique->id,
            'order' => 1,
            'is_active' => true,
            'is_dropdown' => false,
            'target' => '_self',
        ]);

        NavigationMenu::create([
            'title' => 'Entretien Véhicule',
            'url' => '/mecanique/entretien',
            'icon' => 'setting',
            'parent_id' => $mecanique->id,
            'order' => 2,
            'is_active' => true,
            'is_dropdown' => false,
            'target' => '_self',
        ]);

        NavigationMenu::create([
            'title' => 'Diagnostic',
            'url' => '/mecanique/diagnostic',
            'icon' => 'search-list',
            'parent_id' => $mecanique->id,
            'order' => 3,
            'is_active' => true,
            'is_dropdown' => false,
            'target' => '_self',
        ]);

        // Create another parent menu - Services
        $services = NavigationMenu::create([
            'title' => 'Services',
            'url' => '#',
            'icon' => 'briefcase',
            'order' => 2,
            'is_active' => true,
            'is_dropdown' => true,
            'target' => '_self',
        ]);

        // Create child menus for Services
        NavigationMenu::create([
            'title' => 'Devis Gratuit',
            'url' => '/services/devis',
            'icon' => 'document',
            'parent_id' => $services->id,
            'order' => 1,
            'is_active' => true,
            'is_dropdown' => false,
            'target' => '_self',
        ]);

        NavigationMenu::create([
            'title' => 'Prise de Rendez-vous',
            'url' => '/services/rendez-vous',
            'icon' => 'calendar',
            'parent_id' => $services->id,
            'order' => 2,
            'is_active' => true,
            'is_dropdown' => false,
            'target' => '_self',
        ]);

        // Create a simple parent menu without children
        NavigationMenu::create([
            'title' => 'À Propos',
            'url' => '/about',
            'icon' => 'information',
            'order' => 3,
            'is_active' => true,
            'is_dropdown' => false,
            'target' => '_self',
        ]);

        NavigationMenu::create([
            'title' => 'Contact',
            'url' => '/contact',
            'icon' => 'phone',
            'order' => 4,
            'is_active' => true,
            'is_dropdown' => false,
            'target' => '_self',
        ]);
    }
}
