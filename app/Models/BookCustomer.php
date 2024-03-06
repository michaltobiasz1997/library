<?php

namespace App\Models;

use App\Observers\BookCustomerObserver;
use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Carbon;

/**
 * App\Models\BookCustomer
 * @property int $id
 * @property int $book_id
 * @property int $customer_id
 * @property Carbon|null $returned_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Book $book
 * @property-read Customer $customer
 * @mixin Eloquent
 */
class BookCustomer extends Pivot
{
    use HasFactory;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @return bool
     */
    public $incrementing = true;

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
