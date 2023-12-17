<?php
namespace App\Libraries;

class Template
{
    public function views($template = null, $data = null, $scripts = null)
    {
        if ($template != null) {
            # head
            $data['_styles']                            = view('layout/styles', $data, array());
            $data['_scripts']                           = view('layout/scripts', $data, array());
            $data['_meta']                              = view('layout/meta', $data, array());
            $scripts != null ? $data['_custom_scripts'] = view($scripts, $data, array()) : '';

            # main
            $data['_header']  = view('layout/header', $data, array());
            $data['_flash']   = view('layout/flash', $data, array());
            $data['_sidebar'] = view('layout/sidebar', $data, array());
            $data['_footer']  = view('layout/footer', $data, array());

            # content
            $data['_content'] = view($template, $data, array());

            # modals
            // $data['_modals_action'] = view('admin/layout/modals/action', $data, array());
            // $data['_modals_form'] = view('admin/layout/modals/form', $data, array());

            echo $data['_app'] = view('layout/app', $data, array());
        }
    }
}
