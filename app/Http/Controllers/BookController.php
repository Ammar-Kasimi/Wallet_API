<?php

namespace App\Http\Controllers;

use App\Http\Requests\storeBookRequest;
use App\Models\Book;

use Illuminate\Http\Request;

class BookController extends Controller
{


    public function index()
    {
        $book = Book::with('category')->get();
        return response()->json(['status' => 'success', 'data' => $book]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(storeBookRequest $request)
    {
        // $validated = $request->validate([
        //     'title' => 'required|string|max:255',
        //     'author' => 'required|string|max:255',
        //     'isbn' => 'required|string|unique:books,isbn',
        //     'published_year' => 'required|integer|min:1000|max:' . date('Y'),
        //     'category_id' => 'required|exists:categories,id'
        // ]);
        $book = Book::create($request->validated());
        $book->load('category');
        return response()->json(['status' => 'sucess', 'message' => 'book created successufly', 'data' => $book], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        $book->load('category');
        return response()->json(['status' => 'success', 'data' => $book]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'author' => 'sometimes|required|string|max:255',
            'isbn' => 'sometimes|required|string|unique:books,isbn,' .
                $book->id,
            'published_year' => 'sometimes|required|integer|min:1000|max:' .
                date('Y'),
            'category_id' => 'sometimes|required|exists:categories,id',
        ]);

        $book->update($validated);
        $book->load('category');

        return response()->json([
            'status' => 'success',
            'message' => 'Livre mis à jour',
            'data' => $book
        ]);
    }
 
     // DELETE /api/books/


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return response()->json(['status'=>'sucess','message'=>'book deleted successfuly']);
    }
}
