<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Utility extends Model
{
    public static function settings($user_id = 0)
    {
        $data = DB::table('settings');

        if(Auth::check())
        {
            $data->where('created_by', '=', Auth::user()->get_created_by())->orWhere('created_by', '=', 1);
        }
        else if($user_id !== 0)
        {
            $data->where('created_by', '=', $user_id);
        }
        else
        {
            $data->where('created_by', '=', 1);
        }
        $data = $data->get();

        $settings = [
            "site_currency" => "Dollars",
            "site_currency_symbol" => "$",
            "site_currency_symbol_position" => "pre",
            "site_date_format" => "M j, Y",
            "site_time_format" => "g:i A",
            "company_name" => "",
            "company_address" => "",
            "company_city" => "",
            "company_state" => "",
            "company_zipcode" => "",
            "company_country" => "",
            "company_telephone" => "",
            "company_email" => "",
            "company_email_from_name" => "",
            "company_logo" => "logo.png",
            "company_favicon" => "favicon.png",
            "invoice_prefix" => "#INV",
            "invoice_title" => "",
            "invoice_text" => "",
            "invoice_color" => "#6676ef",
            "purchase_invoice_prefix" => "#PUR",
            "sale_invoice_prefix" => "#SALE",
            "quotation_invoice_prefix" => "#QUO",
            "low_product_stock_threshold" => "0",
            "footer_text" => "© 2020 RotaGo",          
            "default_user_language" => "en",
            "invoice_footer_title" => "",
            "invoice_footer_notes" => "",
            "purchase_invoice_template" => "template1",
            "purchase_invoice_color" => "ffffff",
            "sale_invoice_template" => "template1",
            "sale_invoice_color" => "ffffff",
            "quotation_invoice_template" => "template1",
            "quotation_invoice_color" => "ffffff",
            "footer_link_1" => "Support",
            "footer_value_1" => "#",
            "footer_link_2" => "Terms",
            "footer_value_2" => "#",
            "footer_link_3" => "Privacy",
            "footer_value_3" => "#",
            "display_landing_page" => "on",
        ];

        foreach($data as $row)
        {
            $settings[$row->name] = $row->value;
        }

        return $settings;
    }

    public static function languages()
    {
        $dir     = base_path() . '/resources/lang/';
        $glob    = glob($dir . "*", GLOB_ONLYDIR);
        $arrLang = array_map(
            function ($value) use ($dir){
                return str_replace($dir, '', $value);
            }, $glob
        );
        $arrLang = array_map(
            function ($value) use ($dir){
                return preg_replace('/[0-9]+/', '', $value);
            }, $arrLang
        );
        $arrLang = array_filter($arrLang);

        return $arrLang;
    }

    public static function delete_directory($dir)
    {
        if(!file_exists($dir))
        {
            return true;
        }
        if(!is_dir($dir))
        {
            return unlink($dir);
        }
        foreach(scandir($dir) as $item)
        {
            if($item == '.' || $item == '..')
            {
                continue;
            }
            if(!self::delete_directory($dir . DIRECTORY_SEPARATOR . $item))
            {
                return false;
            }
        }
        return rmdir($dir);
    }

    // get font-color code accourding to bg-color
    public static function hex2rgb($hex)
    {
        $hex = str_replace("#", "", $hex);
        if(strlen($hex) == 3)
        {
            $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
        }
        else
        {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }
        $rgb = array(
            $r,
            $g,
            $b,
        );
        //return implode(",", $rgb); // returns the rgb values separated by commas
        return $rgb; // returns an array with the rgb values
    }
    public static function getFontColor($color_code)
    {
        $rgb = self::hex2rgb($color_code);
        $R   = $G = $B = $C = $L = $color = '';
        $R = (floor($rgb[0]));
        $G = (floor($rgb[1]));
        $B = (floor($rgb[2]));
        $C = [
            $R / 255,
            $G / 255,
            $B / 255,
        ];
        for($i = 0; $i < count($C); ++$i)
        {
            if($C[$i] <= 0.03928)
            {
                $C[$i] = $C[$i] / 12.92;
            }
            else
            {
                $C[$i] = pow(($C[$i] + 0.055) / 1.055, 2.4);
            }
        }
        $L = 0.2126 * $C[0] + 0.7152 * $C[1] + 0.0722 * $C[2];
        if($L > 0.179)
        {
            $color = 'black';
        }
        else
        {
            $color = 'white';
        }
        return $color;
    }

    public static function getValByName($key)
    {
        // $setting = Utility::settings();
        // return (!isset($setting[$key]) || empty($setting[$key])) ? '' : $setting[$key];

        $setting = Utility::settings();
        if(!isset($setting[$key]) || empty($setting[$key]))
        {
            $setting[$key] = '';
        }
        return $setting[$key];
    }
    
    public static function getStartEndMonthDates()
    {
        $first_day_of_current_month = Carbon::now()->startOfMonth()->subMonth(0)->toDateString();
        // $last_day_of_current_month = Carbon::now()->subMonth(0)->endOfMonth()->toDateString();

        $first_day_of_next_month = Carbon::now()->startOfMonth()->subMonth(-1)->toDateString();
        // $last_day_of_next_month = Carbon::now()->subMonth(-1)->endOfMonth()->toDateString();

        return ['start_date' => $first_day_of_current_month, 'end_date' => $first_day_of_next_month];
    }

    public static function setEnvironmentValue(array $values)
    {
        $envFile = app()->environmentFilePath();
        $str     = file_get_contents($envFile);
        if(count($values) > 0)
        {
            foreach($values as $envKey => $envValue)
            {
                $keyPosition       = strpos($str, "{$envKey}=");
                $endOfLinePosition = strpos($str, "\n", $keyPosition);
                $oldLine           = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);

                // If key does not exist, add it
                if(!$keyPosition || !$endOfLinePosition || !$oldLine)
                {
                    $str .= "{$envKey}='{$envValue}'\n";
                }
                else
                {
                    $str = str_replace($oldLine, "{$envKey}='{$envValue}'", $str);
                }
            }
        }
        $str = substr($str, 0, -1);
        $str .= "\n";

        return file_put_contents($envFile, $str) ? true : false;
    }

    public static function convertStringToSlug($string = '')
    {
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string)));
    }

    public static function templateData()
    {
        $array = [];
        $array['colors']    = [
                                '003580',
                                '666666',
                                '5e72e4',
                                'f50102',
                                'f9b034',
                                'fbdd03',
                                'c1d82f',
                                '37a4e4',
                                '8a7966',
                                '6a737b',
                                '050f2c',
                                '0e3666',
                                '3baeff',
                                '3368e6',
                                'b84592',
                                'f64f81',
                                'f66c5f',
                                'fac168',
                                '46de98',
                                '40c7d0',
                                'be0028',
                                '2f9f45',
                                '371676',
                                '52325d',
                                '511378',
                                '0f3866',
                                '48c0b6',
                                '297cc0',
                                'ffffff',
                                '000000',
                            ];
        $array['templates'] = [
                                "template1" => "New York",
                                "template2" => "Toronto",
                                "template3" => "Rio",
                                "template4" => "London",
                                "template5" => "Istanbul",
                                "template6" => "Mumbai",
                                "template7" => "Hong Kong",
                                "template8" => "Tokyo",
                                "template9" => "Sydney",
                                "template10" => "Paris",
                            ];
        return $array;
    }

    public static function getSuperAdminValByName($key)
    {
        $data = DB::table('settings');
        $data = $data->where('name', '=', $key);
        $data = $data->first();
        if(!empty($data))
        {
            $record =$data->value;
        }
        else
        {
            $record = '';
        }        
        return $record;
    }
}
