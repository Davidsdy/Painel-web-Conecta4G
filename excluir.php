<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/config/funcoes.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/modais.php");
isLogged($sid);

if ($acao == "servidor") :

    if (isset($_POST['excluir_servidor'])) :

        $id = $_POST['id'];
        $id_owner = $_POST['id_owner'];

        $sql = $conn->query("DELETE FROM servidores WHERE id='$id' AND id_owner='$id_owner'");

        if ($sql) :
            echo "<script>
    alert('Servidor excluido com sucesso !');
    window.location='" . getConfig('link') . "/app.php';
    </script>";
        else :
            echo "<script>
        alert('Falha ao excluir servidor !');
        window.location='" . getConfig('link') . "/app.php';
        </script>";
        endif;
    else :
        header("location: /");
    endif;

elseif ($acao == "payload") :

    if (isset($_POST['excluir_payload'])) :

        $id = $_POST['id'];
        $id_owner = $_POST['id_owner'];

        $sql = $conn->query("DELETE FROM payloads WHERE id='$id' AND id_owner='$id_owner'");

        if ($sql) :
            echo "<script>
            alert('Payload excluida com sucesso !');
            window.location='" . getConfig('link') . "/app.php';
            </script>";
        else :
            echo "<script>
                alert('Falha ao excluir Payload !');
                window.location='" . getConfig('link') . "/app.php';
                </script>";
        endif;
    else :
        header("location: /");
    endif;

elseif ($acao == "porta") :

    if (isset($_POST['excluir_porta'])) :

        $id = $_POST['id'];
        $id_owner = $_POST['id_owner'];

        $sql = $conn->query("DELETE FROM portas WHERE id='$id' AND id_owner='$id_owner'");

        if ($sql) :
            echo "<script>
                alert('Porta excluida com sucesso !');
                window.location='" . getConfig('link') . "/app.php';
                </script>";
        else :
            echo "<script>
                    alert('Falha ao excluir Porta !');
                    window.location='" . getConfig('link') . "/app.php';
                    </script>";
        endif;
    else :
        header("location: /");
    endif;
elseif ($acao == "usuario") :

    if (getOwner($uid) == false) :
        header("location: /");
    endif;

    if (isset($_GET['id'])) :

        $id = $_GET['id'];
        $pasta = getData('pasta_att', $id);

        $sql = $conn->query("SELECT nivel FROM usuarios WHERE id='$id'")->fetch();

        if ($sql[0] >= 3) :
            echo "<script>
            alert('Você não pode excluir o dono do site !');
            window.location='" . getConfig('link') . "/adicionar.php';
            </script>";
        else :

            $conn->query("DELETE FROM usuarios WHERE id='$id'");
            $conn->query("DELETE FROM configuracoes WHERE id_owner='$id'");
            $conn->query("DELETE FROM servidores WHERE id_owner='$id'");
            $conn->query("DELETE FROM payloads WHERE id_owner='$id'");
            $conn->query("DELETE FROM portas WHERE id_owner='$id'");
            $sql = $conn->query("DELETE FROM mensagens WHERE id_owner='$id'");

            delTree("update/$pasta");

            if ($sql) :
                echo "<script>
                    alert('Usuário excluido com sucesso !');
                    window.location='" . getConfig('link') . "/adicionar.php';
                    </script>";
            else :
                echo "<script>
                        alert('Falha ao excluir usuário !');
                        window.location='" . getConfig('link') . "/adicionar.php';
                        </script>";
            endif;
        endif;
    else :
        header("location: /");
    endif;
endif;
