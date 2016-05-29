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
        factory(UserProfile::class)->create([
            'nombre' => 'Admin',
            'apellidos' => 'Consensus',
            'email' => 'admin@consensus.com',
            'user_id' => factory(User::class)->create([
                'username' => 'admin',
                'password' => 'admin',
                'active' => 1
            ])->id
        ]);

        factory(UserProfile::class, 9)->create();
    }
}
