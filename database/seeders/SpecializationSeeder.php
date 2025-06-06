<?php

namespace Database\Seeders;

use App\Modules\Specialization\Models\Specialization;
use Illuminate\Database\Seeder;

class SpecializationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Specialization::create([
            'name' => 'Маникюр'
        ]);
        Specialization::create([
            'name' => 'Педикюр'
        ]);
    }
}
