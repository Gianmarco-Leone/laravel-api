<?php

namespace Database\Seeders;

use App\Models\Type;

use Faker\Generator as Faker;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $labels = ['Frontend', 'Backend', 'Fullstack'];
        foreach($labels as $label) {
            $type = new Type;
            $type->label = $label;
            $type->color = $faker->hexColor();
            $type->save();
        }
    }
}