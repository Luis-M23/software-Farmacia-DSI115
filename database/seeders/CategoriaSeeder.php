<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categoria;


class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorias = [
            'Analgésico',
            'Cuidado Personal',
            'Belleza',
            'Suplementos',
            'Higiene',
            'Medicamentos',
            'Antibióticos',
            'Antiinflamatorios',
            'Antipiréticos',
            'Antihistamínicos',
            'Antidepresivos'
        ];

        foreach ($categorias as $nombre) {
            Categoria::firstOrCreate(['nombre' => $nombre]);
        }
    }
}
