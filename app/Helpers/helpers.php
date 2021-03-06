<?php

if (! function_exists('relative_route')) {
    /**
     *  Generate a relative URL to a named route.
     *
     * @param  string   $routeName
     * @param  mixed    $parameters
     * @param  mixed    $secure
     * @return string
     */
    function relative_route($routeName, $parameters = [], $secure = null)
    {
        $uri = route($routeName, $parameters, $secure);
        $root = url(null, [], $secure);

        return '/'.ltrim(str_replace($root, '', $uri), '/');
    }
}

if (! function_exists('get_query_params_by_key')) {
    
    /**
     *  Get request query params by key
     *
     * @param  Illuminate\Http\Request   $equest
     * @param  Array|String    $key
     * @param  mixed $default  - default value
     * @return array
     */
    function get_query_params_by_key($request, $key, $default = null)
    {
        $return = [];
        if (is_string($key)) {
            if ($request->exists($key)) {
                $return[$key] = $request->get($key, $default);
            }
        } else {
            foreach ($key as $k) {
                if ($request->exists($k)) {
                    $return[$k] = $request->get($k, $default);
                }
            }
        }
        return $return;
    }
}


if (! function_exists('array_remove_null')) {
    /**
     * Removes empty or null element on array
     *
     * @param  array  $array
     * @return array
     */
    function array_remove_null(array $array)
    {
        return array_where($array, function ($value, $key) {
            return (!is_null($value) && !empty($value));
        });
    }
}

if (! function_exists('array_contains')) {
    /**
     *
     * @return boolean
     */
    function array_contains($query, $array, $key)
    {
        if (empty($query)) {
            return true;
        }
        
        if (!isset($array[$key])) {
            return false;
        }

        $query = strtolower($query);
        return (strpos(strtolower($array[$key]), $query) !== false);
    }
}

if (! function_exists('is_query_empty')) {
    /**
     *
     * @return boolean
     */
    function is_query_empty($query)
    {
        return (empty($query) || (trim($query) == "'%%'") || (trim($query) == "%%"));
    }
}

if (! function_exists('validate_amount')) {
    /**
     *
     * @return boolean
     */
    function validate_amount($amt = '0')
    {
        setlocale(LC_MONETARY,"en_US");
        $amt = str_replace(',', '', $amt);
        return money_format('%i', (float) $amt);
    }
}

if (! function_exists('is_admin')) {
    /**
     *
     * @return boolean
     */
    function is_admin()
    {
        if (\Sentinel::check()) {
            $user_id = \Sentinel::getUser()->id;
            return \DB::table('role_users')
                            ->where('user_id', $user_id)
                            ->where('role_id', 1)
                            ->exists();
        }
        return false;
    }
}


