<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateRatingRequest;
use App\Models\BookMove;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookMoveController extends Controller
{
    public function index(Request $request){
        
        $move_ids = BookMove::query();

        if ($request['start_date'] !== null) {
            $move_ids->whereDate('borrow_date', '>=', $request['start_date']);
        }

        if ($request['end_date'] !== null) {
            $move_ids->whereDate('borrow_date', '<=', $request['end_date']);
        }

        $move_ids = $move_ids->get();

        return view('contents.borrowing_history.index',  ['title' => 'Riwayat Peminjaman', 'user' => Auth::user(), 'move_ids' => $move_ids] );
    }

    public function update_rating(UpdateRatingRequest $request)
    {

       $move_id = BookMove::where('id', $request['history_id'])->first();

       if (!$move_id->return_date){
           throw new HttpResponseException(response([
               'error' => [
                   'message' => 'You have to return the book first.'
               ]
           ], 400));
       }

       $move_id->rate = $request['rate'];
       $move_id->save();

       return new JsonResponse([
           'data' => [ 
               'history' => $move_id,
               'message' => 'Rate has been added' 
           ],
           'error' => ''
       ]);

    }

}
