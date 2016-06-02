<?php

use Consensus\Entities\User;
use Consensus\Entities\UserProfile;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->create([
            'username' => 'admin',
            'password' => 'admin',
            'active' => 1,
            'admin' => 1
        ]);

        factory(UserProfile::class)->create([
            'nombre' => 'Admin',
            'apellidos' => 'Consensus',
            'email' => 'admin@consensus.com',
            'user_id' => '1'
        ]);

    }
}
