<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Shirt extends Model
{
    use HasFactory;

    protected $primaryKey = 'product_id';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'customer_id',
        'title',
        'club',
        'country',
        'type',
        'color',
        'price',
        'price_offer',
        'details',
        'product_code',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'price_offer' => 'decimal:2',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (self $shirt): void {
            if (! $shirt->getKey()) {
                $shirt->product_id = (string) Str::uuid();
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'product_id';
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }

    public function sizes(): BelongsToMany
    {
        return $this->belongsToMany(Size::class, 'shirt_sizes', 'shirt_id', 'size_id', 'product_id', 'size_id')->withTimestamps();
    }
}
