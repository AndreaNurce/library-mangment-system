<?php

namespace App\Models;

use App\Enums\LoanRequestStatusEnum;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use http\QueryString;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Book extends Model implements Viewable
{
    use HasFactory;
    use SoftDeletes;
    use HasSlug;
    use InteractsWithViews;

    public static string $morph_key = 'book';

    protected $guarded = ['id'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'in_stock' => 'boolean',
        'is_highlighted' => 'boolean',
        'publication_year' => 'date',
    ];

    protected $appends = [
        'path',
    ];

    public function getPathAttribute(): ?string
    {
        return $this->cover_image_url ? storage_asset($this->cover_image_url) : null;
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->slugsShouldBeNoLongerThan(50)
            ->saveSlugsTo('slug');
    }

    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class, 'book_id', 'id');
    }

    public function getAvailableStock()
    {
        $loanedBooksCopies =  $this->loans()
            ->where(function ($query){
                return $query
                    ->whereNull('return_date')
                    ->whereIn('book_loan_status',[LoanRequestStatusEnum::APPROVED, LoanRequestStatusEnum::PENDING]);
            })
            ->sum('number_copies');

        return $this->copies - $loanedBooksCopies;
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'book_category', 'book_id', 'category_id')
            ->withTimestamps();
    }

    public function scopeSearch(Builder $query, ?string $keyword = null, ?int $id = null): Builder
    {
        if (is_numeric($id)) {
            return $query->where('id', $id)->limit(1);
        }

        if ($keyword == null) {
            return $query->limit(15);
        }

        $keywords = explode(' ', $keyword);

        if (($key = array_search('-', $keywords)) !== false) {
            unset($keywords[$key]);
        }

        foreach ($keywords as $keyword) {
            $query = $query->where(function (Builder $query) use ($keyword) {
                return $query
                    ->orWhere('name', 'LIKE', "%$keyword%");
            });
        }

        return $query->limit(15);
    }
}
