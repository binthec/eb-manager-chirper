<?php

namespace App\Repositories;

use App\Interfaces\BookRepositoryInterface;
use App\Models\Book;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class BookRepository implements BookRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getAllBooks(): Collection
    {
        return Book::all();
    }

    /**
     * @param string $userId
     * @param bool $latest
     * @return Collection
     */
    public function findByUserId(string $userId, bool $latest = true): Collection
    {
        $query = Book::where('user_id', $userId)->with('user:id,name');
        if($latest) $query->latest(); // 昇順指定ある場合は latest() をつける

        return $query->get();
    }

    /**
     * @param $bookId
     * @return Book
     */
    public function findById($bookId): Book
    {
        return Book::findOrFail($bookId);
    }

    /**
     * @param array $bookDetails
     * @return Book
     */
    public function create(array $bookDetails) : Book
    {
        $bookDetails['user_id'] = Auth::id(); // TODO: リレーションについて再考する
        return Book::create($bookDetails);
    }

    /**
     * @param $bookId
     * @param array $newDetails
     * @return bool
     */
    public function update($bookId, array $newDetails) :bool
    {
        return Book::whereId($bookId)->update($newDetails);
    }

    /**
     * @param $bookId
     * @return bool
     */
    public function destroy($bookId) :bool
    {
        return Book::destroy($bookId);
    }
}
