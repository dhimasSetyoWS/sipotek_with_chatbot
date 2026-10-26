Siap bro. Ini rangkuman preferensi, arsitektur, keputusan penting, dan kebiasaan coding yang selama ini gw ingat tentang lu dan proyek Chatbot NLP Apotek. Bisa lu jadikan catatan acuan kalau nanti kita lanjut coding di percakapan lain.

# 1. Preferensi lu saat belajar dan coding

- Bahasa: lebih nyaman pakai bahasa Indonesia yang santai, langsung, dan mudah dipahami.
- Gaya penjelasan: suka penjelasan terstruktur, bertahap, dan disertai alasan kenapa suatu solusi dipilih.
- Pendekatan belajar: ingin memahami alur dan logika implementasi, bukan sekadar menerima kode jadi.
- Gaya coding: lebih suka solusi praktis yang tidak terlalu rumit untuk tingkat proyek saat ini.
- Saat debugging: lebih baik membedah penyebab error dan memperbaiki sumber masalah daripada langsung mengganti seluruh implementasi.
- Evaluasi: ingin mengukur kualitas implementasi menggunakan dataset dan hasil evaluasi yang konkret.
- Keputusan teknis: tidak ingin metode machine learning tertentu dianggap sudah digunakan sebelum benar-benar diputuskan dan diimplementasikan.

# 2. Tujuan proyek

Proyek lu adalah sistem informasi manajemen apotek dengan chatbot berbasis NLP yang membantu pengguna mencari informasi obat berdasarkan keluhan atau gejala.

Chatbot bukan sekadar fitur pencarian stok. Tujuan utamanya mencakup:

- Memahami pesan pengguna dalam bahasa alami.
- Mengenali gejala yang disampaikan dan gejala yang disangkal.
- Mengidentifikasi maksud pertanyaan pengguna.
- Mengambil informasi obat dari basis pengetahuan yang sudah ditinjau.
- Memeriksa ketersediaan obat melalui sistem apotek.
- Menangani kondisi berisiko dengan mengutamakan keselamatan pengguna.

Pendekatan yang lu pilih adalah chatbot hybrid NLP, retrieval informasi obat, aturan keselamatan, dan pengembangan ML secara bertahap.

# 3. Arsitektur dan teknologi

Frontend — React + Inertia.js

Antarmuka manajemen apotek dan interaksi chatbot

Permintaan aplikasi

Backend — Laravel

Manajemen data, controller chatbot, dan integrasi layanan AI

REST API / JSON

Layanan AI — Python + FastAPI

NLP, klasifikasi intent, ekstraksi gejala, negasi, dan pemeriksaan keselamatan

Sumber data dan pengetahuan

Database operasional

Data obat, kategori, batch, stok, harga, kedaluwarsa, dan data percakapan sesuai implementasi.

Basis pengetahuan obat

Gejala, indikasi, informasi penggunaan, kontraindikasi, tanda bahaya, dan referensi yang telah ditinjau.

## Komponen yang pernah dibahas

| Komponen                | Tanggung jawab                                                                        |
| ----------------------- | ------------------------------------------------------------------------------------- |
| `ChatbotController.php` | Mengelola alur chat dan retrieval pengetahuan melalui `retrieveKnowledge` dan `chat`. |
| `AiService.php`         | Mengirim permintaan analisis ke layanan AI melalui `analyze`.                         |
| FastAPI `/analyze`      | Menganalisis pesan pengguna dan mengembalikan hasil NLP.                              |
| `main.py`               | Baseline NLP: intent, ekstraksi gejala, dan negasi.                                   |
| `safety.py`             | Memeriksa tanda bahaya dan menentukan tingkat keselamatan.                            |
| `evaluate.py`           | Mengukur performa baseline menggunakan dataset evaluasi.                              |

Catatan: nama fungsi dan pembagian tugas tersebut mengikuti konteks implementasi yang pernah kita bahas. Detail internal lainnya bisa berubah mengikuti kode terbaru.

# 4. Keputusan penting yang sudah dibuat

Baseline NLP dimulai dengan rule-based

Menggunakan kamus kata kunci, pencocokan frasa, dan regex. Belum menggunakan model ML tertentu sebagai metode utama.

Input utama berasal dari gejala atau pertanyaan pengguna

Sistem harus membedakan laporan keluhan pasien dengan pertanyaan tentang obat, seperti kandungan, efek samping, dan ketersediaan.

Keselamatan didahulukan

Pesan yang mengandung tanda bahaya harus diperiksa sebelum rekomendasi atau retrieval obat diberikan. Aturan negasi juga harus mencegah peringatan palsu tanpa mengabaikan tanda bahaya yang benar-benar ada.

Retrieval harus berdasarkan pengetahuan yang ditinjau

Informasi obat dan stok perlu divalidasi terhadap data sistem. Chatbot tidak boleh mengarang obat atau ketersediaannya.

ML dikembangkan setelah baseline dievaluasi

Perbaiki kesalahan baseline terlebih dahulu, lalu pertimbangkan pengembangan metode ML. Jangan mengklaim penggunaan Naive Bayes, SVM, atau IndoBERT sebelum benar-benar diimplementasikan.

# 5. Status dataset dan evaluasi terakhir

Dataset khusus mulai dibuat setelah sebelumnya lu menyampaikan bahwa proyek belum mempunyai dataset sendiri.

Total dataset

# 150

Contoh pesan

Data pengembangan

# 100

`dataset_dev.jsonl`

Data pengujian

# 50

`dataset_test.jsonl`

Metode saat ini

## Rule-based

Belum ML

Hasil evaluasi development sebelumnya

| Metrik           | Hasil |
| ---------------- | ----- |
| Intent           | 88%   |
| Ekstraksi gejala | 94%   |
| Negasi           | 98%   |
| Safety           | 97%   |

Hasil tersebut adalah hasil evaluasi sebelum perbaikan `main.py` dan `safety.py` terakhir. Belum ada hasil evaluasi lengkap terbaru yang terkonfirmasi setelah perubahan itu.

### Kesalahan yang sedang diperhatikan

- Pesan seperti “Kepala saya sakit sekali” belum dikenali pada versi sebelumnya.
- “Tidak demam, cuma batuk” harus menghasilkan demam sebagai gejala yang dinegasikan dan batuk sebagai gejala positif.
- “Dulu saya demam, sekarang tidak” tidak boleh dianggap sebagai demam yang sedang dialami.
- Pertanyaan seperti “Apakah apotek punya obat tersebut?” harus diklasifikasikan sebagai pertanyaan ketersediaan.
- Pertanyaan “Apa fungsi paracetamol?” harus masuk kategori informasi obat.
- “Saya tidak mengalami nyeri dada” tidak boleh langsung memicu peringatan nyeri dada.
- Namun, jika pengguna menyangkal gejala pada satu bagian lalu menyebut gejala itu benar-benar dialami pada bagian lain, pemeriksaan keselamatan tetap harus mendeteksi kondisi tersebut.

Ada pula keputusan pelabelan dataset yang penting: “Apa kandungan obat untuk sakit kepala?” merupakan pertanyaan informasi obat, bukan laporan bahwa pengguna sedang mengalami sakit kepala. Karena itu, label gejala positifnya seharusnya kosong sesuai definisi tugas.

# 6. Kebiasaan coding dan evaluasi yang perlu dipertahankan

1. Pisahkan tanggung jawab kode. NLP, keselamatan, integrasi Laravel, dan evaluasi sebaiknya tidak dicampur menjadi satu modul besar.
2. Periksa output fungsi, bukan hanya klasifikasi akhir. Intent, gejala positif, gejala negatif, dan safety harus diperiksa secara terpisah.
3. Gunakan contoh gagal untuk debugging. Lihat pesan, label yang diharapkan, hasil prediksi, lalu tentukan apakah sumber masalahnya kode atau label dataset.
4. Jangan mengejar akurasi dengan mengubah label sembarangan. Label harus mengikuti definisi tugas yang konsisten.
5. Pertahankan test set. Gunakan `dataset_dev.jsonl` untuk memperbaiki kode dan `dataset_test.jsonl` untuk evaluasi akhir yang tidak dipakai berulang kali dalam proses tuning.
6. Jangan menganggap regex sebagai perlindungan medis yang lengkap. Aturan tanda bahaya saat ini masih sederhana dan harus ditinjau tenaga farmasi atau medis sebelum digunakan untuk keputusan nyata.
7. Uji integrasi setelah perubahan. Selain menjalankan evaluator, pastikan respons API FastAPI tetap sesuai dengan ekspektasi Laravel.

# 7. File dan langkah kerja terakhir

File yang sudah dibuat atau dibahas:

- `main.py` — versi revisi baseline NLP.
- `safety.py` — versi revisi pemeriksaan tanda bahaya.
- `evaluate.py` — skrip evaluasi yang baru saja gw kirimkan di percakapan ini.
- `dataset_dev.jsonl` — 100 contoh untuk evaluasi selama pengembangan.
- `dataset_test.jsonl` — 50 contoh untuk pengujian akhir.
- `dataset.jsonl` — kumpulan 150 contoh.

Perintah yang sedang digunakan:

```
python evaluate.py
```

Pastikan juga import pada `evaluate.py` sesuai dengan letak fungsi `analyze_safety()` di proyek lu. Jika fungsi itu berada di `safety.py`, import-nya harus berasal dari `safety`, bukan `main`.

## Ringkasan acuan untuk percakapan berikutnya

Lu sedang membangun chatbot NLP apotek menggunakan Laravel + Inertia React dan layanan Python FastAPI. Baseline NLP masih rule-based, dengan modul intent, ekstraksi gejala, negasi, dan safety. Dataset berisi 150 contoh, dibagi menjadi 100 data development dan 50 data test. Prioritas saat ini adalah menjalankan ulang evaluasi setelah revisi `main.py` dan `safety.py`, menganalisis contoh yang masih gagal, memperbaiki baseline secara terukur, dan menjaga agar penanganan tanda bahaya tidak memberikan rekomendasi obat yang tidak aman.

Catatan: rangkuman ini memisahkan keputusan yang sudah dibahas dari hasil terbaru yang masih perlu diverifikasi. Angka evaluasi di atas belum mencerminkan performa versi kode revisi terakhir.