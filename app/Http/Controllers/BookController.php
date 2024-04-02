<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetBookDetailRequest;
use App\Models\Book;
use App\Models\Category;
use App\Models\Language;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BookController extends Controller
{
    public function index(){

        $book_ids = Book::where('is_publish', '=', true)->paginate(10);

        $data = [
            'title' => 'Bibliography',
            'user' => Auth::user(),
            'book_ids' => $book_ids->items(), 
            'links' => $book_ids->links()

        ];

        return view('contents.bibliography.index', $data);
    }

    public function create(){
        
        $data = [
            'category_ids' => Category::all(),
            'language_ids' => Language::all(),
        ];

        return view('contents.bibliography.create', ['title' => 'Bibliography', 'user' => Auth::user()] + $data);
    }
    
    public function store(Request $request){
        
        $data = $request->validate([
            'category_id' => 'required|integer',
            'language_id' => 'required|integer',
            'name' => 'required|string',
            'writer' => 'required|string',
            'publisher' => 'required|string',
            'type' => 'required|string',
            'isbn' => 'required|string',
            'publish_place' => 'required|string',
            'publish_period' => 'required|integer',
            'publish_year' => 'required',
            'internal_reference' => 'required|string',
            'synopsis' => 'required|string',
            'is_publish' => '',
            'stock' => 'required|integer',
        ]);

        $file = $request->validate([
            'cover_file' => 'required|image|mimes:jpeg,png,jpg,gif',
            'book_file' => 'required|',
        ]);

        $data['is_publish'] =(@$data['is_publish'] == 'on') ? TRUE : FALSE ;


        DB::beginTransaction();

        try {
            $book_id = Book::create($data);

            $fileName = $book_id->id . '-' .  Str::uuid();
            
            // Cover
            $coverFile = $file['cover_file'];   
            $book_id->cover_path = $coverFile->storeAs('books/covers', $fileName . "." . $coverFile->getClientOriginalExtension() , 'public');
    
            
            // Files
            $bookFile = $file['book_file'];
            $book_id->book_path = $bookFile->storeAs('books/files', $fileName . "." . $bookFile->getClientOriginalExtension() , 'public');
            
            $book_id->save();

            DB::commit();
    
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->withErrors(['error' => '02', 'message' => 'Failed to save book']);
        }

        return redirect()->intended('/bibliography');

    }

    public function edit($id){
        
        $book_id = Book::where('id', '=', $id)->first();

        
        if ($book_id) {
            $data = [
                'category_ids' => Category::all(),
                'language_ids' => Language::all(),
                'book_id' => $book_id,
            ];
            return view('contents.bibliography.edit',  ['title' => 'Bibliography', 'user' => Auth::user()] + $data);
        } else {
            return redirect()->intended('/bibliography');
        }
    }

    public function update(Request $request, $id)
    {
        
        $data = $request->validate([
            'category_id' => 'required|integer',
            'language_id' => 'required|integer',
            'name' => 'required|string',
            'writer' => 'required|string',
            'publisher' => 'required|string',
            'type' => 'required|string',
            'isbn' => 'required|string',
            'publish_place' => 'required|string',
            'publish_period' => 'required|integer',
            'publish_year' => 'required',
            'internal_reference' => 'required|string',
            'synopsis' => 'required|string',
            'is_publish' => '',
            'stock' => 'required|integer',
        ]);

        $file = $request->validate([
            'cover_file' => 'image|mimes:jpeg,png,jpg,gif',
            'book_file' => '',
            'stock' => 'required|integer',
        ]);

        $data['is_publish'] =(@$data['is_publish'] == 'on') ? TRUE : FALSE ;


        $book_id = Book::findOrFail($id);
        $book_id->update($data);

        $fileName = $book_id->id . '-' .  Str::uuid();

        if (@$file['cover_file']) {
            Storage::delete($book_id->cover_path);
            $coverFile = $file['cover_file'];   
            $book_id->cover_path = $coverFile->storeAs('books/covers', $fileName . "." . $coverFile->getClientOriginalExtension() , 'public');
        }
        
        if (@$file['book_file']) {
            Storage::delete($book_id->book_path);
            $bookFile = $file['book_file'];
            $book_id->book_path = $bookFile->storeAs('books/files', $fileName . "." . $bookFile->getClientOriginalExtension() , 'public');
        }

        $book_id->save();

        return redirect()->intended("/bibliography/edit/$id");

    }

    
    public function get_book_list()
    {
        $books = Book::where('is_publish', '=', true)->get();

        return new JsonResponse([
            'data' => [ 
                'book_lists' => ($books) ? $books : [] 
            ],
            'error' => ''
        ]);
    }

    public function get_book_detail(GetBookDetailRequest $request)
    {
    $data = $request->validated();

        $book = Book::where('id', $data['book_id'])->first();

        return new JsonResponse([
            'data' => [
                'book_lists' => $book
            ],
            'error' => ''
        ]);
    }

    public function download(Book $book)
    {
        if (!$book->book_path) {
            abort(404);
        }

        $filePath = storage_path('app/public/' . $book->book_path);
        
        return response()->download($filePath, 'pdffile');
    }
}
