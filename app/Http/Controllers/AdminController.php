<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\admin;
use Illuminate\Support\Facades\DB;
use App\Models\history_check;
use DataTables;
use Charts;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function __construct() {
        if (Session::get('status') != 'login') {
            return redirect('/loginAdmin');
        }
    }

    public function showLoginForm()
    {
        return view('admin.loginAdmin');
    }

    public function home()
    {
        // persentase judul chart
        $response_judul  = $this->p_judul();
        $originalData1 = $response_judul->original['data'];
        $judul = array_values($originalData1);

        // persentase abstraksi chart
        $response_abstraksi  = $this->p_abstraksi();
        $originalData2 = $response_abstraksi->original['data'];
        $abstraksi = array_values($originalData2);
        // dd(json_encode($nilaiKeseluruhan    ));
        return view('admin/homeAdmin', compact('judul', 'abstraksi'));
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $admin = admin::where('email', $credentials['email'])->first();

        if ($admin && $admin->authenticate($credentials['password'])) {
           
            Session::put('status', 'login');

            return $this->home();
        }
        else{
            dd('bb');
            // Login gagal
            return back()->withErrors([
                'email' => 'Email atau kata sandi salah.',
            ]);
        }
        
    }

    // chart
    public function make_chart()
    {
        $data = $this->getData();

        $chart = Charts::title('Persentase Kemiripan')
            ->labels(['0-10', '10-20', '20-30'])
            ->dataset('Jumlah Orang', $data)
            ->responsive(false)
            ->height(300);

        return $chart;
    }

    private function getData()
    {
        // Query untuk mendapatkan jumlah orang dalam rentang persentase kemiripan
        $data = [
            history_check::whereBetween('persentase_judul', [0, 10])->count(),
            history_check::whereBetween('persentase_judul', [10, 20])->count(),
            history_check::whereBetween('persentase_judul', [20, 30])->count(),
        ];

        return $data;
    }

    public function history()
    {
        if (Session::get('status') != 'login') {
            return redirect('/loginAdmin');
        }
        return view('admin/history_check');
    }
    
    public function datatables()
    {
        $history = DB::table('history_checks as h')
        ->leftJoin('users as u', 'h.id_user', '=', 'u.id')
        ->select('h.*', 'u.name')->get();
        return DataTables::of($history)
        ->addColumn('action', function ($row) {
            $actionBtns = '<div style="display: flex; gap: 10px;">';
        
            if ($row->status == 1 ) {
                $actionBtns .= '<p class="font-weight-bold bg-success px-3">Approved</p>';
            }
            else if ($row->status == 2 ){
                $actionBtns .= '<p class="font-weight-bold text-danger bg-danger px-3">Rejected</p>';
            }
            else{
                $actionBtns .= '<button class="btn btn-success btn-icon-text btn-sm" onclick="if (confirm(\'Are you sure you want to approve this item?\')) { window.location.href = \'approve/' . $row->id . '\'; }">';
                $actionBtns .= '<i class="fas fa-check"></i>';
                $actionBtns .= '<span>Approve</span>';
                $actionBtns .= '</button>';
        
                $actionBtns .= '<button class="btn btn-warning btn-icon-text btn-sm" onclick="if (confirm(\'Are you sure you want to reject this item?\')) { window.location.href = \'reject/' . $row->id . '\'; }">';
                $actionBtns .= '<i class="fas fa-times"></i>';
                $actionBtns .= '<span>Reject</span>';
                $actionBtns .= '</button>';
            

                $actionBtns .= '<button class="btn btn-danger btn-icon-text btn-sm" onclick="if (confirm(\'Are you sure you want to delete this item?\')) { window.location.href = \'delete/' . $row->id . '\'; }">';
                $actionBtns .= '<i class="fas fa-trash"></i>';
                $actionBtns .= '<span>Delete</span>';
                $actionBtns .= '</button>';
                $actionBtns .= '</div>';
            }
            return $actionBtns;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function logout()
    {
        Session::forget('status');
        return redirect('/loginAdmin');
    }

    public function approve($id)
    {
        $history = history_check::findOrFail($id);
        $history->status = 1;
        $history->save();
        return redirect()->route('history-check')->with('success', 'Berhasil Approve.');
    }

    public function reject($id)
    {
        $history = history_check::findOrFail($id);
        $history->status = 2;
        $history->save();
        return redirect()->route('history-check')->with('warning', 'Berhasil Reject.');
    }

    public function edit($id)
    {
        $history = history_check::findOrFail($id);
        // Lakukan apa yang perlu Anda lakukan untuk tampilan pengeditan
        return view('history.edit', compact('history'));
    }

    public function delete($id)
    {
        $history = history_check::findOrFail($id);
        // dd($history);
        // Lakukan apa yang perlu Anda lakukan untuk menghapus data
        $history->delete();

        return redirect()->route('history-check')->with('success', 'Data berhasil dihapus.');
    }

    // get persentase judul
    public function p_judul()
    {
        $ranges = [
            '0-10%' => [0, 10],
            '11-20%' => [11, 20],
            '21-30%' => [21, 30],
            '31-40%' => [31, 40],
            '41-50%' => [41, 50],
            '51-100%' => [51, 100],
            // tambahkan rentang persentase lainnya di sini
        ];

        $jumlahOrang = [];

        foreach ($ranges as $range => $limits) {
            $start = $limits[0];
            $end = $limits[1];

            $count = history_check::whereBetween('persentase_judul', [$start, $end])->count();

            $jumlahOrang[$range] = $count;
        }

        // return response()->json($jumlahOrang);
        return response()->json(['data' => $jumlahOrang]);
    }
    public function p_abstraksi()
    {
        $ranges = [
            '0-10%' => [0, 10],
            '11-20%' => [11, 20],
            '21-30%' => [21, 30],
            '31-40%' => [31, 40],
            '41-50%' => [41, 50],
            '51-100%' => [51, 100],
            // tambahkan rentang persentase lainnya di sini
        ];

        $jumlahOrang = [];

        foreach ($ranges as $range => $limits) {
            $start = $limits[0];
            $end = $limits[1];

            $count = history_check::whereBetween('persentase_abstraksi', [$start, $end])->count();

            $jumlahOrang[$range] = $count;
        }

        // return response()->json($jumlahOrang);
        return response()->json(['data' => $jumlahOrang]);
    }
}
