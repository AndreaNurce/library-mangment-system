<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasSlug;

    public static string $morph_key = 'category';

    protected $guarded = ['id'];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->slugsShouldBeNoLongerThan(50)
            ->saveSlugsTo('slug');
    }

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'book_category', 'category_id', 'book_id')
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
                    ->orWhere('title', 'LIKE', "%$keyword%");
            });
        }

        return $query->limit(15);
    }
}
