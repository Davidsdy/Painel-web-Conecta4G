<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/config/funcoes.php");
isLogged($sid);

if ($acao == "servidor") :

    if (isset($_POST['adicionar_servidor'])) :

        $id_owner = $_POST['id_owner'];
        $nome = $_POST['nome'];
        $tipo = $_POST['tipo'];
        $flag = $_POST['flag'];
        $serverip = $_POST['serverip'];
        $checkuser = $_POST['checkuser'];
        $serverport = $_POST['serverport'];
        $sslport = $_POST['sslport'];

        $sql = $conn->query("SELECT * FROM servidores WHERE Name='$nome' AND id_owner='$id_owner'")->rowCount();

        if ($sql > 0) :
            echo "<script>
            alert('Já existe um servidor com esse nome !');
            window.location='" . getConfig('link') . "/app.php';
            </script>";
        elseif (empty($nome)) :
            echo "<script>
            alert('Nome não pode ficar vazio !');
            window.location='" . getConfig('link') . "/app.php';
            </script>";

        else :

            $sql = $conn->prepare("INSERT INTO servidores SET id_owner='$id_owner', Name='$nome', TYPE='$tipo', FLAG='$flag', ServerIP='$serverip', CheckUser='$checkuser', ServerPort='$serverport', SSLPort='$sslport', USER='', PASS=''");
            $sql->execute();

            echo "<script>
            alert('Servidor adicionado com sucesso !');
            window.location='" . getConfig('link') . "/app.php';
            </script>";

        endif;

    else :
        header("location: /");
    endif;

elseif ($acao == "payload") :

    if (isset($_POST['adicionar_payload'])) :

        $id_owner = $_POST['id_owner'];
        $nome = $_POST['nome'];
        $flag = $_POST['flag'];
        $payload = $_POST['pay'];
        $sni = $_POST['sni'];
        $tlsip = $_POST['tlsip'];
        $proxyip = $_POST['proxyip'];
        $proxyport = $_POST['proxyport'];
        $info = $_POST['info'];

        $sql = $conn->query("SELECT * FROM payloads WHERE Name='$nome' AND id_owner='$id_owner'")->rowCount();

        if ($sql > 0) :
            echo "<script>
            alert('Já existe uma payload com esse nome !');
            window.location='" . getConfig('link') . "/app.php';
            </script>";
        elseif (empty($nome)) :
            echo "<script>
            alert('Nome não pode ficar vazio !');
            window.location='" . getConfig('link') . "/app.php';
            </script>";
        else :

            $sql = $conn->prepare("INSERT INTO payloads SET id_owner='$id_owner', Name='$nome', FLAG='$flag', Payload='$payload', SNI='$sni', TlsIP='$tlsip', ProxyIP='$proxyip', ProxyPort='$proxyport', Info='$info'");
            $sql->execute();

            echo "<script>
            alert('Payload adicionada com sucesso !');
            window.location='" . getConfig('link') . "/app.php';
            </script>";

        endif;

    else :
        header("location: /");
    endif;

elseif ($acao == "porta") :

    if (isset($_POST['adicionar_porta'])) :

        $id_owner = $_POST['id_owner'];
        $porta = $_POST['porta'];

        $sql = $conn->query("SELECT * FROM portas WHERE Porta='$porta' AND id_owner='$id_owner'")->rowCount();

        if ($sql > 0) :
            echo "<script>
            alert('Essa porta já existe !');
            window.location='" . getConfig('link') . "/app.php';
            </script>";
        elseif (empty($porta)) :
            echo "<script>
            alert('Porta não pode ficar vazio !');
            window.location='" . getConfig('link') . "/app.php';
            </script>";
        else :

            $sql = $conn->prepare("INSERT INTO portas SET id_owner='$id_owner', Porta='$porta'");
            $sql->execute();

            echo "<script>
            alert('Porta adicionada com sucesso !');
            window.location='" . getConfig('link') . "/app.php';
            </script>";

        endif;

    else :
        header("location: /");
    endif;

    elseif ($acao == "multi") :

        if (isset($_POST['adicionar_multi'])) :
    
            $id_owner = $_POST['id_owner'];
            $texto = $_POST['texto'];
    
            if (empty($texto)) :
                echo "<script>
                alert('As payloads não podem ficar vazias !');
                window.location='" . getConfig('link') . "/app.php';
                </script>";
            else :
    
                $json = '[
                    '.$texto.'
                  ]
                ';
                
                $obj = json_decode($json, true);
                $qtd = count($obj);
				
				if($qtd <= 0):
				                echo "<script>
                alert('Erro de syntax nas payloads !');
                window.location='" . getConfig('link') . "/app.php';
                </script>";
				else:
                
                for($i=0; $i < $qtd; $i++){
                    $nome = $obj[$i]['Name'];
                    $flag = $obj[$i]['FLAG'];
                    $payload = $obj[$i]['Payload'];
                    $sni = $obj[$i]['SNI'];
                    $tlsip = $obj[$i]['TlsIP'];
                    $proxyip = $obj[$i]['ProxyIP'];
                    $proxyport = $obj[$i]['ProxyPort'];
                    $info = $obj[$i]['Info'];
                    $conn->query("INSERT INTO payloads SET id_owner='$id_owner', Name='$nome', FLAG='$flag', Payload='$payload', SNI='$sni', TlsIP='$tlsip', ProxyIP='$proxyip', ProxyPort='$proxyport', Info='$info'");
                }
    
                echo "<script>
                alert('Payloads adicionadas com sucesso !');
                window.location='" . getConfig('link') . "/app.php';
                </script>";
			endif;
            endif;
    
        else :
            header("location: /");
        endif;

elseif ($acao == "usuario") :

    if (getOwner($uid) == false) :
        header("location: /");
    endif;

    if (isset($_POST['adicionar_usuario'])) :

        $nome = $_POST['nome'];
        $login = $_POST['login'];
        $senha = $_POST['senha'];
        $pasta = $_POST['pasta_nova'];

        if(empty($pasta)):
            $pasta = $login;
        endif;

        $sql = $conn->query("SELECT * FROM usuarios WHERE login='$login'");

        if ($sql->rowCount() > 0) :
            echo "<script>
            alert('Já existe um usuário com esse login !');
            window.location='" . getConfig('link') . "/adicionar.php';
            </script>";
        else :
            $senha = md5($senha);
            $sql = $conn->query("INSERT INTO usuarios SET nome='$nome', login='$login', senha='$senha', pasta_att='$pasta'");

            if ($sql) :
                echo "<script>
                alert('Usuário adicionado com sucesso !');
                window.location='" . getConfig('link') . "/adicionar.php';
                </script>";
            endif;
        endif;
    else :
        header("location: /");
    endif;

else :
    header("location: /");
endif;
