<?php

namespace Libs\Support;

class ArrayUtil
{
    static function get_deep(array $array, $name, $default = null)
    {
        $keys = explode('.', $name);
        $tmpData = $array[array_shift($keys)];
        if (!isset($tmpData)) {
            return $default;
        }
        foreach($keys as $key) {
            if (isset($tmpData[$key])) {
                $tmpData = $tmpData[$key];
            } else {
                // 途中で存在しないキーがあった場合、$defaultを返してループをぬける。
                return $default;
            };
        }
        return $tmpData;
    }

    static function put_deep(array $array, string $name, $value) :array
    {
        // 配列に値をセットするか、上書きする
        $keys = explode('.', $name);
        $keys = array_reverse($keys);
        $tmpData = $value;
        for ($i=0; $i < count($keys); $i++) {
            $last = $tmpData;
            $tmpData = [];
            $tmpData[$keys[$i]] = $last;
        }
        // キーが被った場合は、後ろの配列のものが優先される
        // array_merge()やarray_merge_recursive()ではうまくいかなかった
        return $array = array_replace_recursive($array, $tmpData);
    }

    
    static function unset_deep(&$array, $name)
    {
        $keys = explode('.', $name);
        if (!isset($array[$keys[0]])) {
            return;
        }
        if (count($keys) === 1) {
            unset($array[$name]);
            return;
        }
        $tmpData = &$array[array_shift($keys)];
        foreach($keys as $index => $key) {
            if (isset($tmpData[$key])) {
                if ($index === count($keys) - 1) {
                    unset($tmpData[$key]);
                } else {
                    $tmpData = &$tmpData[$key];
                }
            } else {
                // 途中で存在しないキーがあった場合、ループをぬける。
                return;
            };
        }
        return $array;
    }
}
