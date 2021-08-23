<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    //CREATE METHOD - POST
    public function create(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'book_cost' => 'required',
        ]);

        $auth_id = auth()->user()->id;
        $book = new Book();
        $book->author_id =  $auth_id;
        $book->title = $request->title;
        $book->description = $request->description;
        $book->book_cost = $request->book_cost;

        $book->save();

        return response()->json(['status' => 1, 'message' => 'Book created succssfully']);
    }

    //LIST METHOD - GET
    public function listBook()
    {
        $books = Book::get();
        return response()->json(['status' => 1, 'message' => 'All Book', 'data'=> $books]);
    }

    //SINGLE BOOK METHOD - GET
    public function singleBook($book_id)
    {
        $author_id = auth()->user()->id;

        if(Book::where(['id' => $book_id, 'author_id' => $author_id])){

            $books = Book::find($book_id);
            return response()->json(['status' => 1, 'message' => 'single  Book', 'data'=> $books]);

        }else{
            return response()->json(['status' => 0, 'message' => 'Book Not Found']);

        }
    }

    //Author BOOK METHOD - GET
    public function authorBook()
    {
        $author_id = auth()->user()->id;
        $books = Author::find($author_id)->books;
        return response()->json(['status' => 1, 'message' => 'Authors Book', 'data'=> $books]);
    }

     //UPDATE BOOK METHOD - GET
     public function updateBook(Request $request,$book_id)
     {
        $author_id = auth()->user()->id;

        if(Book::where(['id' => $book_id, 'author_id' => $author_id])){

            $book = Book::find($book_id);

            $book->title = isset($request->title) ? $request->title : $book->title;
            $book->description = isset($request->description) ? $request->description : $book->description;
            $book->book_cost = isset($request->book_cost) ? $request->book_cost : $book->book_cost;
            $book->save();


            return response()->json(['status' => 1, 'message' => 'Book Data has been updated', 'data'=> $book]);

        }else{
            return response()->json(['status' => 0, 'message' => 'Book Not Found']);

        }

     }

     //DEELTE BOOK METHOD - GET
     public function deleteBook($book_id)
     {
        $author_id = auth()->user()->id;
        if(Book::where(['id' => $book_id, 'author_id' => $author_id])){

            Book::findOrFail($book_id)->delete();
            return response()->json(['status' => 1, 'message' => 'Delete  Book']);

        }else{
            return response()->json(['status' => 0, 'message' => "Author Book doesn't exit"]);

        }
        
     }

}
