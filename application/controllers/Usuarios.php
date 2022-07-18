<?php

defined('BASEPATH') or exit('Ação não permitida'); //aqui e para que caso uma pessoa tente acessar o controlador de forma direta

class Usuarios extends CI_Controller
{

    public function index()
    {

        $data = array(
            'titulo' => 'Usuários Cadastrados',
            'subtitulo' => 'Chegou a hora de listar todos os usuários cadastrados no Banco de dados',

            'styles' => array( //um array que armazena os estilos
                'plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css',
            ),
            'scripts' => array(
                'plugins/datatables.net/js/jquery.dataTables.min.js',
                'plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js',
                'plugins/datatables.net/js/estacionamento.js',
            ),

            'usuarios' => $this->ion_auth->users()->result(), //aqui esta retornando os usuarios do BD
        );

        // echo '<pre>';
        // print_r($data['usuarios']);
        // exit;
        // echo '</pre>';

        $this->load->view('layout/header', $data); //aqui estamos mandando para a view o $data
        $this->load->view('usuarios/index');
        $this->load->view('layout/footer');
    }

    public function core($usuario_id = NULL)
    {

        if (!$usuario_id) {

            exit('Pode cadastrar um novo usuário');
            //Cadastro de novo usuario
        } else {
            //editar usuário
            if (!$this->ion_auth->user($usuario_id)->row()) {
                exit('Usuário não existe');
            } else {

                $this->form_validation->set_rules('first_name', 'Nome', 'trim|required|min_length[5]|max_length[20]'); //se o primeiro valor nao for valido o Nome ira no lugar, depois vem as validacao o trim apaga espaçoes no inicio e no fim, ele e obrigatorio, minimo de 5 maximo de 20 caracter
                $this->form_validation->set_rules('last_name', 'Sobrenome', 'trim|required|min_length[5]|max_length[30]');
                $this->form_validation->set_rules('username', 'Usuário', 'trim|required|min_length[5]|max_length[30]|callback_username_check');
                $this->form_validation->set_rules('email', 'E-mail', 'trim|valid_email|min_length[5]|max_length[200]|callback_email_check');
                $this->form_validation->set_rules('password', 'Senha', 'trim|min_length[8]');
                $this->form_validation->set_rules('confirmacao', 'Confirmação', 'trim|matches[password]');

                if ($this->form_validation->run()) {

                    // [first_name] => Admin
                    // [last_name] => istrator
                    // [username] => administrator
                    // [email] => admin@admin.com
                    // [password] => 
                    // [perfil] => 1
                    //[active] => 1

                    $data = elements(
                        array(
                            'first_name',
                            'last_name',
                            'username',
                            'email',
                            'password',
                            'active'
                        ), $this->input->post()
                    );

                    $password = $this->input->post('password');//se ele receber a senha no array significa que o user que atualizar 

                    //se nao foi passado a senha nao atualiza
                    if(!$password) {
                        unset($data['password']);//remove a referencia da coluna password
                    }
                    
                    $data = html_escape($data);//sanitizar array, significa limpar o array

                    if($this->ion_auth->update($usuario_id, $data)) {
                       
                        $this->session->set_flashdata('sucesso', 'Dados atualizados com sucesso!');

                    }else{

                        $this->session->set_flashdata('error', 'Não foi possível atualizar os dados');

                    }
                    redirect($this->router->fetch_class());//retorna ao usuarios, controlador Usuarios, metodo index

                    // echo '<pre>';
                    // print_r($data);
                    // echo '</pre>';
                } else {
                    //Editar usuário
                    $data = array(
                        'titulo' => 'Editar Usuários',
                        'subtitulo' => 'Chegou a hora de editar o usuário',
                        'icone_view' => 'ik ik-user', //aqui estamos colocando dinamicamente o icone
                        'usuario' => $this->ion_auth->user($usuario_id)->row(), //busco os dados e armazeno na variavel usuario
                        'perfil_usuario' => $this->ion_auth->get_users_groups($usuario_id)->row(),
                    );

                    // echo '<pre>';
                    // print_r($data['perfil_usuario']);
                    // exit;
                    // echo '</pre>';

                    $this->load->view('layout/header', $data); //aqui estamos mandando para a view o $data
                    $this->load->view('usuarios/core');
                    $this->load->view('layout/footer');
                }
            }
        }
    }

    public function username_check($username)
    {
        $usuario_id = $this->input->post('usuario_id');
        if($this->core_model->get_by_id('users', array('username' => '$username', 'id !=' => $usuario_id))) {
            //na minha tabela users, procure minha coluna o username onde ele seja igual ao $username, onde o id e diferente do meu usuario editado
            $this->form_validation->set_message('username_check', 'Esse usuário já existe');
            return FALSE;
        } else {
            return TRUE;//se estiver validado retornara TRUE
        }
    }

    public function email_check($email)
    {
        $usuario_id = $this->input->post('usuario_id');
        if($this->core_model->get_by_id('users', array('email' => '$email', 'id !=' => $usuario_id))) {
            //na minha tabela users, procure minha coluna o username onde ele seja igual ao $username, onde o id e diferente do meu usuario editado
            $this->form_validation->set_message('username_check', 'Esse e-mail já existe');
            return FALSE;
        } else {
            return TRUE;//se estiver validado retornara TRUE
        }
    }
}
