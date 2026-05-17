<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Masyarakat;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MasyarakatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $masyarakats = [
            ['nik' => '3201010101010001', 'nama' => 'Ahmad Wijaya', 'email' => 'ahmad@test.com', 'jabatan' => 'Karyawan Swasta', 'telp' => '081234567890'],
            ['nik' => '3201010101010002', 'nama' => 'Siti Nurhaliza', 'email' => 'siti@test.com', 'jabatan' => 'Guru', 'telp' => '081234567891'],
            ['nik' => '3201010101010003', 'nama' => 'Budi Santoso', 'email' => 'budi@test.com', 'jabatan' => 'Petani', 'telp' => '081234567892'],
            ['nik' => '3201010101010004', 'nama' => 'Dewi Lestari', 'email' => 'dewi@test.com', 'jabatan' => 'Dokter', 'telp' => '081234567893'],
            ['nik' => '3201010101010005', 'nama' => 'Rizki Ramadhan', 'email' => 'rizki@test.com', 'jabatan' => 'Pengusaha', 'telp' => '081234567894'],
            ['nik' => '3201010101010006', 'nama' => 'Putri Ayu', 'email' => 'putri@test.com', 'jabatan' => 'Perawat', 'telp' => '081234567895'],
            ['nik' => '3201010101010007', 'nama' => 'Hendra Kusuma', 'email' => 'hendra@test.com', 'jabatan' => 'PNS', 'telp' => '081234567896'],
            ['nik' => '3201010101010008', 'nama' => 'Maya Sari', 'email' => 'maya@test.com', 'jabatan' => 'Ibu Rumah Tangga', 'telp' => '081234567897'],
            ['nik' => '3201010101010009', 'nama' => 'Fajar Nugroho', 'email' => 'fajar@test.com', 'jabatan' => 'Wiraswasta', 'telp' => '081234567898'],
            ['nik' => '3201010101010010', 'nama' => 'Rina Amelia', 'email' => 'rina@test.com', 'jabatan' => 'Akuntan', 'telp' => '081234567899'],
        ];

        foreach ($masyarakats as $index => $data) {
            $user = User::create([
                'name' => $data['nama'],
                'email' => $data['email'],
                'password' => Hash::make('mpp'),
                'role' => 'user',
            ]);

            Masyarakat::create([
                'nik' => $data['nik'],
                'nama' => $data['nama'],
                'email' => $data['email'],
                'jabatan' => $data['jabatan'],
                'telp' => $data['telp'],
                'user_id' => $user->id,
            ]);
        }
    }
}