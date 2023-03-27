<?php

use App\Models\Category;

function categaories_aggregated()
{
    $category = new Category();
    $cats = $category->all();
    $new_cats_array = $cats;
    foreach ($new_cats_array as $cat) {
        $child_cats = [];
        foreach ($new_cats_array as $cat2) {
            if ($cat2->parent == $cat->id) {
                array_push($child_cats, $cat2);
            }
        }
        $cat->children = $child_cats;
    }

    return $new_cats_array;
}
