<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\history_check;
use Illuminate\Support\Facades\Auth;
use DataTables;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function history()
    {
        $history = DB::table('history_checks as h')
                    ->select('h.*', 'u.name')
                    ->leftJoin('users as u', 'h.id_user', '=', 'u.id')
                    ->where('h.id_user', Auth::user()->id)
                    ->get();
        return view('history');
    }
    
    public function datatables()
    {
        $userId = Auth::user()->id;
        $history = DB::table('history_checks as h')
                    ->leftJoin('users as u', 'h.id_user', '=', 'u.id')
                    ->select('h.*', 'u.name')
                    ->WHERE('h.id_user','=', $userId)
                    ->get();
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
                $actionBtns .= '<p class="font-weight-bold text-danger bg-warning px-3">Waiting</p>';
            }
            return $actionBtns;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

}
