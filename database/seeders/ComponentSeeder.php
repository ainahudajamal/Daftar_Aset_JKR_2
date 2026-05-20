<?php

namespace Database\Seeders;

use App\Models\Component;
use App\Models\MainComponent;
use App\Models\SubComponent;
use Illuminate\Database\Seeder;

class ComponentSeeder extends Seeder
{
    public function run()
    {
        // Komponen 1: Parlimen Malaysia
        $component1 = Component::create([
            'nama_premis' => 'PARLIMEN MALAYSIA',
            'nombor_dpa' => '1610MYS.140144.BD0001',
            'ada_blok' => true,
            'kod_blok' => 'C - BLOK UTAMA',
            'kod_aras' => '02',
            'kod_ruang' => '044',
            'nama_ruang' => 'KAFETERIA - COOKING AREA',
            'catatan_blok' => 'Kawasan memasak di tingkat 2',
            'ada_binaan_luar' => false,
            'status' => 'aktif'
        ]);

        // Komponen Utama untuk Parlimen
        $mainComp1 = MainComponent::create([
            'component_id' => $component1->id,
            'nama_komponen_utama' => 'PERALATAN DAPUR',
            // 'kod_komponen_utama' => 'KOMP001-UT001',
            // 'keterangan' => 'Peralatan memasak dan penyediaan makanan',
            // 'urutan' => 1,
            'status' => 'aktif'
        ]);

        // Sub Komponen untuk Peralatan Dapur
        SubComponent::create([
            'main_component_id' => $mainComp1->id,
            'nama_sub_komponen' => 'OVEN INDUSTRIAL',
            // 'kod_sub_komponen' => 'KOMP001-UT001-SUB001',
            'deskripsi' => 'Oven besar untuk memasak makanan',
            // 'peratus_wajaran' => 35.00,
            // 'urutan' => 1,
            'status' => 'aktif'
        ]);

        SubComponent::create([
            'main_component_id' => $mainComp1->id,
            'nama_sub_komponen' => 'REFRIGERATOR KOMERSIAL',
            // 'kod_sub_komponen' => 'KOMP001-UT001-SUB002',
            'deskripsi' => 'Peti sejuk besar untuk simpanan makanan',
            // 'peratus_wajaran' => 30.00,
            // 'urutan' => 2,
            'status' => 'aktif'
        ]);

        SubComponent::create([
            'main_component_id' => $mainComp1->id,
            'nama_sub_komponen' => 'STOVE GAS INDUSTRIAL',
            // 'kod_sub_komponen' => 'KOMP001-UT001-SUB003',
            'deskripsi' => 'Dapur gas 6 mulut untuk memasak',
            // 'peratus_wajaran' => 25.00,
            // 'urutan' => 3,
            'status' => 'aktif'
        ]);

        // Komponen Utama 2
        $mainComp2 = MainComponent::create([
            'component_id' => $component1->id,
            'nama_komponen_utama' => 'SISTEM PENGUDARAAN',
            // 'kod_komponen_utama' => 'KOMP001-UT002',
            // 'keterangan' => 'Sistem pengudaraan dan exhaust',
            // 'urutan' => 2,
            'status' => 'aktif'
        ]);

        SubComponent::create([
            'main_component_id' => $mainComp2->id,
            'nama_sub_komponen' => 'EXHAUST FAN',
            // 'kod_sub_komponen' => 'KOMP001-UT002-SUB001',
            'deskripsi' => 'Kipas exhaust untuk keluar asap',
            // 'peratus_wajaran' => 60.00,
            // 'urutan' => 1,
            'status' => 'aktif'
        ]);

        // Komponen 2: Bangunan Luar
        $component2 = Component::create([
            'nama_premis' => 'KOMPLEKS SUKAN BUKIT JALIL',
            'nombor_dpa' => '1610MYS.140145.BL0001',
            'ada_blok' => false,
            'ada_binaan_luar' => true,
            'nama_binaan_luar' => 'PADANG RUGBY',
            'kod_binaan_luar' => 'BL-RUGBY-01',
            'koordinat_x' => 3.063930,
            'koordinat_y' => 101.688530,
            'catatan_binaan' => 'Padang rugby standard antarabangsa',
            'status' => 'aktif'
        ]);

        $mainComp3 = MainComponent::create([
            'component_id' => $component2->id,
            'nama_komponen_utama' => 'SISTEM LAMPU PADANG',
            // 'kod_komponen_utama' => 'KOMP002-UT001',
            // 'keterangan' => 'Sistem pencahayaan padang rugby',
            // 'urutan' => 1,
            'status' => 'aktif'
        ]);

        SubComponent::create([
            'main_component_id' => $mainComp3->id,
            'nama_sub_komponen' => 'FLOODLIGHT LED 1000W',
            // 'kod_sub_komponen' => 'KOMP002-UT001-SUB001',
            'deskripsi' => 'Lampu LED berkuasa tinggi',
            // 'peratus_wajaran' => 80.00,
            // 'urutan' => 1,
            'status' => 'aktif'
        ]);

        SubComponent::create([
            'main_component_id' => $mainComp3->id,
            'nama_sub_komponen' => 'PANEL KAWALAN LAMPU',
            // 'kod_sub_komponen' => 'KOMP002-UT001-SUB002',
            'deskripsi' => 'Sistem kawalan automatik lampu',
            // 'peratus_wajaran' => 20.00,
            // 'urutan' => 2,
            'status' => 'aktif'
        ]);

        // Komponen 3: Kombinasi Blok dan Binaan Luar
        $component3 = Component::create([
            'nama_premis' => 'HOSPITAL KUALA LUMPUR',
            'nombor_dpa' => '1610MYS.140146.BD0001',
            'ada_blok' => true,
            'kod_blok' => 'A - BLOK PENTADBIRAN',
            'kod_aras' => '05',
            'kod_ruang' => '501',
            'nama_ruang' => 'BILIK SERVER UTAMA',
            'ada_binaan_luar' => true,
            'nama_binaan_luar' => 'HELIPAD',
            'kod_binaan_luar' => 'HKL-HELI-01',
            'koordinat_x' => 3.168570,
            'koordinat_y' => 101.698530,
            'kod_aras_binaan' => 'ROOF',
            'nama_ruang_binaan' => 'LANDING PAD',
            'catatan_binaan' => 'Helipad untuk helicopter kecemasan',
            'status' => 'aktif'
        ]);

        $mainComp4 = MainComponent::create([
            'component_id' => $component3->id,
            'nama_komponen_utama' => 'SISTEM IT DAN KOMUNIKASI',
            // 'kod_komponen_utama' => 'KOMP003-UT001',
            // 'keterangan' => 'Infrastruktur IT dan rangkaian',
            // 'urutan' => 1,
            'status' => 'aktif'
        ]);

        SubComponent::create([
            'main_component_id' => $mainComp4->id,
            'nama_sub_komponen' => 'SERVER RACK UTAMA',
            // 'kod_sub_komponen' => 'KOMP003-UT001-SUB001',
            'deskripsi' => '42U Server Rack dengan cooling',
            // 'peratus_wajaran' => 45.00,
            // 'urutan' => 1,
            'status' => 'aktif'
        ]);

        SubComponent::create([
            'main_component_id' => $mainComp4->id,
            'nama_sub_komponen' => 'UPS SYSTEM',
            // 'kod_sub_komponen' => 'KOMP003-UT001-SUB002',
            'deskripsi' => 'Uninterruptible Power Supply 100kVA',
            // 'peratus_wajaran' => 35.00,
            // 'urutan' => 2,
            'status' => 'aktif'
        ]);

        SubComponent::create([
            'main_component_id' => $mainComp4->id,
            'nama_sub_komponen' => 'NETWORK SWITCHES',
            // 'kod_sub_komponen' => 'KOMP003-UT001-SUB003',
            'deskripsi' => 'Core switches untuk rangkaian hospital',
            // 'peratus_wajaran' => 20.00,
            // 'urutan' => 3,
            'status' => 'aktif'
        ]);

        $mainComp5 = MainComponent::create([
            'component_id' => $component3->id,
            'nama_komponen_utama' => 'SISTEM HELIPAD',
            // 'kod_komponen_utama' => 'KOMP003-UT002',
            // 'keterangan' => 'Peralatan dan sistem helipad',
            // 'urutan' => 2,
            'status' => 'aktif'
        ]);

        SubComponent::create([
            'main_component_id' => $mainComp5->id,
            'nama_sub_komponen' => 'LANDING LIGHTS',
            // 'kod_sub_komponen' => 'KOMP003-UT002-SUB001',
            'deskripsi' => 'Sistem lampu pendaratan helikopter',
            // 'peratus_wajaran' => 40.00,
            // 'urutan' => 1,
            'status' => 'aktif'
        ]);

        SubComponent::create([
            'main_component_id' => $mainComp5->id,
            'nama_sub_komponen' => 'WINDSOCK',
            // 'kod_sub_komponen' => 'KOMP003-UT002-SUB002',
            'deskripsi' => 'Penunjuk arah angin',
            // 'peratus_wajaran' => 15.00,
            // 'urutan' => 2,
            'status' => 'aktif'
        ]);

        SubComponent::create([
            'main_component_id' => $mainComp5->id,
            'nama_sub_komponen' => 'FIRE SUPPRESSION SYSTEM',
            // 'kod_sub_komponen' => 'KOMP003-UT002-SUB003',
            'deskripsi' => 'Sistem pencegah kebakaran helipad',
            // 'peratus_wajaran' => 45.00,
            // 'urutan' => 3,
            'status' => 'aktif'
        ]);
    }
}