<?php

namespace Database\Seeders;

use App\Models\BilliardTable;
use App\Models\GameType;
use App\Models\Hall;
use Illuminate\Database\Seeder;

class BilliardTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mainHall = Hall::where('name', 'Основной зал')->firstOrFail();
        $vipHall = Hall::where('name', 'VIP-зал')->firstOrFail();
        $tournamentHall = Hall::where('name', 'Турнирный зал')->firstOrFail();

        $pool = GameType::where('name', 'Пул')->firstOrFail();
        $russian = GameType::where('name', 'Русский бильярд')->firstOrFail();
        $snooker = GameType::where('name', 'Снукер')->firstOrFail();

        BilliardTable::insert([
            [
                'hall_id' => $mainHall->id,
                'game_type_id' => $russian->id,
                'name' => 'Стол 1',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'hall_id' => $mainHall->id,
                'game_type_id' => $russian->id,
                'name' => 'Стол 2',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'hall_id' => $mainHall->id,
                'game_type_id' => $pool->id,
                'name' => 'Стол 3',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'hall_id' => $vipHall->id,
                'game_type_id' => $russian->id,
                'name' => 'VIP-1',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'hall_id' => $vipHall->id,
                'game_type_id' => $pool->id,
                'name' => 'VIP-2',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'hall_id' => $tournamentHall->id,
                'game_type_id' => $snooker->id,
                'name' => 'Турнирный 1',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'hall_id' => $tournamentHall->id,
                'game_type_id' => $russian->id,
                'name' => 'Турнирный 2',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
