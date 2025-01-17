<?php

namespace App\Http\Controllers;
 
use App\Models\Book;
use App\Models\Category;
use App\Models\Borrowing;
use Illuminate\Http\Request;
 
class BookController extends Controller {
    public function index() {
        $books = Book::with('category')->get();
        return view('books.index', compact('books'));
    }

    public function borrow($id)
    {
        $book = Book::findOrFail($id); 

        if (!$book->available) {
            return redirect()->route('books.index')->with('error', 'A könyv nem elérhető!');
        }

        Borrowing::create([
            'user_id' => auth()->id(), 
            'book_id' => $book->id,     
            'start_date' => now(),      
        ]);

        $book->update(['available' => 0]);

        return redirect()->route('dashboard')->with('success', 'A könyvet sikeresen kikölcsönözted!');
    }

    public function returnBook($id)
    {
        $borrowing = Borrowing::where('book_id', $id)
            ->where('user_id', auth()->id())
            ->whereNull('end_date')          
            ->firstOrFail();                

        $borrowing->update(['end_date' => now()]);

        $book = Book::findOrFail($id);
        $book->update(['available' => true]);

        return redirect()->route('books.index')->with('success', 'A könyvet sikeresen visszaadtad!');
    }

    public function create()
    {
        $categories = Category::all();
        return view('dashboard', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
        ]);
          
        Book::create([
            'title' => $request->title,
            'author' => $request->author,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('dashboard')->with('success', 'A könyv sikeresen hozzáadva!');
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()->route('books.index')->with('success', 'Könyv sikeresen törölve.');
    }

    public function back() {
        return redirect()->route('dashboard')->with('success', 'Könyv sikeresen törölve.');
    }
}
