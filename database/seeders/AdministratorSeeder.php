<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class=AdministratorSeeder
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'nip'       => 1,
            'name'      => 'Administrator',
            'gender'    => 'Pria',
            'is_active' => true,
            'scope'     => 'Admin',
            'email'     => 'superadmin@admin.com',
            'password'  => Hash::make('password'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        $this->command->info("User Admin berhasil diinsert");
    }
}
