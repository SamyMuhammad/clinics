<?php

if(!function_exists('custom_asset')){
    /**
     * Store file in the uploads disk;
     */
    function custom_asset($path = '')
    {
        if (strpos($path, '-rtl') !== false && \LaravelLocalization::getCurrentLocaleDirection() === 'ltr') {
            $path = str_replace('-rtl', '', $path);
        }
        return asset($path);
    }
}

if(!function_exists('storeFile')){
    /**
     * Store file in the uploads disk;
     */
    function storeFile($fileInputName, $path)
    {
        $file = request()->$fileInputName;
        $name = time() .'_'. $file->getClientOriginalName();
        $file->storeAs($path, $name, 'uploads');
        return $name;
    }
}

if(!function_exists('success')){
    /**
     * Flash a success message with session;
     */
    function success($message)
    {
        return session()->flash('success', $message);
    }
}

if(!function_exists('warning')){
    /**
     * Flash a warning message with session;
     */
    function warning($message)
    {
        return session()->flash('warning', $message);
    }
}

if(!function_exists('error')){
    /**
     * Flash a error message with session;
     */
    function error($message)
    {
        return session()->flash('error', $message);
    }
}

if(!function_exists('setActiveClass')){
    /**
     * Set active class for sidebar list items.
     */
    function setActiveClass($route)
    {
        if (is_array($route)) {
            $routeName = $route[0];
            $routeArg = $route[1];

            return request()->url() === route($routeName, $routeArg) ? 'active open' : '';
        }
        return request()->routeIs($route) ? 'active open' : '';
    }
}

if(!function_exists('doctors')){
    /**
     * Get the Users with job = 'doctor'.
     * 
     * @return Collection
     */
    function doctors()
    {
        return \App\Models\User::doctors();
    }
}

if(!function_exists('activeGuard')){
    /**
     * Get the current active guard.
     */
    function activeGuard(){
    
        foreach(array_keys(config('auth.guards')) as $guard){
        
            if(auth()->guard($guard)->check()) return $guard;
        
        }
        return null;
    }
}