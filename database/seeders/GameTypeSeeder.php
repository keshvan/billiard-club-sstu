<?php

namespace Database\Seeders;

use App\Models\GameType;
use Illuminate\Database\Seeder;

class GameTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GameType::insert([
            [
                'name' => 'Русский бильярд',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Пул',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Снукер',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
