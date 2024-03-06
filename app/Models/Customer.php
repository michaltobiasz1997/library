<?php

namespace App\Models;

use App\Observers\CustomerObserver;
use Database\Factories\CustomerFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * App\Models\Customer
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property Carbon|null $birth_date
 * @property string|null $pesel
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Collection|Book[] $books
 * @property-read Collection<int, Book> $booksHistory
 * @method static CustomerFactory factory($count = null, $state=[])
 * @mixin Eloquent
 */
class Customer extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * @inheritdoc
     */
    protected $guarded = ['id'];

    public static function booted(): void
    {
        self::observe(CustomerObserver::class);
    }

    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }

    public function booksHistory(): BelongsToMany
    {
        return $this
            ->belongsToMany(Book::class)
            ->using(BookCustomer::class)
            ->withPivot('id', 'returned_at')
            ->as('book_customer')
            ->withTimestamps();
    }
}
