<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/config/funcoes.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/modais.php");
isLogged($sid);

if (getAdm($uid) == false) :
    header("location: /");
endif;
?>

<div class="container">
    <center>
        <a href="home.php"><img class="mt-5" src="<?= getConfig('logo') ?>" width="<?= getConfig('largura') ?>" height="<?= getConfig('altura') ?>"></a><br>
        Bem vindo(a) <b><?= getNickById($uid) ?></b>!
    </center><br><br>

    <div class="row mb-1 mt-2">
        <div class="col">
            <div style="float: right;"><button class="btn btn-secondary float-right" type="button" data-bs-toggle="modal" data-bs-target="#modal-novo-usuario"><i class="fa-solid fa-plus"></i> Novo usuário</button></div>
        </div>
    </div>
    <div class="card card-body shadow border-0 table-wrapper table-responsive">

        <table class="table user-table table-hover align-items-center">
            <thead>
                <tr>
                    <th class="border-bottom">Nome</th>
                    <th class="border-bottom">Login</th>
                    <th class="border-bottom">Status</th>
                    <th class="border-bottom">Situação</th>
                    <th class="border-bottom">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = $conn->query("SELECT * FROM usuarios");
                while ($row = $sql->fetch(PDO::FETCH_ASSOC)) : ?>
                    <tr>
                        <td><a href="#" class="d-flex align-items-center">
                                <div class="d-block"><span class="fw-bold"><?= $row['nome'] ?></span>
                                </div>
                            </a></td>
                        <td><span class="fw-normal"><?= $row['login'] ?></span></td>
                        <td><span class="fw-normal d-flex align-items-center">
                                </svg>
                                <?php
                                if ($row['nivel'] == 1) :
                                    echo "Usuário";
                                elseif ($row['nivel'] == 2) :
                                    echo "Administrador";
                                elseif ($row['nivel'] == 3) :
                                    echo "Dono";
                                else :
                                    echo "Desconhecido";
                                endif;
                                ?>
                            </span></td>
                        <td>
                            <?php
                            if ($row['banido'] == 1) : ?>
                                <svg class="icon icon-xs text-danger ms-1" title="" data-bs-toggle="tooltip" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" data-bs-original-title="Delete" aria-label="Delete">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="fw-normal text-danger"> Banido</span>
                            <?php else : ?>
                                <svg class="icon icon-xxs text-success me-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path><span class="fw-normal text-success"> Ativo</span>
                                <?php endif; ?>

                        </td>
                        <td>
                            <div class="row">
							<?php if ($row['nivel'] != 3) : ?>
                                <div class="col px-md-0">
                                    <form action="" method="post">
                                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                        <button type="submit" class="btn btn-info btn-sm" name="btn_editar"><i class="fa-solid fa-pen-to-square"></i></button>
                                    </form>
                                </div>
                                <div class="col px-md-0">
                                    <a href="excluir.php?acao=usuario&id=<?= $row['id'] ?>" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
                                </div>
								<?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endwhile ?>
            </tbody>
        </table>
    </div>

    <!------------------------------------------------------------------------------------>
    <!-- MODAL CONFIG USUÁRIO -->
    <!------------------------------------------------------------------------------------>
    <div class="modal fade" id="modal-novo-usuario" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="h6 modal-title">Novo usuário</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="adicionar.php?acao=usuario" method="post">
                        <div class="row">
                            <div class="col">
                                <label for="">Nome</label>
                                <input type="text" name="nome" class="form-control">
                            </div>
                            <div class="col">
                                <label for="">Login</label>
                                <input type="text" name="login" class="form-control">
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col">
                                <label for="">Senha</label>
                                <input type="text" name="senha" class="form-control">
                            </div>
                            <div class="col">
                                <label for="">Pasta atualização</label>
                                <input type="text" name="pasta_nova" class="form-control">
                            </div>
                        </div>

                        <div class="row mt-2">
                        <div class="col">
                            Nivel de permissão
                            <select name="nivel" class="form-select">
                                <option value="1">Usuário</option>
                                <option value="2">Administrador</option>
                            </select>
                        </div>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" name="adicionar_usuario" style="color: white" class="btn btn-success">Adicionar</button></form>
                    <button type="button" style="color: white" class="btn btn-secondary text-gray ms-auto" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <?php
    if (isset($_POST['btn_editar'])) :
        $sql = $conn->query("SELECT * FROM usuarios WHERE id='" . $_POST['id'] . "'");
        $dados = $sql->fetch(PDO::FETCH_ASSOC); ?>
        <!------------------------------------------------------------------------------------>
        <!-- MODAL EDITAR USUÁRIO -->
        <!------------------------------------------------------------------------------------>
        <div class="modal fade" id="modal-editar-usuario" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="h6 modal-title">Editar usuário</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mt-2 mb-3"><i class="fa-solid fa-skull-crossbones"></i> Não digite a senha se não quiser alterar</div>
                        <form action="editar.php?acao=usuarios" method="post">
                            <input type="hidden" name="pasta_velha" value="<?=getData('pasta_att', $_POST['id'])?>">
                            <input type="hidden" name="id" value="<?= $dados['id'] ?>">
                            <div class="row">
                                <div class="col">
                                    <label for="">Nome</label>
                                    <input type="text" name="nome" value="<?= $dados['nome'] ?>" class="form-control">
                                </div>
                                <div class="col">
                                    <label for="">Login</label>
                                    <input type="text" name="login" value="<?= $dados['login'] ?>" class="form-control">
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col">
                                    <label for="">Senha</label>
                                    <input type="text" name="senha" class="form-control">
                                </div>
                                <div class="col">
                                    <label for="">Pasta atualização</label>
                                    <input type="text" value="<?= $dados['pasta_att'] ?>" name="pasta_nova" class="form-control">
                                </div>
                            </div>

                            <div class="row mt-2">
                        <div class="col">
                            Nivel de permissão
                            <select name="nivel" class="form-select">
                                <option value="1">Usuário</option>
                                <option value="2">Administrador</option>
                            </select>
                        </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="atualiza_usuarios" style="color: white" class="btn btn-success">Editar</button></form>
                        <button type="button" style="color: white" class="btn btn-secondary text-gray ms-auto" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
        $(document).ready(function() {
            $('#modal-editar-usuario').modal('show');
        });
    </script>

    <?php
    endif; ?>