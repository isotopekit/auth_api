<?php

namespace IsotopeKit\AuthAPI\Models;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    protected $table = 'site_settings';

    protected $fillable = [
        'language','theme', 'name', 'logo', 'agency_id'
    ];

    public static function settings()
    {
        $url = $_SERVER['HTTP_HOST'];
        
        if(strpos($url, env('APP_URL_DOMAIN')) != false)
        {
            $parsedUrl = parse_url($url);
            // $host = explode('.', $parsedUrl['host']);
            // for server
            $host = explode('.', $parsedUrl['path']);
            $subdomain = $host[0];
            
            if($subdomain != "dashboard")
            {
                $site = Site::where('unique_name', $subdomain)->first();
                if($site)
                {
                    return $site;
                }
            }
        }
        else
        {
            // return Site::where('id', 2)->first();

            $url_1 = "http://".$url;
            $url_2 = "https://".$url;

            $site = Site::where('external_url', $url_1)->orWhere('external_url', $url_2)->first();
            if($site)
            {
                return $site;
            }
        }

		
        
        // app
        return Site::first();

        // agency
        // return Site::where('id', 2)->first();
    }
}