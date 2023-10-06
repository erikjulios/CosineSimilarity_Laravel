function execute($judul, $abstrak){
        

        $doc2 = "Selama ini perpustakaan Kejaksaan Negeri Jember belum dikelola dengan baik. 
            Pada saat pegawai perpustakaan ingin mengetahui macam-macam judul buku sesuai kategori 
            yang mereka inginkan, pegawai perpustakaan mencari satu persatu di katalog bukunya. Sehingga 
            kondisi demikian akan menyulitkan pegawai perpustakaan dalam mencari judul buku sesuai kategori 
            yang diinginkan. Hal ini dapat mengakibatkan pegawai perpustakaan kewalahan. Pelayanan yang 
            sangat baik jika pengguna perpustakaan merasa puas dengan pelayananya. Semakin banyaknya 
            dokumen buku yang ada di perpustakaan semakin banyak tenaga dan waktu yang diperlukan. 
            Maka memerlukan sebuah sistem aplikasi untuk mengklasifikasikan dokumen buku berdasarkan 
            kategori buku secara otomatis. Untuk mendapatkan hasil yang optimal dalam mengklasifikasikan 
            sebuah dokumen maka diperlukan sebuah metode untuk mengklasifikasikan dokumen. Metode yang 
            digunakan adalah pembobotan TF-IDF dan cosine similarity pada model vector space model. 
            Untuk mengukur tingkat kemiripan suatu dokumen dengan menggunakan sinopsis buku.
            Pengujian aplikasi terdapat 120 dokumen sinopsis dengan 10 kategori dan menghasilkan nilai 
            precision sebesar 90,91% pada threshold 0,1 dan nilai recall sebesar 100% pada threshold 
            0,1 dan 0,2. Ketepatan akurasi pada sistem aplikasi yang diuji adalah 80,83%.";
        // membuat array dokumen
        $docs = array($judul, $doc2);
        $docs2 = array($abstrak, $doc2);

        // menghitung jumlah dokumen
        $num_docs = count($docs);
        $num_docs2 = count($docs2);

        // menghitung pembobotan tf judul
        $tf = array();
        $stopwords = array(
            'ada', 'adalah', 'adanya', 'adapun', 'agak', 'agaknya', 'agar', 'akan', 'akankah', 'akhir',
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
        foreach ($docs as $doc) {
        $words = preg_split('/\s+/', strtolower($doc), -1, PREG_SPLIT_NO_EMPTY);
        $words = array_diff($words, $stopwords);
        $doc_weights = array_count_values($words);
        $tf[] = $doc_weights;
        }

        // menghitung pembobotan tf abstrak
        $tf2 = array();
        $stopwords2 = array(
            'ada', 'adalah', 'adanya', 'adapun', 'agak', 'agaknya', 'agar', 'akan', 'akankah', 'akhir',
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
        foreach ($docs2 as $doc2) {
        $words2 = preg_split('/\s+/', strtolower($doc2), -1, PREG_SPLIT_NO_EMPTY);
        $words2 = array_diff($words2, $stopwords2);
        $doc_weights2 = array_count_values($words2);
        $tf2[] = $doc_weights2;
        }

        

        // menghitung pembobotan idf judul
        // membuat array dari kata-kata
        $judul_words = preg_split('/\s+/', strtolower($judul), -1, PREG_SPLIT_NO_EMPTY);
        $doc2_words = preg_split('/\s+/', strtolower($doc2), -1, PREG_SPLIT_NO_EMPTY);

        // menghapus stopwords
        $judul_words = array_diff($judul_words, $stopwords);
        $doc2_words = array_diff($doc2_words, $stopwords);
        $idf = array();
        $unique_words = array_unique(array_merge($judul_words, $doc2_words));
        foreach ($unique_words as $word) {
        $count = 0;
        foreach ($docs as $doc) {
            if (stripos($doc, $word) !== false) {
            $count++;
            }
        }
        //
        $idf[$word] = log($num_docs / $count);
        }

        // menghitung pembobotan idf abstraksi
        // membuat array dari kata-kata
        $judul_words2 = preg_split('/\s+/', strtolower($abstrak), -1, PREG_SPLIT_NO_EMPTY);
        $doc2_words2 = preg_split('/\s+/', strtolower($doc2), -1, PREG_SPLIT_NO_EMPTY);

        // menghapus stopwords
        $judul_words2 = array_diff($judul_words2, $stopwords2);
        $doc2_words2 = array_diff($doc2_words2, $stopwords2);
        $idf2 = array();
        $unique_words2 = array_unique(array_merge($judul_words2, $doc2_words2));
        foreach ($unique_words2 as $word2) {
        $count2 = 0;
        foreach ($docs2 as $doc2) {
            if (stripos($doc2, $word2) !== false) {
            $count2++;
            }
        }
        //
        $idf2[$word] = log($num_docs2 / $count2);
        }
        // menghitung pembobotan tf-idf judul
        $tf_idf = array();
        foreach ($tf as $doc_weights) {
        $doc_tfidf = array();
        foreach ($doc_weights as $word => $weight) {
            $doc_tfidf[$word] = $weight * $idf[$word];
        }
        $tf_idf[] = $doc_tfidf;
        }
        //cosine similarity pada judul
        $similarity = $this->cosine_similarity($judul, $doc2);
        $total =$similarity*100;
        $result = substr($total, 0, 5);
        $format_result = $result."%";

         // menghitung pembobotan tf-idf abstrak
        //  $tf_idf2 = array();
        //  foreach ($tf2 as $doc_weights2) {
        //  $doc_tfidf2 = array();
        //  foreach ($doc_weights2 as $word2 => $weight2) {
        //      $doc_tfidf2[$word2] = $weight2 * $idf2[$word2];
        //  }
        //  $tf_idf2[] = $doc_tfidf2;
        //  }
         //cosine similarity pada abstraksi
         $similarity2 = $this->cosine_similarity2($abstrak, $doc2);
         $total2 =$similarity2*100;
         $result2 = substr($total2, 0, 5);
         $format_result2 = $result2."%";



        // return response($format_result);
        $response1 =  response([
            'judul' => $format_result,
            'abstraksi' => $format_result2,
        ]);

        $data = file_get_contents('http://program.test/api/getJA');
        $response = json_decode($data);

        $response2 = response($response);

        return [$response1, $response2];
        // return response()->json([$response1, $response2]);
    }