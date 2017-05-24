<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        User::create([
            'name' => 'Veralux',
            'email' => 'info@veralux-promet.hr',
            'password' => Hash::make('123456', ['rounds' => 15]),
            'verified' => 1,
            'admin' => 1
        ]);

        Model::reguard();
    }
}
