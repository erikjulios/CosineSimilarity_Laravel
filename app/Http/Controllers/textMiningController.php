<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\dokumen;
use App\Models\history_check;
use Sastrawi\Stemmer\StemmerFactory;
use voku\helper\StopWords;
use Illuminate\Support\Facades\Http;

class textMiningController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
	}

    function getAPI(){
         // Lakukan request ke API
         $response = Http::get('http://jurusan.tik.pnj.ac.id/newrepositori/api/getJA');

         if ($response->successful()) {
            $data = $response->json();
            $transformedArray = [];
            $id = 1;
            foreach ($data as $item) {
            $transformedArray[] = [
                    "id" => $id,
                    "judul" => $item["judul"],
                    "abstraksi" => $item["deskripsi"]
                ];
            $id+=1;
            }
            return $transformedArray;
        } else {
            $errorMessage = $response->body(); 
        }


    }

    //cosine similarity judul
    function cosine_similarity($judul, $doc2) {
            
        // Membersihkan tanda baca
        $judul = preg_replace('/[^\w\s\/]/u', '', $judul);
        $doc2 = preg_replace('/[^\w\s\/]/u', '', $doc2);
        

        // membuat array dari kata-kata
        $judul_word = preg_split('/\s+/', strtolower($judul), -1, PREG_SPLIT_NO_EMPTY);
        $doc2_word = preg_split('/\s+/', strtolower($doc2), -1, PREG_SPLIT_NO_EMPTY);
        

        // menghapus stopword
        $stopWords = new StopWords();
        $stopwords = $stopWords->getStopWordsFromLanguage('id');
        $tokens_judul = explode(' ', $judul);
        $filteredTokens_judul= array_filter($tokens_judul, function ($token) use ($stopwords) {
            return !in_array($token, $stopwords, true);
        });

        $judul_word = $filteredTokens_judul;     
                
        $tokens_doc2 = explode(' ', $doc2);
        $filteredTokens_doc2 = array_filter($tokens_doc2, function ($token) use ($stopwords) {
            return !in_array($token, $stopwords, true);
        });
        $doc2_word = $filteredTokens_doc2;   
        // stemmer
        
        //         $stemmerFactory = new StemmerFactory();
                
        //         $stemmer = $stemmerFactory->createStemmer();
        //         $stemmedText_judul = $stemmer->stem($judul);
        //         $text = 'Mereka pengolahan bernyanyi pekerjaan memenangkan mengerjakan sedang belajar memasak dan bermain musik bersama.';
        //         $words = explode(' ', $text);

        // $stemmedWords = array_map(function ($word) use ($stemmer) {
        //     return $stemmer->stem($word);
        // }, $words);
        // dd($stemmedWords);


        // menghitung pembobotan (menghitung jumlah kemunculan setiap kata dalam array tersebut.)
        $judul_weights = array_count_values($judul_word);
        $doc2_weights = array_count_values($doc2_word);

        // mengambil kata-kata unik dari kedua dokumen
        $unique_words = array_unique(array_merge($judul_word, $doc2_word));
           
        // inisialisasi vektor dokumen ( menggabungkan semua kata dari $judul_word dan $doc2_word 
        //menjadi satu array, dan kemudian menghapus kata-kata duplikat dari array tersebut menggunakan 
        //fungsi array_unique().)
        $judul_vector = array_fill_keys($unique_words, 0);
        $doc2_vector = array_fill_keys($unique_words, 0);

        // menghitung nilai vektor dokumen
        foreach ($unique_words as $word) {
            if (isset($judul_weights[$word])) {
            $judul_vector[$word] = $judul_weights[$word];
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
            $dot_product += ($judul_vector[$word] * $doc2_vector[$word]);
            $magnitude1 += pow($judul_vector[$word], 2);
            $magnitude2 += pow($doc2_vector[$word], 2);
        }
        
        $magnitude1 = sqrt($magnitude1);
        $magnitude2 = sqrt($magnitude2);
        
        if ($magnitude1 == 0.0 || $magnitude2 == 0.0) {
            return 0.0;
        } else {
            return ($dot_product / ($magnitude1 * $magnitude2));
        }
        
    }

    // TF
    function tf($judul, $doc2){

        $judul_word = preg_split('/\s+/', strtolower($judul), -1, PREG_SPLIT_NO_EMPTY);
        $doc2_word = preg_split('/\s+/', strtolower($doc2), -1, PREG_SPLIT_NO_EMPTY);

        $common_words = array_intersect($judul_word, $doc2_word);
        $all_words = array_unique(array_merge($judul_word, $doc2_word));
        $word_counts = array();

        foreach ($common_words as $word) {
        $word_counts[$word] = count(array_keys(array_merge($judul_word, $doc2_word), $word));
        }

        return $word_counts;
    }

    //echo hasil dari perhitungan TF
    // function print_word_counts_table($word_counts) {
    // echo '<table border=2>';
    // echo '<thead><tr><th>Word</th><th>Count</th></tr></thead>';
    // echo '<tbody>';
    // foreach ($word_counts as $word => $count) {
    //     echo '<tr>';
    //     echo '<td>' . htmlspecialchars($word) . '</td>';
    //     echo '<td>' . $count . '</td>';
    //     echo '</tr>';
    // }
    // echo '</tbody>';
    // echo '</table>';
    // }
    


    function cosine_similarity2($abstrak, $doc2) {


        // memisahkan tanda baca
        $abstrak = preg_replace('/[^\w\s\/]/u', '', $abstrak);
        $doc2 = preg_replace('/[^\w\s\/]/u', '', $doc2);

        // membuat array dari kata-kata
        $abstrak_word = preg_split('/\s+/', strtolower($abstrak), -1, PREG_SPLIT_NO_EMPTY);
        $doc2_word = preg_split('/\s+/', strtolower($doc2), -1, PREG_SPLIT_NO_EMPTY);

        // menghapus stopword
        $stopWords = new StopWords();
        $stopwords = $stopWords->getStopWordsFromLanguage('id');

        $tokens_judul = explode(' ', $abstrak);
        $filteredTokens_judul= array_filter($tokens_judul, function ($token) use ($stopwords) {
            return !in_array($token, $stopwords, true);
        });

        $abstrak_word = $filteredTokens_judul;     
                
        $tokens_doc2 = explode(' ', $doc2);
        $filteredTokens_doc2 = array_filter($tokens_doc2, function ($token) use ($stopwords) {
            return !in_array($token, $stopwords, true);
        });

        $doc2_word = $filteredTokens_doc2; 

        // menghitung pembobotan (menghitung jumlah kemunculan setiap kata dalam array tersebut.)
        $abstrak_weights = array_count_values($abstrak_word);
        $doc2_weights = array_count_values($doc2_word);

        // mengambil kata-kata unik dari kedua dokumen
        $unique_words = array_unique(array_merge($abstrak_word, $doc2_word));

        // inisialisasi vektor dokumen ( menggabungkan semua kata dari $abstrak_word dan $doc2_word menjadi satu array, dan kemudian menghapus kata-kata duplikat dari array tersebut menggunakan fungsi array_unique().)
        $abstrak_vector = array_fill_keys($unique_words, 0);
        $doc2_vector = array_fill_keys($unique_words, 0);

        // menghitung nilai vektor dokumen
        foreach ($unique_words as $word) {
            if (isset($abstrak_weights[$word])) {
            $abstrak_vector[$word] = $abstrak_weights[$word];
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
            $dot_product += ($abstrak_vector[$word] * $doc2_vector[$word]);
            $magnitude1 += pow($abstrak_vector[$word], 2);
            $magnitude2 += pow($doc2_vector[$word], 2);
        }

        $magnitude1 = sqrt($magnitude1);
        $magnitude2 = sqrt($magnitude2);

        if ($magnitude1 == 0.0 || $magnitude2 == 0.0) {
            return 0.0;
        } else {
            return ($dot_product / ($magnitude1 * $magnitude2));
        }
    }

    // TF
    function tf2($abstrak, $doc2){

        $abstrak_word = preg_split('/\s+/', strtolower($abstrak), -1, PREG_SPLIT_NO_EMPTY);
        $doc2_word = preg_split('/\s+/', strtolower($doc2), -1, PREG_SPLIT_NO_EMPTY);

        $common_words = array_intersect($abstrak_word, $doc2_word);
        $all_words = array_unique(array_merge($abstrak_word, $doc2_word));
        $word_counts = array();

        foreach ($common_words as $word) {
        $word_counts[$word] = count(array_keys(array_merge($abstrak_word, $doc2_word), $word));
        }

        return $word_counts;
    }



    // function executejadi($judul, $abstrak){
    //     $data = dokumen::select('judul', 'abstraksi')->get();
    //     foreach ($data as $d) {
    //         $doc2 = $d->judul;
        
    //     }
    //     // membuat array dokumen
    //     $docs = array($judul, $doc2);
    //     $docs2 = array($abstrak, $doc2);

    //     // menghitung jumlah dokumen
    //     $num_docs = count($docs);
    //     $num_docs2 = count($docs2);

    //     // menghitung pembobotan tf judul
    //     $tf = array();
    //     $stopwords = array(
    //         'ada', 'adalah', 'adanya', 'adapun', 'agak', 'agaknya', 'agar', 'akan', 'akankah', 'akhir',
    //         'akhiri', 'akhirnya', 'aku', 'akulah', 'amat', 'amatlah', 'anda', 'andalah', 'antar', 'antara',
    //         'antaranya', 'apa', 'apaan', 'apabila', 'apakah', 'apalagi', 'apatah', 'artinya', 'asal',
    //         'asalkan', 'atas', 'atau', 'ataukah', 'ataupun', 'awal', 'awalnya', 'bagai', 'bagaikan',
    //         'bagaimana', 'bagaimanakah', 'bagaimanapun', 'bagi', 'bagian', 'bahkan', 'bahwa', 'bahwasannya',
    //         'bahwasanya', 'baik', 'bakal', 'bakalan', 'balik', 'banyak', 'bapak', 'baru', 'bawah', 'beberapa',
    //         'begini', 'beginian', 'beginikah', 'beginilah', 'begitu', 'begitukah', 'begitulah', 'begitupun',
    //         'belakang', 'belakangan', 'belum', 'belumlah', 'benar', 'benarkah', 'benarlah', 'berada',
    //         'berakhirlah', 'berakhirnya', 'berapa', 'berapakah', 'berapalah', 'berapapun', 'berarti',
    //         'berawal', 'berbagai', 'berdatangan', 'beri', 'berikan', 'berikut', 'berikutnya', 'berjumlah',
    //         'berkali-kali', 'berkata', 'berkehendak', 'berkeinginan', 'berkenaan', 'berlainan', 'berlalu',
    //         'berlangsung', 'berlebihan', 'bermacam', 'bermacam-macam', 'bermaksud', 'bermula', 'bersama',
    //         'bersama-sama', 'bersiap', 'bersiap-siap', 'bertanya', 'bertanya-tanya', 'berturut', 'berturut-turut',
    //         'bertutur', 'berujar', 'berupa', 'besar', 'betul', 'betulkah', 'biasa', 'biasanya', 'bila',
    //         'bilakah', 'bisa', 'bisakah', 'boleh', 'bolehkah', 'bolehlah', 'buat', 'bukan', 'bukankah',
    //         'bukanlah', 'bulan', 'bung', 'cara', 'caranya', 'cukup', 'cukupkah', 'cukuplah', 'dahulu',
    //         'dalam', 'dan', 'dapat', 'dari', 'daripada', 'datang', 'dekat', 'demi', 'demikian', 'demikianlah',
    //         'dengan', 'depan', 'di', 'dia', 'diakhiri', 'diakhirinya', 'dialah', 'diantara', 'diantaranya',
    //         'diberi', 'diberikan', 'diberikannya', 'dibuat');
    //     foreach ($docs as $doc) {
    //     $words = preg_split('/\s+/', strtolower($doc), -1, PREG_SPLIT_NO_EMPTY);
    //     $words = array_diff($words, $stopwords);
    //     $doc_weights = array_count_values($words);
    //     $tf[] = $doc_weights;
    //     }

    //     // menghitung pembobotan tf abstrak
    //     $tf2 = array();
    //     $stopwords2 = array(
    //         'ada', 'adalah', 'adanya', 'adapun', 'agak', 'agaknya', 'agar', 'akan', 'akankah', 'akhir',
    //         'akhiri', 'akhirnya', 'aku', 'akulah', 'amat', 'amatlah', 'anda', 'andalah', 'antar', 'antara',
    //         'antaranya', 'apa', 'apaan', 'apabila', 'apakah', 'apalagi', 'apatah', 'artinya', 'asal',
    //         'asalkan', 'atas', 'atau', 'ataukah', 'ataupun', 'awal', 'awalnya', 'bagai', 'bagaikan',
    //         'bagaimana', 'bagaimanakah', 'bagaimanapun', 'bagi', 'bagian', 'bahkan', 'bahwa', 'bahwasannya',
    //         'bahwasanya', 'baik', 'bakal', 'bakalan', 'balik', 'banyak', 'bapak', 'baru', 'bawah', 'beberapa',
    //         'begini', 'beginian', 'beginikah', 'beginilah', 'begitu', 'begitukah', 'begitulah', 'begitupun',
    //         'belakang', 'belakangan', 'belum', 'belumlah', 'benar', 'benarkah', 'benarlah', 'berada',
    //         'berakhirlah', 'berakhirnya', 'berapa', 'berapakah', 'berapalah', 'berapapun', 'berarti',
    //         'berawal', 'berbagai', 'berdatangan', 'beri', 'berikan', 'berikut', 'berikutnya', 'berjumlah',
    //         'berkali-kali', 'berkata', 'berkehendak', 'berkeinginan', 'berkenaan', 'berlainan', 'berlalu',
    //         'berlangsung', 'berlebihan', 'bermacam', 'bermacam-macam', 'bermaksud', 'bermula', 'bersama',
    //         'bersama-sama', 'bersiap', 'bersiap-siap', 'bertanya', 'bertanya-tanya', 'berturut', 'berturut-turut',
    //         'bertutur', 'berujar', 'berupa', 'besar', 'betul', 'betulkah', 'biasa', 'biasanya', 'bila',
    //         'bilakah', 'bisa', 'bisakah', 'boleh', 'bolehkah', 'bolehlah', 'buat', 'bukan', 'bukankah',
    //         'bukanlah', 'bulan', 'bung', 'cara', 'caranya', 'cukup', 'cukupkah', 'cukuplah', 'dahulu',
    //         'dalam', 'dan', 'dapat', 'dari', 'daripada', 'datang', 'dekat', 'demi', 'demikian', 'demikianlah',
    //         'dengan', 'depan', 'di', 'dia', 'diakhiri', 'diakhirinya', 'dialah', 'diantara', 'diantaranya',
    //         'diberi', 'diberikan', 'diberikannya', 'dibuat');
    //     foreach ($docs2 as $doc2) {
    //     $words2 = preg_split('/\s+/', strtolower($doc2), -1, PREG_SPLIT_NO_EMPTY);
    //     $words2 = array_diff($words2, $stopwords2);
    //     $doc_weights2 = array_count_values($words2);
    //     $tf2[] = $doc_weights2;
    //     }

        

    //     // menghitung pembobotan idf judul
    //     // membuat array dari kata-kata
    //     $judul_words = preg_split('/\s+/', strtolower($judul), -1, PREG_SPLIT_NO_EMPTY);
    //     $doc2_words = preg_split('/\s+/', strtolower($doc2), -1, PREG_SPLIT_NO_EMPTY);

    //     // menghapus stopwords
    //     $judul_words = array_diff($judul_words, $stopwords);
    //     $doc2_words = array_diff($doc2_words, $stopwords);
    //     $idf = array();
    //     $unique_words = array_unique(array_merge($judul_words, $doc2_words));
    //     foreach ($unique_words as $word) {
    //     $count = 0;
    //     foreach ($docs as $doc) {
    //         if (stripos($doc, $word) !== false) {
    //         $count++;
    //         }
    //     }
    //     //
    //     $idf[$word] = log($num_docs / $count);
    //     }

    //     // menghitung pembobotan idf abstraksi
    //     // membuat array dari kata-kata
    //     $judul_words2 = preg_split('/\s+/', strtolower($abstrak), -1, PREG_SPLIT_NO_EMPTY);
    //     $doc2_words2 = preg_split('/\s+/', strtolower($doc2), -1, PREG_SPLIT_NO_EMPTY);

    //     // menghapus stopwords
    //     $judul_words2 = array_diff($judul_words2, $stopwords2);
    //     $doc2_words2 = array_diff($doc2_words2, $stopwords2);
    //     $idf2 = array();
    //     $unique_words2 = array_unique(array_merge($judul_words2, $doc2_words2));
    //     foreach ($unique_words2 as $word2) {
    //     $count2 = 0;
    //     foreach ($docs2 as $doc2) {
    //         if (stripos($doc2, $word2) !== false) {
    //         $count2++;
    //         }
    //     }
    //     //
    //     $idf2[$word] = log($num_docs2 / $count2);
    //     }
    //     // menghitung pembobotan tf-idf judul
    //     $tf_idf = array();
    //     foreach ($tf as $doc_weights) {
    //     $doc_tfidf = array();
    //     foreach ($doc_weights as $word => $weight) {
    //         $doc_tfidf[$word] = $weight * $idf[$word];
    //     }
    //     $tf_idf[] = $doc_tfidf;
    //     }
    //     //cosine similarity pada judul
    //     $similarity = $this->cosine_similarity($judul, $doc2);
    //     $total =$similarity*100;
    //     $result = substr($total, 0, 5);
    //     $format_result = $result."%";

    //      // menghitung pembobotan tf-idf abstrak
    //      $tf_idf2 = array();
    //      foreach ($tf2 as $doc_weights2) {
    //      $doc_tfidf2 = array();
    //      foreach ($doc_weights2 as $word2 => $weight2) {
    //          $doc_tfidf2[$word2] = $weight2 * $idf2[$word2];
    //      }
    //      $tf_idf2[] = $doc_tfidf2;
    //      }
    //      //cosine similarity pada abstraksi
    //      $similarity2 = $this->cosine_similarity2($abstrak, $doc2);
    //      $total2 =$similarity2*100;
    //      $result2 = substr($total2, 0, 5);
    //      $format_result2 = $result2."%";



    //     // return response($format_result);
    //     $response1 =  response([
    //         'judul' => $format_result,
    //         'abstraksi' => $format_result2,
    //     ]);

    //     $data = file_get_contents('http://program.test/api/getJA');
    //     $response = json_decode($data);

    //     $response2 = response($response);

    //     return [$response1, $response2];
    //     // return response()->json([$response1, $response2]);
    // }


    function execute(Request $request){
        // data dummy dari local sebagai repo
        // $data = dokumen::select('id','judul', 'abstraksi')->get();
        
        // // mengubah data collection menjadi array
        // $data_repo = $data->map(function ($item) {
        //     return [
        //         'id' => $item->id,
        //         'judul' => $item->judul,
        //         'abstraksi' => $item->abstraksi,
        //     ];
        // })->toArray();
        $data_repo = $this->getAPI();
        
        //menghitung cosine similarity pada judul
        $hasil_cosine_judul = array();
        //variable berisi persentase tertinggi
        $bigger_judul = 0;
        foreach ($data_repo as $key ) {
            $similarity = $this->cosine_similarity($request->judul, $key['judul']);
            $total =$similarity*100;
            $result = substr($total, 0, 4);
            //membandingkan nilai persentase tertinggi
            if ($result > $bigger_judul) {
                $bigger_judul = $result;
            }
            // masukan $key kesini
            $hasil_cosine_judul[] = [
                'id' => $key['id'],
                'judul' => $key['judul'],
                'persentase' => $result.'%',
            ];
        }
        // sorting dari persentase terbesar
        usort($hasil_cosine_judul, function($a, $b) {
            return -1 * strcmp($a['persentase'], $b['persentase']);
        });        

        //menghitung cosine similarity pada abstraksi
        $hasil_cosine_abstraksi = array();
        //variable berisi persentase tertinggi
        $bigger_abstraksi = 0;
        foreach ($data_repo as $key ) {
            $similarity2 = $this->cosine_similarity($request->abstraksi, $key['abstraksi']);
            $total2 =$similarity2*100;
            $result2 = substr($total2, 0, 4);
            //membandingkan nilai persentase tertinggi
            if ($result2 > $bigger_abstraksi) {
                $bigger_abstraksi = $result2;
            }
            $hasil_cosine_abstraksi[] = [
                'id' => $key['id'],
                'abstraksi' => $key['abstraksi'],
                'persentase' => $result2.'%',
            ];
        }
        // sorting dari persentase terbesar
        usort($hasil_cosine_abstraksi, function($a, $b) {
            return -1 * strcmp($a['persentase'], $b['persentase']);
        });
        
        // gabungan persentase judul dan abstrak yang di sort
        $total_persentase = array_merge($hasil_cosine_judul, $hasil_cosine_abstraksi);

        // Mengubah nilai persentase menjadi tipe data float
        foreach ($total_persentase as &$item) {
            $item['persentase'] = floatval($item['persentase']);
        }

        // Mengurutkan array secara numerik
        usort($total_persentase, function($a, $b) {
            return $b['persentase'] <=> $a['persentase'];
        });
        

        // print_r($bigger_abstraksi."<br><br>");
        // print_r($hasil_cosine_abstraksi);


        // bisa dihapus (pembobotan)


        //tfidf
        $doc2 = "tester";
        // membuat array dokumen
        $docs = array($request->judul, $doc2);
        $docs2 = array($request->abstrak, $doc2);

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
        $judul_words = preg_split('/\s+/', strtolower($request->judul), -1, PREG_SPLIT_NO_EMPTY);
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
        $judul_words2 = preg_split('/\s+/', strtolower($request->abstrak), -1, PREG_SPLIT_NO_EMPTY);
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
        $similarity = $this->cosine_similarity($request->judul, $doc2);
        $total =$similarity*100;
        $result = substr($total, 0, 4);
        $format_result = $result."%";


         // menghitung pembobotan tf-idf abstrak
         $tf_idf2 = array();
         foreach ($tf2 as $doc_weights2) {
         $doc_tfidf2 = array();
         foreach ($doc_weights2 as $word2 => $weight2) {
             $doc_tfidf2[$word2] = $weight2 * $idf2[$word2];
         }
         $tf_idf2[] = $doc_tfidf2;
         }
        //  dd($tf_idf);

        //  bobot 0.69314718055995
        //  batas bisa dihapus

        // variabel menampung karya ilmiah sejenis
        $output = [];

        // mengelompokkan data berdasarkan id
        $groups = [];
        foreach ($total_persentase as $data) {
            $id = $data['id'];
            if (!isset($groups[$id])) {
                $groups[$id] = [];
            }
            $groups[$id][] = $data;
        }
        
        // menggabungkan nilai persentase abstraksi dan judul jika keduanya tersedia
        foreach ($groups as $id => $data) {
            $item = ['id' => $id];
            foreach ($data as $d) {
                if (isset($d['abstraksi'])) {
                    $item['abstraksi'] = $d['abstraksi'];
                    $item['persentase_abstraksi'] = $d['persentase'];
                }
                if (isset($d['judul'])) {
                    $item['judul'] = $d['judul'];
                    if (isset($item['persentase_judul'])) {
                        $item['persentase_judul'] += $d['persentase'];
                    } else {
                        $item['persentase_judul'] = $d['persentase'];
                    }
                }
            }
            $output[] = $item;
        }
        // menampilkan top 10 data teratas
        $output = array_slice($output, 0, 10);



        // dd($total_persentase);
        $history = new history_check;
        $history->id_user = Auth::user()->id;
        $history->judul = $request->judul;
        $history->abstraksi = $request->abstraksi;
        $history->persentase_judul = $bigger_judul ;  
        $history->persentase_abstraksi = $bigger_abstraksi ;  
        $history->status = 0 ;  
        $history->save();

        return view('home', compact('output', 'bigger_judul', 'bigger_abstraksi'));
    }

    function showDetail($id){
        $detail_datas = $this->getAPI();
        // dd($detail);
        $detail_data = [];
        foreach ($detail_datas as $data) {
            if ($data['id'] == $id) {
                $detail_data = $data;
                break;
            }
        }
        // dd($detail_data);
        return view('detail', compact('detail_data'));
    }
    function validasi($judul,$abstrak){
        $judul1 = $judul;
        $abstrak1 = $abstrak;
        // dd($detail);
        return $judul1;
    }




    
    function calculateTFIDF($judul, $doc2) {
        // $text1 = "Pembelajaran secara daring merupakan salah satu cara mengajar yang efektif saat kondisi pandemi seperti saat ini, namun tentunya pembelajaran harus dikemas dengan baik, salah satunya seperti pada penelitian ini. Penelitian ini bertujuan untuk mengembangkan bahan ajar menggunakan live worksheet berbasis realistic mathematics educationRME berbantuan geogebra yang validitasnya baik dan juga praktis, kemudian menelaah pencapaian kemampuan abstraksi dengan menggunakan bahan ajar tersebut. Metode penelitian yang digunakan adalah pengembangan, dengan subjek yaitu siswa SMP. Instrumen yang digunakan yaitu lembar validasi, lembar observasi dan soal tes abstraksi. Teknik pengolahan data yang digunakan adalah dengan mengolah data menggunakan rumus validasi dan praktikalisasi dan menggunakan uji t satu pihak. Hasil penelitian yang diperoleh yaitu 1 bahan ajar sangat valid, dengan rata-rata penilaian validator sebesar 85% bahan ajar sudah dapat digunakan, terlebih dalam pembelajaran daring seperti saat ini; 2 bahan ajar sangat praktis untuk digunakan, dengan rata-rata penilaian yang diberikan oleh siswa sebesar 82%; 3 pencapaian kemampuan abstraksi siswa kelas yang menggunakan pembelajaran dengan bahan ajar  live worksheet berbasis RME berbantuan geogebra lebih baik dari pada yang menggunakan pembelajaran saintifik. Rekomendasi yang dapat diberikan adalah penggunaan live worksheet berbasis RME berbantuan geogebra menunjukkan hasil yang signifikan terhadap pembelajaran dan kemampuan abstraksi siswa.";

        // $text2 = "Upaya setiap perguruan tinggi  untuk meningkatkan pelayanan kepada seluruh sivitas akademika salah satunya adalah penyediaan fasilitas pelayanan berbasis teknologi informasi dan komunikasi , upaya tersebut dilakukan tidak lain untuk mempermudah proses pelayanan akademik. Hal ini dibuktikan salah satunya dengan banyaknya perguruan tinggi yang menerapkan sistem informasi akademik dengan berbagai bentuk dan teknologi. Pemanfaatan TIK terutama penerapan penggunaan sistem informasi pada bidang layanan administrasi akademik di perguruan tinggi saat ini menjadi suatu kebutuhan wajib supaya dapat meningkatkan daya saing perguruan tinggi. Tujuan penulisan artikel ini adalah untuk mengulas bagaimana implementasi pengembangan Student Information Terminal  pada perguruan tinggi. S-IT sendiri merupakan paket perangkat sistem informasi akademik mahasiswa yang mengkombinasikan hardware, software dan teknologi guna memudahkan pelayanan akademik kepada mahasiswa secara terkomputerisasi pada perguruan tinggi. Hasil akhir dari implementasi pengembangan (S-IT) ini diharapkan dapat meningkatkan fungsi pelayanan akademik perguruan tinggi terhadap mahasiswa secara mudah, cepat, efektif dan efisien.";

        // Membersihkan tanda baca
        $judul = preg_replace('/[^\w\s\/]/u', '', $judul);
        $doc2 = preg_replace('/[^\w\s\/]/u', '', $doc2);
        

        // membuat array dari kata-kata
        $judul_word = preg_split("/\s+/", strtolower($judul));
        $doc2_word = preg_split("/\s+/", strtolower($doc2));

        // menghapus stopword
        $stopWords = new StopWords();
        $stopwords = $stopWords->getStopWordsFromLanguage('id');
        $tokens_judul = explode(' ', $judul);
        $filteredTokens_judul= array_filter($tokens_judul, function ($token) use ($stopwords) {
            return !in_array($token, $stopwords, true);
        });

        $judul_word = $filteredTokens_judul;     
                
        $tokens_doc2 = explode(' ', $doc2);
        $filteredTokens_doc2 = array_filter($tokens_doc2, function ($token) use ($stopwords) {
            return !in_array($token, $stopwords, true);
        });
        $doc2_word = $filteredTokens_doc2;   


        // Menghitung Term Frequency (TF) dari kata-kata dalam teks 1
        $tf1 = array_count_values($judul_word);

        // Menghitung Term Frequency (TF) dari kata-kata dalam teks 2
        $tf2 = array_count_values($doc2_word);

        // Menggabungkan kata-kata dari kedua teks untuk mendapatkan total kumpulan kata
        $allWords = array_unique(array_merge($judul_word, $doc2_word));

        // Menghitung Inverse Document Frequency (IDF) untuk setiap kata dalam kumpulan kata
        $idf = array();
        $totalDocuments = 2; // Total jumlah dokumen (dalam kasus ini, ada 2 teks)
        foreach ($allWords as $word) {
            $wordInText1 = isset($tf1[$word]) ? 1 : 0;
            $wordInText2 = isset($tf2[$word]) ? 1 : 0;
            $documentFrequency = $wordInText1 + $wordInText2;
            $idf[$word] = log($totalDocuments / ($documentFrequency + 1)); // Menggunakan logaritma alami
        }

        // Menghitung TF-IDF untuk setiap kata dalam teks 1
        $tfidf1 = array();
        foreach ($tf1 as $word => $tfValue) {
            $tfidf1[$word] = $tfValue * $idf[$word];
        }

        // Menghitung TF-IDF untuk setiap kata dalam teks 2
        $tfidf2 = array();
        foreach ($tf2 as $word => $tfValue) {
            $tfidf2[$word] = $tfValue * $idf[$word];
        }
        // dd($tfidf1);
        // Mengembalikan nilai TF-IDF dari kedua teks dalam bentuk array
        return array($tfidf1, $tfidf2);
    
    }

    function highlightSameWords($tfidf1, $tfidf2) {
        // Mendapatkan kata-kata yang sama pada kedua array
        $sameWords = array_intersect(array_keys($tfidf1), array_keys($tfidf2));

        // Menandai kata-kata yang sama dengan warna merah pada array teks 1
        foreach ($tfidf1 as $word => $weight) {
            if (in_array($word, $sameWords)) {
                $tfidf1[$word] = $weight < -0.4 ? '<span style="background-color: yellow;">' . $word . '</span>' : $word;
            }
        }


        // Mengembalikan array yang telah ditandai
        return array($tfidf1, $tfidf2);
    }

    public function detail_persentase_judul($id)
    {
        $data = $this->getAPI();

        // Mengambil data dokumen berdasarkan ID
        $histories = history_check::select('judul')
            ->where('id', $id)
            ->first();
        // dd($histories->judul);
        // Mengolah kata-kata pada judul dan abstraksi
        $judul_words = explode(" ", $histories['judul']);

        // Mendapatkan kata-kata dengan bobot < -0.4 yang perlu diberi warna kuning
        $highlightedWords = array();
        foreach ($data as $item) {
            $tfidf = $this->calculateTFIDF($histories['judul'], $item['judul']);
            $highlightedTFIDF = $this->highlightSameWords($tfidf[0], $tfidf[1]);

            foreach ($highlightedTFIDF[0] as $word => $weight) {
                if (strpos($weight, 'yellow') !== false) {
                    $highlightedWords[] = $word;
                }
            }
        }
        

        return view('detail_persentase', [
            'judul_words' => $judul_words,
            'highlightedWords' => $highlightedWords
        ]);
    }

    public function detail_persentase_abstrak($id)
{
    $data = $this->getAPI();

    // Mengambil data dokumen berdasarkan ID
    $histories = history_check::select('abstraksi')
        ->where('id', $id)
        ->first();

    // Mengolah kata-kata pada abstraksi
    $abstraksi_words = explode(" ", $histories['abstraksi']);

    // Mendapatkan kata-kata dengan bobot < -0.4 yang perlu diberi warna kuning
    $highlightedWords = array();
    foreach ($data as $item) {
        $tfidfAbstraksi = $this->calculateTFIDF($histories['abstraksi'], $item['abstraksi']);
        $highlightedTFIDFAbstraksi = $this->highlightSameWords($tfidfAbstraksi[0], $tfidfAbstraksi[1]);

        foreach ($highlightedTFIDFAbstraksi[0] as $word => $weight) {
            if (strpos($weight, 'yellow') !== false) {
                if (!in_array($word, $highlightedWords)) {
                    $highlightedWords[] = $word;
                }
            }
        }
    }

    return view('detail_persentase', [
        'abstraksi_words' => $abstraksi_words,
        'highlightedWords' => $highlightedWords
    ]);
}



// // Contoh penggunaan fungsi

// $tfidf = calculateTFIDF($text1, $text2);

// // Menampilkan bobot TF-IDF untuk masing-masing teks
// echo "Bobot TF-IDF teks 1: ";
// print_r($tfidf[0]);

// echo "Bobot TF-IDF teks 2: ";
// print_r($tfidf[1]);


}
// slash pada abstraksi terbaca code
// menentukan nilai kesamaan tertinggi dari judul dan abstraksi yang diinputkan pada form, jika 
// abstraksi yang dapat kesamaan tertinggi maka tammpilkan berdasarkan abstraksi walaupun judulnya tidak mirip

// Fungsi executejadi menerima dua parameter, yaitu $judul dan $abstrak. Fungsi ini melakukan beberapa tugas terkait pengolahan dokumen dan pembobotan tf-idf serta perhitungan cosine similarity pada dokumen.

// Pertama, fungsi ini mengambil semua data judul dan abstraksi dari tabel dokumen menggunakan model dokumen dengan query dokumen::select('judul', 'abstraksi')->get(). Kemudian, dilakukan perulangan menggunakan foreach untuk setiap data judul, dimana nilai dari judul disimpan pada variabel $doc2. Selanjutnya, dibuat dua buah array $docs dan $docs2 yang berisi $judul dan $doc2 yang kemudian digunakan untuk perhitungan pembobotan tf-idf.

// Kemudian, dilakukan perhitungan pembobotan tf pada judul dan abstraksi menggunakan perulangan foreach. Stopwords telah diatur sebelumnya, dan kata-kata dari dokumen diubah menjadi huruf kecil dan kemudian dibagi menjadi array menggunakan preg_split('/\s+/', strtolower($doc), -1, PREG_SPLIT_NO_EMPTY) dengan tanda spasi sebagai delimiter. Selanjutnya, dilakukan penghitungan frekuensi kemunculan setiap kata dalam dokumen dengan array_count_values($words) untuk menghasilkan array berisi bobot untuk setiap kata pada dokumen, yang disimpan dalam variabel $tf dan $tf2 untuk dokumen judul dan abstraksi, masing-masing.

// Kemudian, dilakukan perhitungan pembobotan idf. Kata-kata pada dokumen diambil menggunakan preg_split('/\s+/', strtolower($judul), -1, PREG_SPLIT_NO_EMPTY) dan preg_split('/\s+/', strtolower($abstrak), -1, PREG_SPLIT_NO_EMPTY) untuk masing-masing judul dan abstraksi. Stopwords dihapus menggunakan array_diff($judul_words, $stopwords) dan array_diff($judul_words2, $stopwords2). Kemudian, dihitung jumlah dokumen yang mengandung setiap kata menggunakan perulangan foreach, dan kemudian dihitung idf untuk masing-masing kata dengan log($num_docs / $count) dan disimpan dalam variabel $idf dan $idf2 untuk dokumen judul dan abstraksi, masing-masing.

// Selanjutnya, dilakukan perhitungan pembobotan tf-idf pada dokumen judul dan abstraksi. Untuk setiap dokumen, bobot setiap kata dikalikan dengan idf-nya. Hasilnya disimpan dalam variabel $tf_idf dan $tf_idf2.

// Terakhir, dilakukan perhitungan cosine similarity pada judul dan abstraksi. Fungsi cosine_similarity dan cosine_similarity2 digunakan untuk menghitung cosine similarity antara dokumen yang dicari dan dokumen yang diambil. Hasil perhitungan cosine similarity dikonversi ke persentase dan disimpan dalam variabel $format_result dan $format_result2. Setelah itu, hasil akhir yang berisi data judul dan abstraksi dalam bentuk response JSON dikembalikan dengan response(['judul' => $format_result, 'abstraksi' => $format_result2]).

// Kemudian, variabel $data

