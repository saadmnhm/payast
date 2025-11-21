<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PieceCategory;

class PieceCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Mécanique parent category
        $mecanique = PieceCategory::create([
            'name' => 'Mécanique',
            'slug' => 'mecanique',
            'description' => 'Pièces mécaniques pour véhicules',
            'order' => 0,
            'is_active' => true
        ]);

        // Create sub-categories under Mécanique
        PieceCategory::create([
            'name' => 'Freinage',
            'slug' => 'freinage',
            'description' => 'Système de freinage complet',
            'parent_id' => $mecanique->id,
            'order' => 0,
            'is_active' => true
        ]);

        $freinage = PieceCategory::where('slug', 'freinage')->first();

        // Create Disque under Freinage
        PieceCategory::create([
            'name' => 'Disque',
            'slug' => 'disque',
            'description' => 'Disques de frein',
            'parent_id' => $freinage->id,
            'order' => 0,
            'is_active' => true
        ]);

        PieceCategory::create([
            'name' => 'Plaquettes',
            'slug' => 'plaquettes',
            'description' => 'Plaquettes de frein',
            'parent_id' => $freinage->id,
            'order' => 1,
            'is_active' => true
        ]);

        // Create Batterie under Mécanique
        PieceCategory::create([
            'name' => 'Batterie',
            'slug' => 'batterie',
            'description' => 'Batteries pour véhicules',
            'parent_id' => $mecanique->id,
            'order' => 1,
            'is_active' => true
        ]);

        // Create Électrique parent category
        $electrique = PieceCategory::create([
            'name' => 'Électrique',
            'slug' => 'electrique',
            'description' => 'Pièces électriques pour véhicules',
            'order' => 1,
            'is_active' => true
        ]);

        PieceCategory::create([
            'name' => 'Éclairage',
            'slug' => 'eclairage',
            'description' => 'Système d\'éclairage',
            'parent_id' => $electrique->id,
            'order' => 0,
            'is_active' => true
        ]);

        // Create Carrosserie parent category
        PieceCategory::create([
            'name' => 'Carrosserie',
            'slug' => 'carrosserie',
            'description' => 'Pièces de carrosserie',
            'order' => 2,
            'is_active' => true
        ]);
    }
}

