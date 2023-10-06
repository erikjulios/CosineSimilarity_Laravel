teks A : Penelitian ini dilatarbelakangi oleh data observasi yang menunjukkan perolehan hasil belajar siswa pada materi IPA sangat rendah. Untuk merespons hal itu maka peneliti melakukan penelitian tindakan kelas yang bertujuan untuk meningkatkan hasil belajar siswa. 
teks B : Satu di antara tujuan pembangunan nasional adalah menurunkan tingkat kemiskinan bangsanya. Hal ini karena kemiskinan merupakan satu di antara masalah ekonomi yang harus segera diatasi. 
buatlah perhitungan manual tanpa script  dengan menghilangkan stopword dan tanda baca terhadap kedua teks tersebut dengan cosine similarity





Untuk melakukan perhitungan cosine similarity antara kedua teks, kita perlu menghilangkan stopwords dan tanda baca terlebih dahulu. Setelah itu, kita dapat menghitung kedua vektor dan kemudian melakukan perhitungan cosine similarity.

Setelah menghilangkan stopwords dan tanda baca, teks A menjadi:
Teks A: "Penelitian dilatarbelakangi data observasi menunjukkan perolehan hasil belajar siswa materi IPA rendah merespons peneliti melakukan penelitian tindakan kelas bertujuan meningkatkan hasil belajar siswa"

Teks B: "Satu tujuan pembangunan nasional menurunkan tingkat kemiskinan bangsanya kemiskinan masalah ekonomi diatasi"

Selanjutnya, kita dapat menghitung kedua vektor sebagai berikut:

Teks A: {'penelitian': 1, 'dilatarbelakangi': 1, 'data': 1, 'observasi': 1, 'menunjukkan': 1, 'perolehan': 1, 'hasil': 2, 'belajar': 2, 'siswa': 2, 'materi': 1, 'IPA': 1, 'rendah': 1, 'merespons': 1, 'tindakan': 1, 'kelas': 1, 'bertujuan': 1, 'meningkatkan': 1}

Teks B: {'tujuan': 1, 'pembangunan': 1, 'nasional': 1, 'menurunkan': 1, 'tingkat': 1, 'kemiskinan': 2, 'bangsanya': 1, 'masalah': 1, 'ekonomi': 1, 'diatasi': 1}

Selanjutnya, kita akan menghitung dot product dari kedua vektor:

Dot Product = (1 * 1) + (1 * 1) + (1 * 1) + (1 * 1) + (1 * 1) + (1 * 1) + (2 * 2) + (2 * 2) + (2 * 2) + (1 * 1) + (1 * 1) + (1 * 1) + (1 * 1) + (1 * 1) + (1 * 1) + (1 * 1) + (1 * 1)

Dot Product = 1 + 1 + 1 + 1 + 1 + 1 + 4 + 4 + 4 + 1 + 1 + 1 + 1 + 1 + 1 + 1

Dot Product = 23

Dalam perhitungan cosine similarity, kita juga perlu menghitung magnitude dari masing-masing vektor:

Magnitude Teks A = sqrt((1^2) + (1^2) + (1^2) + (1^2) + (1^2) + (1^2) + (2^2) + (2^2) + (2^2) + (1^2) + (1^2) + (1^2) + (1^2) + (1^2) + (1^2) + (1^2) + (1^2))

Magnitude Teks A = sqrt(1 + 1 + 1 + 1 + 1 + 1 + 4 + 4 + 4 + 1 + 1 + 1 + 1 + 1 + 1 + 1 + 1)

Magnitude Teks A = sqrt(29)

Magnitude Teks B = sqrt((1^2) + (1^2) + (1^2) + (1^2) + (1^2) + (2^2) + (1^2) + (1^2) + (1^2) + (1^2))

Magnitude Teks B = sqrt(1 + 1 + 1 + 1 + 1 + 4 + 1 + 1 + 1 + 1)

Magnitude Teks B = sqrt(12)

Terakhir, kita dapat menghitung cosine similarity dengan rumus:

Cosine Similarity = Dot Product / (Magnitude Teks A * Magnitude Teks B)

Cosine Similarity = 23 / (sqrt(29) * sqrt(12))

Cosine Similarity ≈ 0.743

Jadi, cosine similarity antara Teks A dan Teks B adalah sekitar 0.743.