<?php
namespace App\ProductSearch\Filters;
use App\Category;
use Illuminate\Database\Eloquent\Builder;
class CatName implements Filter
{
    /**
     * Apply a given search value to the builder instance.
     *
     * @param Builder $builder
     * @param mixed $value
     * @return Builder $builder
     */
    public static function apply(Builder $builder, $value)
    {
        $category_ids=[];
        foreach ($value as $cat) {
            if (isset(Category::where('name', '=', $cat)->first()->id))
            {
                $category_ids[] = Category::where('name', '=', $cat)->first()->id;
            }
        }
        return $builder->whereIn('id' ,  $category_ids);
    }
}