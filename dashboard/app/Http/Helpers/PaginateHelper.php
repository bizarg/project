<?php

namespace App\Http\Helpers;

use Illuminate\Pagination\LengthAwarePaginator;

class PaginateHelper
{
    const LIMIT = 10;

    public static function getArraySlice($request, array $items, $limit = self::LIMIT)
    {
        $start = 0;
        if($request->has('page') && $request->page != 1) {
            $start = ($request->page * $limit) - $limit;
        }

        return array_slice($items, $start, $limit);
    }

    public static function getPaginate($items, $total, $limit = self::LIMIT)
    {
        return new LengthAwarePaginator($items, $total, $limit);
    }

    public static function getSearchResult($items ,$search)
    {
        $arr = [];
        foreach ($items as $item) {
            if (preg_match('/'. $search .'/', $item->domain)) {
                $arr[] = $item;
            }
        }
        return $arr;
    }

    public static function getItems($request, $items)
    {
        if($request->search != 'false') {
            return $items = self::getArraySlice($request, self::getSearchResult($items, $request->search));
        } else {
            return $items = self::getArraySlice($request, $items);
        }
    }
}