<?php

declare(strict_types=1);

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Hashing\Hasher;

class UsersSeeder extends Seeder
{
    public function run(Hasher $hasher): void
    {
        Model::unguard();

        User::create([
            'name' => 'Veralux',
            'email' => 'info@veraluxpromet.hr',
            'password' => $hasher->make('VP1022', ['rounds' => 15]),
            'company' => 'Veralux-Promet d.o.o.',
            'company_id' => '44635399735 ',
            'postal' => '49223',
            'city' => 'Sveti Križ Začretje',
            'address' => 'Vrankovec 4/H',
            'phone' => '+385 49 236 059 ',
            'verified' => 1,
            'admin' => 1,
        ]);

        Model::reguard();
    }
}
