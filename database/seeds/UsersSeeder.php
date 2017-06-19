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
            'email' => 'info@veraluxpromet.hr',
            'password' => Hash::make('VP1022', ['rounds' => 15]),
            'company' => 'Veralux-Promet d.o.o.',
            'company_id' => '44635399735 ',
            'postal' => '49223',
            'city' => 'Sveti Križ Začretje',
            'address' => 'Vrankovec 4/H',
            'phone' => '+385 49 236 059 ',
            'verified' => 1,
            'admin' => 1
        ]);

        Model::reguard();
    }
}
