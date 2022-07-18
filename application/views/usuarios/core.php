<?php $this->load->view('layout/navbar'); ?>

<div class="page-wrap">

    <?php $this->load->view('layout/sidebar'); ?>

    <div class="main-content">
        <div class="container-fluid">
            <div class="page-header">
                <div class="row align-items-end">
                    <div class="col-lg-8">
                        <div class="page-header-title">
                            <i class="<?php echo $icone_view; ?> bg-blue"></i>
                            <!--aqui estamos colocando dinamicamente o icone-->
                            <div class="d-inline">
                                <h5><?php echo $titulo; ?></h5>
                                <span><?php echo $subtitulo ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <nav class="breadcrumb-container" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a data-toggle="tooltip" data-placement="bottom" title="Home" href="<?php echo base_url('/') ?>"><i class="ik ik-home"></i></a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a data-toggle="tooltip" data-placement="bottom" title="Listar <?php echo $this->router->fetch_class(); ?>" href="<?php echo base_url($this->router->fetch_class()); ?>">Listar &nbsp;<?php echo ($this->router->fetch_class()); ?></a>
                                    <!--aqui n vai o base_url pq ele ja esta sendo usado-->
                                </li>
                                <li data-toggle="tooltip" data-placement="bottom" class="breadcrumb-item active" aria-current="page"><?php echo $titulo ?></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <!--se a var usuario estiver setado va em usuario->ultima_alteracao se nao nao coloque nada-->
                        <div class="card-header"><?php echo (isset($usuario) ? '<i class="ik ik-calendar ik-2x"></i>&nbsp;Data da última alteração: &nbsp;' . formata_data_banco_com_hora($usuario->data_ultima_alteracao) : '') ?></div>
                        <div class="card-body">
                            <form class="forms-sample" name="form_core" method="POST">

                                <div class="form-group row">
                                    <div class="col-md-4 mb-20">
                                        <label>Nome</label>
                                        <!--se tem uma var usuario significa que estamos editando-->
                                        <input type="text" class="form-control" name="first_name" value="<?php echo (isset($usuario) ? $usuario->first_name : set_value('first_name')); ?>">
                                        <?php echo form_error('first_name', '<div class="text-danger">', '</div>')?>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Sobrenome</label>
                                        <!--se tem uma var usuario significa que estamos editando-->
                                        <input type="text" class="form-control" name="last_name" value="<?php echo (isset($usuario) ? $usuario->last_name : set_value('last_name')); ?>">
                                        <?php echo form_error('last_name', '<div class="text-danger">', '</div>')?>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-4 mb-20">
                                        <label>Usuário</label>
                                        <!--se tem uma var usuario significa que estamos editando-->
                                        <input type="text" class="form-control" name="username" value="<?php echo (isset($usuario) ? $usuario->username : set_value('username')); ?>">
                                        <?php echo form_error('username', '<div class="text-danger">', '</div>')?>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Email (Login)</label>
                                        <!--se tem uma var usuario significa que estamos editando-->
                                        <input type="text" class="form-control" name="email" value="<?php echo (isset($usuario) ? $usuario->email : set_value('email')); ?>">
                                        <?php echo form_error('email', '<div class="text-danger">', '</div>')?>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-4 mb-20">
                                        <label>Senha</label>
                                        <!--se tem uma var usuario significa que estamos editando-->
                                        <input type="password" class="form-control" name="password" value="">
                                        <!--O value de senha fica em branco para nao retornar a senha-->
                                        <?php echo form_error('password', '<div class="text-danger">', '</div>')?>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Confirmação</label>
                                        <!--se tem uma var usuario significa que estamos editando-->
                                        <input type="password" class="form-control" name="confirmacao" value="">
                                        <?php echo form_error('confirmacao', '<div class="text-danger">', '</div>')?>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-4 mb-20">
                                        <label>Perfil de acesso</label>
                                        <select class="form-control" name="perfil">

                                        <?php if(isset($usuario)): ?>

                                            <option value="2"<?php echo ($perfil_usuario->id == 2 ? 'selected' : ''); ?>>Atendente</option>
                                            <option value="1"<?php echo ($perfil_usuario->id == 1 ? 'selected' : ''); ?>>Administrador</option>

                                        <?php else: ?>

                                            <option value="2">Atendente</option>
                                            <option value="1">Administrador</option>

                                        <?php endif; ?>

                                        </select>
                                    </div>

                                    <div class="col-md-4 mb-20">
                                        <label>Ativo</label>
                                        <select class="form-control" name="active">

                                            <?php if (isset($usuario)) : ?>

                                                <option value="0" <?php echo ($usuario->active == 0 ? 'selected' : '') ?>>Não</option>
                                                <option value="1" <?php echo ($usuario->active == 1 ? 'selected' : '')?>>Sim</option>
                                                <!--se o campo do active for igual a 1 selected sera sim,se nao, nao fara nada-->
                                            <?php else : ?>
                                                <option value="0">NÃO</option>
                                                <option value="1">SIM</option>
                                            <?php endif; ?>

                                        </select>
                                    </div>

                                </div>
                                
                                <?php if(isset($usuario)) :?>
                                <div class="form-group row">
                                    <div class="col-md-12"><!--aqui e para enviar o id do usuario para fazer futuras verfificaçoes-->
                                        <input type="hidden" class="form-control" name="username_id" value="<?php echo $usuario->id?>">
                                    </div>
                                </div>
                                <?php endif; ?>

                                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                                <button class="btn btn-light">Cancel</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <footer class="footer">
        <div class="w-100 clearfix">
            <span class="text-center text-sm-left d-md-inline-block">Copyright © <?php echo date('Y') ?> ThemeKit v2.0. All Rights Reserved.</span>
            <span class="float-none float-sm-right mt-1 mt-sm-0 text-center">Customizado por <i class="fas fa-code text-dark"></i> by <a href="javascript:void" class="text-dark" target="">José Machado</a></span>
        </div>
    </footer>

</div>