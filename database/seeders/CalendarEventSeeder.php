<?php

namespace Database\Seeders;

use App\Models\CalendarEvent;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CalendarEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::with('userProfile')->get();
        
        // Get actual worker names from user profiles
        $workerNames = $users->pluck('userProfile.name')
            ->filter() // Remove null values
            ->toArray();
        
        // If no user profiles exist, use default names
        if (empty($workerNames)) {
            $workerNames = ['田中太郎', '佐藤次郎', '鈴木三郎', '高橋四郎', '渡辺五郎'];
        }

        for ($i = 0; $i < 10; ++$i) {
            $authUser = $users->random();
            
            // Generate random workers (1-3 workers)
            $selectedWorkers = collect($workerNames)->random(rand(1, min(3, count($workerNames))))->toArray();
            
            CalendarEvent::factory()->create([
                'user_id' => $authUser->id,
                'workers' => $selectedWorkers,
            ]);
        }
    }
}
