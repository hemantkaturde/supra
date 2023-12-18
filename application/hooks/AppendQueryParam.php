<?php

class AppendQueryParam
{
    public function appendParameter()
    {
        // Get the CodeIgniter instance
        $CI =& get_instance();

       
 

        // Get the current URL
        $current_url = $CI->config->site_url($CI->uri->uri_string());

        redirect($current_url, 'location', 301);

        // Append a query string parameter (e.g., "your_param=your_value")
        // $modified_url = $current_url . '?your_param=your_value';
        // redirect($modified_url, 'location', 301);

    //     // Redirect to the modified URL
    //     if ($current_url !== $modified_url) {
    //        redirect($modified_url, 'location', 301);
    //    }

    
    }
}