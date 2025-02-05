<?php

namespace Database\Seeders;

use App\Models\Property;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    public function run()
    {
        Property::create([
            'title'       => 'Monoambiente a Estrenar en Belgrano',
            'address'     => 'Zapiola 2300, Belgrano R, Belgrano',
            'description' => 'A cozy and modern apartment in the heart of the city.',
            'lat'         => 40.7128,
            'lng'         => -74.0060,
            'images'      => ['https://drive.google.com/file/d/1YaF7s1kE6RrQVYC0kCYiJNUt4TQqIZYS/view?usp=sharing'],
            'type'        => 'apartment',
            'status'      => 'sale',
            'price'       => 135.000,
            'area'        => 800.00,
            'beds'        => 2,
            'baths'       => 1,
            'user_id'     => "9738d517-c98e-4f51-aaf0-9e07b6c2480a",
        ]);
    }
}
