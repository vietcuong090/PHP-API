<?php

namespace App\Helpers;

use Carbon\Carbon;
use Throwable;

class Casts
{
    /**
     * Make full link
     */
    public function makeFullUrl($domain, $value)
    {
        if ($value && !preg_match('#((https?|ftp)://(\S*?\.\S*?))([\s)\[\]{},;"\':<]|\.\s|$)#i', $value)) {
            $domain = $domain . (substr($domain, -1) === '/' ? '' : '/');

            return $domain . trim($value, '/');
        }

        return is_null($value) ? "" : $value;
    }

    /**
     * Make cms url
     */
    public function makeCMSUrl($value)
    {
        return $this->makeFullUrl(url('/'), $value);
    }

    /**
     * Get full file url
     *
     * @param  string $value
     * @return string
     */
    public function fullFileUrl($value)
    {
        return $this->makeFullUrl(env('AWS_URL_FULL'), $value);
    }

    /**
     * Format date
     *
     * @param $date
     * @param $fm
     */
    public function dateFormat($date, $fm = 'Y-m-d H:i:s')
    {
        if (!$date) {
            return '';
        }

        $newDate = is_string($date) ? Carbon::parse($date) : $date;
        return $newDate->format($fm);
    }

    /**
     * Format date with locale
     */
    public function localeDate($date)
    {
        if (app()->language->code === 'ja') {
            return $this->dateFormat($date, 'Y年m月d日');
        }

        return $this->dateFormat($date, 'Y.m.d');
    }

    /**
     * Convert string to json
     *
     * @param  string $value
     * @return object
     */
    public function json($value, $default = null)
    {
        try {
            return $value ? json_decode($value, true) : $default;
        } catch (Throwable $e) {
            return $default;
        }
    }

    /**
     * Format price
     *
     * @param  int $price
     * @return string
     */
    public function price($value)
    {
        return number_format($value ?? 0);
    }
}
