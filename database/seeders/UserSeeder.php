<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currentDate = $this->getCurrentDate();

        User::create([
            'name' => 'Carlos Canales',
            'email' => 'carloscanales303@gmail.com',
            'password' => Hash::make('1234567'),
            'created_at' => $currentDate
        ]);
    }

    protected function getCurrentDate(): String
    {
        return now()->setTimezone(config('app.timezone'))->format('Y-m-d H:m:s');
    }
}
