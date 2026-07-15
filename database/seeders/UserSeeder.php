<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Admin KKN',
                'email' => 'admin@kkn.local',
                'password' => Hash::make('AdminKKN#2026'),
                'role' => 'admin',
                'division' => null,
                'position' => 'Admin',
            ]
        );

        $participants = [
            ['Rizky Syaban Faudi', 'applepieandelmo', 'Pengurus Inti', 'Ketua'],
            ['Azzahra Salsabila', 'azzahra.salsabila', 'Pengurus Inti', 'Wakil Ketua'],
            ['Sundawi Sabina', 'sundawi.sabina', 'Pengurus Inti', 'Sekretaris 1'],
            ['Nazma Malihah', 'nazma.malihah', 'Pengurus Inti', 'Sekretaris 2'],
            ['Widya Amelia R', 'widya.amelia', 'Pengurus Inti', 'Bendahara'],

            ['Rini Nurjanah', 'rini.nurjanah', 'Divisi Acara', 'Ketua Divisi'],
            ['Agus Alan Maolana', 'agus.alan', 'Divisi Acara', 'Anggota'],
            ['Alsina Yulistia Salsabila', 'alsina.yulistia', 'Divisi Acara', 'Anggota'],
            ['Charlee', 'charlee', 'Divisi Acara', 'Anggota'],
            ['Azzahra Nurhaliza', 'azzahra.nurhaliza', 'Divisi Acara', 'Anggota'],

            ['Fajar Muhammad', 'fajar.muhammad', 'Divisi Humas', 'Ketua Divisi'],
            ['Syabrina Reva', 'syabrina.reva', 'Divisi Humas', 'Anggota'],
            ['Ayu Lestari', 'ayu.lestari', 'Divisi Humas', 'Anggota'],

            ['Ziad Haqqinnazili Ridh', 'ziad.haqqinnazili', 'Divisi PDD', 'Ketua Divisi'],
            ['Sri Justikan Wulandari', 'sri.justikan', 'Divisi PDD', 'Anggota'],
            ['Nabil Musyafa', 'nabil.musyafa', 'Divisi PDD', 'Anggota'],

            ['Arif Indi Fauzi', 'arif.indi', 'Divisi Logistik', 'Ketua Divisi'],
            ['Muhammad Rizky Firdaus', 'muhammad.rizky', 'Divisi Logistik', 'Anggota'],
        ];

        foreach ($participants as [$name, $username, $division, $position]) {
            User::updateOrCreate(
                ['username' => $username],
                [
                    'name' => $name,
                    'email' => $username.'@kkn.local',
                    'password' => Hash::make('kkn2026'),
                    'role' => 'peserta',
                    'division' => $division,
                    'position' => $position,
                ]
            );
        }
    }
}
