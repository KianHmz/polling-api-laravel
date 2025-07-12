<?php

namespace Database\Seeders;

use App\Models\Poll;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PollSeeder extends Seeder
{
    public function run(): void
    {
        Poll::factory(5)->create();
    }
}
