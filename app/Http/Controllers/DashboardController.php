<?php

namespace App\Http\Controllers;

use App\Models\Major;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request){
        
        $major_ids = Major::all();
        
        $datas = [
            'total_visitors' => 0,
            'total_book_borrowed' => 0,
            'chart_data' => [
                'labels' => [],
                'total_visitors' => [],
                'total_book_borrowed' => [],
            ],
        ];

        foreach ($major_ids as $major_id) {
            $total_book_borrowed = $major_id->total_book_borrowed($request['start_date'], $request['end_date']);
            $total_visitors = $major_id->total_visitors($request['start_date'], $request['end_date']);

            array_push($datas['chart_data']['labels'], $major_id->alias !== "" ? $major_id->alias : $major_id->name);
            array_push($datas['chart_data']['total_visitors'], $total_visitors);
            array_push($datas['chart_data']['total_book_borrowed'], $total_book_borrowed);
            
            $datas['total_book_borrowed'] +=  $total_book_borrowed;
            $datas['total_visitors'] += $total_visitors;
        }

        return view('contents.dashboard.index', ['title' => 'Dashboard', 'user' => Auth::user(), 'dashboard_data' => $datas, 'start_date' => $request['start_date'], 'end_date' => $request['end_date']]);

    }
}
