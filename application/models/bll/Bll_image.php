<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bll_image extends CI_Model
{
    public function get_image_per_page_list()
    {
        $this->load->model('dal/Dal_image');
        $this->load->model('bll/Bll_tool');
        $this->config->load('pagination', TRUE, TRUE);
        $total_rows = $this->Dal_image->get_image_count();
        $config = $this->config->item('pagination');
        $config['base_url'] = site_url('blog/album');
        $config['total_rows'] = $total_rows;
        $page_size = $config['per_page'];
        $current_page = $this->input->get('page') ? $this->input->get('page') : 1;
        $this->Bll_tool->pagination($config);
        $start = ($current_page - 1) * $page_size;
        $data['images'] = $this->Dal_image->get_image($start, $page_size);
        $total_page = ceil($total_rows / $page_size);
        if ($current_page <= 1) {
            $current_page = 1;
        }
        if ($current_page >= $total_page) {
            $current_page = $total_page;
        }
        $data['current_page'] = $current_page;
        $data['total_page'] = $total_page;
        $data['last_page'] = $current_page - 1;
        $data['next_page'] = $current_page + 1;
        return $data;
    }
}