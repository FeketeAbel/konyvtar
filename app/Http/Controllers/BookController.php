<?php

namespace App\Http\Controllers;
 
use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Http\Request;
 
class BookController extends Controller {
    public function index() {
        $books = Book::with('category')->get();
        return view('books.index', compact('books'));
    }

    public function borrow($id) {
        $book = Book::findOrFail($id);
 
        if (!$book->available) {
            return redirect()->route('books.index')->with('error', 'A könyv nem elérhető!');
        }
 
        Borrowing::create([
            'user_id' => auth()->id(),
            'book_id' => $book->id,
            'start_date' => now(),
        ]);
 
        $book->update(['available' => false]);
 
        return redirect()->route('books.index')->with('success', 'A könyvet sikeresen kikölcsönözted!');
    }

    public function returnBook($id) {
        $borrowing = Borrowing::where('book_id', $id)
            ->where('user_id', auth()->id())
            ->whereNull('end_date')
            ->firstOrFail();
     
        $borrowing->update(['end_date' => now()]);
     
        $book = Book::findOrFail($id);
        $book->update(['available' => true]);
     
        return redirect()->route('books.index')->with('success', 'A könyvet sikeresen visszaadtad!');
    }
}
