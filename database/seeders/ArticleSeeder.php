<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\Profile;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    /**
     * Seed 50+ articles with 5 author users & profiles.
     */
    public function run(): void
    {
        // Create 5 authors with profiles
        $authors = [];
        $authorData = [
            [
                'name' => 'Ahmad Rizky Pratama',
                'email' => 'ahmad.rizky@paredaily.com',
                'bio' => 'Jurnalis senior dengan pengalaman 10 tahun di bidang teknologi dan inovasi digital. Lulusan Ilmu Komunikasi Universitas Airlangga yang aktif meliput perkembangan startup dan ekonomi digital Indonesia.',
            ],
            [
                'name' => 'Siti Nurhaliza',
                'email' => 'siti.nurhaliza@paredaily.com',
                'bio' => 'Reporter investigasi yang fokus pada isu politik lokal dan nasional. Pernah meraih penghargaan Journalist of the Year dari AJI. Bergabung dengan PareDaily sejak 2020.',
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi.santoso@paredaily.com',
                'bio' => 'Editor olahraga yang gemar menulis tentang sepakbola, bulu tangkis, dan e-sports. Mantan atlet bulu tangkis tingkat provinsi yang beralih ke dunia jurnalistik.',
            ],
            [
                'name' => 'Dewi Lestari',
                'email' => 'dewi.lestari@paredaily.com',
                'bio' => 'Penulis lifestyle dan kuliner yang telah menjelajahi lebih dari 100 destinasi kuliner di Jawa Timur. Aktif sebagai food blogger dan content creator.',
            ],
            [
                'name' => 'Fajar Nugroho',
                'email' => 'fajar.nugroho@paredaily.com',
                'bio' => 'Koresponden ekonomi dan bisnis dengan spesialisasi di sektor UMKM dan agrikultur. Lulusan Ekonomi Pembangunan yang peduli terhadap pertumbuhan ekonomi daerah.',
            ],
        ];

        foreach ($authorData as $data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]);

            Profile::create([
                'user_id' => $user->id,
                'bio' => $data['bio'],
                'avatar' => null,
                'phone' => fake('id_ID')->phoneNumber(),
            ]);

            $authors[] = $user;
        }

        // Predefined article titles for realism (Indonesian news style)
        $articleTemplates = [
            ['title' => 'Pemkot Kediri Luncurkan Program Smart City untuk Tingkatkan Pelayanan Publik', 'category' => 'Teknologi'],
            ['title' => 'Harga Bawang Merah di Pasar Pare Melonjak 30 Persen Jelang Lebaran', 'category' => 'Ekonomi & Bisnis'],
            ['title' => 'Tim Persik Kediri Raih Kemenangan Dramatis di Liga 2 Indonesia', 'category' => 'Olahraga'],
            ['title' => 'Startup Asal Kediri Berhasil Raih Pendanaan Seri A Senilai 5 Juta Dolar', 'category' => 'Teknologi'],
            ['title' => 'UMKM Kediri Manfaatkan AI untuk Optimalkan Penjualan Online', 'category' => 'Teknologi'],
            ['title' => 'Festival Kuliner Nusantara 2026 Digelar di Simpang Lima Gumul', 'category' => 'Gaya Hidup'],
            ['title' => 'KPU Tetapkan Jadwal Kampanye Pilkada Serentak 2026', 'category' => 'Politik'],
            ['title' => 'Turnamen Esports Mobile Legends Tingkat Jawa Timur Digelar di Kediri', 'category' => 'Hiburan'],
            ['title' => 'Bank Indonesia Catat Inflasi Kediri Raya Terkendali di Angka 2,5 Persen', 'category' => 'Ekonomi & Bisnis'],
            ['title' => 'Dinas Pendidikan Kediri Terapkan Kurikulum Digital di 50 Sekolah Dasar', 'category' => 'Sains & Edukasi'],
            ['title' => 'Wisata Alam Gunung Kelud Catat Rekor Pengunjung Selama Libur Panjang', 'category' => 'Gaya Hidup'],
            ['title' => 'Debat Terbuka Calon Gubernur Jawa Timur Berlangsung Panas', 'category' => 'Politik'],
            ['title' => 'Petani Pare Adopsi Teknologi Drone untuk Penyemprotan Pertanian', 'category' => 'Teknologi'],
            ['title' => 'Menkes Resmikan Rumah Sakit Bertaraf Internasional di Kediri', 'category' => 'Kesehatan'],
            ['title' => 'Mahasiswa UNP Kediri Raih Juara 1 Hackathon Nasional di Jakarta', 'category' => 'Sains & Edukasi'],
            ['title' => 'Pusat Perbelanjaan Baru di Kediri Targetkan 5.000 Pengunjung per Hari', 'category' => 'Ekonomi & Bisnis'],
            ['title' => 'Presiden Kunjungi Proyek Strategis Nasional di Jawa Timur', 'category' => 'Nasional'],
            ['title' => 'Pelatihan Coding Gratis untuk Anak Muda Kediri Dibuka Hingga Desember', 'category' => 'Sains & Edukasi'],
            ['title' => 'Pasar Tradisional Pare Akan Direvitalisasi dengan Konsep Modern', 'category' => 'Ekonomi & Bisnis'],
            ['title' => 'Konferensi Tingkat Tinggi ASEAN Bahas Stabilitas Ekonomi Regional', 'category' => 'Internasional'],
            ['title' => 'Jaringan 5G Mulai Diuji Coba di Kawasan Industri Kediri', 'category' => 'Teknologi'],
            ['title' => 'Kasus Demam Berdarah Menurun Signifikan Setelah Vaksinasi Massal', 'category' => 'Kesehatan'],
            ['title' => 'Polres Kediri Tingkatkan Patroli Siber untuk Cegah Kejahatan Digital', 'category' => 'Nasional'],
            ['title' => 'Konser Musik K-Pop Pertama di Kediri Tarik Ratusan Penggemar', 'category' => 'Hiburan'],
            ['title' => 'Ekspor Produk UMKM Kediri ke Jepang Meningkat 25 Persen', 'category' => 'Ekonomi & Bisnis'],
            ['title' => 'Inovasi Chatbot Berbasis GPT Dikembangkan Mahasiswa Teknik Informatika', 'category' => 'Teknologi'],
            ['title' => 'Jalan Tol Kediri-Tulungagung Ditargetkan Rampung Akhir 2026', 'category' => 'Nasional'],
            ['title' => 'Wabah Virus Varian Baru di Eropa, Kemenkes Tingkatkan Kewaspadaan', 'category' => 'Internasional'],
            ['title' => 'Kedai Kopi Specialty di Pare Jadi Destinasi Favorit Anak Muda', 'category' => 'Gaya Hidup'],
            ['title' => 'Peluncuran Aplikasi PareGo untuk Transportasi Online Lokal', 'category' => 'Teknologi'],
            ['title' => 'Workshop Jurnalistik Digelar untuk Mahasiswa se-Kediri Raya', 'category' => 'Sains & Edukasi'],
            ['title' => 'Pertumbuhan Ekonomi Kediri Raya Kuartal I 2026 Capai 5,8 Persen', 'category' => 'Ekonomi & Bisnis'],
            ['title' => 'Museum Airlangga Kediri Luncurkan Tur Virtual Berbasis VR', 'category' => 'Teknologi'],
            ['title' => 'Parlemen Setujui RUU Perlindungan Data Pribadi yang Baru', 'category' => 'Politik'],
            ['title' => 'Pemerintah Dorong Digitalisasi UMKM Melalui Program Kediri Digital', 'category' => 'Ekonomi & Bisnis'],
            ['title' => 'Atlet Badminton Kediri Lolos Seleksi Timnas untuk Kejuaraan Asia', 'category' => 'Olahraga'],
            ['title' => 'Serangan Ransomware Targetkan Beberapa Instansi Pemerintah di Eropa', 'category' => 'Internasional'],
            ['title' => 'Kediri Innovation Hub Resmi Dibuka untuk Akselerasi Startup Lokal', 'category' => 'Teknologi'],
            ['title' => 'Tips Menjaga Kesehatan Mental di Tengah Padatnya Rutinitas Pekerjaan', 'category' => 'Kesehatan'],
            ['title' => 'Festival Tahu dan Tempe Kediri 2026 Sajikan 100 Varian Menu Kreatif', 'category' => 'Gaya Hidup'],
            ['title' => 'AI Generatif Mulai Dimanfaatkan Pelaku Bisnis Kediri untuk Marketing', 'category' => 'Teknologi'],
            ['title' => 'Pembangunan Bandara Dhoho Kediri Capai Progress 85 Persen', 'category' => 'Nasional'],
            ['title' => 'Film Dokumenter Sejarah Kediri Masuk Nominasi Festival Internasional', 'category' => 'Hiburan'],
            ['title' => 'Koperasi Digital Pertama di Kediri Layani 10.000 Anggota', 'category' => 'Ekonomi & Bisnis'],
            ['title' => 'Pelatihan Machine Learning untuk Guru SMA Diselenggarakan Diskominfo', 'category' => 'Sains & Edukasi'],
            ['title' => 'Wali Kota Kediri Resmikan Pusat Data Center Pertama di Kota', 'category' => 'Teknologi'],
            ['title' => 'Trend Olahraga Lari Pagi di Kawasan Simpang Lima Gumul Meningkat', 'category' => 'Olahraga'],
            ['title' => 'Partai Politik Mulai Panaskan Mesin Jelang Pemilu Serentak', 'category' => 'Politik'],
            ['title' => 'Kolaborasi Kampus dan Industri Hasilkan 15 Prototipe Teknologi Baru', 'category' => 'Teknologi'],
            ['title' => 'Bazar UMKM Digital di GOR Jayabaya Kediri Raup Omzet Miliaran Rupiah', 'category' => 'Ekonomi & Bisnis'],
            ['title' => 'PBB Desak Gencatan Senjata Segera di Kawasan Timur Tengah', 'category' => 'Internasional'],
            ['title' => 'Kediri Terpilih Sebagai Kota Percontohan Smart Village Nasional', 'category' => 'Nasional'],
            ['title' => 'Final Turnamen Basket Antar Kampus Jawa Timur Digelar di Kediri Mall', 'category' => 'Olahraga'],
        ];

        $categories = Category::all()->keyBy('name');
        $tags = Tag::all();

        foreach ($articleTemplates as $index => $template) {
            $author = $authors[$index % count($authors)];
            $category = $categories->get($template['category']) ?? $categories->first();

            $paragraphs = [];
            $numParagraphs = rand(8, 14);
            for ($i = 0; $i < $numParagraphs; $i++) {
                $paragraphs[] = fake('id_ID')->paragraph(rand(4, 8));
            }
            $content = implode("\n\n", $paragraphs);
            $excerpt = Str::limit($paragraphs[0], 200);

            $article = Article::create([
                'user_id' => $author->id,
                'category_id' => $category->id,
                'title' => $template['title'],
                'slug' => Str::slug($template['title']),
                'content' => $content,
                'excerpt' => $excerpt,
                'image' => null,
                'published_at' => now()->subDays(rand(0, 29))->subHours(rand(0, 23))->subMinutes(rand(0, 59)),
            ]);

            // Attach 1-3 random tags
            $randomTags = $tags->random(rand(1, 3))->pluck('id')->toArray();
            $article->tags()->attach($randomTags);
        }
    }
}
