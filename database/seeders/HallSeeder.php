<?php

namespace Database\Seeders;

use App\Models\Hall;
use Illuminate\Database\Seeder;

class HallSeeder extends Seeder
{
    public function run(): void
    {
        Hall::create([
            'name' => 'Основной зал',
            'description' => 'Основной зал клуба с бильярдными столами.',
        ]);

        Hall::create([
            'name' => 'VIP-зал',
            'description' => 'Отдельный зал для VIP-бронирований.',
        ]);

        Hall::create([
            'name' => 'Турнирный зал',
            'description' => 'Зал для проведения турниров и соревнований.',
        ]);
    }
}
