<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Book;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    /**
     * 一覧
     * @return Response
     */
    public function index(): Response
    {
        return Inertia::render('Books/Index', [
            'books' => Book::where('user_id', Auth::id())->with('user:id,name')->latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * 新規登録処理
     * @param BookRequest $request
     * @return RedirectResponse
     */
    public function store(BookRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // ファイルをストレージに保存
        $validated['filepath'] = $request->file->store('books/' . $request->user()->id, 'public');
        // DBに情報を保存
        $request->user()->books()->create($validated);

        return redirect(route('books.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * 編集画面表示
     * @param Book $book
     * @return Response
     */
    public function edit(Book $book) :Response
    {
        return Inertia::render('Books/Edit', [
            'book' => $book,
        ]);
    }

    /**
     * 更新処理
     * @param BookRequest $request
     * @param Book $book
     * @return RedirectResponse
     */
    public function update(BookRequest $request, Book $book) :RedirectResponse
    {
        Gate::authorize('update', $book);

        $validated = $request->validated();
        $book->update($validated);

        return redirect(route('books.index'));
    }

    /**
     * 削除処理
     * @param Book $book
     * @return RedirectResponse
     */
    public function destroy(Book $book): RedirectResponse
    {
        sleep(1);

        Gate::authorize('delete', $book);

        // ファイルの実体を削除。削除出来たら、DBレコードも削除
        if (Storage::delete($book->filepath)) {
            $book->delete();
        }

        return redirect(route('books.index'));
    }
}
