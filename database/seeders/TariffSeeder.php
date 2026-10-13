<?php

namespace Database\Seeders;

use App\Models\GameType;
use App\Models\Hall;
use App\Models\Tariff;
use Illuminate\Database\Seeder;

class TariffSeeder extends Seeder
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

        Tariff::insert([
            [
                'hall_id' => $mainHall->id,
                'game_type_id' => $russian->id,
                'name' => 'Будни — день',
                'day_of_week' => null,
                'start_time' => '10:00',
                'end_time' => '18:00',
                'price_per_hour' => 800,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'hall_id' => $mainHall->id,
                'game_type_id' => $russian->id,
                'name' => 'Будни — вечер',
                'day_of_week' => null,
                'start_time' => '18:00',
                'end_time' => '23:00',
                'price_per_hour' => 1200,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'hall_id' => $mainHall->id,
                'game_type_id' => $pool->id,
                'name' => 'Пул — стандарт',
                'day_of_week' => null,
                'start_time' => '10:00',
                'end_time' => '23:00',
                'price_per_hour' => 700,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'hall_id' => $vipHall->id,
                'game_type_id' => $russian->id,
                'name' => 'VIP — день',
                'day_of_week' => null,
                'start_time' => '10:00',
                'end_time' => '18:00',
                'price_per_hour' => 1500,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'hall_id' => $vipHall->id,
                'game_type_id' => $russian->id,
                'name' => 'VIP — вечер',
                'day_of_week' => null,
                'start_time' => '18:00',
                'end_time' => '02:00',
                'price_per_hour' => 2000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'hall_id' => $vipHall->id,
                'game_type_id' => $pool->id,
                'name' => 'VIP — пул',
                'day_of_week' => null,
                'start_time' => '10:00',
                'end_time' => '02:00',
                'price_per_hour' => 1700,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'hall_id' => $tournamentHall->id,
                'game_type_id' => $snooker->id,
                'name' => 'Снукер',
                'day_of_week' => null,
                'start_time' => '10:00',
                'end_time' => '23:00',
                'price_per_hour' => 1300,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'hall_id' => $tournamentHall->id,
                'game_type_id' => $russian->id,
                'name' => 'Русский бильярд',
                'day_of_week' => null,
                'start_time' => '10:00',
                'end_time' => '23:00',
                'price_per_hour' => 1100,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
