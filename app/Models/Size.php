<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Size extends Model
{
    use HasFactory;

    protected $primaryKey = 'size_id';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'name',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $size): void {
            if (! $size->getKey()) {
                $size->size_id = (string) Str::uuid();
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'size_id';
    }

    public function shirts(): BelongsToMany
    {
        return $this->belongsToMany(Shirt::class, 'shirt_sizes', 'size_id', 'shirt_id', 'size_id', 'product_id')->withTimestamps();
    }
}
