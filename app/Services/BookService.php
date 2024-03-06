<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Customer;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class BookService
{
    public function search(?string $phrase): Builder
    {
        $phrase = Str::lower($phrase);

        return Book::query()
            ->where(function (Builder $query) use ($phrase) {
                $query
                    ->whereRaw('LOWER(title) LIKE ?', '%' . $phrase . '%')
                    ->orWhereRaw('LOWER(author) LIKE ?', '%' . $phrase . '%');
            })
            ->orWhereHas('customer', function (Builder $query) use ($phrase) {
                $query
                    ->whereRaw('LOWER(CONCAT(first_name, " ", last_name)) LIKE ?', '%' . $phrase . '%');
            });
    }

    /**
     * @throws Exception
     */
    public function borrow(Book $book, Customer $customer): Book
    {
        if (null !== $book->customer_id) {
            throw new Exception('This book is already borrowed');
        }

        $book->customerHistory()->attach($customer->id);

        $book->customer()->associate($customer);
        $book->save();

        return $book;
    }

    /**
     * @throws Exception
     */
    public function drop(Book $book): Book
    {
        if (null === $book->customer_id) {
            throw new Exception('This book is not borrowed');
        }

        $book
            ->customerHistory()
            ->wherePivotNull('returned_at')
            ->updateExistingPivot($book->customer_id, [
                'returned_at' => now(),
            ]);

        $book->customer()->dissociate();
        $book->save();

        return $book;
    }
}
