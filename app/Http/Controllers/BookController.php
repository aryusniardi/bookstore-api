<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Book;
use App\Http\Resources\Books as BookResourceCollection;
use App\Http\Resources\Book as BookResource;


class BookController extends Controller
{
    public function index() {
        $criteria = Book::paginate(4);
        return new BookResourceCollection($criteria);
    }

    public function print($title) {
        return $title;
    }

    public function view($id) {
        $book = new BookResourceCollection(Book::find($id));
        return $book;
    }

    public function top($count) {
        $criteria = Book::select('*')
        ->orderBy('views', 'DESC')
        ->limit($count)
        ->get();
        return new BookResourceCollection($criteria);
    }

    public function slug($slug) {
        $criteria = Book::where('slug', $slug)->first();
        return new BookResource($criteria);
    }

    public function search($keyword) {
        $criteria = Book::select('*')
        ->where('title', 'LIKE', "%".$keyword."%")
        ->orderBy('views', 'DESC')
        ->get();

        return new BookResourceCollection($criteria);
    }

    
}
