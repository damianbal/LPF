<?php

namespace LPF\Framework\Utils;

class Link
{
    /**
     * Generates link to controller's action with provided data
     * Note: deprecated
     * 
     * @param string $controller
     * @param string $action
     * @param array $data
     * @return string
     */
    public static function to($controller, $action = 'index', $data = []): string
    {
        $queryStr = "";

        foreach ($data as $key => $value) {
            $queryStr .= "&" . $key . "=" . $value;
        }

        return "index.php?controller=$controller&action=$action" . $queryStr;
    }

    /**
     * Generate link to route
     *
     * @param string $route
     * @return string
     */
    public static function toRoute($route, $data = []): string 
    {
        $queryStr = "";

        $i = 0;
        foreach ($data as $key => $value) {
            if($i == 0) {
                $queryStr .= "?" . $key . "=" . $value;
            }
            else {
                $queryStr .= "&" . $key . "=" . $value;
            }
            $i ++;
        }

        return "/" . ltrim($route,'/') . $queryStr;
    }
}
