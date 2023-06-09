<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $appends = ['shop_name', 'category_name', 'service_name'];
    protected $casts = [
    'price' => 'integer',
    ];

    public function scopeSearch($query, $filter)
    {
    	$searchQuery = trim($filter);
    	$requestData = ['name'];
    	$query->when($filter!='', function ($query) use($requestData, $searchQuery) {
    		return $query->where(function($q) use($requestData, $searchQuery) {
    			foreach ($requestData as $field)
    				$q->orWhere($field, 'like', "%{$searchQuery}%");
    			});
    	});
    }

    public function getCategoryNameAttribute()
    {
        $category = Category::where('id', $this->category_id)->first();
        if($category){
             return $category->name;
        }
        return null;
       
    }

     public function getServiceNameAttribute()
    {
        $service = Service::where('id', $this->service_id)->first();
       if($service){
         return $service->name;
       }
       return null;
    }

     public function getShopNameAttribute()
    {
        $vendor = Vendor::where('id', $this->shop_id)->first();
       if($vendor){
         return $vendor->shop_name;
       }
       return null;
    }
}
