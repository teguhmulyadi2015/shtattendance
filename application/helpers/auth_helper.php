<?php
function check_login_permission()
{
    $CI = &get_instance();
    if (!$CI->session->userdata('is_loged_in')) {
        redirect('auth');
    }
}

function check_access_menu()
{
    $CI = &get_instance();
    $role = $CI->session->userdata('role_name');

    if ($role == 'guest') {
        $url = 'attendance';
    } elseif ($role == 'admin') {
        $url = 'admin';
    }

    $uriSegment = $CI->uri->segment(1);
    if ($url != $uriSegment) {
        // print_r($url);
        // print_r($uriSegment);

        redirect('auth/blocked');
    }
}
