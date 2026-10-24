# PRODUCT REQUIREMENTS DOCUMENT (PRD)
## Chatbot Rekomendasi Obat pada Sistem Informasi Apotek Berbasis Hybrid NLP

**Versi:** 1.0  
**Status:** Draft  
**Platform:** Web Application  
**Backend utama:** Laravel  
**Frontend:** Inertia.js + React  
**AI Service:** Python + FastAPI  
**Database:** MySQL  
**Pendekatan AI:** Hybrid NLP, Information Retrieval, Safety Rules, dan Machine Learning

---

## 1. Ringkasan Produk

Chatbot Rekomendasi Obat merupakan fitur berbasis kecerdasan buatan yang terintegrasi dengan Sistem Informasi Apotek. Sistem dirancang untuk membantu pengguna memperoleh informasi obat yang tersedia di apotek berdasarkan keluhan atau kebutuhan informasi yang disampaikan menggunakan bahasa alami.

Pengguna dapat menyampaikan keluhan melalui antarmuka percakapan. Chatbot kemudian memproses pesan menggunakan Natural Language Processing (NLP), mengidentifikasi maksud percakapan, mengajukan pertanyaan lanjutan apabila informasi belum mencukupi, dan mencari informasi yang relevan dari basis pengetahuan yang telah diverifikasi.

Informasi obat yang ditampilkan harus dicocokkan dengan katalog dan kondisi stok pada sistem apotek. Chatbot juga menerapkan aturan keselamatan untuk mendeteksi tanda bahaya, menghindari rekomendasi yang tidak didukung informasi memadai, serta mengarahkan pengguna kepada apoteker atau tenaga medis apabila diperlukan.

Sistem menggunakan pendekatan hybrid yang menggabungkan NLP, information retrieval, aturan keselamatan, dan pengembangan machine learning secara bertahap. Laravel berfungsi sebagai backend utama dan pengelola data apotek, sedangkan Python FastAPI menangani proses kecerdasan buatan.

## 2. Latar Belakang

Sistem informasi apotek umumnya menyediakan fitur untuk mengelola data obat, stok, transaksi, dan informasi produk. Namun, pengguna belum tentu mengetahui nama obat atau produk yang relevan dengan kebutuhan mereka.

Pencarian berdasarkan nama produk saja dapat menyulitkan pengguna yang hanya mengetahui keluhan atau gejala yang dialami. Oleh karena itu, diperlukan antarmuka percakapan yang memungkinkan pengguna menyampaikan kebutuhan menggunakan bahasa sehari-hari.

Chatbot diharapkan membantu menjembatani kebutuhan tersebut dengan informasi obat yang tersedia dalam sistem apotek. Agar jawaban tidak hanya bergantung pada keluaran model AI, sistem menggabungkan pemrosesan bahasa alami, pencarian informasi terverifikasi, validasi katalog, dan aturan keselamatan.

Pengembangan dilakukan secara bertahap, dimulai dari pembangunan basis data obat dan layanan percakapan dasar, kemudian dilanjutkan dengan retrieval, integrasi sistem, serta pengembangan dan evaluasi model machine learning.

## 3. Visi Produk

Membangun chatbot informasi dan rekomendasi kandidat obat yang mampu memahami kebutuhan pengguna melalui bahasa alami, menyajikan informasi berdasarkan sumber yang dapat ditelusuri, serta mempertimbangkan ketersediaan produk dan aspek keselamatan.

## 4. Tujuan Produk

1. Memudahkan pengguna mencari informasi obat melalui percakapan bahasa alami.
2. Menghubungkan kebutuhan informasi pengguna dengan katalog obat yang tersedia di apotek.
3. Menyediakan jawaban yang didukung oleh basis pengetahuan dan sumber informasi terverifikasi.
4. Menerapkan pemeriksaan keselamatan sebelum menampilkan informasi yang berpotensi memengaruhi keputusan kesehatan.
5. Mengurangi ketergantungan pada pencarian produk berdasarkan nama obat saja.
6. Menyediakan fondasi teknis untuk pengembangan machine learning dan evaluasi performa chatbot.

## 5. Target Pengguna

### 5.1 Pengunjung atau Pasien

Pengguna yang ingin mencari informasi obat, memahami informasi produk, atau menyampaikan keluhan untuk memperoleh panduan awal.

### 5.2 Apoteker atau Tenaga Kefarmasian

Pihak yang meninjau informasi obat, memastikan kelayakan konten, serta memberikan konsultasi ketika sistem tidak dapat menentukan informasi yang sesuai secara aman.

### 5.3 Administrator Apotek

Pihak yang mengelola data obat, kategori, stok, batch, tanggal kedaluwarsa, dan informasi pendukung yang digunakan sistem.

### 5.4 Pengembang atau Pengelola Sistem

Pihak yang memelihara layanan AI, mengelola konfigurasi, memantau kesalahan, serta melakukan evaluasi performa chatbot.

## 6. Ruang Lingkup Produk

### 6.1 Fitur dalam Ruang Lingkup

- Antarmuka chatbot berbasis web.
- Input keluhan dan pertanyaan menggunakan bahasa alami.
- Pengenalan intent atau maksud percakapan.
- Ekstraksi informasi relevan dari pesan pengguna.
- Pertanyaan lanjutan ketika informasi belum memadai.
- Pencarian informasi dari basis pengetahuan terverifikasi.
- Pencocokan kandidat produk dengan katalog obat apotek.
- Pemeriksaan status produk, stok, dan tanggal kedaluwarsa.
- Aturan keselamatan dan mekanisme rujukan.
- Penyimpanan riwayat percakapan sesuai kebijakan privasi.
- Pengelolaan data obat melalui sistem Laravel.
- Evaluasi dan pengembangan model klasifikasi intent.
- Pencatatan sumber informasi yang mendukung jawaban.

### 6.2 Fitur di Luar Ruang Lingkup Versi Awal

- Diagnosis penyakit secara otomatis.
- Peresepan obat oleh AI.
- Penentuan dosis individual tanpa validasi profesional.
- Penggantian obat resep secara otomatis.
- Pembelian dan pembayaran obat secara daring.
- Integrasi dengan rekam medis rumah sakit.
- Penggunaan model AI sebagai satu-satunya penentu kelayakan obat.
- Pengambilan keputusan klinis tanpa keterlibatan tenaga kesehatan.

Fitur di luar ruang lingkup dapat dipertimbangkan pada pengembangan berikutnya setelah kebutuhan, regulasi, dan aspek keselamatannya dievaluasi.

## 7. Teknologi yang Digunakan

| Komponen | Teknologi | Tanggung Jawab |
|---|---|---|
| Backend utama | Laravel | Pengelolaan data, autentikasi, validasi, dan integrasi layanan |
| Frontend | Inertia.js + React | Halaman sistem apotek dan antarmuka chatbot |
| Database | MySQL | Penyimpanan katalog, inventaris, dan percakapan |
| AI service | Python + FastAPI | Pemrosesan pesan dan orkestrasi chatbot |
| NLP | Python, spaCy, scikit-learn | Preprocessing dan klasifikasi intent |
| Retrieval | Pencarian teks dan BM25 | Pengambilan informasi relevan |
| Machine learning | scikit-learn | Pengembangan model klasifikasi intent |
| Validasi API | Laravel Validation dan Pydantic | Validasi request dan response |

Pemilihan library dan versinya ditetapkan pada tahap implementasi. Penggunaan LLM, embeddings, atau vector database bersifat opsional dan tidak diwajibkan pada versi awal.

## 8. Kebutuhan Fungsional

### FR-01 — Pengelolaan Kategori Obat

Administrator dapat menambah, melihat, memperbarui, dan menonaktifkan kategori obat.

**Kriteria penerimaan:**
- Kategori memiliki identitas unik dan nama.
- Nama kategori divalidasi agar tidak menimbulkan duplikasi yang tidak diinginkan.
- Kategori yang masih digunakan tidak dihapus secara sembarangan.

### FR-02 — Pengelolaan Data Obat

Administrator dapat mengelola identitas produk dan informasi dasar obat.

Data minimal meliputi nama, merek, bahan aktif, kekuatan, bentuk sediaan, klasifikasi, status aktif, dan nomor registrasi apabila relevan.

**Kriteria penerimaan:**
- Data wajib divalidasi.
- Informasi registrasi dan klasifikasi tidak boleh dikarang.
- Produk yang tidak aktif tidak ditampilkan sebagai kandidat produk yang dapat diperoleh.
- Informasi medis harus memiliki sumber yang dapat ditelusuri.

### FR-03 — Pengelolaan Stok dan Batch

Administrator dapat mengelola stok per batch dan tanggal kedaluwarsa.

**Kriteria penerimaan:**
- Sistem dapat menghitung stok yang layak tersedia.
- Batch kedaluwarsa tidak digunakan sebagai sumber stok tersedia.
- Produk dengan stok kosong tidak ditampilkan sebagai produk yang tersedia.
- Data stok berasal dari database utama, bukan prediksi AI.

### FR-04 — Antarmuka Chatbot

Pengguna dapat mengirim pesan dan menerima jawaban dalam antarmuka percakapan.

**Kriteria penerimaan:**
- Pesan pengguna dan jawaban sistem dapat dibedakan.
- Sistem menampilkan indikator proses dan pesan kesalahan yang informatif.
- Pengguna dapat memulai percakapan baru.
- Jawaban yang tidak tersedia dalam basis pengetahuan tidak boleh direkayasa.

### FR-05 — Pemrosesan Bahasa Alami

Sistem memproses pesan pengguna untuk mengidentifikasi maksud percakapan dan informasi yang relevan.

Intent awal meliputi:
- `greeting`
- `describe_symptom`
- `ask_medicine_info`
- `ask_stock`
- `ask_usage_info`
- `unknown_intent`

**Kriteria penerimaan:**
- Pesan yang tidak dipahami dapat dikenali sebagai intent tidak diketahui.
- Sistem dapat meminta klarifikasi ketika informasi tidak cukup.
- Klasifikasi intent tidak dianggap sebagai diagnosis medis.
- Pesan ambigu tidak langsung menghasilkan rekomendasi obat.

### FR-06 — Pengelolaan Dialog

Chatbot dapat mempertahankan konteks percakapan dalam satu sesi.

**Kriteria penerimaan:**
- Pesan lanjutan dikaitkan dengan sesi yang benar.
- Sistem hanya menggunakan informasi yang relevan dan diperlukan.
- Konteks sesi tidak tercampur dengan sesi pengguna lain.
- Pengguna dapat mengakhiri percakapan.

### FR-07 — Retrieval Informasi

Sistem mencari informasi relevan dari basis pengetahuan yang telah diverifikasi.

**Kriteria penerimaan:**
- Informasi yang dikembalikan memiliki referensi sumber.
- Dokumen yang tidak relevan tidak digunakan hanya karena mengandung kata yang sama.
- Sistem tidak menghasilkan klaim medis yang tidak didukung sumber.
- Ketika tidak ditemukan informasi memadai, sistem meminta klarifikasi atau memberikan rujukan.

### FR-08 — Pencocokan Kandidat Produk

Sistem mencocokkan hasil retrieval dengan produk yang tercatat dalam katalog apotek.

**Kriteria penerimaan:**
- Setiap kandidat memiliki ID produk yang valid.
- Status produk dan stok diperiksa kembali oleh Laravel.
- Informasi kedaluwarsa dan klasifikasi diperhitungkan.
- Kecocokan teks tidak dianggap sebagai bukti kesesuaian klinis.

### FR-09 — Pemeriksaan Keselamatan

Sistem menerapkan aturan keselamatan sebelum memberikan respons.

**Kriteria penerimaan:**
- Tanda bahaya yang dikenali memicu arahan pertolongan medis yang sesuai.
- Sistem tidak terus mencari obat apabila kondisi memerlukan rujukan segera.
- Informasi mengenai alergi, usia, kehamilan, kondisi kesehatan, atau penggunaan obat lain ditangani sesuai kebutuhan dan risiko.
- Sistem tidak menyimpulkan bahwa suatu obat aman hanya karena tersedia di apotek.
- Aturan kritis memiliki dokumentasi, versi, pengujian, dan proses peninjauan profesional.

### FR-10 — Penyusunan Respons

Sistem menyusun jawaban berdasarkan intent, hasil retrieval, status keselamatan, dan validasi katalog.

**Kriteria penerimaan:**
- Respons memiliki format terstruktur.
- Sumber pendukung dapat ditelusuri.
- Informasi ketersediaan sesuai dengan data inventaris terbaru.
- Sistem dapat memberikan respons berupa klarifikasi, informasi produk, atau rujukan.
- Sistem tidak memberikan kepastian diagnosis.

### FR-11 — Riwayat Percakapan

Sistem dapat menyimpan riwayat percakapan sesuai kebutuhan operasional.

**Kriteria penerimaan:**
- Riwayat terhubung dengan sesi yang benar.
- Akses dibatasi sesuai hak pengguna.
- Informasi kesehatan tidak disimpan lebih lama dari yang diperlukan.
- Kebijakan retensi dan penghapusan tersedia.

### FR-12 — Pengembangan Machine Learning

Sistem mendukung pengembangan model klasifikasi intent menggunakan dataset yang telah dianotasi.

**Kriteria penerimaan:**
- Dataset memiliki definisi label yang jelas.
- Data pelatihan, validasi, dan pengujian dipisahkan.
- Model dievaluasi menggunakan metrik yang sesuai.
- Model dapat dibandingkan dengan baseline berbasis aturan.
- Model tidak menggantikan aturan keselamatan yang wajib dijalankan.

## 9. Kebutuhan Nonfungsional

### NFR-01 — Keamanan

- Komunikasi menggunakan HTTPS pada lingkungan produksi.
- Layanan internal FastAPI dilindungi autentikasi antarlayanan.
- Secret key disimpan pada environment variables atau secret manager.
- Validasi input diterapkan pada setiap endpoint.
- Akses sesi percakapan dan data administrasi diperiksa berdasarkan hak akses.

### NFR-02 — Privasi

- Data pribadi dan kesehatan diminimalkan.
- Pengguna memperoleh informasi mengenai pemrosesan datanya.
- Riwayat percakapan memiliki aturan retensi dan penghapusan.
- Data untuk pelatihan tidak digunakan tanpa dasar dan pengamanan yang sesuai.

### NFR-03 — Kinerja

Target awal yang diusulkan:
- Respons endpoint non-AI: p95 di bawah 500 ms pada lingkungan uji yang ditentukan.
- Respons chatbot: p95 di bawah 5 detik untuk permintaan sederhana, tidak termasuk kondisi gangguan jaringan atau model eksternal.

Target ini merupakan sasaran pengujian awal, bukan jaminan performa.

### NFR-04 — Keandalan

- Layanan AI memiliki timeout dan penanganan error.
- Kegagalan FastAPI tidak menyebabkan sistem mengarang jawaban.
- Kesalahan integrasi dapat ditelusuri melalui log.
- Operasi inventaris menggunakan database Laravel sebagai sumber data utama.

### NFR-05 — Maintainability

- Backend Laravel dan AI service dipisahkan.
- API memiliki skema request dan response yang terdokumentasi.
- Modul NLP, retrieval, safety, dan response builder dipisahkan.
- Migration dan perubahan skema database dikelola melalui version control.

### NFR-06 — Usability

- Antarmuka percakapan mudah dipahami.
- Pesan kesalahan menggunakan bahasa yang jelas.
- Informasi produk dan peringatan mudah dibedakan.
- Tampilan dapat digunakan melalui desktop maupun perangkat seluler.

## 10. Arsitektur Sistem

Arsitektur menggunakan pendekatan client-server dengan layanan AI terpisah.

1. React menampilkan antarmuka chatbot melalui Inertia.js.
2. Laravel menerima pesan, memvalidasi sesi, dan menyimpan pesan sesuai kebijakan.
3. Laravel mengirim permintaan terstruktur kepada FastAPI.
4. FastAPI menjalankan NLP, pemeriksaan keselamatan, dan retrieval.
5. Hasil pemrosesan dikembalikan kepada Laravel.
6. Laravel memvalidasi kembali kandidat produk dan kondisi stok.
7. Respons disimpan dan dikirim ke frontend.

Laravel menjadi sumber kebenaran untuk data produk dan inventaris. FastAPI tidak boleh mengubah stok secara langsung.

### Endpoint Laravel

| Method | Endpoint | Fungsi |
|---|---|---|
| GET | `/medicines` | Menampilkan katalog |
| POST | `/medicines` | Menambahkan obat |
| PUT | `/medicines/{id}` | Memperbarui obat |
| POST | `/chat/sessions` | Membuat sesi |
| POST | `/chat/sessions/{id}/messages` | Mengirim pesan |
| GET | `/chat/sessions/{id}/messages` | Mengambil riwayat |

### Endpoint FastAPI

| Method | Endpoint | Fungsi |
|---|---|---|
| GET | `/health` | Memeriksa status layanan |
| POST | `/internal/chat/respond` | Memproses percakapan |
| POST | `/internal/search/knowledge` | Mencari basis pengetahuan |

Endpoint internal tidak boleh dapat diakses tanpa otorisasi yang sesuai.

## 11. Rancangan Basis Data

### Tabel `categories`

Menyimpan kategori produk.

Atribut utama:
- `id`
- `name`
- `description`
- `created_at`
- `updated_at`

### Tabel `medicines`

Menyimpan identitas produk.

Atribut utama:
- `id`
- `category_id`
- `name`
- `brand`
- `active_ingredients`
- `strength`
- `dosage_form`
- `registration_number`
- `classification`
- `is_active`
- `created_at`
- `updated_at`

### Tabel `medicine_batches`

Menyimpan informasi stok per batch.

Atribut utama:
- `id`
- `medicine_id`
- `batch_number`
- `stock_quantity`
- `expiry_date`
- `created_at`
- `updated_at`

### Tabel `knowledge_documents`

Menyimpan referensi pengetahuan yang digunakan retrieval.

Atribut utama:
- `id`
- `title`
- `source_name`
- `source_url`
- `document_type`
- `version`
- `review_status`
- `reviewed_at`

### Tabel `medicine_knowledge`

Menyimpan informasi terverifikasi yang dikaitkan dengan obat.

Atribut utama:
- `id`
- `medicine_id`
- `knowledge_document_id`
- `approved_indications`
- `contraindications`
- `warnings`
- `reviewed_by`
- `reviewed_at`

### Tabel `safety_rules`

Menyimpan aturan keselamatan.

Atribut utama:
- `id`
- `rule_code`
- `description`
- `severity`
- `condition_definition`
- `action`
- `version`
- `is_active`

### Tabel `chat_sessions`

Menyimpan metadata sesi percakapan.

Atribut utama:
- `id`
- `user_id` nullable
- `status`
- `created_at`
- `updated_at`

### Tabel `chat_messages`

Menyimpan pesan percakapan.

Atribut utama:
- `id`
- `session_id`
- `sender`
- `message`
- `created_at`

Skema akhir dapat disesuaikan dengan kebutuhan sistem. Data medis yang kritis harus terstruktur dan memiliki sumber yang jelas, bukan hanya disimpan sebagai teks bebas.

## 12. Strategi NLP, Retrieval, dan Machine Learning

### Tahap 1 — NLP Dasar

Melakukan normalisasi teks, pembersihan karakter yang tidak diperlukan, tokenisasi bila relevan, serta klasifikasi intent berbasis aturan.

Tahap ini bertujuan membangun baseline yang mudah diuji.

### Tahap 2 — Retrieval

Membangun pencarian kata kunci terhadap dokumen terverifikasi. Setelah baseline berfungsi, pencarian dapat dikembangkan menggunakan BM25 untuk meningkatkan relevansi dokumen.

### Tahap 3 — Machine Learning

Mengumpulkan contoh pesan yang merepresentasikan variasi bahasa pengguna. Data dapat berupa contoh sintetis yang ditinjau dan dianotasi, serta data nyata yang penggunaannya memiliki dasar dan pengamanan yang sesuai.

Model awal dapat berupa TF-IDF dengan Logistic Regression atau Linear SVM untuk klasifikasi intent.

Evaluasi meliputi:
- Accuracy.
- Precision.
- Recall.
- Macro F1-score.
- Confusion matrix.
- Evaluasi khusus terhadap intent yang berkaitan dengan keselamatan.

### Tahap 4 — Evaluasi dan Pengembangan

Bandingkan performa model dengan baseline, uji pesan ambigu, variasi bahasa, salah ketik, serta pesan yang mengandung tanda bahaya.

Machine learning digunakan untuk meningkatkan pemahaman bahasa, bukan untuk menggantikan sumber medis terverifikasi atau aturan keselamatan.

## 13. Alur Utama Pengguna

1. Pengguna membuka halaman chatbot.
2. Pengguna memasukkan pertanyaan atau keluhan.
3. Sistem mengidentifikasi intent dan mengekstrak informasi relevan.
4. Sistem memeriksa apakah pesan mengandung tanda bahaya yang dikenali.
5. Jika terdapat kondisi yang memerlukan rujukan, sistem memberikan arahan yang sesuai.
6. Jika informasi belum cukup, chatbot mengajukan pertanyaan lanjutan.
7. Jika pencarian dapat dilanjutkan, sistem mengambil informasi dari basis pengetahuan.
8. Kandidat produk dicocokkan dengan katalog apotek.
9. Sistem memvalidasi status produk dan stok.
10. Chatbot menampilkan informasi yang didukung sumber, atau menyatakan bahwa informasi yang memadai belum tersedia.
11. Pengguna dapat melanjutkan percakapan atau mengakhiri sesi.

## 14. Kriteria Keberhasilan Produk

Keberhasilan sistem tidak hanya diukur dari kemampuan menghasilkan jawaban, tetapi juga dari ketepatan informasi dan keselamatannya.

Indikator evaluasi:
- Intent pengguna dapat diklasifikasikan secara memadai.
- Retrieval mengembalikan sumber yang relevan.
- Informasi ketersediaan produk sesuai database.
- Tidak ada kandidat yang berasal dari produk tidak aktif atau batch kedaluwarsa.
- Respons memiliki sumber yang dapat ditelusuri.
- Kasus tanda bahaya yang telah ditentukan dalam skenario pengujian menghasilkan tindakan rujukan yang diharapkan.
- Sistem tidak memberikan rekomendasi tanpa dukungan informasi yang memadai.
- Pengguna dapat menyelesaikan pencarian informasi dengan antarmuka yang mudah dipahami.

Target numerik untuk metrik NLP dan retrieval ditetapkan setelah dataset evaluasi tersedia. Kasus keselamatan kritis harus diuji secara terpisah dan tidak cukup dinilai hanya menggunakan accuracy keseluruhan.

## 15. Risiko dan Mitigasi

| Risiko | Mitigasi |
|---|---|
| Data obat belum tersedia | Bangun skema database dan gunakan data dummy untuk pengujian teknis |
| Dataset NLP terbatas | Mulai dari rule-based baseline, lalu kumpulkan data beranotasi |
| AI menghasilkan informasi yang keliru | Gunakan retrieval terverifikasi, validasi, dan respons terbatas |
| Rekomendasi tidak sesuai kondisi pengguna | Ajukan klarifikasi dan rujuk kepada tenaga kesehatan |
| Stok tidak akurat | Gunakan Laravel sebagai sumber inventaris utama |
| Produk kedaluwarsa ikut direkomendasikan | Validasi stok per batch dan tanggal kedaluwarsa |
| Layanan AI gagal | Terapkan timeout, logging, dan pesan kegagalan yang aman |
| Kebocoran data percakapan | Terapkan pembatasan akses, minimisasi data, dan kebijakan retensi |
| Dataset bias atau tidak representatif | Evaluasi variasi bahasa, salah ketik, dan skenario pengguna yang berbeda |

## 16. Tahapan Pengembangan

### Sprint 1 — Fondasi Sistem Apotek

- Membuat migration kategori, obat, dan batch.
- Membuat model dan relasi Eloquent.
- Membuat CRUD obat.
- Membuat validasi stok dan kedaluwarsa.

### Sprint 2 — Fondasi AI Service

- Membuat proyek FastAPI.
- Membuat endpoint health dan endpoint percakapan.
- Membuat skema Pydantic.
- Membuat preprocessing dan intent awal.

### Sprint 3 — Knowledge Retrieval dan Safety

- Menentukan sumber pengetahuan terverifikasi.
- Membuat struktur dokumen.
- Mengembangkan pencarian informasi.
- Membuat dan menguji aturan keselamatan.

### Sprint 4 — Integrasi Sistem

- Menghubungkan Laravel dengan FastAPI.
- Membuat sesi percakapan dan penyimpanan pesan.
- Membuat UI chatbot dengan Inertia React.
- Menghubungkan hasil pencarian dengan katalog obat.

### Sprint 5 — Machine Learning dan Pengujian

- Menyusun dataset intent.
- Melatih model baseline.
- Melakukan evaluasi model.
- Menguji integrasi, keamanan, dan skenario keselamatan.
- Menyiapkan dokumentasi dan deployment.

Durasi sprint ditetapkan sesuai jadwal pengerjaan, kompleksitas, dan ketersediaan data.

## 17. Asumsi dan Ketergantungan

- Proyek menggunakan Laravel dan Inertia React.
- Python FastAPI berjalan sebagai layanan terpisah.
- MySQL menjadi database utama pada rancangan awal.
- Data obat belum tersedia dan perlu dibuat melalui fitur administrasi.
- Informasi medis harus diperoleh dari sumber yang kredibel dan ditinjau secara memadai.
- Pengembangan model machine learning dilakukan setelah kebutuhan label dan dataset ditetapkan.
- Sistem tidak menggantikan konsultasi dengan dokter atau apoteker.

## 18. Kesimpulan

Chatbot Rekomendasi Obat dirancang sebagai fitur pendukung Sistem Informasi Apotek yang menggabungkan NLP, retrieval informasi terverifikasi, aturan keselamatan, dan pengembangan machine learning secara bertahap.

Laravel menjadi pusat pengelolaan data dan inventaris, React menyediakan antarmuka pengguna, sedangkan Python FastAPI menangani pemrosesan bahasa dan orkestrasi AI. Pemisahan ini memungkinkan pengembangan yang modular, terukur, dan mudah diuji.

Prioritas implementasi adalah membangun struktur data obat, memastikan integritas inventaris, menyusun basis pengetahuan yang dapat ditelusuri, dan menerapkan pemeriksaan keselamatan sebelum mengembangkan model machine learning yang lebih kompleks.

Dengan pendekatan tersebut, sistem diharapkan mampu membantu pengguna menemukan informasi obat yang relevan dan tersedia di apotek tanpa menjadikan AI sebagai pengganti penilaian profesional kesehatan.
