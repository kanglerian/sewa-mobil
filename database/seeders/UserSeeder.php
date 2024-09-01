<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Administrator',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin123'),
                'phone' => '6281286501015',
                'sim' => NULL,
                'address' => NULL,
                'role' => 'A',
                'created_at' => Carbon::now()->setTimezone('Asia/Jakarta'),
                'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')
            ],[
                'name' => 'Client 1',
                'email' => 'clientone@gmail.com',
                'password' => Hash::make('client123'),
                'phone' => '6281286501011',
                'sim' => '111111111',
                'address' => 'Kota Tasikmalaya',
                'role' => 'U',
                'created_at' => Carbon::now()->setTimezone('Asia/Jakarta'),
                'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')
            ],[
                'name' => 'Client 2',
                'email' => 'clienttwo@gmail.com',
                'password' => Hash::make('client123'),
                'phone' => '6281286501010',
                'sim' => '222222222',
                'address' => 'Kabupaten Tasikmalaya',
                'role' => 'U',
                'created_at' => Carbon::now()->setTimezone('Asia/Jakarta'),
                'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')
            ]
        ]);
    }
}
