<?php

if (!function_exists('route')) {
    /**
     * Generate the URL to a named route.
     *
     * @param  string $name
     * @return string
     */
    function route($name)
    {
        return APP_URL . "/{$name}";
    }
}

if (!function_exists('auth_check')) {
    /**
     * Check if user logged in.
     */
    function auth_check()
    {
        if (isset($_SESSION['user'])) {
            return true;
        }

        return false;
    }
}

if (!function_exists('auth')) {
    /**
     * Get logged in user data.
     */
    function auth()
    {
        if (auth_check()) {
            return $_SESSION['user'];
        }

        return null;
    }
}

if (!function_exists('status_parse')) {
    /**
     * Parse passed status.
     *
     * @param $status
     * @return string
     */
    function status_parse($status)
    {
        return isset($status) && $status == true ? "Active" : "Disabled";
    }
}

if (!function_exists('status_button')) {
    /**
     * Parse passed status for button.
     *
     * @param $status
     * @return string
     */
    function status_button($status)
    {
        return isset($status) && $status == true ? "Activate" : "Disable";
    }
}

if (!function_exists('string_get')) {
    /**
     * Get the passed key value or render default.
     *
     * @param $string
     * @param $default
     * @return string
     */
    function string_get($string, $default = null)
    {
        return isset($string) ? $string : $default;
    }
}

if (!function_exists('session_has')) {
    /**
     * Generate the URL to a named route.
     *
     * @param $key
     * @param $item
     * @return string
     */
    function session_has($key, $item = null)
    {
        if (isset($key)) {

            if (isset($item)) {

                if (isset($_SESSION[$key][$item])) {
                    return true;
                }

                return false;
            }

            return isset($_SESSION[$key]);
        }

        return false;
    }
}

if (!function_exists('session_get')) {
    /**
     * Get the passed key value.
     *
     * @param $key
     * @param $item
     * @return string
     */
    function session_get($key, $item = null)
    {
        $value = null;


        if (isset($item)) {

            if (isset($_SESSION[$key][$item])) {
                $value = $_SESSION[$key][$item];
            }

        } elseif (isset($_SESSION[$key])) {
            $value = $_SESSION[$key];
        }

        return $value;
    }
}

if (!function_exists('session_pop')) {
    /**
     * Generate the URL to a named route.
     *
     * @param $key
     * @param $item
     * @return string
     */
    function session_pop($key, $item = null)
    {
        $value = null;


        if (isset($item)) {

            if (isset($_SESSION[$key][$item])) {
                $value = $_SESSION[$key][$item];

                unset($_SESSION[$key][$item]);
            }

        } elseif (isset($_SESSION[$key])) {
            $value = $_SESSION[$key];

            unset($_SESSION[$key]);
        }

        return $value;
    }
}

if (!function_exists('required')) {
    /**
     * Check if field is set and not empty.
     * @param $field
     * @return bool
     */
    function required($field)
    {
        return isset($field);
    }
}

if (!function_exists('max_length')) {
    /**
     * Check field max length.
     * @param $field
     * @param $value
     * @return bool
     */
    function max_length($field, $value)
    {
        return strlen($field) <= $value;
    }
}

if (!function_exists('min_length')) {
    /**
     * Check field min length.
     * @param $field
     * @param $value
     * @return bool
     */
    function min_length($field, $value)
    {
        return strlen($field) >= $value;
    }
}

if (!function_exists('is_match')) {
    /**
     * Check if passed values match.
     * @param $value1
     * @param $value2
     * @return bool
     */
    function is_match($value1, $value2)
    {
        return strlen($value1) == strlen($value2) && $value1 == $value2;
    }
}

if (!function_exists('is_email')) {
    /**
     * Check if passed email is valid.
     * @param $email
     * @return bool
     */
    function is_email($email)
    {
        return preg_match('/^([0-9a-zA-Z]([-.\w]*[0-9a-zA-Z])*@([0-9a-zA-Z][-\w]*[0-9a-zA-Z]\.)+[a-zA-Z]{2,9})$/', $email);
    }
}

if (!function_exists('is_phone')) {
    /**
     * Check if passed phone is valid.
     * @param $phone
     * @return bool
     */
    function is_phone($phone)
    {
        $phone = preg_replace('/^[0-9]/', '', $phone);

        return preg_match('/^([0-9])/', $phone);
    }
}

if (!function_exists('slug')) {
    /**
     * Convert passed string to slug.
     * @param $str
     * @return mixed
     */
    function slug($str)
    {
        $search = array('', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
        $replace = array('s', 't', 's', 't', 's', 't', 's', 't', 'i', 'a', 'a', 'i', 'a', 'a', 'e', 'E');
        $str = str_ireplace($search, $replace, strtolower(trim($str)));
        $str = preg_replace('/[^\w\d\-\ ]/', '', $str);
        $str = str_replace(' ', '-', $str);
        return preg_replace('/\-{2,}/', '-', $str);
    }
}
