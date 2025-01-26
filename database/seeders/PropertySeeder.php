<?php

namespace Database\Seeders;

use App\Models\Property;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    public function run()
    {
        Property::create([
            'title'       => 'Cozy Apartment in the City',
            'address'     => '123 Main St, Cityville',
            'description' => 'A cozy and modern apartment in the heart of the city.',
            'lat'         => 40.7128,
            'lng'         => -74.0060,
            'images'      => json_encode(['image1.jpg', 'image2.jpg']),
            'type'        => 'apartment',
            'status'      => 'available',
            'price'       => 1200.50,
            'area'        => 800.00,
            'beds'        => 2,
            'baths'       => 1,
            'user_id'     => "5c2b14f0-e4fb-47e8-8bcc-2bff3fa6291a",
        ]);
    }
}
