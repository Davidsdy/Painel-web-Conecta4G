<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/config/funcoes.php");

if(isset($_POST['btn_login'])):

    $login = $_POST['login'];
    $senha = $_POST['senha'];
    $senha = md5($senha);

    $sql = $conn->query("SELECT * FROM usuarios WHERE login = '$login' AND senha = '$senha'");

    if($sql->fetchColumn() > 0):
        $conn->query("DELETE FROM sessao WHERE uid='".getIdByNick($login)."'");

        $uid = getIdByNick($login);
        $xtm = time() + 2000;
        $did = $uid;
        $tdid = $uid.$xtm.$did;
        $gerar = md5($tdid);
        $_SESSION["logado"] = $gerar;

        $conn->query("INSERT INTO sessao SET id = '".$_SESSION["logado"]."', uid = '$uid', expira = '$xtm' ");
        header("location: home.php");
    else:
        $_SESSION['erro'] = "<center><div style='padding: 1px; margin: 1px' class='alert alert-danger'>Usuário ou senha incorretos</div></center>";
    endif;
endif;