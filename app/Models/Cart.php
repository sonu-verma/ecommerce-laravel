<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'user_id',
        'session_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'cart_items')
            ->withPivot('quantity', 'unit_price')
            ->withTimestamps();
    }

    public static function generateCartId(): string
    {
        return 'CART-' . strtoupper(Str::random(8));
    }

    public function getTotalAttribute()
    {
        return $this->cartItems->sum(function ($item) {
            return $item->quantity * $item->unit_price;
        });
    }

    public function getItemCountAttribute()
    {
        return $this->cartItems->sum('quantity');
    }

    public function isEmpty(): bool
    {
        return $this->cartItems->count() === 0;
    }

    public function hasProduct($productId): bool
    {
        return $this->cartItems->where('product_id', $productId)->count() > 0;
    }

    public function getProductQuantity($productId): int
    {
        $item = $this->cartItems->where('product_id', $productId)->first();
        return $item ? $item->quantity : 0;
    }

    public function addProduct(Product $product, int $quantity = 1): void
    {
        $existingItem = $this->cartItems->where('product_id', $product->id)->first();

        if ($existingItem) {
            $existingItem->update([
                'quantity' => $existingItem->quantity + $quantity,
                'unit_price' => $product->current_price,
            ]);
        } else {
            $this->cartItems()->create([
                'product_id' => $product->id,
                'quantity' => $quantity,
                'unit_price' => $product->current_price,
            ]);
        }
    }

    public function updateProductQuantity(Product $product, int $quantity): void
    {
        if ($quantity <= 0) {
            $this->removeProduct($product);
            return;
        }

        $item = $this->cartItems->where('product_id', $product->id)->first();
        if ($item) {
            $item->update([
                'quantity' => $quantity,
                'unit_price' => $product->current_price,
            ]);
        }
    }

    public function removeProduct(Product $product): void
    {
        $this->cartItems->where('product_id', $product->id)->first()?->delete();
    }

    public function clear(): void
    {
        $this->cartItems()->delete();
    }

    public function mergeWithUserCart(Cart $userCart): void
    {
        foreach ($this->cartItems as $item) {
            $userCart->addProduct($item->product, $item->quantity);
        }
        $this->delete();
    }
}
