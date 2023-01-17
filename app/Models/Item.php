<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    public function scopeFilter($query, array $filters)
    {
        if ($filters["category"] ?? false) {
            if ($filters["category"]  == "Akustické gitary")
                $query->where("category", "like", "Akustická gitara");
            else if ($filters["category"]  == "Elektroakustické gitary")
                $query->where("category", "like", "Elektroakustická gitara");
            else if ($filters["category"]  == "Basgitary")
                $query->where("category", "like", "Basgitara");
            else if ($filters["category"]  == "Elektrické gitary")
                $query->where("category", "like", "Elektrická gitara");
        }
        if ($filters["brand"] ?? false)
            $query->where("brand", "like", $filters["brand"]);
        if ($filters["search"] ?? false) {
            $query->where("model", "like", "%" . $filters["search"] . "%")
                ->orWhere("brand", "like", "%" . $filters["search"] . "%")
                ->orWhere("category", "like", "%" . $filters["search"] . "%")
                ->orWhere("description", "like", "%" . $filters["search"] . "%");
        }
        if ($filters["min_price"] ?? false)
            $query->where("price", ">=", $filters["min_price"]);
        if ($filters["max_price"] ?? false)
            $query->where("price", "<=", $filters["max_price"]);
        if ($filters["available"] == "true")
            $query->where("amount", ">", 0);
        if ($filters["newer"] == "true") {
            $date = new DateTime();
            $date->format('Y-m-d h:i:s');
            $date->modify("-1 month");
            $query->where("created_at", ">=", $date);
        }
    }

    public function wishlists(){
        return $this->hasMany(Wishlist::class);
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }

    public function ratings(){
        return $this->hasMany(Rating::class);
    }
}
