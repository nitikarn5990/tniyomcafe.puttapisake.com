<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class bill extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct() {

        parent::__construct();

        if ($this->session->userdata('is_logged_in') == '') {

            $this->session->set_userdata('url_back', current_url());
            redirect('auth/login');
        }
    }

    public function index($active_order_id) {
        if ($active_order_id != '') {

            $this->db->select("active_order_detail.*,SUM(active_order_detail.qty * active_order_detail.price) as total_price");
            $this->db->select("SUM(active_order_detail.qty) as total_qty");
            $this->db->select("menu.product");
            $this->db->select("active_order.cashier_id");
            $this->db->select("users.name");
            $this->db->select("users.name");
            $this->db->select("active_order.paid_date");
            $this->db->select("active_order.cash_receive");
            

            $this->db->from('active_order');
            $this->db->where('paid_date !=', '0000-00-00 00:00:00');
            $this->db->where('active_order.id', $active_order_id);
            $this->db->join('active_order_detail', 'active_order.id = active_order_detail.active_order_id');
            $this->db->join('menu', 'active_order_detail.menu_id = menu.id');
            $this->db->join('users', 'active_order.cashier_id = users.id');

            //  $this->db->join('member', 'active_rent.member_id = member.id');
            // $start_date = trim($this->input->post('date_start'));
            //   $end_date = trim($this->input->post('date_end'));
            //  $this->db->where('active_order.created_at BETWEEN "' . $start_date . '" and "' . $end_date . '"');
            $this->db->group_by('active_order_detail.menu_id');
            $this->db->group_by('active_order_detail.menu_type');
            $this->db->order_by('menu.product', 'ASC');


            $query = $this->db->get();
    
            
//            echo "<pre>";
//            print_r($query->result_array());
//            
//            die();
            if ($query->num_rows() > 0) {
                $dataBill = [
                    'res_bill' => $query->result_array(),
                ];


                $this->load->view('bill', $dataBill, false);
            }
        }
    }
    


    public function bill_end_month($id = '') {



        $res_active_rent = $this->db->get_where('active_rent', array('id' => $id))->row_array();
        $number_room = $this->db->get_where('room', array('id' => $res_active_rent['room_id']))->row_array()['number_room'];

        $res_member = $this->db->get_where('member', array('id' => $res_active_rent['member_id']))->row_array();


        $electric_rate = $this->db->get_where('electric_rate', array('id' => 1))->row_array()['rate_price'];
        $water_rate = $this->db->get_where('water_rate', array('id' => 1))->row_array()['rate_price'];

        $data = [
            'res_active_rent' => $res_active_rent,
            'number_room' => $number_room,
            'monthly' => ShowDateTh($res_active_rent['pay_monthly']),
            'updated_at' => ShowDateThTime(DATE_TIME),
            'res_member' => $res_member,
            'electric_rate' => $electric_rate,
            'water_rate' => $water_rate
        ];

        //บิลเก็บเงินตอนสิ้นเดือน
        $this->load->view('bill_end_month', $data, false);
    }

    public function bill_end_month_receipt($id = '') {
        //พิมพ์ใบเสร็จรับเงิน

        $res_active_rent = $this->db->get_where('active_rent', array('id' => $id))->row_array();


        $number_room = $this->db->get_where('room', array('id' => $res_active_rent['room_id']))->row_array()['number_room'];

        $res_member = $this->db->get_where('member', array('id' => $res_active_rent['member_id']))->row_array();


        $electric_rate = $this->db->get_where('electric_rate', array('id' => 1))->row_array()['rate_price'];
        $water_rate = $this->db->get_where('water_rate', array('id' => 1))->row_array()['rate_price'];

        $data = [
            'res_active_rent' => $res_active_rent,
            'number_room' => $number_room,
            'monthly' => ShowDateTh($res_active_rent['pay_monthly']),
            'updated_at' => ShowDateThTime(DATE_TIME),
            'res_member' => $res_member,
            'electric_rate' => $electric_rate,
            'water_rate' => $water_rate
        ];

        //บิลเก็บเงินตอนสิ้นเดือน
        $this->load->view('bill_end_month_receipt', $data, false);
    }

    public function bill_damages($rental_id = '') {
        //พิมพ์ใบเสร็จค่าเสียหายและยอดเงินคงเหลือ

        $res_active_rent = $this->db->order_by("id", "asc")->get_where('active_rent', array('rental_id' => $rental_id), '1')->row_array();


        $res_rental = $this->db->get_where('rental', array('id' => $rental_id))->row_array();
        $res_damages = $this->db->get_where('damages', array('rental_id' => $rental_id))->result_array();


        $num_rec_damages = $this->db->get_where('damages', array('rental_id' => $rental_id))->num_rows();

        //หาค่าเสียหายทั้งหมด
        $total_dm = 0;
        if ($num_rec_damages > 0) {

            foreach ($res_damages as $key => $value) {
                $total_dm = $total_dm + $value['price'];
            }
        }


        $number_room = $this->db->get_where('room', array('id' => $res_rental['room_id']))->row_array()['number_room'];

        $res_member = $this->db->get_where('member', array('id' => $res_rental['member_id']))->row_array();


        $electric_rate = $this->db->get_where('electric_rate', array('id' => 1))->row_array()['rate_price'];
        $water_rate = $this->db->get_where('water_rate', array('id' => 1))->row_array()['rate_price'];

        $data = [
            // 'res_active_rent' => $res_active_rent,
            'number_room' => $number_room,
            // 'monthly' => ShowDateTh($res_active_rent['pay_monthly']),
            'res_active_rent' => $res_active_rent,
            'res_member' => $res_member,
            'electric_rate' => $electric_rate,
            'water_rate' => $water_rate,
            'res_damages' => $res_damages,
            'total_dm' => $total_dm
        ];


        $this->load->view('bill_damages', $data, false);
    }

    public function bill_el_water() {

        //บิลเก็บเงินตอนสิ้นเดือน
        $this->load->view('bill_el_water', '', false);
    }

    public function bill3() {
        $this->load->view('bill', '', false);
    }

    public function bill2() {


        $data = [];

        //load mPDF library
        $this->load->library('m_pdf');

        $html = $this->load->view('bill', $data, true);

        $this->m_pdf->pdf->WriteHTML($html);
        //download it.

        $this->m_pdf->pdf->Output();
    }

}
