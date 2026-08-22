<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\Pelanggaran;
use App\Models\JadwalPelajaran;
use App\Models\Tugas;
use App\Models\TugasSubmission;
use App\Models\ProfilSekolah;
use App\Models\Guru;
use App\Models\Staff;
use App\Models\Fasilitas;
use App\Models\Ekstrakurikuler;
use App\Models\PrestasiSiswa;
use App\Models\Galeri;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 0. Seed Profil Sekolah Astika Dharma & ASDHA TV
        ProfilSekolah::updateOrCreate(
            ['id' => 1],
            [
                'nama_sekolah' => 'Utama Widyalaya Astika Dharma',
                'npsn_status' => '50103648 | Swasta',
                'kepala_sekolah' => 'I Ketut Suena, S.Pd',
                'nama_kepala_sekolah' => 'I Ketut Suena, S.Pd',
                'slogan' => 'Unggul, Berkarakter Berbasis Tri Hita Karana & Inovatif Bersama ASDHA TV',
                'akreditasi' => 'A',
                'jam_operasional' => 'Senin - Jumat (07:00 - 15:30 WITA)',
                'alamat' => 'Desa Pempatan, Kecamatan Rendang, Kabupaten Karangasem, Bali',
                'email' => 'info@astikadharma.sch.id',
                'telepon' => '081234567890',
                'whatsapp' => '081234567890',
                'instagram' => 'https://instagram.com/asdhatv',
                'tiktok' => 'https://tiktok.com/@asdhatv',
                'youtube' => 'https://youtube.com/@asdhatv?si=6dcfwv3FKNSWBKNu',
                'visi' => 'Mewujudkan Sumber Daya Manusia Hindu yang Unggul, Berkarakter Mulia Berlandaskan Tri Hita Karana dan Tri Kaya Parisudha, Berdaya Saing, serta Menguasai Teknologi Terdepan.',
                'misi' => "1. Menyelenggarakan pendidikan holistik berbasis karakter spiritual Hindu dan nilai-nilai kebangsaan.\n2. Mengembangkan literasi digital, kreativitas, dan media jurnalisme siswa melalui kanal ASDHA TV.\n3. Menerapkan pembelajaran berpusat pada siswa (deep learning) berbasis kearifan lokal.\n4. Meningkatkan kompetensi pendidik dalam penerapan teknologi serta kurikulum berkarakter.",
                'deskripsi_tentang' => 'Utama Widyalaya Astika Dharma (SMA Hindu Astika Dharma / ASDHA) adalah lembaga pendidikan berprestasi di Rendang, Karangasem, Bali. Melalui wadah kreasi media ASDHA TV, sekolah ini mencetak generasi muda berakhlak mulia, cerdas, dan tanggap terhadap perkembangan zaman.',
                'sambutan_kepala_sekolah' => 'Om Swastyastu. Selamat datang di portal resmi Utama Widyalaya Astika Dharma. Kami berkomitmen menyelenggarakan pendidikan berkualitas tinggi yang memadukan keunggulan akademik, spiritualitas Hindu, dan literasi digital abad 21 melalui inovasi jurnalisme visual ASDHA TV. Om Shanti Shanti Shanti Om.',
            ]
        );

        // 0b. Seed Guru & Staf Astika Dharma
        $gurusData = [
            ['nip' => '197805122005011001', 'nama' => 'I Ketut Suena, S.Pd', 'mata_pelajaran' => 'Kepala Sekolah & Pembina Pendidikan', 'no_hp' => '081234567891'],
            ['nip' => '198203152008012002', 'nama' => 'Dra. Ni Made Wardani', 'mata_pelajaran' => 'Waka Kurikulum / Bahasa Indonesia', 'no_hp' => '081234567892'],
            ['nip' => '198507202010011003', 'nama' => 'I Wayan Gede, S.Ag', 'mata_pelajaran' => 'Pendidikan Agama Hindu & Budhi Pekerti', 'no_hp' => '081234567893'],
            ['nip' => '199011042015022004', 'nama' => 'Ni Luh Putu Sri, S.Pd', 'mata_pelajaran' => 'Teknologi Informasi & Pembina ASDHA TV', 'no_hp' => '081234567894'],
            ['nip' => '199204102018011005', 'nama' => 'I Made Putra, S.Pd', 'mata_pelajaran' => 'Pendidikan Jasmani, Olahraga & Kesehatan', 'no_hp' => '081234567895'],
            ['nip' => '199408252020012006', 'nama' => 'Ni Kadek Swastini, S.Pd', 'mata_pelajaran' => 'Matematika & Literasi Sains', 'no_hp' => '081234567896'],
        ];

        foreach ($gurusData as $gData) {
            Guru::updateOrCreate(
                ['nama' => $gData['nama']],
                [
                    'nip' => $gData['nip'],
                    'mata_pelajaran' => $gData['mata_pelajaran'],
                    'no_hp' => $gData['no_hp'],
                    'is_active' => true
                ]
            );
        }

        // 0c. Seed Program Keahlian (Jurusan) Astika Dharma
        $jurusansData = [
            [
                'nama_jurusan' => 'Keagamaan & Pasraman Widyalaya',
                'deskripsi' => 'Program pendidikan karakter spiritual Hindu, pendalaman Kitab Suci Veda, Dharma Wacana, dan kepemimpinan berlandaskan Tri Hita Karana.',
                'detail_informasi' => "Fokus Pembelajaran:\n- Pendalaman Tattwa, Susila, dan Acara Hindu.\n- Pelatihan Dharma Wacana & Utsawa Dharmagita.\n- Kepemimpinan spiritual & pengabdian masyarakat.",
                'icon' => 'book-open',
                'foto' => 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?auto=format&fit=crop&w=800&q=80',
                'is_active' => true
            ],
            [
                'nama_jurusan' => 'Multimedia & ASDHA TV Broadcasting',
                'deskripsi' => 'Pengembangan keterampilan sinematografi, produksi TV digital, jurnalisme visual, dan pengelolaan media kreatif ASDHA TV.',
                'detail_informasi' => "Fokus Pembelajaran:\n- Teknik Wawancara, Presenter TV & Liputan Berita.\n- Videografi, Video Editing (Adobe Premiere/DaVinci), & Sound Design.\n- Pengelolaan Live Streaming & Konten Youtube ASDHA TV.",
                'icon' => 'camera',
                'foto' => 'https://images.unsplash.com/photo-1574717024653-61fd2cf4d44d?auto=format&fit=crop&w=800&q=80',
                'is_active' => true
            ],
            [
                'nama_jurusan' => 'Teknologi Informasi & Digital Skills',
                'deskripsi' => 'Penguasaan pemrograman komputer, pengembangan aplikasi web, jaringan digital, dan literasi teknologi modern.',
                'detail_informasi' => "Fokus Pembelajaran:\n- Dasar Pemrograman Web & Aplikasi Mobile.\n- Desain Grafis (UI/UX) & Digital Marketing.\n- Pengoperasian Sistem Informasi Sekolah & Jaringan Digital.",
                'icon' => 'code',
                'foto' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?auto=format&fit=crop&w=800&q=80',
                'is_active' => true
            ],
            [
                'nama_jurusan' => 'Seni Budaya & Kearifan Lokal Bali',
                'deskripsi' => 'Pelestarian seni tari Bali, seni tabuh gamelan tradisional, karya seni kerajinan, dan eko-inovasi pembelajaran lokal.',
                'detail_informasi' => "Fokus Pembelajaran:\n- Seni Tari Tradisional & Kontemporer Bali.\n- Seni Tabuh & Pembinaan Sanggar Kerawitan.\n- Eko-Inovasi & Kewirausahaan Berbasis Budaya.",
                'icon' => 'palette',
                'foto' => 'https://images.unsplash.com/photo-1511632765486-a01980e01a18?auto=format&fit=crop&w=800&q=80',
                'is_active' => true
            ]
        ];

        foreach ($jurusansData as $jData) {
            Jurusan::updateOrCreate(
                ['nama_jurusan' => $jData['nama_jurusan']],
                $jData
            );
        }

        // 0d. Seed Fasilitas Sekolah Astika Dharma
        $fasilitasData = [
            [
                'nama_fasilitas' => 'Studio ASDHA TV & Lab Broadcasting',
                'deskripsi' => 'Ruang produksi penyiaran digital yang dilengkapi dengan kamera profesional, lighting studio, green screen, dan perangkat live streaming media ASDHA TV.',
                'foto' => 'https://images.unsplash.com/photo-1598899134739-24c46f58b8c0?auto=format&fit=crop&w=800&q=80',
                'is_active' => true,
                'is_large' => true
            ],
            [
                'nama_fasilitas' => 'Padmasana & Area Pasraman Utama',
                'deskripsi' => 'Tempat ibadah & pembinaan spiritual siswa-siswi Astika Dharma untuk persembahyangan bersama, meditasi, dan kegiatan keagamaan Hindu.',
                'foto' => 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?auto=format&fit=crop&w=800&q=80',
                'is_active' => true,
                'is_large' => false
            ],
            [
                'nama_fasilitas' => 'Laboratorium Komputer & Digital Learning',
                'deskripsi' => 'Fasilitas komputer modern dengan koneksi internet cepat untuk mendukung pembelajaran pemrograman, riset digital, dan pengeditan media.',
                'foto' => 'https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&w=800&q=80',
                'is_active' => true,
                'is_large' => false
            ],
            [
                'nama_fasilitas' => 'Perpustakaan Literasi & Digital Corner',
                'deskripsi' => 'Koleksi buku keagamaan, buku pelajaran umum, novel, serta akses e-library untuk mengasah budaya literasi peserta didik.',
                'foto' => 'https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=800&q=80',
                'is_active' => true,
                'is_large' => false
            ],
            [
                'nama_fasilitas' => 'Gedung Aula Pertemuan & Pentas Seni',
                'deskripsi' => 'Aula serbaguna tempat penyelenggaraan pagelaran seni budaya, seminar pendidikan, pertunjukan Dharmawacana, dan perpisahan sekolah.',
                'foto' => 'https://images.unsplash.com/photo-1511578314322-379afb476865?auto=format&fit=crop&w=800&q=80',
                'is_active' => true,
                'is_large' => false
            ]
        ];

        foreach ($fasilitasData as $fData) {
            Fasilitas::updateOrCreate(
                ['nama_fasilitas' => $fData['nama_fasilitas']],
                $fData
            );
        }

        // 0e. Seed Ekstrakurikuler Astika Dharma
        $ekskulData = [
            [
                'nama_ekskul' => 'ASDHA TV Broadcasting & Jurnalisme',
                'kategori' => 'Media & Teknologi',
                'pembina' => 'Ni Luh Putu Sri, S.Pd',
                'hari_latihan' => 'Selasa & Jumat',
                'jam_latihan' => '15:30 - 17:00 WITA',
                'lokasi' => 'Studio ASDHA TV',
                'deskripsi' => 'Wadah berekspresi siswa dalam dunia penyiaran TV, pembuatan video berita, liputan acara sekolah, dan wawancara narasumber.',
                'foto' => 'https://images.unsplash.com/photo-1574717024653-61fd2cf4d44d?auto=format&fit=crop&w=800&q=80',
                'status' => 'Aktif'
            ],
            [
                'nama_ekskul' => 'Seni Tari & Tabuh Gamelan Bali',
                'kategori' => 'Seni & Budaya',
                'pembina' => 'Ni Wayan Murni, S.Pd',
                'hari_latihan' => 'Rabu & Sabtu',
                'jam_latihan' => '15:30 - 17:30 WITA',
                'lokasi' => 'Aula Sanggar Seni',
                'deskripsi' => 'Pelatihan seni tari khas Bali dan penguasaan instrumen gamelan tradisional untuk memperkuat nilai-nilai kearifan lokal.',
                'foto' => 'https://images.unsplash.com/photo-1511632765486-a01980e01a18?auto=format&fit=crop&w=800&q=80',
                'status' => 'Aktif'
            ],
            [
                'nama_ekskul' => 'Utsawa Dharmagita & Dharma Wacana',
                'kategori' => 'Keagamaan',
                'pembina' => 'I Wayan Gede, S.Ag',
                'hari_latihan' => 'Senin & Kamis',
                'jam_latihan' => '15:30 - 17:00 WITA',
                'lokasi' => 'Pasraman Astika Dharma',
                'deskripsi' => 'Pendalaman seni melantunkan Sloka, Palawakya, Kakawin, serta olah vokal public speaking dalam ajaran Dharma Wacana.',
                'foto' => 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?auto=format&fit=crop&w=800&q=80',
                'status' => 'Aktif'
            ],
            [
                'nama_ekskul' => 'Pramuka & Paskibra Astika Dharma',
                'kategori' => 'Kepemimpinan',
                'pembina' => 'I Made Putra, S.Pd',
                'hari_latihan' => 'Sabtu',
                'jam_latihan' => '14:00 - 17:00 WITA',
                'lokasi' => 'Lapangan Utama',
                'deskripsi' => 'Pembentukan kedisiplinan, jiwa kepemimpinan, kecintaan tanah air, dan keterampilan baris-berbaris.',
                'foto' => 'https://images.unsplash.com/photo-1517649763962-0c623266010b?auto=format&fit=crop&w=800&q=80',
                'status' => 'Aktif'
            ]
        ];

        foreach ($ekskulData as $eData) {
            Ekstrakurikuler::updateOrCreate(
                ['nama_ekskul' => $eData['nama_ekskul']],
                $eData
            );
        }

        // 0f. Seed Prestasi Kebanggaan Sekolah Astika Dharma & ASDHA TV
        $prestasiData = [
            [
                'nama_siswa' => 'Budi Santoso & Tim Media ASDHA TV',
                'kelas' => 'XI Broadcasting ASDHA TV',
                'judul_prestasi' => 'Juara 1 Lomba Jurnalisme Digital & Liputan Berita Sekolah',
                'kategori' => 'Jurnalisme & Media',
                'tingkat' => 'Provinsi',
                'peringkat' => 'Juara 1',
                'tahun' => '2025',
                'penyelenggara' => 'Dinas Pendidikan & Kebudayaan Provinsi Bali',
                'deskripsi' => 'Tim ASDHA TV berhasil meraih penghargaan utama atas keunggulan kualitas liputan berita, sinematografi, dan kedalaman materi kebudayaan.',
                'tampilkan_di_beranda' => true
            ],
            [
                'nama_siswa' => 'Ni Putu Ayu Saraswati',
                'kelas' => 'XI MIPA 1',
                'judul_prestasi' => 'Juara 1 Olimpiade Sains & Matematika Widyalaya Bali',
                'kategori' => 'Sains & Matematika',
                'tingkat' => 'Provinsi',
                'peringkat' => 'Juara 1',
                'tahun' => '2025',
                'penyelenggara' => 'Ikatan Sains & Teknologi Widyalaya Bali',
                'deskripsi' => 'Meraih nilai tertinggi pada ujian teori fisika terapan dan matematika sains tingkat SMA/Widyalaya.',
                'tampilkan_di_beranda' => true
            ],
            [
                'nama_siswa' => 'I Gede Ryan Wibawa',
                'kelas' => 'XII Keagamaan Hindu 1',
                'judul_prestasi' => 'Juara 1 Utsawa Dharmagita & Lomba Dharma Wacana',
                'kategori' => 'Keagamaan & Seni',
                'tingkat' => 'Provinsi',
                'peringkat' => 'Juara 1',
                'tahun' => '2024',
                'penyelenggara' => 'Panitia Utsawa Dharmagita Bali',
                'deskripsi' => 'Meraih nilai tertinggi dalam kategori penafsiran sloka Veda dan penyampaian pesan moral keagamaan secara lisan.',
                'tampilkan_di_beranda' => true
            ],
            [
                'nama_siswa' => 'I Wayan Gede Dharmawan',
                'kelas' => 'XI IPS 1',
                'judul_prestasi' => 'Juara 2 Lomba Debat Bahasa & Budaya Kebangsaan',
                'kategori' => 'Sosial & Kebudayaan',
                'tingkat' => 'Provinsi',
                'peringkat' => 'Juara 2',
                'tahun' => '2024',
                'penyelenggara' => 'Badan Kemasyarakatan & Kebudayaan Bali',
                'deskripsi' => 'Menampilkan wawasan kebudayaan lokal dan argumentasi sosial yang tajam dalam kompetisi debat SMA/Widyalaya.',
                'tampilkan_di_beranda' => true
            ]
        ];

        // Update legacy/dummy class names in existing PrestasiSiswa records
        PrestasiSiswa::whereNotIn('kelas', ['XI Broadcasting ASDHA TV', 'XI MIPA 1', 'XII Keagamaan Hindu 1', 'XI IPS 1'])
            ->update(['kelas' => 'XI Broadcasting ASDHA TV']);

        foreach ($prestasiData as $pData) {
            PrestasiSiswa::updateOrCreate(
                ['judul_prestasi' => $pData['judul_prestasi']],
                $pData
            );
        }

        // 0g. Seed Galeri Kegiatan Sekolah Astika Dharma & ASDHA TV
        $galeriData = [
            [
                'judul' => 'Liputan Berita & Penyiaran Digital ASDHA TV',
                'kategori' => 'Jurnalisme Digital',
                'foto' => 'https://images.unsplash.com/photo-1574717024653-61fd2cf4d44d?auto=format&fit=crop&w=800&q=80',
                'is_active' => true
            ],
            [
                'judul' => 'Pementasan Seni Tari Bali & Utsawa Dharmagita',
                'kategori' => 'Seni & Budaya',
                'foto' => 'https://images.unsplash.com/photo-1511632765486-a01980e01a18?auto=format&fit=crop&w=800&q=80',
                'is_active' => true
            ],
            [
                'judul' => 'Peninjauan Cek Kesehatan Gratis (CKG) Sekolah oleh Kementerian RI',
                'kategori' => 'Kesehatan & Lingkungan',
                'foto' => 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&w=800&q=80',
                'is_active' => true
            ],
            [
                'judul' => 'Praktikum Pemrograman & Multimedia Siswa',
                'kategori' => 'Teknologi & Pendidikan',
                'foto' => 'https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&w=800&q=80',
                'is_active' => true
            ],
            [
                'judul' => 'Persembahyangan Bersama Tri Sandhya di Pasraman Padmasana',
                'kategori' => 'Keagamaan',
                'foto' => 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?auto=format&fit=crop&w=800&q=80',
                'is_active' => true
            ],
            [
                'judul' => 'Pelatihan Baris-Berbaris Paskibra & Kepramukaan Astika Dharma',
                'kategori' => 'Ekstrakurikuler',
                'foto' => 'https://images.unsplash.com/photo-1517649763962-0c623266010b?auto=format&fit=crop&w=800&q=80',
                'is_active' => true
            ]
        ];

        foreach ($galeriData as $gData) {
            Galeri::updateOrCreate(
                ['judul' => $gData['judul']],
                $gData
            );
        }

        // 0h. Seed Berita & Kabar Utama Widyalaya Astika Dharma & ASDHA TV
        $beritaData = [
            [
                'judul' => 'Inovasi Penyiaran Digital ASDHA TV: Siswa Astika Dharma Raih Juara 1 Jurnalisme',
                'kategori' => 'Jurnalisme Digital',
                'penulis' => 'Humas ASDHA TV',
                'tanggal_publikasi' => now()->format('Y-m-d'),
                'ringkasan' => 'Tim Jurnalistik dan Broadcasting ASDHA TV Utama Widyalaya Astika Dharma berhasil menyabet penghargaan pertama dalam kompetisi jurnalisme visual.',
                'konten' => "Kompetisi jurnalisme media sekolah tingkat provinsi yang diselenggarakan oleh Dinas Pendidikan & Kebudayaan Provinsi Bali menjadi ajang pembuktian prestasi siswa-siswi Utama Widyalaya Astika Dharma.\n\nMelalui divisi penyiaran ASDHA TV, para siswa menyajikan liputan berita komprehensif yang mengedepankan kearifan lokal, pelestarian budaya spiritual Hindu, serta kecanggihan teknologi videografi abad 21.\n\nKepala Sekolah Utama Widyalaya Astika Dharma menyampaikan apresiasi mendalam atas semangat juang dan dedikasi tim media sekolah yang telah membawa nama harum institusi di kancah daerah.",
                'foto' => 'https://images.unsplash.com/photo-1574717024653-61fd2cf4d44d?auto=format&fit=crop&w=800&q=80',
                'is_active' => true,
                'is_highlight' => true,
                'tags' => 'AstikaDharma; ASDHATV; JurnalismeSekolah; PrestasiBali; PendidikanHindu; Digitalisasi; MediaSiswa'
            ],
            [
                'judul' => 'Kunjungan Kerja Pejabat Kementerian RI dalam Peninjauan Cek Kesehatan Gratis (CKG)',
                'kategori' => 'Kesehatan & Lingkungan',
                'penulis' => 'Tim Redaksi Astika Dharma',
                'tanggal_publikasi' => now()->subDays(2)->format('Y-m-d'),
                'ringkasan' => 'Utama Widyalaya Astika Dharma terpilih menjadi salah satu sekolah percontohan program Cek Kesehatan Gratis (CKG) berbasis kearifan lokal.',
                'konten' => "Program Cek Kesehatan Gratis (CKG) yang diprakarsai oleh Kementerian Keuangan & Kementerian Kesehatan RI dilaksanakan secara khidmat di lingkungan Utama Widyalaya Astika Dharma.\n\nSeluruh civitas akademika, mulai dari siswa, guru, hingga staf tata usaha mengikuti pemeriksaan kesehatan berkala yang mencakup skrining fisik, pencegahan penyakit, dan edukasi pola hidup bersih sehat berlandaskan ajaran Tri Hita Karana (Palemahan & Pawongan).",
                'foto' => 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&w=800&q=80',
                'is_active' => true,
                'is_highlight' => false,
                'tags' => 'CekKesehatanGratis; SekolahSehat; KementerianRI; AstikaDharma; Palemahan; PolaHidupSehat'
            ],
            [
                'judul' => 'Persembahyangan Bersama & Pelaksanaan Utsawa Dharmagita Pasraman Astika Dharma',
                'kategori' => 'Keagamaan',
                'penulis' => 'Pembina Pasraman',
                'tanggal_publikasi' => now()->subDays(5)->format('Y-m-d'),
                'ringkasan' => 'Kegiatan rutin peninggian nilai-nilai Tattwa, Susila, dan Acara Hindu melalui lantunan Sloka Veda dan Utsawa Dharmagita.',
                'konten' => "Dalam rangka memperkuat pendidikan karakter spiritual keagamaan Hindu, Utama Widyalaya Astika Dharma menggelar persembahyangan bersama Rahina Purnama di Padmasana Pasraman Utama.\n\nKegiatan diisi dengan pembacaan Sloka-Sloka suci Veda, peragaan Dharma Wacana oleh para siswa berprestasi, serta pementasan seni Kidung keagamaan yang menginspirasi seluruh peserta didik.",
                'foto' => 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?auto=format&fit=crop&w=800&q=80',
                'is_active' => true,
                'is_highlight' => false,
                'tags' => 'UtsawaDharmagita; SlokaVeda; DharmaWacana; PasramanHindu; TriHitaKarana; CharacterBuilding'
            ]
        ];

        foreach ($beritaData as $bData) {
            \App\Models\Berita::updateOrCreate(
                ['judul' => $bData['judul']],
                $bData
            );
        }

        // 1. Seed Kelas Real Utama Widyalaya Astika Dharma & ASDHA TV
        $realKelasNames = [
            'X MIPA 1', 'XI MIPA 1', 'XII MIPA 1',
            'X IPS 1', 'XI IPS 1', 'XII IPS 1',
            'X Keagamaan Hindu 1', 'XI Keagamaan Hindu 1', 'XII Keagamaan Hindu 1',
            'X Broadcasting ASDHA TV', 'XI Broadcasting ASDHA TV', 'XII Broadcasting ASDHA TV'
        ];

        // Delete ALL previous/legacy classes completely
        Kelas::whereNotIn('nama_kelas', $realKelasNames)->delete();

        foreach ($realKelasNames as $name) {
            Kelas::firstOrCreate(['nama_kelas' => $name], ['is_active' => true]);
        }

        // 2. Seed Jurusan / Program Keahlian Real Astika Dharma
        $jurusans = [
            'Matematika & Ilmu Pengetahuan Alam (MIPA)',
            'Ilmu Pengetahuan Sosial (IPS)',
            'Keagamaan Hindu & Ke-Pasramanan (Agama)',
            'Jurnalistik & Broadcasting Media (ASDHA TV)'
        ];

        // Clear ALL previous/legacy jurusan completely
        Jurusan::whereNotIn('nama_jurusan', $jurusans)->delete();

        foreach ($jurusans as $name) {
            Jurusan::firstOrCreate(['nama_jurusan' => $name], ['is_active' => true]);
        }

        // 3. Seed Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin Sat',
                'password' => Hash::make('password123'),
                'role' => 'admin'
            ]
        );
        $admin->update(['role' => 'admin']);

        // 4. Seed Siswa Real Utama Widyalaya Astika Dharma & ASDHA TV
        $siswaData = [
            [
                'nis' => '10001',
                'nama' => 'Budi Santoso',
                'kelas' => 'XI Broadcasting ASDHA TV',
                'jurusan' => 'Jurnalistik & Broadcasting Media (ASDHA TV)',
                'email' => 'budi@gmail.com'
            ],
            [
                'nis' => '10002',
                'nama' => 'Ni Putu Ayu Saraswati',
                'kelas' => 'XI MIPA 1',
                'jurusan' => 'Matematika & Ilmu Pengetahuan Alam (MIPA)',
                'email' => 'saraswati@gmail.com'
            ],
            [
                'nis' => '10003',
                'nama' => 'I Wayan Gede Dharmawan',
                'kelas' => 'XI IPS 1',
                'jurusan' => 'Ilmu Pengetahuan Sosial (IPS)',
                'email' => 'dharmawan@gmail.com'
            ],
            [
                'nis' => '10004',
                'nama' => 'Ni Kadek Supraba Dewi',
                'kelas' => 'XI Keagamaan Hindu 1',
                'jurusan' => 'Keagamaan Hindu & Ke-Pasramanan (Agama)',
                'email' => 'supraba@gmail.com'
            ],
            [
                'nis' => '10005',
                'nama' => 'I Gede Ryan Wibawa',
                'kelas' => 'XII Keagamaan Hindu 1',
                'jurusan' => 'Keagamaan Hindu & Ke-Pasramanan (Agama)',
                'email' => 'ryan@gmail.com'
            ]
        ];

        // Cascade update any old legacy student records to valid classes
        Siswa::whereNotIn('kelas', $realKelasNames)->update([
            'kelas' => 'XI Broadcasting ASDHA TV',
            'jurusan' => 'Jurnalistik & Broadcasting Media (ASDHA TV)'
        ]);

        foreach ($siswaData as $sItem) {
            $siswaRecord = Siswa::updateOrCreate(
                ['nis' => $sItem['nis']],
                [
                    'nama' => $sItem['nama'],
                    'kelas' => $sItem['kelas'],
                    'jurusan' => $sItem['jurusan'],
                    'status' => 'Pelajar'
                ]
            );

            User::updateOrCreate(
                ['email' => $sItem['email']],
                [
                    'name' => $sItem['nama'],
                    'password' => Hash::make('password123'),
                    'role' => 'siswa',
                    'siswa_id' => $siswaRecord->id
                ]
            );
        }

        // Ensure EVERY student in siswas table has a User login account with default password 'password123'
        $allSiswas = Siswa::all();
        foreach ($allSiswas as $sRecord) {
            $userEmail = !empty($sRecord->email) ? strtolower($sRecord->email) : strtolower($sRecord->nis) . '@astikadharma.sch.id';
            
            $u = User::where('siswa_id', $sRecord->id)->orWhere('email', $userEmail)->first();
            if (!$u) {
                User::create([
                    'name' => $sRecord->nama,
                    'email' => $userEmail,
                    'password' => Hash::make('password123'),
                    'role' => 'siswa',
                    'siswa_id' => $sRecord->id
                ]);
            } else {
                $u->update([
                    'name' => $sRecord->nama,
                    'role' => 'siswa',
                    'siswa_id' => $sRecord->id,
                    'password' => Hash::make('password123')
                ]);
            }

            // Link achievement records to student ID
            PrestasiSiswa::where('nama_siswa', 'LIKE', '%' . strtok($sRecord->nama, ' ') . '%')
                ->update(['siswa_id' => $sRecord->id]);
        }

        $mainSiswa = Siswa::where('nis', '10001')->first();

        // 6. Seed Pelanggaran
        if ($mainSiswa) {
            Pelanggaran::firstOrCreate(
                [
                    'siswa_id' => $mainSiswa->id,
                    'nama_pelanggaran' => 'Terlambat masuk sesi penyiaran ASDHA TV'
                ],
                [
                    'point' => 10,
                    'tanggal' => now()->format('Y-m-d')
                ]
            );

            Pelanggaran::firstOrCreate(
                [
                    'siswa_id' => $mainSiswa->id,
                    'nama_pelanggaran' => 'Tidak memakai atribut seragam adat rapi'
                ],
                [
                    'point' => 5,
                    'tanggal' => now()->subDays(2)->format('Y-m-d')
                ]
            );
        }

        // 7. Seed Jadwal Pelajaran (Schedule) Real Astika Dharma & ASDHA TV
        JadwalPelajaran::whereNotIn('kelas', $realKelasNames)->update(['kelas' => 'XI Broadcasting ASDHA TV']);

        $schedules = [
            ['kelas' => 'XI Broadcasting ASDHA TV', 'hari' => 'Senin', 'mata_pelajaran' => 'Pendidikan Agama Hindu & Tri Hita Karana', 'jam_mulai' => '07:30', 'jam_selesai' => '09:00'],
            ['kelas' => 'XI Broadcasting ASDHA TV', 'hari' => 'Senin', 'mata_pelajaran' => 'Jurnalistik & Produksi Konten ASDHA TV', 'jam_mulai' => '09:15', 'jam_selesai' => '11:15'],
            ['kelas' => 'XI Broadcasting ASDHA TV', 'hari' => 'Selasa', 'mata_pelajaran' => 'Teknik Videografi & Liputan Lapangan', 'jam_mulai' => '08:00', 'jam_selesai' => '11:15'],
            ['kelas' => 'XI Broadcasting ASDHA TV', 'hari' => 'Rabu', 'mata_pelajaran' => 'Editing Media & Penyiaran Digital', 'jam_mulai' => '08:00', 'jam_selesai' => '10:15'],
            ['kelas' => 'XI Broadcasting ASDHA TV', 'hari' => 'Rabu', 'mata_pelajaran' => 'Bahasa Indonesia & Publik Speaking', 'jam_mulai' => '10:30', 'jam_selesai' => '12:00'],
            ['kelas' => 'XI MIPA 1', 'hari' => 'Senin', 'mata_pelajaran' => 'Matematika Tingkat Lanjut', 'jam_mulai' => '08:00', 'jam_selesai' => '10:00'],
            ['kelas' => 'XI MIPA 1', 'hari' => 'Selasa', 'mata_pelajaran' => 'Fisika & Literasi Sains', 'jam_mulai' => '08:00', 'jam_selesai' => '10:00'],
            ['kelas' => 'XI Keagamaan Hindu 1', 'hari' => 'Senin', 'mata_pelajaran' => 'Kajian Kitab Suci Veda & Sloka', 'jam_mulai' => '08:00', 'jam_selesai' => '10:00'],
        ];

        foreach ($schedules as $sched) {
            JadwalPelajaran::firstOrCreate([
                'kelas' => $sched['kelas'],
                'hari' => $sched['hari'],
                'mata_pelajaran' => $sched['mata_pelajaran'],
                'jam_mulai' => $sched['jam_mulai'],
                'jam_selesai' => $sched['jam_selesai'],
            ]);
        }

        // 8. Seed Assignments (Tugas) Real Astika Dharma & ASDHA TV
        Tugas::whereNotIn('kelas', $realKelasNames)->update(['kelas' => 'XI Broadcasting ASDHA TV']);

        $tugas1 = Tugas::firstOrCreate(
            [
                'kelas' => 'XI Broadcasting ASDHA TV',
                'judul' => 'Produksi Video Liputan Singkat Kegiatan Sekolah ASDHA TV'
            ],
            [
                'mata_pelajaran' => 'Jurnalistik & Produksi Konten ASDHA TV',
                'deskripsi' => 'Buatlah video liputan berdurasi 2-3 menit tentang kegiatan ekstrakurikuler atau akademik di sekolah, unggah draft untuk review penyiaran ASDHA TV.',
                'deadline' => now()->addDays(7)->format('Y-m-d')
            ]
        );

        $tugas2 = Tugas::firstOrCreate(
            [
                'kelas' => 'XI Broadcasting ASDHA TV',
                'judul' => 'Analisis Nilai-Nilai Tri Hita Karana dalam Lingkungan Sekolah'
            ],
            [
                'mata_pelajaran' => 'Pendidikan Agama Hindu & Tri Hita Karana',
                'deskripsi' => 'Tuliskan esai singkat mengenai penerapan Parahyangan, Pawongan, dan Palemahan di lingkungan Utama Widyalaya Astika Dharma.',
                'deadline' => now()->subDay()->format('Y-m-d')
            ]
        );

        // 9. Seed Assignment Submission
        if ($mainSiswa) {
            TugasSubmission::firstOrCreate(
                [
                    'tugas_id' => $tugas2->id,
                    'siswa_id' => $mainSiswa->id
                ],
                [
                    'catatan' => 'Tugas Analisis Nilai Tri Hita Karana selesai dibuat, Om Shanti.',
                    'file_path' => 'siswa/tugas/budi_tri_hita_karana.pdf',
                    'dikumpulkan_pada' => now()->subHours(2)
                ]
            );
        }
    }
}
