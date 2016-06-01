<?php

namespace Armory\Autocomplete;

class Str
{
    /**
     * Cleans a term
     * @param string $string
     * @return string
     */
    public static function clean(string $string) : string
    {
        // Replace all spaces
        $string = str_replace(' ', '_', $string);

        // Make underscore
        $string = strtolower($string);

        // Replace special characters
        return preg_replace('/[^a-z0-9\-]/', '', $string);
    }

    /**
     * Get all permutations of a string
     * @param  string $string
     * @return array
     */
    public static function permutations(string $string, int $min = 1) : array
    {
        $permutations = [];
        $count = strlen($string) - ($min - 1);

        for ($i = 0; $i < $count; $i++) {
            $permutations[] = substr($string, 0, $min + $i);
        }

        return $permutations;
    }
}
