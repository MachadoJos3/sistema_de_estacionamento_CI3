<?php

defined('BASEPATH') or exit('Ação não permitida');

class Core_model extends CI_Model
{ //a classe core_model ira extender da CI_Model

    public function get_all($table = NULL, $condition = NULL) //get all recebe uma tabela como parametro e um array de  condiçoes
    {
        if ($table && $this->db->table_exists($table)) {//se a tabela for passada e ela nao existir ela ira retornar falso
            if (is_array($condition)) {//agora se existir ira fazer a consulta
                $this->db->where($condition);
            }
            return $this->db->where($condition);
        }else{
            return FALSE;
        }
    }

    public function get_by_id($table = NULL, $condition = NULL)//se a tabela existe e se o condition e um array ele ira verificar
    {
//se der algum erro volta para o table_exists($table)
        if ($table && $this->db->table_exists($table) && is_array($condition)) {
            
            $this->db->where($condition);//ira dar um where nas condiçoes
            $this->db->limit(1);//ira trazer um registro

            return $this->db->get($table)->row();

        }else{
            return FALSE;
        }

    }

    public function insert($table = NULL, $data = NULL)
    {
        if ($table && $this->db->table_exists($table) && is_array($data)) {
            $this->db->insert($table, $data);

            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('sucesso','Dados salvos com sucesso');//ira setar na sessao uma chave chamada sucesso e ira mandar o valor com a mensagem
            }else{
                $this->session_abort->set_flashdata('error','Não foi possivel salvar os dados');
            }

        } else {
            return FALSE;
        }
    }

    public function update($table = NULL,$data = NULL, $condition = NULL)
    {

        if ($table && $this->db->table_exists($table) && is_array($data) && is_array($condition)) {//se foi passado uma tabela e o data e um array e o condiiton tmb e um array ele atualiza a tabela

            if ($this->db->update($table, $data, $condition)) {

                $this->session->set_flashdata('sucesso', 'Dados salvos com sucesso!');

            } else {
                $this->session->set_flashdata('error','Não foi possível salvar os dados');
            }

        } else {
            return FALSE;
        }

    }

    public function delete($table = NULL,$data = NULL, $condition = NULL)
    {

        if ($table && $this->db->table_exists($table) && is_array($condition)) {

            if ($this->db->delete($table, $condition)) {

                $this->session_abort->set_flashdata('sucesso', 'Registro excluido com sucesso!');

            } else {
                $this->session_abort->set_flashdata('error', 'Não foi possivel excluir nosso registro');
            }

        } else {
            return FALSE;
        }

    }

}
