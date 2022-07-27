<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/config/funcoes.php");
isLogged($sid); ?>

<div class="container">
    <center>
        <a href="home.php"><img class="mt-5" src="<?= getConfig('logo') ?>" width="<?= getConfig('largura') ?>" height="<?= getConfig('altura') ?>"></a><br>
        Bem vindo(a) <b><?= getNickById($uid) ?></b>!<br>

        <div class="mt-3" class="col-12 px-0 mb-4">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between border-bottom pb-3">
                        <div><i class="fa-solid fa-bars"></i>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between border-bottom py-3">
                        <div>
                            <div class="h6 mb-0 d-flex align-items-center">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#modal-nome"><i class="fa-solid fa-pen-to-square"></i> Alterar nome</a>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between border-bottom py-3">
                        <div>
                            <div class="h6 mb-0 d-flex align-items-center">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#modal-login"><i class="fa-solid fa-pen-to-square"></i> Alterar login</a>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between border-bottom py-3">
                        <div>
                            <div class="h6 mb-0 d-flex align-items-center">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#modal-senha"><i class="fa-solid fa-pen-to-square"></i> Alterar senha</a>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between border-bottom py-3">
                        <div>
                            <div class="h6 mb-0 d-flex align-items-center">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#modal-pasta"><i class="fa-solid fa-pen-to-square"></i> Pasta de atualização</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>

<!------------------------------------------------------------------------------------>
<!-- MODAL NOME -->
<!------------------------------------------------------------------------------------>
    <div class="modal fade" id="modal-nome" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="h6 modal-title">Alterar nome</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="editar.php?acao=dados" method="post">
                                <label for="">Nome</label>
                                <input type="text" name="nome" class="form-control" value="<?= getUser('nome', getIdBySid($sid)) ?>">

                </div>
                <div class="modal-footer">
                    <button type="submit" style="color: white" class="btn btn-success">Salvar</button></form>
                    <button type="button" style="color: white" class="btn btn-secondary text-gray ms-auto" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

<!------------------------------------------------------------------------------------>
<!-- MODAL LOGIN -->
<!------------------------------------------------------------------------------------>
<div class="modal fade" id="modal-login" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="h6 modal-title">Alterar login</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="editar.php?acao=dados" method="post">
                                <label for="">Login</label>
                                <input type="text" name="login" class="form-control" value="<?= getUser('login', getIdBySid($sid)) ?>">

                </div>
                <div class="modal-footer">
                    <button type="submit" style="color: white" class="btn btn-success">Salvar</button></form>
                    <button type="button" style="color: white" class="btn btn-secondary text-gray ms-auto" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
<!------------------------------------------------------------------------------------>
<!-- MODAL SENHA -->
<!------------------------------------------------------------------------------------>
<div class="modal fade" id="modal-senha" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="h6 modal-title">Alterar senha</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="editar.php?acao=dados" method="post">
                                <label for="">Nova senha</label>
                                <input type="text" name="senha" class="form-control">
                </div>
                <div class="modal-footer">
                    <button type="submit" style="color: white" class="btn btn-success">Salvar</button></form>
                    <button type="button" style="color: white" class="btn btn-secondary text-gray ms-auto" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
<!------------------------------------------------------------------------------------>
<!-- MODAL PASTA -->
<!------------------------------------------------------------------------------------>
<div class="modal fade" id="modal-pasta" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="h6 modal-title">Alterar pasta</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="editar.php?acao=dados" method="post">
                        <input type="hidden" name="pasta_velha" value="<?= getFolderById($uid) ?>">
                                <label for="">Pasta de atualização</label>
                                <input type="text" name="pasta" class="form-control" value="<?= getFolderById($uid) ?>">

                </div>
                <div class="modal-footer">
                    <button type="submit" style="color: white" class="btn btn-success">Salvar</button></form>
                    <button type="button" style="color: white" class="btn btn-secondary text-gray ms-auto" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>