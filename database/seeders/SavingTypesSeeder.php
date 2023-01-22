<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SavingTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class=SavingTypesSeeder
     * @return void
     */
    public function run()
    {
        $types = ['Pokok', 'Wajib', 'Sukarela'];

        foreach ($types as $type) {
            DB::table('saving_types')->insert([
                'name'      => $type,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        } 
        $this->command->info("Type tabungan berhasil diinsert");
    }
}
