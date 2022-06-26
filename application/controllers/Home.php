<?php

defined('BASEPATH') OR exit('Açao não permitida');//aqui estamos falando que ele nao pode ser acessado diretamente

class Home extends CI_Controller {

    public function index()
    {

        $data = array (
            'titulo' => 'Home'
        );

        $this->load->view('layout/header', $data);//aqui estamos mandando o $data para o header
        $this->load->view('home/index');//pasta home e view index
        $this->load->view('layout/footer');
    }

}
