<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddWishListRequest;
use App\Http\Requests\ApiUserLoginRequest;
use App\Http\Requests\BorrowBookRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\DeleteWishListRequest;
use App\Http\Requests\ReturnBookRequest;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\WebUserLoginRequest;
use App\Models\Book;
use App\Models\BookMove;
use App\Models\Institution;
use App\Models\LoginHistory;
use App\Models\Major;
use App\Models\User;
use App\Models\WishList;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index(){
        $user_ids = User::all();

        return view('contents.member.index',  ['title' => 'Anggota', 'user' => Auth::user(), 'user_ids' => $user_ids] );
    }

    public function create(){
        $data = [
            'institution_ids' => Institution::all(),
            'major_ids' => Major::all(),
        ];

        return view('contents.member.create',  ['title' => 'Anggota', 'user' => Auth::user()] + $data );
    }
    
    public function store(Request $request){
        
        $data = $request->validate([
            'institution_id' => 'required|integer',
            'username' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'password' => 'required',
            'name' => 'required',
            'join_date' => 'required',
            'gender' => 'required',
            'active' => '',
            'address' => '',
            'major_id' => 'required',
        ]);

        $data['active'] =(@$data['active'] == 'on') ? 0 : 1 ;

        $data['password'] = Hash::make($data['password']);
        
        User::create($data);

        return redirect()->intended("/member")->with('success', 'Book created successfully');

    }

    public function edit($id){
        
        $user_id = User::findOrFail($id);

        if (@$user_id) {
            $data = [
                'institution_ids' => Institution::all(),
                'major_ids' => Major::all(),
                'user_id' => $user_id,
            ];
            return view('contents.member.edit',  ['title' => 'Anggota', 'user' => Auth::user()] + $data);
        } else {
            return redirect()->intended('/member');
        }
    }

    public function update(Request $request, $id){
        
        $user_id = User::findOrFail($id);

        $data = $request->validate([
            'institution_id' => 'required|integer',
            'username' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'name' => 'required',
            'join_date' => 'required',
            'gender' => 'required',
            'active' => '',
            'address' => '',
            'major_id' => 'required',
        ]);

        $data['active'] =(@$data['active'] == 'on') ? 0 : 1 ;


        if (@$request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $user_id->update($data);
        $user_id->save();

        dd($data);

        // return redirect()->intended("/member/edit/$id");
        return redirect()->intended("/member")->with('success', 'Book updated successfully');

    }

    public function login(){
        return view('login', ['title' => 'Login']);
    }

    public function action_login(Request $request){
        
        if (Auth::attempt(['username' => $request['username'], 'password' => $request['password']])) {
            $user = $request->user();
            $token = $user->generateToken();
            return ['error' => '00', 'data' => ['user_id' => $user] + $token];
        } 

        return ['error' => '01', 'message' => 'Username Atau Password Salah', 'data' => []];
    }

    public function web_login(WebUserLoginRequest $request)
    {
        $res = $this->action_login($request);
        if ($res['error'] == '00'){
            $user = $res['data']['user_id'];
            if ($user->role == 'super_admin' or $user->role == 'admin') {
                return redirect()->intended('/');
            } else {
                $res =  ['error' => '01', 'message' => 'Username Atau Password Salah', 'data' => []];
            }
        }

        return back()->withErrors($res);

    }

    public function api_login(ApiUserLoginRequest $request)
    {
        $res = $this->action_login($request);
        if ($res['error'] == '00'){
            $user = auth()->user();
            
            LoginHistory::create([
                'user_id' => $user->id,
            ]);
            
            return new JsonResponse([
                'data' => [
                    'name' => $user->name,
                    'access_token' => $res['data']['access_token'],
                    'refresh_token' => $res['data']['refresh_token'],
                ],
                'error' => ''
            ]);
        } else {
                return new JsonResponse(['error' => 'Invalid credentials'], 401);
            }
    }

    public function get_user_info()
    {
        $user = Auth::user();

        return new JsonResponse([
            'data' => [
                'name' => $user->name,
                'email' => $user->email,
                'username' => $user->username,
                'major' => $user->major->name,
                'generation' => $user->generation,
            ],
            'error' => ''
        ]);
    }

    
    public function get_wish_list()
    {
        $user = Auth::user();
        $wish_lists = $user->wish_lists;

        return new JsonResponse([
            'data' => [
                'wish_lists' => $wish_lists,
            ],
            'error' => ''
        ]);
    }

    public function add_wish_list(AddWishListRequest $request)
    {
        $data = $request->validated();

        $user = Auth::user();

        $wish_list = WishList::create([
            'user_id' => $user->id,
            'book_id' => $data['book_id'],
        ]);

        return new JsonResponse([
            'data' => [
                'wish_lists' => $wish_list,
            ],
            'error' => ''
        ]);
    }

    public function delete_wish_list(DeleteWishListRequest $request)
    {
        $data = $request->validated();
        $wish_list = WishList::where('id', $data['wishlist_id'])->first();
     
        $wish_list->delete();
     
        return new JsonResponse([
            'data' => [
                'message' => 'Wishlist Deleted',
            ],
            'error' => ''
        ]);
    }

    
    public function borrow_book(BorrowBookRequest $request)
    {
        $data = $request->validated();
        $book = Book::where('id', $data['book_id'])->first();
        
        $user = Auth::user();

        $existing_borrow = BookMove::where('user_id', $user->id) ->where('book_id', $data['book_id'])->whereNull('return_date')->first();
        
        if ($existing_borrow) {
            throw new HttpResponseException(response([
                'error' => [
                    'message' => 'You have already borrowed this book.'
                ]
            ], 400));
        }
        
        if ($book->stock_left <= 0) {
            throw new HttpResponseException(response([
                'error' => [
                    'message' => 'Book run out of stock'
                ]
            ], 400));
        }

        $borrowed_date = now();
        $expires_date = $borrowed_date->addDay();

        $book_move = BookMove::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'borrow_date' => $borrowed_date,
            'expires_date' => $expires_date,
        ]);

        return new JsonResponse([
            'data' => [
                'borrow_lists' => $book_move,
                'file_url' => $book->getDownloadLink(),
            ],
            'error' => ''
        ]);
    }
    
    public function return_book(ReturnBookRequest $request)
    {
        $data = $request->validated();
        $user = Auth::user();
        $book_move = BookMove::where('user_id', $user->id)->where('book_id', $data['book_id'])->whereNull('return_date')->first();

        if ($book_move) {
            
            $book_move->return_date = now();
            $book_move->save();
            
            return new JsonResponse([
                'data' => [
                    'message' => 'Book returned successfully',
                ],
                'error' => ''
            ]);
        } else {
            throw new HttpResponseException(response([
                'error' => [
                    'message' => 'No Borrow Book Found'
                ]
            ], 400));
        }
    }

    public function get_book_list()
    {
        $user = Auth::user();

        $books = $user->borrowed_book;

        return new JsonResponse([
            'data' => [
                'book_lists' => $books,
            ],
            'error' => ''
        ]);
    }

    public function get_history()
    {
        $user = Auth::user();

        $historys = $user->borrowed_history;

        return new JsonResponse([
            'data' => [
                'history_lists' => $historys,
            ],
            'error' => ''
        ]);
    }

    public function change_password(ChangePasswordRequest $request)
    {
        $data = $request->validated();
        
        $user = Auth::user();

        if (!Hash::check($data['current_password'], $user->password)) {
            return response()->json(['error' => 'Current password is incorrect'], 401);
        }

        // Update the password
        $user->password = Hash::make($data['new_password']);
        $user->save();

        return new JsonResponse([
            'data' => [
                'message' => 'Password changed successfully',
            ],
            'error' => ''
        ]);
    }

    public function action_logout(Request $request)
    {
        $request->user()->tokens->each(function ($token) {
            $token->delete();
        });

        return ['error' => '', 'data' => []];
    }

    public function web_logout(Request $request)
    {
        $this->action_logout($request);
        
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->intended('/login');
    }

}
