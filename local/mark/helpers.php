<?php

namespace mark;

class helpers
{

    /**
     * Функция "склонения" существительных
     *
     * @param int $number число
     * @param array $arForms возможные формы склоняемого существительного в зависимости от остатка деления
     *                       на степень 10
     * Пример  $arForms = ['стол' => [1],'стола' => [2,3,4], 'столов' => [0,5,6,7,8,9,11,12,13,14]]
     * @return string
     *
     */
    public static function declensionOfNouns($number, $arForms)
    {
        $modulo100 = $number % 100;
        $modulo10 = $number % 10;
        return array_key_first(
            array_filter(
                $arForms,
                function ($item) use ($modulo100) {
                    return in_array($modulo100, $item);
                }
            )
        ) ? : array_key_first(
            array_filter(
                $arForms,
                function ($item) use ($modulo10) {
                    return in_array($modulo10, $item);
                }
            )
        );
    }

    /**
     * Функция оборачивающая вывод в тег
     *
     * @param string $tag тег
     * @param string $var переменная
     * @return void
     */
    public static function wrapper($tag, $var)
    {
        echo "<$tag>$var</$tag>";
    }
}

