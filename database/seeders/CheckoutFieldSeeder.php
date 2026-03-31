<?php

namespace Database\Seeders;

use App\Models\CheckoutField;
use Illuminate\Database\Seeder;

class CheckoutFieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fields = [
            [
                'label' => 'Full Name',
                'name' => 'full_name',
                'type' => 'text',
                'placeholder' => 'Enter your full name',
                'is_required' => true,
                'sort_order' => 1,
            ],
            [
                'label' => 'Email Address',
                'name' => 'email',
                'type' => 'email',
                'placeholder' => 'e.g. john@example.com',
                'is_required' => true,
                'sort_order' => 2,
            ],
            [
                'label' => 'Phone Number',
                'name' => 'phone',
                'type' => 'tel',
                'placeholder' => 'e.g. +1234567890',
                'is_required' => true,
                'sort_order' => 3,
            ],
            [
                'label' => 'Shipping Address',
                'name' => 'address',
                'type' => 'textarea',
                'placeholder' => 'Enter your full shipping address',
                'is_required' => true,
                'sort_order' => 4,
            ],
            [
                'label' => 'City',
                'name' => 'city',
                'type' => 'text',
                'placeholder' => 'Enter your city',
                'is_required' => true,
                'sort_order' => 5,
            ],
            [
                'label' => 'District',
                'name' => 'district',
                'type' => 'select',
                'placeholder' => 'Select your district',
                'options' => ['Dhaka', 'Chittagong', 'Rajshahi', 'Khulna', 'Sylhet', 'Barisal', 'Rangpur'],
                'is_required' => true,
                'sort_order' => 6,
            ],
        ];

        foreach ($fields as $field) {
            CheckoutField::create($field);
        }
    }
}
