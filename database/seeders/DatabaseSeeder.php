<?php
// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Faq;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // === PETUGAS ===
        User::create([
            'name' => 'Admin Polisi',
            'email' => 'admin@polisi.id',
            'password' => Hash::make('password'),
            'phone' => '081234567890',
            'address' => 'Kantor Polisi Jakarta',
            'nik' => '3174012345678901',
            'role' => 'petugas',
        ]);

        // === MASYARAKAT ===
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@gmail.com',
            'password' => Hash::make('password'),
            'phone' => '089876543210',
            'address' => 'Jl. Sudirman No. 45, Jakarta Selatan',
            'nik' => '3174011234567890',
            'role' => 'masyarakat',
        ]);

        // === FAQ SEED DATA ===
        $faqs = [
            [
                'pertanyaan' => 'Bagaimana cara membuat laporan pengaduan?',
                'jawaban' => 'Anda dapat membuat laporan pengaduan dengan login terlebih dahulu, kemudian klik menu "Buat Pengaduan Baru". Isi formulir dengan lengkap termasuk judul, deskripsi, lokasi, tanggal kejadian, dan lampirkan foto jika diperlukan. Setelah selesai, klik "Kirim Pengaduan".',
                'kategori' => 'pengaduan',
                'keywords' => 'cara,membuat,laporan,pengaduan,buat',
            ],
            [
                'pertanyaan' => 'Berapa lama proses pengaduan saya?',
                'jawaban' => 'Proses pengaduan biasanya memakan waktu 3-7 hari kerja tergantung pada tingkat kesulitan dan prioritas kasus. Untuk kasus dengan prioritas tinggi, kami akan berusaha menangani lebih cepat. Anda dapat memantau status pengaduan Anda secara real-time di halaman "Riwayat Pengaduan".',
                'kategori' => 'pengaduan',
                'keywords' => 'lama,proses,waktu,durasi',
            ],
            [
                'pertanyaan' => 'Apakah saya bisa membuat pengaduan tanpa login?',
                'jawaban' => 'Tidak, Anda harus mendaftar dan login terlebih dahulu untuk membuat pengaduan. Ini untuk memastikan keamanan data, validitas laporan, dan memudahkan kami menghubungi Anda jika diperlukan klarifikasi lebih lanjut.',
                'kategori' => 'akun',
                'keywords' => 'login,daftar,tanpa,akun',
            ],
            [
                'pertanyaan' => 'Dokumen apa yang diperlukan untuk membuat pengaduan?',
                'jawaban' => 'Dokumen yang diperlukan: 1) NIK (Nomor Induk Kependudukan) yang sudah terdaftar di akun Anda, 2) Deskripsi detail kejadian, 3) Foto atau bukti pendukung jika ada, 4) Informasi lokasi dan waktu kejadian yang akurat.',
                'kategori' => 'pengaduan',
                'keywords' => 'dokumen,persyaratan,butuh,diperlukan',
            ],
            [
                'pertanyaan' => 'Bagaimana cara melihat status pengaduan saya?',
                'jawaban' => 'Login ke akun Anda, lalu klik menu "Riwayat Pengaduan" di bagian atas atau dari Dashboard. Di sana Anda dapat melihat semua pengaduan yang pernah Anda buat beserta status terkini (Menunggu, Diproses, Selesai, atau Ditolak).',
                'kategori' => 'pengaduan',
                'keywords' => 'status,lihat,cek,pantau',
            ],
            [
                'pertanyaan' => 'Apa yang harus saya lakukan jika kehilangan barang?',
                'jawaban' => 'Segera buat laporan kehilangan melalui sistem ini. Pilih kategori "Pencurian", jelaskan detail barang yang hilang, lokasi dan waktu kejadian. Lampirkan foto barang jika ada. Untuk kasus pencurian kendaraan, hubungi juga nomor darurat 110 untuk penanganan lebih cepat.',
                'kategori' => 'kehilangan',
                'keywords' => 'hilang,barang,kehilangan,pencurian',
            ],
            [
                'pertanyaan' => 'Nomor telepon darurat polisi berapa?',
                'jawaban' => 'Nomor darurat polisi adalah 110. Hubungi nomor ini untuk situasi darurat yang memerlukan penanganan segera seperti kejahatan yang sedang terjadi, kecelakaan serius, atau ancaman nyawa.',
                'kategori' => 'kontak',
                'keywords' => 'telepon,darurat,nomor,110,hubungi',
            ],
            [
                'pertanyaan' => 'Apakah laporan saya bersifat rahasia?',
                'jawaban' => 'Ya, semua laporan pengaduan bersifat rahasia dan hanya dapat diakses oleh Anda dan petugas berwenang. Data pribadi Anda dilindungi sesuai dengan undang-undang perlindungan data pribadi.',
                'kategori' => 'privasi',
                'keywords' => 'rahasia,privasi,keamanan,data',
            ],
            [
                'pertanyaan' => 'Bagaimana cara mendaftar akun baru?',
                'jawaban' => 'Klik tombol "Daftar" di pojok kanan atas. Isi formulir dengan data lengkap: nama, NIK, email, nomor telepon, alamat, dan password. Setelah berhasil mendaftar, Anda bisa langsung login dan membuat pengaduan.',
                'kategori' => 'akun',
                'keywords' => 'daftar,registrasi,akun,baru',
            ],
            [
                'pertanyaan' => 'Apa itu prioritas pengaduan?',
                'jawaban' => 'Prioritas pengaduan dibagi menjadi 3: Rendah, Sedang, dan Tinggi. Pilih prioritas sesuai dengan tingkat urgensi kasus Anda. Kasus dengan prioritas tinggi akan diproses lebih cepat oleh petugas.',
                'kategori' => 'pengaduan',
                'keywords' => 'prioritas,tinggi,rendah,sedang',
            ],
            [
                'pertanyaan' => 'Bisakah saya mengupload foto sebagai bukti?',
                'jawaban' => 'Ya, Anda dapat mengupload foto sebagai bukti pendukung dalam format JPG atau PNG dengan ukuran maksimal 2MB. Foto yang jelas akan sangat membantu proses investigasi.',
                'kategori' => 'pengaduan',
                'keywords' => 'foto,upload,bukti,gambar',
            ],
            [
                'pertanyaan' => 'Bagaimana jika saya lupa password?',
                'jawaban' => 'Jika Anda lupa password, silakan hubungi admin melalui email admin@polisi.id dengan menyertakan NIK dan nama lengkap Anda untuk verifikasi identitas. Fitur reset password otomatis sedang dalam pengembangan.',
                'kategori' => 'akun',
                'keywords' => 'lupa,password,reset',
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }

        // === INFO KONFIRMASI ===
        $this->command->info('✅ Database seeded successfully!');
        $this->command->info('');
        $this->command->info('📧 Login Petugas:');
        $this->command->info('   Email: admin@polisi.id');
        $this->command->info('   Password: password');
        $this->command->info('');
        $this->command->info('👤 Login Masyarakat:');
        $this->command->info('   Email: budi@gmail.com');
        $this->command->info('   Password: password');
    }
}
