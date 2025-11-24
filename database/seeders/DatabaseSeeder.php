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
                'pertanyaan' => 'Bagaimana cara membuat SIM?',
                'jawaban' => 'Untuk membuat SIM, Anda perlu: 1) Datang ke Satpas terdekat, 2) Membawa KTP asli dan fotokopi, 3) Mengisi formulir pendaftaran, 4) Melakukan tes kesehatan, 5) Mengikuti ujian teori dan praktik, 6) Foto dan tanda tangan digital, 7) Pembayaran biaya administrasi. Proses biasanya memakan waktu 1 hari kerja.',
                'kategori' => 'informasi',
                'keywords' => 'sim,pembuatan,cara,persyaratan',
            ],
            [
                'pertanyaan' => 'Apa saja persyaratan membuat SKCK?',
                'jawaban' => 'Persyaratan SKCK: 1) KTP asli dan fotokopi, 2) Kartu Keluarga asli dan fotokopi, 3) Akta Kelahiran/Ijazah, 4) Pas foto berwarna ukuran 4x6 (6 lembar), 5) Sidik jari, 6) Surat pengantar dari RT/RW (untuk keperluan tertentu). Biaya administrasi Rp 30.000. Proses 3-7 hari kerja.',
                'kategori' => 'informasi',
                'keywords' => 'skck,persyaratan,dokumen,cara',
            ],
            [
                'pertanyaan' => 'Bagaimana cara melaporkan kecelakaan lalu lintas?',
                'jawaban' => 'Langkah-langkah: 1) Amankan lokasi kejadian, 2) Hubungi 110 jika ada korban, 3) Jangan pindahkan kendaraan sebelum polisi datang, 4) Ambil foto/video kondisi kejadian, 5) Catat data saksi jika ada, 6) Tunggu petugas untuk membuat laporan kecelakaan. Anda juga bisa membuat laporan online melalui sistem ini.',
                'kategori' => 'pengaduan',
                'keywords' => 'kecelakaan,lalu lintas,laporan,cara',
            ],
            [
                'pertanyaan' => 'Bagaimana cara meminta pengawalan dari polisi?',
                'jawaban' => 'Untuk mengajukan permohonan pengawalan: 1) Buat pengaduan melalui sistem ini dengan kategori "Permintaan - Pengawalan", 2) Jelaskan detail acara (tanggal, waktu, lokasi, jumlah peserta), 3) Lampirkan surat permohonan resmi jika untuk organisasi/instansi, 4) Tunggu konfirmasi dari petugas maksimal 3 hari kerja, 5) Koordinasi lebih lanjut dengan petugas yang ditunjuk.',
                'kategori' => 'permintaan',
                'keywords' => 'pengawalan,permintaan,cara,prosedur',
            ],
            [
                'pertanyaan' => 'Apa yang harus dilakukan jika menjadi korban pencurian?',
                'jawaban' => 'Langkah yang harus dilakukan: 1) Segera hubungi 110 atau kantor polisi terdekat, 2) Jangan sentuh barang bukti di TKP, 3) Catat ciri-ciri pelaku jika melihat, 4) Buat laporan kehilangan melalui sistem ini atau langsung ke polsek, 5) Siapkan dokumen kepemilikan barang yang hilang, 6) Ikuti perkembangan penyelidikan melalui sistem.',
                'kategori' => 'pengaduan',
                'keywords' => 'pencurian,korban,laporan,kehilangan',
            ],
            [
                'pertanyaan' => 'Bagaimana cara memperpanjang SIM yang sudah habis masa berlaku?',
                'jawaban' => 'Perpanjangan SIM: 1) Datang ke Satpas terdekat maksimal 30 hari sebelum atau setelah masa berlaku habis, 2) Bawa SIM lama, KTP asli dan fotokopi, 3) Isi formulir perpanjangan, 4) Tes kesehatan sederhana, 5) Foto dan tanda tangan digital, 6) Bayar biaya perpanjangan. Proses cepat, sekitar 1-2 jam. Jika telat lebih dari 1 tahun, harus mengulang tes dari awal.',
                'kategori' => 'informasi',
                'keywords' => 'sim,perpanjangan,habis,cara',
            ],
            [
                'pertanyaan' => 'Bagaimana melaporkan tindak kekerasan?',
                'jawaban' => 'Jika Anda atau orang lain menjadi korban kekerasan: 1) Segera hubungi 110 untuk bantuan darurat, 2) Cari tempat aman, 3) Dokumentasikan luka-luka dengan foto, 4) Segera lakukan visum et repertum di rumah sakit, 5) Buat laporan polisi dengan membawa hasil visum, 6) Ceritakan kronologi dengan jelas dan lengkap. Polisi akan melakukan penyelidikan dan penangkapan pelaku.',
                'kategori' => 'pengaduan',
                'keywords' => 'kekerasan,penganiayaan,korban,laporan',
            ],
            [
                'pertanyaan' => 'Nomor telepon darurat polisi berapa?',
                'jawaban' => 'Nomor darurat polisi adalah 110. Hubungi nomor ini untuk: kecelakaan serius, kejahatan yang sedang terjadi, ancaman nyawa, situasi darurat lainnya. Layanan 24/7 gratis. Untuk hal non-darurat, silakan buat laporan melalui sistem online ini atau datang langsung ke polsek terdekat.',
                'kategori' => 'informasi',
                'keywords' => 'telepon,darurat,110,nomor,kontak',
            ],
            [
                'pertanyaan' => 'Bagaimana cara melaporkan kejahatan siber/online?',
                'jawaban' => 'Laporan kejahatan siber: 1) Screenshot semua bukti percakapan/transaksi, 2) Simpan nomor rekening/kontak pelaku, 3) Buat laporan melalui sistem ini dengan kategori "pengaduan - Kejahatan Siber", 4) Lampirkan semua bukti digital, 5) Atau datang langsung ke Unit Cyber Crime di Polda/Polres setempat, 6) Jangan hapus bukti di perangkat Anda sampai kasus selesai.',
                'kategori' => 'pengaduan',
                'keywords' => 'siber,cyber,online,penipuan,internet',
            ],
            [
                'pertanyaan' => 'Apakah bisa membuat laporan kehilangan untuk klaim asuransi?',
                'jawaban' => 'Ya, bisa. Untuk klaim asuransi: 1) Buat laporan kehilangan melalui sistem ini dengan kategori "Informasi - Laporan Kehilangan", 2) Atau datang langsung ke polsek untuk membuat surat kehilangan, 3) Jelaskan detail barang yang hilang dan kronologinya, 4) Anda akan mendapat surat keterangan kehilangan resmi dari kepolisian, 5) Surat ini bisa digunakan untuk klaim asuransi, pengurusan dokumen baru, dll.',
                'kategori' => 'informasi',
                'keywords' => 'kehilangan,laporan,asuransi,surat keterangan',
            ],
            [
                'pertanyaan' => 'Berapa lama proses penanganan pengaduan?',
                'jawaban' => 'Waktu proses bervariasi tergantung jenis pengaduan: Informasi (SIM, SKCK) = 1-7 hari, pengaduan ringan = 7-14 hari, pengaduan serius = 14-30 hari atau lebih (tergantung penyelidikan), Permintaan pengawalan = 3-7 hari. Anda dapat memantau status pengaduan secara real-time melalui dashboard. Petugas akan memberikan update berkala.',
                'kategori' => 'informasi',
                'keywords' => 'lama,proses,waktu,durasi',
            ],
            [
                'pertanyaan' => 'Apakah laporan saya bersifat rahasia?',
                'jawaban' => 'Ya, semua laporan pengaduan bersifat rahasia dan hanya dapat diakses oleh Anda dan petugas berwenang yang menangani kasus. Data pribadi Anda dilindungi sesuai undang-undang perlindungan data. Untuk kasus tertentu yang memerlukan identitas saksi/pelapor dilindungi, Anda dapat meminta perlindungan khusus kepada petugas yang menangani.',
                'kategori' => 'informasi',
                'keywords' => 'rahasia,privasi,keamanan,data',
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }

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