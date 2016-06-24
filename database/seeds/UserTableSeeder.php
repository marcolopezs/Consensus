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

        factory(User::class)->create([
            'username' => 'abogado',
            'password' => 'abogado',
            'active' => 1,
            'admin' => 0,
            'abogado_id' => 12,
        ]);

        factory(UserProfile::class)->create([
            'nombre' => 'Abogado',
            'apellidos' => 'Consensus',
            'email' => 'abogado@consensus.com',
            'user_id' => '2'
        ]);

        factory(User::class)->create([
            'username' => 'cliente',
            'password' => 'cliente',
            'active' => 1,
            'admin' => 0,
            'cliente_id' => 5,
        ]);

        factory(UserProfile::class)->create([
            'nombre' => 'Cliente',
            'apellidos' => 'Consensus',
            'email' => 'cliente@consensus.com',
            'user_id' => '3'
        ]);

    }
}
