<?php
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;

function setActive($path)
{
    if (Request::is($path)) {
        return 'class="active"';
    } else {
        return '';
    }
}

function deleteRedisKeysPattern($pattern = "")
{
    $redis = Cache::getRedis();
    $cursor = 0;

    while ($data = $redis->scan($cursor)) {

        $cursor = $data[0];

        foreach ($data[1] as $key) {
            if (strpos($key, $pattern) !== false) {
                $redis->del($key);
            }
        }
        if ($cursor == 0) break;
    }
}

function flushCategoriesCache()
{
    Cache::forget('categories');
    Cache::forget('CategoriesSelectHTML');
    deleteRedisKeysPattern('category');
}