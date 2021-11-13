<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name'        => "IWellness Administrator",
            'username'    => 'admin',
            'user_type'   => 1,
            'address'     => '',
            'contact'     => '',
            'email'       => 'admin@gmail.com',
            'password'    => bcrypt('secret')
        ]);

        User::findOrFail(1)->assignRole('system administrator');

        $array_roles = array("member", "team leader", "manager");

        for ($i=1; $i < 20; $i++) { 
            $user = User::create([
                'name'        => "Jane Doe". $i,
                'username'    => "janedoe". $i,
                'user_type'   => 2,
                'address'     => '',
                'contact'     => '',
                'email'       => 'janedoe'.$i.'@gmail.com',
                'referer'     => null,
                'password'    => 'secret'
            ]);
    
            $user->assignRole($array_roles[rand(0,2)]);
        }
    }
}
