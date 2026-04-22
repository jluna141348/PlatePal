<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatererSeeder extends Seeder
{
    public function run(): void
    {
        $userId = DB::table('users')->insertGetId([
            'name' => 'Lola Maria',
            'email' => 'lolamaria@kitchen.com',
            'password' => bcrypt('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $catererId = DB::table('caterers')->insertGetId([
            'user_id' => $userId,
            'business_name' => "Lola Maria's Kitchen",
            'slug' => 'lola-marias-kitchen',
            'description' => "Lola Maria's Kitchen has been serving authentic Filipino cuisine in Tagum City for over 15 years. We specialize in traditional recipes passed down through generations, with our famous Native Chicken as the star of every celebration.",
            'cover_photo' => 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=900&h=280&fit=crop',
            'phone' => '+63 912 345 6789',
            'email' => 'lolamaria@kitchen.com',
            'barangay' => 'Magugpo Poblacion',
            'cuisine_type' => 'Filipino',
            'price_min' => 300,
            'price_max' => 500,
            'min_guests' => 20,
            'max_guests' => 500,
            'is_featured' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('packages')->insert([
            [
                'caterer_id' => $catererId,
                'name' => 'Classic Filipino Package',
                'description' => 'Traditional Filipino menu for intimate celebrations',
                'price' => 350,
                'price_note' => 'Min 30 guests',
                'items' => json_encode(['Lechon Manok or Chicken Inasal', '3 Main Dish Choices', 'Crispy Pata', 'Fresh Lumpia', 'Buko Salad', 'Steamed Rice']),
                'serving' => '20–100 guests',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'caterer_id' => $catererId,
                'name' => 'Premium Fiesta Package',
                'description' => 'Our flagship package for big celebrations',
                'price' => 500,
                'price_note' => 'Min 50 guests',
                'items' => json_encode(['Whole Roasted Native Chicken', 'Grilled Seafood', 'Beef Caldereta', 'Kare-Kare', 'Pancit Palabok', 'Fresh Fruit Platter']),
                'serving' => '50–300 guests',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('reviews')->insert([
            [
                'caterer_id' => $catererId,
                'user_id' => $userId,
                'rating' => 5,
                'comment' => 'Amazing food! The best catering service in Tagum City.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
