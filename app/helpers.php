<?php

declare(strict_types=1);
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

function deleteRedisKeysPattern($pattern = '')
{
    $redis = Cache::getRedis();
    $cursor = 0;

    while ($data = $redis->scan($cursor)) {
        $cursor = $data[0];

        foreach ($data[1] as $key) {
            if (false !== strpos($key, $pattern)) {
                $redis->del($key);
            }
        }
        if ('0' === (string) $cursor) {
            break;
        }
    }
}

function flushCategoriesCache()
{
    Cache::forget('categories');
    Cache::forget('CategoriesSelectHTML');
    deleteRedisKeysPattern('category');
}
