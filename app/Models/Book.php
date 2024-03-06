<?php

namespace App\Models;

use App\Enums\BookStatusEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\Book
 * @property int $id
 * @property int|null $customer_id
 * @property string $title
 * @property string $author
 * @property int $year
 * @property string $publisher
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read BookStatusEnum $status
 * @property-read Customer $customer
 * @property-read Collection<int, Customer> $customersHistory
 */
class Book extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * @inheritdoc
     */
    protected $guarded = ['id'];

    protected function status(): Attribute
    {
        return Attribute::make(
            get: fn () => is_null($this->customer_id) ? BookStatusEnum::AVAILABLE : BookStatusEnum::BORROWED,
        );
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function customerHistory(): BelongsToMany
    {
        return $this
            ->belongsToMany(Customer::class)
            ->using(BookCustomer::class)
            ->withPivot('id', 'returned_at')
            ->as('book_customer')
            ->withTimestamps();
    }
}
