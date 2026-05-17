<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Petugas;
use App\Models\Instansi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PetugasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create some instances first if not exist
        $instansi1 = Instansi::firstOrCreate(
            ['nama' => 'Dinas Kependudukan'],
            ['alamat' => 'Jl. Merdeka No. 1', 'deskripsi' => 'Dinas Kependudukan dan Pencatatan Sipil', 'telp' => '021123456', 'status' => 'aktif']
        );

        $instansi2 = Instansi::firstOrCreate(
            ['nama' => 'Dinas Sosial'],
            ['alamat' => 'Jl. Sudirman No. 2', 'deskripsi' => 'Dinas Sosial Kabupaten', 'telp' => '021123457', 'status' => 'aktif']
        );

        $petugasList = [
            ['nip' => '198501012010011001', 'nama' => 'Dr. Hendra Wijaya', 'email' => 'hendra.kepala@test.com', 'jabatan' => 'Kepala Dinas', 'telp' => '081234500001', 'instansi_id' => $instansi1->id],
            ['nip' => '199002152011012002', 'nama' => 'Nurul Hidayati', 'email' => 'nurul.sekretaris@test.com', 'jabatan' => 'Sekretaris', 'telp' => '081234500002', 'instansi_id' => $instansi1->id],
            ['nip' => '199103202012011003', 'nama' => 'Asep Supriatna', 'email' => 'asep.kasi1@test.com', 'jabatan' => 'Kasi Pelayanan', 'telp' => '081234500003', 'instansi_id' => $instansi1->id],
            ['nip' => '198807302009012004', 'nama' => 'Lisa Permatasari', 'email' => 'lisa.staff1@test.com', 'jabatan' => 'Staff Pelayanan', 'telp' => '081234500004', 'instansi_id' => $instansi1->id],
            ['nip' => '199205182013011005', 'nama' => 'Dedi Kurniawan', 'email' => 'dedi.staff2@test.com', 'jabatan' => 'Staff Teknis', 'telp' => '081234500005', 'instansi_id' => $instansi1->id],
            ['nip' => '199011252010012006', 'nama' => 'Yuniarti', 'email' => 'yuni.kabid@test.com', 'jabatan' => 'Kabid Sosial', 'telp' => '081234500006', 'instansi_id' => $instansi2->id],
            ['nip' => '198912102008012007', 'nama' => 'Taufik Hidayat', 'email' => 'taufik.kasi@test.com', 'jabatan' => 'Kasi Rehab', 'telp' => '081234500007', 'instansi_id' => $instansi2->id],
            ['nip' => '199306202014011008', 'nama' => 'Rini Wulandari', 'email' => 'rini.staff@test.com', 'jabatan' => 'Staff Rehabilitasi', 'telp' => '081234500008', 'instansi_id' => $instansi2->id],
            ['nip' => '199108152011012009', 'nama' => 'Agus Setiawan', 'email' => 'agus.petugas@test.com', 'jabatan' => 'Petugas Lapangan', 'telp' => '081234500009', 'instansi_id' => $instansi2->id],
            ['nip' => '199405252015011010', 'nama' => 'Dian Pratama', 'email' => 'dian.staff3@test.com', 'jabatan' => 'Staf Administrasi', 'telp' => '081234500010', 'instansi_id' => $instansi1->id],
        ];

        foreach ($petugasList as $data) {
            $user = User::create([
                'name' => $data['nama'],
                'email' => $data['email'],
                'password' => Hash::make('mpp'),
                'role' => 'petugas',
            ]);

            Petugas::create([
                'nip' => $data['nip'],
                'nama' => $data['nama'],
                'email' => $data['email'],
                'jabatan' => $data['jabatan'],
                'telp' => $data['telp'],
                'instansi_id' => $data['instansi_id'],
                'user_id' => $user->id,
            ]);
        }
    }
}