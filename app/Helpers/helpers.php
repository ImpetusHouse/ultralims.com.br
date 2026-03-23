<?php

if (!function_exists('generateBreadcrumbs')) {
    function generateBreadcrumbs()
    {
        $segments = request()->segments();
        $breadcrumbs = [];
        $url = '';

        foreach ($segments as $segment) {
            $url .= '/' . $segment;
            $breadcrumbs[] = [
                'name' => ucfirst(str_replace('-', ' ', $segment)),
                'url' => $url,
            ];
        }

        return $breadcrumbs;
    }
}
