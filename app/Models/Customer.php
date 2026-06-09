<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Customer extends Model
{
    use HasFactory;

    protected $primaryKey = 'customer_id';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'trade_name',
        'tax_id',
        'address',
        'category',
        'contact_name',
        'contact_email',
        'offer_percentage',
    ];

    protected function casts(): array
    {
        return [
            'offer_percentage' => 'decimal:2',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (self $customer): void {
            if (! $customer->getKey()) {
                $customer->customer_id = (string) Str::uuid();
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'customer_id';
    }

    public function shirts(): HasMany
    {
        return $this->hasMany(Shirt::class, 'customer_id', 'customer_id');
    }

    public function isPreferential(): bool
    {
        return $this->category === 'preferential';
    }
}
