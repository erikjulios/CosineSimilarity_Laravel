Langkah 1: Memisahkan tanda baca
Menghapus tanda baca dari kedua dokumen:
doc1 = "Penelitian ini dilatarbelakangi oleh data observasi yang menunjukkan perolehan hasil belajar siswa pada materi IPA sangat rendah Untuk merespons hal itu maka peneliti melakukan penelitian tindakan kelas yang bertujuan untuk meningkatkan hasil belajar siswa"
doc2 = "Satu di antara tujuan pembangunan nasional adalah menurunkan tingkat kemiskinan bangsanya Hal ini karena kemiskinan merupakan satu di antara masalah ekonomi yang harus segera diatasi"

Langkah 2: Membuat array dari kata-kata
Membuat array dari kata-kata di kedua dokumen:
doc1_word = ["penelitian", "ini", "dilatarbelakangi", "oleh", "data", "observasi", "yang", "menunjukkan", "perolehan", "hasil", "belajar", "siswa", "pada", "materi", "ipa", "sangat", "rendah", "untuk", "merespons", "hal", "itu", "maka", "peneliti", "melakukan", "penelitian", "tindakan", "kelas", "yang", "bertujuan", "untuk", "meningkatkan", "hasil", "belajar", "siswa"]
doc2_word = ["satu", "di", "antara", "tujuan", "pembangunan", "nasional", "adalah", "menurunkan", "tingkat", "kemiskinan", "bangsanya", "hal", "ini", "karena", "kemiskinan", "merupakan", "satu", "di", "antara", "masalah", "ekonomi", "yang", "harus", "segera", "diatasi"]

Langkah 3: Menghapus stopwords
Tidak ada langkah ini dalam fungsi yang diberikan.

Langkah 4: Menghitung pembobotan
Menghitung jumlah kemunculan setiap kata dalam array kata-kata:
doc1_weights = ["penelitian" => 2, "ini" => 1, "dilatarbelakangi" => 1, "oleh" => 1, "data" => 1, "observasi" => 1, "yang" => 2, "menunjukkan" => 1, "perolehan" => 1, "hasil" => 2, "belajar" => 2, "siswa" => 2, "pada" => 1, "materi" => 1, "ipa" => 1, "sangat" => 1, "rendah" => 1, "untuk" => 2, "merespons" => 1, "hal" => 1, "itu" => 1, "maka" => 1, "tindakan" => 1, "kelas" => 1, "bertujuan" => 1, "meningkatkan" => 1]
doc2_weights = ["satu" => 2, "di" => 2, "antara" => 2, "tujuan" => 1, "pembangunan" => 1, "nasional" => 1, "adalah" => 1, "menurunkan" => 1, "tingkat" => 1, "kemiskinan" => 2, "bangsanya" => 1, "hal" => 1, "ini" => 1, "karena" => 1, "merupakan" => 1, "masalah" => 1, "ekonomi" => 1, "yang" => 1, "harus" => 1, "segera" => 1, "diatasi" => 1]

Langkah 5: Mengambil kata-kata unik
Menggabungkan array kata-kata dari doc1_word dan doc2_word, kemudian menghapus kata-kata duplikat:
unique_words = ["penelitian", "ini", "dilatarbelakangi", "oleh", "data", "observasi", "yang", "menunjukkan", "perolehan", "hasil", "belajar", "siswa", "pada", "materi", "ipa", "sangat", "rendah", "untuk", "merespons", "hal", "itu", "maka", "tindakan", "kelas", "bertujuan", "meningkatkan", "satu", "di", "antara", "tujuan", "pembangunan", "nasional", "adalah", "menurunkan", "tingkat", "kemiskinan", "bangsanya", "karena", "merupakan", "masalah", "ekonomi", "harus", "segera", "diatasi"]

Langkah 6: Inisialisasi vektor dokumen
Mengisi vektor dokumen dengan 0 untuk setiap kata unik:
doc1_vector = ["penelitian" => 0, "ini" => 0, "dilatarbelakangi" => 0, "oleh" => 0, "data" => 0, "observasi" => 0, "yang" => 0, "menunjukkan" => 0, "perolehan" => 0, "hasil" => 0, "belajar" => 0, "siswa" => 0, "pada" => 0, "materi" => 0, "ipa" => 0, "sangat" => 0, "rendah" => 0, "untuk" => 0, "merespons" => 0, "hal" => 0, "itu" => 0, "maka" => 0, "tindakan" => 0, "kelas" => 0, "bertujuan" => 0, "meningkatkan" => 0, "satu" => 0, "di" => 0, "antara" => 0, "tujuan" => 0, "pembangunan" => 0, "nasional" => 0, "adalah" => 0, "menurunkan" => 0, "tingkat" => 0, "kemiskinan" => 0, "bangsanya" => 0, "karena" => 0, "merupakan" => 0, "masalah" => 0, "ekonomi" => 0, "harus" => 0, "segera" => 0, "diatasi" => 0]
doc2_vector = ["penelitian" => 0, "ini" => 0, "dilatarbelakangi" => 0, "oleh" => 0, "data" => 0, "observasi" => 0, "yang" => 0, "menunjukkan" => 0, "perolehan" => 0, "hasil" => 0, "belajar" => 0, "siswa" => 0, "pada" => 0, "materi" => 0, "ipa" => 0, "sangat" => 0, "rendah" => 0, "untuk" => 0, "merespons" => 0, "hal" => 0, "itu" => 0, "maka" => 0, "tindakan" => 0, "kelas" => 0, "bertujuan" => 0, "meningkatkan" => 0, "satu" => 0, "di" => 0, "antara" => 0, "tujuan" => 0, "pembangunan" => 0, "nasional" => 0, "adalah" => 0, "menurunkan" => 0, "tingkat" => 0, "kemiskinan" => 0, "bangsanya" => 0, "karena" => 0, "merupakan" => 0, "masalah" => 0, "ekonomi" => 0, "harus" => 0, "segera" => 0, "diatasi" => 0]

Langkah 7: Menghitung nilai vektor dokumen
Mengisi nilai vektor dokumen dengan jumlah kemunculan kata dalam doc1_weights dan doc2_weights:
doc1_vector = ["penelitian" => 2, "ini" => 1, "dilatarbelakangi" => 1, "oleh" => 1, "data" => 1, "observasi" => 1, "yang" => 2, "menunjukkan" => 1, "perolehan" => 1, "hasil" => 2, "belajar" => 2, "siswa" => 2, "pada" => 1, "materi" => 1, "ipa" => 1, "sangat" => 1, "rendah" => 1, "untuk" => 2, "merespons" => 1, "hal" => 1, "itu" => 1, "maka" => 1, "tindakan" => 1, "kelas" => 1, "bertujuan" => 1, "meningkatkan" => 1, "satu" => 0, "di" => 0, "antara" => 0, "tujuan" => 0, "pembangunan" => 0, "nasional" => 0, "adalah" => 0, "menurunkan" => 0, "tingkat" => 0, "kemiskinan" => 0, "bangsanya" => 0, "karena" => 0, "merupakan" => 0, "masalah" => 0, "ekonomi" => 0, "harus" => 0, "segera" => 0, "diatasi" => 0]
doc2_vector = ["penelitian" => 0, "ini" => 1, "dilatarbelakangi" => 0, "oleh" => 0, "data" => 0, "observasi" => 0, "yang" => 1, "menunjukkan" => 0, "perolehan" => 0, "hasil" => 0, "belajar" => 0, "siswa" => 0, "pada" => 0, "materi" => 0, "ipa" => 0, "sangat" => 0, "rendah" => 0, "untuk" => 0, "merespons" => 0, "hal" => 1, "itu" => 1, "maka" => 0, "tindakan" => 0, "kelas" => 0, "bertujuan" => 0, "meningkatkan" => 0, "satu" => 2, "di" => 2, "antara" => 2, "tujuan" => 1, "pembangunan" => 1, "nasional" => 1, "adalah" => 1, "menurunkan" => 1, "tingkat" => 1, "kemiskinan" => 2, "bangsanya" => 1, "karena" => 1, "merupakan" => 1, "masalah" => 1, "ekonomi" => 1, "harus" => 1, "segera" => 1, "diatasi" => 1]

Langkah 8: Menghitung cosine similarity
Menghitung dot product, magnitude1, dan magnitude2:
dot_product = (2 * 0) + (1 * 1) + (1 * 0) + (1 * 0) + (1 * 0) + (1 * 0) + (2 * 1) + (1 * 0) + (1 * 0) + (2 * 0) + (2 * 0) + (2 * 0) + (1 * 0) + (1 * 0) + (1 * 0) + (1 * 0) + (1 * 0) + (2 * 0) + (1 * 0) + (1 * 1) + (1 * 1) + (1 * 0) + (1 * 0) + (1 * 0) + (1 * 0) + (1 * 0) + (0 * 2) + (0 * 2) + (0 * 2) + (0 * 1) + (0 * 1) + (0 * 1) + (0 * 1) + (0 * 1) + (0 * 1) + (0 * 1) + (0 * 2) + (0 * 1) + (0 * 1) + (0 * 1) + (0 * 1) + (0 * 1) + (0 * 1) + (0 * 1) + (0 * 1) + (0 * 1) + (0 * 1) + (0 * 1) + (0 * 1) = 3
magnitude1 = sqrt((2^2) + (1^2) + (1^2) + (1^2) + (1^2) + (1^2) + (2^2) + (1^2) + (1^2) + (2^2) + (2^2) + (2^2) + (1^2) + (1^2) + (1^2) + (1^2) + (1^2) + (2^2) + (1^2) + (1^2) + (1^2) + (1^2) + (1^2) + (1^2) + (1^2) + (0^2) + (0^2) + (0^2) + (0^2) + (0^2) + (0^2) + (0^2) + (0^2) + (0^2) + (0^2) + (0^2) + (0^2) + (0^2) + (0^2) + (0^2) + (0^2) + (0^2) + (0^2) + (0^2) + (0^2) + (0^2) + (0^2) + (0^2) + (0^2)) = sqrt(20) = 4.472
magnitude2 = sqrt((0^2) + (1^2) + (0^2) + (0^2) + (0^2) + (0^2) + (1^2) + (0^2) + (0^2) + (0^2) + (0^2) + (0^2) + (0^2) + (0^2) + (0^2) + (0^2) + (0^2) + (0^2) + (0^2) + (1^2) + (1^2) + (0^2) + (0^2) + (0^2) + (0^2) + (2^2) + (2^2) + (2^2) + (1^2) + (1^2) + (1^2) + (1^2) + (1^2) + (1^2) + (1^2) + (1^2) + (2^2) + (1^2) + (1^2) + (1^2) + (1^2) + (1^2) + (1^2) + (1^2) + (1^2) + (1^2) + (1^2) + (1^2) + (1^2) + (1^2) + (1^2)) = sqrt(27) = 5.196

Langkah 9: Menghitung hasil cosine similarity
cosine_similarity = dot_product / (magnitude1 * magnitude2) = 3 / (4.472 * 5.196) = 0.131

Jadi, hasil perhitungan manual dari fungsi cosine_similarity dengan dokumen doc1 dan doc2 adalah 0.131 atau 13.1%.



















function cosine_similarity($doc1, $doc2){

$stopwords = array(
  'ada','harus','oleh','maka','sangat','hal','itu','untuk','satu','ini','yang','pada', 'adalah', 'adanya', 'adapun', 'agak', 'agaknya', 'agar', 'akan', 'akankah', 'akhir',
  'akhiri', 'akhirnya', 'aku', 'akulah', 'amat', 'amatlah', 'anda', 'andalah', 'antar', 'antara',
  'antaranya', 'apa', 'apaan', 'apabila', 'apakah', 'apalagi', 'apatah', 'artinya', 'asal',
  'asalkan', 'atas', 'atau', 'ataukah', 'ataupun', 'awal', 'awalnya', 'bagai', 'bagaikan',
  'bagaimana', 'bagaimanakah', 'bagaimanapun', 'bagi', 'bagian', 'bahkan', 'bahwa', 'bahwasannya',
  'bahwasanya', 'baik', 'bakal', 'bakalan', 'balik', 'banyak', 'bapak', 'baru', 'bawah', 'beberapa',
  'begini', 'beginian', 'beginikah', 'beginilah', 'begitu', 'begitukah', 'begitulah', 'begitupun',
  'belakang', 'belakangan', 'belum', 'belumlah', 'benar', 'benarkah', 'benarlah', 'berada',
  'berakhirlah', 'berakhirnya', 'berapa', 'berapakah', 'berapalah', 'berapapun', 'berarti',
  'berawal', 'berbagai', 'berdatangan', 'beri', 'berikan', 'berikut', 'berikutnya', 'berjumlah',
  'berkali-kali', 'berkata', 'berkehendak', 'berkeinginan', 'berkenaan', 'berlainan', 'berlalu',
  'berlangsung', 'berlebihan', 'bermacam', 'bermacam-macam', 'bermaksud', 'bermula', 'bersama',
  'bersama-sama', 'bersiap', 'bersiap-siap', 'bertanya', 'bertanya-tanya', 'berturut', 'berturut-turut',
  'bertutur', 'berujar', 'berupa', 'besar', 'betul', 'betulkah', 'biasa', 'biasanya', 'bila',
  'bilakah', 'bisa', 'bisakah', 'boleh', 'bolehkah', 'bolehlah', 'buat', 'bukan', 'bukankah',
  'bukanlah', 'bulan', 'bung', 'cara', 'caranya', 'cukup', 'cukupkah', 'cukuplah', 'dahulu',
  'dalam', 'dan', 'dapat', 'dari', 'daripada', 'datang', 'dekat', 'demi', 'demikian', 'demikianlah',
  'dengan', 'depan', 'di', 'dia', 'diakhiri', 'diakhirinya', 'dialah', 'diantara', 'diantaranya',
  'diberi', 'diberikan', 'diberikannya', 'dibuat'
);


// memisahkan tanda baca
$doc1 = preg_replace('/[^\w\s]/u', '', $doc1);
$doc2 = preg_replace('/[^\w\s]/u', '', $doc2);

// membuat array dari kata-kata
$doc1_word = preg_split('/\s+/', strtolower($doc1), -1, PREG_SPLIT_NO_EMPTY);
$doc2_word = preg_split('/\s+/', strtolower($doc2), -1, PREG_SPLIT_NO_EMPTY);

// menghapus stopwords
$doc1_word = array_diff($doc1_word, $stopwords);
$doc2_word = array_diff($doc2_word, $stopwords);


// menghitung pembobotan (menghitung jumlah kemunculan setiap kata dalam array tersebut.)
$doc1_weights = array_count_values($doc1_word);
$doc2_weights = array_count_values($doc2_word);


// mengambil kata-kata unik dari kedua dokumen
$unique_words = array_unique(array_merge($doc1_word, $doc2_word));

// inisialisasi vektor dokumen ( menggabungkan semua kata dari $doc1_word dan $doc2_word menjadi satu array, dan kemudian menghapus kata-kata duplikat dari array tersebut menggunakan fungsi array_unique().)
$doc1_vector = array_fill_keys($unique_words, 0);
$doc2_vector = array_fill_keys($unique_words, 0);


// menghitung nilai vektor dokumen
foreach ($unique_words as $word) {
  if (isset($doc1_weights[$word])) {
    $doc1_vector[$word] = $doc1_weights[$word];
  }
  if (isset($doc2_weights[$word])) {
    $doc2_vector[$word] = $doc2_weights[$word];
  }
}

// menghitung cosine similarity
$dot_product = 0.0;
$magnitude1 = 0.0;
$magnitude2 = 0.0;

foreach ($unique_words as $word) {
  $dot_product += ($doc1_vector[$word] * $doc2_vector[$word]);
  // kuadrat
  $magnitude1 += pow($doc1_vector[$word], 2);
  $magnitude2 += pow($doc2_vector[$word], 2);
}

// akar pangkat 2
$magnitude1 = sqrt($magnitude1);
$magnitude2 = sqrt($magnitude2);

if ($magnitude1 == 0.0 || $magnitude2 == 0.0) {
  return 0.0;
} else {
  return ($dot_product / ($magnitude1 * $magnitude2));
}
}
$doc2 = "Meningkatnya tindakan plagiarisme di universitas dan perguruan tinggi merupakan masalah yang
cukup serius dan perlu ditangani. Pada zaman sekarang ini, mendapatkan suatu informasi memang
sangatlah mudah sehingga memberikan kesempatan kepada kalangan tertentu untuk mendapatkan
keuntungan pribadi. Salah satunya adalah dengan mengambil atau menggunakan karya orang lain
tanpa izin seolah-olah itu adalah hasil karyanya sendiri dan ini disebut juga plagiarisme. Berdasarkan
keadaan ini peneliti bertujuan untuk merancang sebuah aplikasi pendeteksi kemiripan kata pada
dokumen.";
$doc1 = "Plagiarisme merupakan pengambilan karangan atau pendapat orang lain dan menjadikannya
seolah-olah karangan atau pendapat sendiri, misalnyamenerbitkan karya tulis orang lain atas nama dirinya
sendiri. Dalam hal mengantisipasi pendapat karangan oranglain yaitu dibutuhkan cara dalam menganalisis suatu
dokumen, salah satunya yaitu dengan menerapkan fungsimetode rolling hash pada algoritma winnowing karena
metode winnowing ini algoritma yang digunakan untukmelakukan proses pengecekkan kesamaan kata (document
fingerprinting) untuk mengidentifikasi plagiarisme ataupenjiplakan.";
buatlah perhitungan manual berdasarkan fungsi diatas dan berapa hasil persentasenya






Berikut adalah perhitungan manual berdasarkan fungsi cosine_similarity() di atas:

Preprocessing:

Menghilangkan tanda baca:
$doc1 = "Plagiarisme merupakan pengambilan karangan atau pendapat orang lain dan menjadikannya seolaholah karangan atau pendapat sendiri misalnyamenerbitkan karya tulis orang lain atas nama dirinya sendiri Dalam hal mengantisipasi pendapat karangan oranglain yaitu dibutuhkan cara dalam menganalisis suatu dokumen salah satunya yaitu dengan menerapkan fungsimetode rolling hash pada algoritma winnowing karena metode winnowing ini algoritma yang digunakan untukmelakukan proses pengecekkan kesamaan kata document fingerprinting untuk mengidentifikasi plagiarisme ataupenjiplakan"
$doc2 = "Meningkatnya tindakan plagiarisme di universitas dan perguruan tinggi merupakan masalah yang cukup serius dan perlu ditangani Pada zaman sekarang ini mendapatkan suatu informasi memang sangatlah mudah sehingga memberikan kesempatan kepada kalangan tertentu untuk mendapatkan keuntungan pribadi Salah satunya adalah dengan mengambil atau menggunakan karya orang lain tanpa izin seolaholah itu adalah hasil karyanya sendiri dan ini disebut juga plagiarisme Berdasarkan keadaan ini peneliti bertujuan untuk merancang sebuah aplikasi pendeteksi kemiripan kata pada dokumen"

Menghapus stopwords:
$doc1 = "Plagiarisme pengambilan karangan pendapat orang menjadikannya seolaholah karangan pendapat sendiri misalnyamenerbitkan karya tulis orang atas nama diri sendiri mengantisipasi pendapat karangan oranglain dibutuhkan menganalisis dokumen salah satunya menerapkan fungsimetode rolling hash algoritma winnowing metode winnowing algoritma untukmelakukan pengecekkan kesamaan kata document fingerprinting mengidentifikasi plagiarisme ataupenjiplakan"
$doc2 = "Meningkatnya tindakan plagiarisme universitas perguruan tinggi masalah cukup serius ditangani zaman mendapatkan informasi sangatlah mudah memberikan kesempatan kalangan tertentu mendapatkan keuntungan pribadi mengambil menggunakan karya orang tanpa izin seolaholah hasil karyanya sendiri disebut plagiarisme Berdasarkan keadaan peneliti bertujuan merancang aplikasi pendeteksi kemiripan kata dokumen"

Membuat array kata-kata:
$doc1_word = ["plagiarisme", "pengambilan", "karangan", "pendapat", "orang", "menjadikannya", "seolaholah", "karangan", "pendapat", "sendiri", "misalnyamenerbitkan", "karya", "tulis", "orang", "atas", "nama", "diri", "sendiri", "mengantisipasi", "pendapat", "karangan", "oranglain", "dibutuhkan", "menganalisis", "dokumen", "salah", "satunya", "menerapkan", "fungsimetode", "rolling", "hash", "algoritma", "winnowing", "metode", "winnowing", "algoritma", "untukmelakukan", "pengecekkan", "kesamaan", "kata", "document", "fingerprinting", "mengidentifikasi", "plagiarisme", "ataupenjiplakan"]
$doc2_word = ["meningkatnya", "tindakan", "plagiarisme", "universitas", "perguruan", "tinggi", "masalah", "cukup", "serius", "ditangani", "zaman", "mendapatkan", "informasi", "sangatlah", "mudah", "memberikan", "kesempatan", "kalangan", "tertentu", "mendapatkan", "keuntungan", "pribadi", "mengambil", "menggunakan", "karya", "orang", "tanpa", "izin", "seolaholah", "hasil", "karyanya", "sendiri", "disebut", "plagiarisme", "berdasarkan", "keadaan", "peneliti", "bertujuan", "merancang", "aplikasi", "pendeteksi", "kemiripan", "kata", "dokumen"]

Menghitung pembobotan (jumlah kemunculan setiap kata):
$doc1_weights = [
"plagiarisme" => 2,
"pengambilan" => 1,
"karangan" => 2,
"pendapat" => 3,
"orang" => 2,
"menjadikannya" => 1,
"seolaholah" => 2,
"sendiri" => 2,
"misalnyamenerbitkan" => 1,
"karya" => 2,
"tulis" => 1,
"atas" => 1,
"nama" => 1,
"diri" => 2,
"mengantisipasi" => 1,
"oranglain" => 1,
"dibutuhkan" => 1,
"menganalisis" => 1,
"dokumen" => 1,
"salah" => 1,
"satunya" => 1,
"menerapkan" => 1,
"fungsimetode" => 1,
"rolling" => 1,
"hash" => 1,
"algoritma" => 2,
"winnowing" => 2,
"untukmelakukan" => 1,
"pengecekkan" => 1,
"kesamaan" => 1,
"kata" => 1,
"document" => 1,
"fingerprinting" => 1,
"mengidentifikasi" => 1,
"ataupenjiplakan" => 1
]

$doc2_weights = [
"meningkatnya" => 1,
"tindakan" => 1,
"plagiarisme" => 2,
"universitas" => 1,
"perguruan" => 1,
"tinggi" => 1,
"masalah" => 1,
"cukup" => 1,
"serius" => 1,
"ditangani" => 1,
"zaman" => 1,
"mendapatkan" => 2,
"informasi" => 1,
"sangatlah" => 1,
"mudah" => 1,
"memberikan" => 1,
"kesempatan" => 1,
"kalangan" => 1,
"tertentu" => 1,
"keuntungan" => 1,
"pribadi" => 1,
"mengambil" => 1,
"menggunakan" => 1,
"karya" => 1,
"orang" => 1,
"tanpa" => 1,
"izin" => 1,
"seolaholah" => 1,
"hasil" => 1,
"karyanya" => 1,
"sendiri" => 1,
"disebut" => 1,
"berdasarkan" => 1,
"keadaan" => 1,
"peneliti" => 1,
"bertujuan" => 1,
"merancang" => 1,
"aplikasi" => 1,
"pendeteksi" => 1,
"kemiripan" => 1,
"kata" => 1,
"dokumen" => 1
]

Mengambil kata-kata unik dari kedua dokumen:
$unique_words = [
"plagiarisme", "pengambilan", "karangan", "pendapat", "orang", "menjadikannya", "seolaholah", "sendiri", "misalnyamenerbitkan", "karya", "tulis", "atas", "nama", "diri", "mengantisipasi", "oranglain", "dibutuhkan", "menganalisis", "dokumen", "salah", "satunya", "menerapkan", "fungsimetode", "rolling", "hash", "algoritma", "winnowing", "untukmelakukan", "pengecekkan", "kesamaan", "kata", "document", "fingerprinting", "mengidentifikasi", "ataupenjiplakan", "meningkatnya", "tindakan", "universitas", "perguruan", "tinggi", "masalah", "cukup", "serius", "ditangani", "zaman", "mendapatkan", "informasi", "sangatlah", "mudah", "memberikan", "kesempatan", "kalangan", "tertentu", "keuntungan", "pribadi", "mengambil", "menggunakan", "tanpa", "izin", "hasil", "karyanya", "disebut", "berdasarkan", "keadaan", "peneliti", "bertujuan", "merancang", "aplikasi", "pendeteksi", "kemiripan"
]

Inisialisasi vektor dokumen:
$doc1_vector = [
"plagiarisme" => 2,
"pengambilan" => 1,
"karangan" => 2,
"pendapat" => 3,
"orang" => 2,
"menjadikannya" => 1,
"seolaholah" => 2,
"sendiri" => 2,
"misalnyamenerbitkan" => 1,
"karya" => 2,
"tulis" => 1,
"atas" => 1,
"nama" => 1,
"diri" => 2,
"mengantisipasi" => 1,
"oranglain" => 1,
"dibutuhkan" => 1,
"menganalisis" => 1,
"dokumen" => 1,
"salah" => 1,
"satunya" => 1,
"menerapkan" => 1,
"fungsimetode" => 1,
"rolling" => 1,
"hash" => 1,
"algoritma" => 2,
"winnowing" => 2,
"untukmelakukan" => 1,
"pengecekkan" => 1,
"kesamaan" => 1,
"kata" => 1,
"document" => 1,
"fingerprinting" => 1,
"mengidentifikasi" => 1,
"ataupenjiplakan" => 1,
"meningkatnya" => 0,
"tindakan" => 0,
"universitas" => 0,
"perguruan" => 0,
"tinggi" => 0,
"masalah" => 0,
"cukup" => 0,
"serius" => 0,
"ditangani" => 0,
"zaman" => 0,
"mendapatkan" => 0,
"informasi" => 0,
"sangatlah" => 0,
"mudah" => 0,
"memberikan" => 0,
"kesempatan" => 0,
"kalangan" => 0,
"tertentu" => 0,
"keuntungan" => 0,
"pribadi" => 0,
"mengambil" => 0,
"menggunakan" => 0,
"tanpa" => 0,
"izin" => 0,
"hasil" => 0,
"karyanya" => 0,
"disebut" => 0,
"berdasarkan" => 0,
"keadaan" => 0,
"peneliti" => 0,
"bertujuan" => 0,
"merancang" => 0,
"aplikasi" => 0,
"pendeteksi" => 0,
"kemiripan" => 0
]

$doc2_vector = [
"plagiarisme" => 2,
"pengambilan" => 0,
"karangan" => 0,
"pendapat" => 0,
"orang" => 1,
"menjadikannya" => 0,
"seolaholah" => 0,
"sendiri" => 1,
"misalnyamenerbitkan" => 0,
"karya" => 1,
"tulis" => 0,
"atas" => 0,
"nama" => 0,
"diri" => 0,
"mengantisipasi" => 0,
"oranglain" => 0,
"dibutuhkan" => 0,
"menganalisis" => 0,
"dokumen" => 1,
"salah" => 0,
"satunya" => 0,
"menerapkan" => 0,
"fungsimetode" => 0,
"rolling" => 0,
"hash" => 0,
"algoritma" => 0,
"winnowing" => 0,
"untukmelakukan" => 0,
"pengecekkan" => 0,
"kesamaan" => 0,
"kata" => 1,
"document" => 1,
"fingerprinting" => 1,
"mengidentifikasi" => 1,
"ataupenjiplakan" => 1,
"meningkatnya" => 1,
"tindakan" => 1,
"universitas" => 1,
"perguruan" => 1,
"tinggi" => 1,
"masalah" => 1,
"cukup" => 1,
"serius" => 1,
"ditangani" => 1,
"zaman" => 1,
"mendapatkan" => 2,
"informasi" => 1,
"sangatlah" => 1,
"mudah" => 1,
"memberikan" => 1,
"kesempatan" => 1,
"kalangan" => 1,
"tertentu" => 1,
"keuntungan" => 1,
"pribadi" => 1,
"mengambil" => 1,
"menggunakan" => 1,
"tanpa" => 1,
"izin" => 1,
"hasil" => 1,
"karyanya" => 1,
"disebut" => 1,
"berdasarkan" => 1,
"keadaan" => 1,
"peneliti" => 1,
"bertujuan" => 1,
"merancang" => 1,
"aplikasi" => 1,
"pendeteksi" => 1,
"kemiripan" => 1
]

Menghitung cosine similarity antara kedua vektor dokumen:
$dot_product = 22 + 11 + 20 + 30 + 21 + 10 + 20 + 21 + 10 + 21 + 10 + 10 + 10 + 20 + 10 + 10 + 10 + 10 + 11 + 10 + 10 + 10 + 10 + 10 + 20 + 20 + 10 + 10 + 10 + 11 + 11 + 11 + 11 + 11 + 11 + 11 + 11 + 11 + 11 + 11 + 11 + 21 + 11 + 11 + 11 + 11 + 11 + 11 + 11 + 11 + 11 + 11 + 11 + 11 + 11 + 11 + 11 + 11 + 11 + 11 + 11 + 11 + 11 + 11 + 11 + 11 + 11 + 11 + 
















perhitungan 3
function cosine_similarity($doc1, $doc2) {
  // $stopwords = array('di', 'ke', 'dari', 'yang', 'dan', 'atau', 'dalam', 'pada', 'untuk', 'dengan');
  $stopwords = array(
    'ada','pada', 'adalah', 'adanya', 'adapun', 'agak', 'agaknya', 'agar', 'akan', 'akankah', 'akhir',
    'akhiri', 'akhirnya', 'aku', 'akulah', 'amat', 'amatlah', 'anda', 'andalah', 'antar', 'antara',
    'antaranya', 'apa', 'apaan', 'apabila', 'apakah', 'apalagi', 'apatah', 'artinya', 'asal',
    'asalkan', 'atas', 'atau', 'ataukah', 'ataupun', 'awal', 'awalnya', 'bagai', 'bagaikan',
    'bagaimana', 'bagaimanakah', 'bagaimanapun', 'bagi', 'bagian', 'bahkan', 'bahwa', 'bahwasannya',
    'bahwasanya', 'baik', 'bakal', 'bakalan', 'balik', 'banyak', 'bapak', 'baru', 'bawah', 'beberapa',
    'begini', 'beginian', 'beginikah', 'beginilah', 'begitu', 'begitukah', 'begitulah', 'begitupun',
    'belakang', 'belakangan', 'belum', 'belumlah', 'benar', 'benarkah', 'benarlah', 'berada',
    'berakhirlah', 'berakhirnya', 'berapa', 'berapakah', 'berapalah', 'berapapun', 'berarti',
    'berawal', 'berbagai', 'berdatangan', 'beri', 'berikan', 'berikut', 'berikutnya', 'berjumlah',
    'berkali-kali', 'berkata', 'berkehendak', 'berkeinginan', 'berkenaan', 'berlainan', 'berlalu',
    'berlangsung', 'berlebihan', 'bermacam', 'bermacam-macam', 'bermaksud', 'bermula', 'bersama',
    'bersama-sama', 'bersiap', 'bersiap-siap', 'bertanya', 'bertanya-tanya', 'berturut', 'berturut-turut',
    'bertutur', 'berujar', 'berupa', 'besar', 'betul', 'betulkah', 'biasa', 'biasanya', 'bila',
    'bilakah', 'bisa', 'bisakah', 'boleh', 'bolehkah', 'bolehlah', 'buat', 'bukan', 'bukankah',
    'bukanlah', 'bulan', 'bung', 'cara', 'caranya', 'cukup', 'cukupkah', 'cukuplah', 'dahulu',
    'dalam', 'dan', 'dapat', 'dari', 'daripada', 'datang', 'dekat', 'demi', 'demikian', 'demikianlah',
    'dengan', 'depan', 'di', 'dia', 'diakhiri', 'diakhirinya', 'dialah', 'diantara', 'diantaranya',
    'diberi', 'diberikan', 'diberikannya', 'dibuat');


  // memisahkan tanda baca
  $doc1 = preg_replace('/[^\w\s]/u', '', $doc1);
  $doc2 = preg_replace('/[^\w\s]/u', '', $doc2);
  
  // membuat array dari kata-kata
  $doc1_word = preg_split('/\s+/', strtolower($doc1), -1, PREG_SPLIT_NO_EMPTY);
  $doc2_word = preg_split('/\s+/', strtolower($doc2), -1, PREG_SPLIT_NO_EMPTY);
  // menghapus stopwords
  $doc1_word = array_diff($doc1_word, $stopwords);
  $doc2_word = array_diff($doc2_word, $stopwords);

  // menghitung pembobotan (menghitung jumlah kemunculan setiap kata dalam array tersebut.)
  $doc1_weights = array_count_values($doc1_word);
  $doc2_weights = array_count_values($doc2_word);

  // mengambil kata-kata unik dari kedua dokumen
  $unique_words = array_unique(array_merge($doc1_word, $doc2_word));

  // inisialisasi vektor dokumen ( menggabungkan semua kata dari $doc1_word dan $doc2_word menjadi satu array, dan kemudian menghapus kata-kata duplikat dari array tersebut menggunakan fungsi array_unique().)
  $doc1_vector = array_fill_keys($unique_words, 0);
  $doc2_vector = array_fill_keys($unique_words, 0);

  // menghitung nilai vektor dokumen
  foreach ($unique_words as $word) {
    if (isset($doc1_weights[$word])) {
      $doc1_vector[$word] = $doc1_weights[$word];
    }
    if (isset($doc2_weights[$word])) {
      $doc2_vector[$word] = $doc2_weights[$word];
    }
  }

  // menghitung cosine similarity
  $dot_product = 0.0;
  $magnitude1 = 0.0;
  $magnitude2 = 0.0;

  foreach ($unique_words as $word) {
    $dot_product += ($doc1_vector[$word] * $doc2_vector[$word]);
    // kuadrat
    $magnitude1 += pow($doc1_vector[$word], 2);
    $magnitude2 += pow($doc2_vector[$word], 2);
  }

// akar pangkat 2
  $magnitude1 = sqrt($magnitude1);
  $magnitude2 = sqrt($magnitude2);


  if ($magnitude1 == 0.0 || $magnitude2 == 0.0) {
    return 0.0;
  } else {
    return ($dot_product / ($magnitude1 * $magnitude2));
  }
}
buatlah perhitungan cosine similarity secara manual berdasarkan function diatas dengan
doc1 : Penelitian ini dilatarbelakangi oleh data observasi yang menunjukkan perolehan hasil belajar siswa pada materi IPA sangat rendah. Untuk merespons hal itu maka peneliti melakukan penelitian tindakan kelas yang bertujuan untuk meningkatkan hasil belajar siswa. 
doc2 : Satu di antara tujuan pembangunan nasional adalah menurunkan tingkat kemiskinan bangsanya. Hal ini karena kemiskinan merupakan satu di antara masalah ekonomi yang harus segera diatasi. 
buatlah perhitungan manual tanpa script  dengan menghilangkan stopword dan tanda baca terhadap kedua teks tersebut dengan cosine similarity
