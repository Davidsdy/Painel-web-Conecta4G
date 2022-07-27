<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/config/funcoes.php");
isLogged($sid);

if ($acao == "servidor") :

    if (isset($_POST['atualiza_servidor'])) :

        $id_owner = $_POST['id_owner'];
        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $tipo = $_POST['tipo'];
        $flag = $_POST['flag'];
        $serverip = $_POST['serverip'];
        $checkuser = $_POST['checkuser'];
        $serverport = $_POST['serverport'];
        $sslport = $_POST['sslport'];

        if (empty($nome)) :
            echo "<script>
    alert('Nome não pode ficar vazio !');
    window.location='" . getConfig('link') . "/app.php';
    </script>";

        else :

            $sql = $conn->prepare("UPDATE servidores SET id_owner='$id_owner', Name='$nome', TYPE='$tipo', FLAG='$flag', ServerIP='$serverip', CheckUser='$checkuser', ServerPort='$serverport', SSLPort='$sslport', USER='', PASS='' WHERE id='$id'");
            $sql->execute();

            echo "<script>
        alert('Servidor editado com sucesso !');
        window.location='" . getConfig('link') . "/app.php';
        </script>";

        endif;
    else :
        header("location: /");
    endif;

elseif ($acao == "payload") :

    if (isset($_POST['atualiza_payload'])) :
        $id_owner = $_POST['id_owner'];
        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $flag = $_POST['flag'];
        $payload = $_POST['pay'];
        $sni = $_POST['sni'];
        $tlsip = $_POST['tlsip'];
        $proxyip = $_POST['proxyip'];
        $proxyport = $_POST['proxyport'];
        $info = $_POST['info'];

        if (empty($nome)) :
            echo "<script>
            alert('Nome não pode ficar vazio !');
            window.location='" . getConfig('link') . "/app.php';
            </script>";

        else :

            $sql = $conn->prepare("UPDATE payloads SET id_owner='$id_owner', Name='$nome', FLAG='$flag', Payload='$payload', SNI='$sni', TlsIP='$tlsip', ProxyIP='$proxyip', ProxyPort='$proxyport', Info='$info' WHERE id='$id'");
            $sql->execute();

            echo "<script>
            alert('Payload editada com sucesso !');
            window.location='" . getConfig('link') . "/app.php';
            </script>";

        endif;
    else :
        header("location: /");
    endif;

elseif ($acao == "porta") :

    if (isset($_POST['atualiza_porta'])) :
        $id_owner = $_POST['id_owner'];
        $id = $_POST['id'];
        $porta = $_POST['porta'];

        if (empty($porta)) :
            echo "<script>
                alert('Porta não pode ficar vazio');
                window.location='" . getConfig('link') . "/app.php';
                </script>";

        else :

            $sql = $conn->prepare("UPDATE portas SET id_owner='$id_owner', Porta='$porta' WHERE id='$id'");
            $sql->execute();

            echo "<script>
                alert('Porta editada com sucesso !');
                window.location='" . getConfig('link') . "/app.php';
                </script>";

        endif;
    else :
        header("location: /");
    endif;

elseif ($acao == "sms") :

    if (isset($_POST['atualiza_sms'])) :

        $id_owner = $_POST['id_owner'];
        $sms = $_POST['sms'];

        $busca = $conn->query("SELECT * FROM mensagens WHERE id_owner='$id_owner'");

        if ($busca->rowCount() > 0) :

            $sql = $conn->query("UPDATE mensagens SET msg='$sms' WHERE id_owner='$id_owner'");

        else :

            $sql = $conn->query("INSERT INTO mensagens SET id_owner='$id_owner', msg='$sms'");

        endif;


        addSms($id_owner);

        $busca = $conn->query("SELECT * FROM mensagens WHERE id_owner='$id_owner'")->fetch();

        $pronto = '{"SendMessage":"' . $busca['att'] . '","MyMessage":"' . $busca['msg'] . '"}';

        $path = "update/" . getData('pasta_att', $uid) . "";
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $config = "update/" . getData('pasta_att', $uid) . "/sms";

        //verifica se já tem
        if (file_exists($config)) {
            unlink($config);
        }

        file_put_contents($config, $pronto);

        echo "<script>
        alert('SMS enviado com sucesso !');
        window.location='" . getConfig('link') . "/app.php';
        </script>";
    else :
        header("location: /");
    endif;

elseif ($acao == "config") :

    if (isset($_POST['atualiza_config'])) :

        $id_owner = $_POST['id_owner'];
        $notas = $_POST['notas'];
        $sms = getConfig('link') . '/update/' . getData('pasta_att', $uid) . '/sms';
        $update = getConfig('link') . '/update/' . getData('pasta_att', $uid) . '/config';
        $email = $_POST['email'];
        $contato = $_POST['contato'];
        $termos = $_POST['termos'];
        $checkuser = $_POST['checkuser'];

        $sql = $conn->query("SELECT * FROM configuracoes WHERE id_owner='$id_owner'");

        if ($sql->rowCount() == 0) :
            $config = $conn->query("INSERT INTO configuracoes SET id_owner='$id_owner', notas='$notas', sms='$sms', att='$update', email='$email', contato='$contato', termos='$termos', checkuser='$checkuser'");

            if ($config) :
                echo "<script>
            alert('Configurações editadas com sucesso !');
            window.location='" . getConfig('link') . "/app.php';
            </script>";
            endif;
        elseif ($sql->rowCount() == 1) :
            $config = $conn->query("UPDATE configuracoes SET notas='$notas', email='$email', contato='$contato', termos='$termos', checkuser='$checkuser' WHERE id_owner='$id_owner'");

            if ($config) :
                echo "<script>
            alert('Configurações editadas com sucesso !');
            window.location='" . getConfig('link') . "/app.php';
            </script>";
            endif;
        endif;
    else :
        header("location: /");
    endif;

elseif ($acao == "site") :

    if (getAdm($uid) == false) :
        header("location: /");
    endif;

    if (isset($_POST['atualiza_site'])) :

        $logo = $_POST['logo'];
        $altura = $_POST['altura'];
        $largura = $_POST['largura'];
        $link = $_POST['link'];
        $titulo = $_POST['titulo'];

        $sql_logo = $conn->query("UPDATE configs SET valor='$logo' WHERE nome='logo'");
        $sql_altura = $conn->query("UPDATE configs SET valor='$altura' WHERE nome='altura'");
        $sql_largura = $conn->query("UPDATE configs SET valor='$largura' WHERE nome='largura'");
        $sql_link = $conn->query("UPDATE configs SET valor='$link' WHERE nome='link'");
        $sql_titulo = $conn->query("UPDATE configs SET valor='$titulo' WHERE nome='titulo'");

        if ($sql_titulo) :
            echo "<script>
        alert('Configurações do site editadas com sucesso !');
        window.location='" . getConfig('link') . "';
        </script>";
        endif;
    else :
        header("location: /");
    endif;

elseif ($acao == "dados") :

    if ($_POST['nome']) :
        $nome = $_POST['nome'];
        $sql = $conn->query("SELECT * FROM usuarios WHERE nome='$nome'")->rowCount();

        if ($sql > 0) :
            echo "<script>
                alert('Este nome de usuário já está em uso !');
                window.location='" . getConfig('link') . "/perfil.php';
                </script>";
        elseif (empty($nome)) :
            echo "<script>
        alert('O nome não pode ficar vazio !');
        window.location='" . getConfig('link') . "/perfil.php';
        </script>";
        else :
            $sql = $conn->query("UPDATE usuarios SET nome='$nome' WHERE id='" . getIdBySid($sid) . "'");
            echo "<script>
                alert('Nome atualizado com sucesso !');
                window.location='" . getConfig('link') . "/perfil.php';
                </script>";
        endif;

    elseif ($_POST['login']) :
        $login = $_POST['login'];
        $sql = $conn->query("SELECT * FROM usuarios WHERE login='$login'")->rowCount();

        if ($sql > 0) :
            echo "<script>
                alert('Este login de usuário já está em uso !');
                window.location='" . getConfig('link') . "/perfil.php';
                </script>";
        elseif (empty($login)) :
            echo "<script>
        alert('O login não pode ficar vazio !');
        window.location='" . getConfig('link') . "/perfil.php';
        </script>";
        else :
            $sql = $conn->query("UPDATE usuarios SET login='$login' WHERE id='" . getIdBySid($sid) . "'");
            echo "<script>
                alert('Login atualizado com sucesso !');
                window.location='" . getConfig('link') . "/perfil.php';
                </script>";
        endif;
    elseif ($_POST['senha']) :
        $senha = $_POST['senha'];
        $senha = md5($senha);

        if (empty($senha)) :
            echo "<script>
        alert('A senha não pode ficar em branco !');
        window.location='" . getConfig('link') . "/perfil.php';
        </script>";
        else :

            $sql = $conn->query("UPDATE usuarios SET senha='$senha' WHERE id='" . getIdBySid($sid) . "'");
            echo "<script>
                    alert('Senha atualizada com sucesso !');
                    window.location='" . getConfig('link') . "/perfil.php';
                    </script>";
        endif;

elseif ($_POST['pasta']) :
    $pasta = $_POST['pasta'];

    $sql = $conn->query("SELECT * FROM usuarios WHERE pasta_att='$pasta'");
    $contar = $sql->rowCount();
    $dados = $sql->fetch(PDO::FETCH_ASSOC);
    if ($contar > 0 && $dados['id'] != $uid) :
        echo "<script>
        alert('Esta pasta já está em uso !');
        window.location='" . getConfig('link') . "/perfil.php';
        </script>";
    elseif (empty($pasta)) :
        echo "<script>
        alert('O nome da pasta não pode ficar vazio !');
        window.location='" . getConfig('link') . "/perfil.php';
        </script>";
    else :
        $pasta_velha = "update/" . $_POST['pasta_velha'];
        $pasta_nova = "update/" . $_POST['pasta'];

        rename($pasta_velha, $pasta_nova);

        $sms = getConfig('link') . '/update/' . $_POST['pasta'] . '/sms';
        $update = getConfig('link') . '/update/' . $_POST['pasta'] . '/config';

        $conn->query("UPDATE configuracoes SET att='$update', sms='$sms' WHERE id_owner='" . getIdBySid($sid) . "'");

        $sql = $conn->query("UPDATE usuarios SET pasta_att='$pasta' WHERE id='" . getIdBySid($sid) . "'");
        echo "<script>
        alert('Pasta atualizada com sucesso !');
        window.location='" . getConfig('link') . "/perfil.php';
        </script>";
    endif;

elseif ($acao == "usuarios") :

    if (getAdm($uid) == false) :
        header("location: /");
    endif;

    if (isset($_POST['atualiza_usuarios'])) :

        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $login = $_POST['login'];
        $senha = $_POST['senha'];
        $nivel = $_POST['nivel'];

        if (empty($senha)) :

            $sql = $conn->query("UPDATE usuarios SET nome='$nome', login='$login', nivel='$nivel', pasta_att='" . $_POST['pasta_nova'] . "' WHERE id='$id'");

            $pasta_velha = "update/" . $_POST['pasta_velha'];
            $pasta_nova = "update/" . $_POST['pasta_nova'];

            rename($pasta_velha, $pasta_nova);

            $sms = getConfig('link') . '/update/' . getData('pasta_att', $id) . '/sms';
            $update = getConfig('link') . '/update/' . getData('pasta_att', $id) . '/config';

            $conn->query("UPDATE configuracoes SET att='$update', sms='$sms' WHERE id_owner='$id");

            if ($sql) :
                echo "<script>
            alert('Usuário editado com sucesso !');
            window.location='" . getConfig('link') . "/usuarios.php';
            </script>";
            endif;
        else :

            $senha = md5($senha);

            $sql = $conn->query("UPDATE usuarios SET nome='$nome', login='$login', senha='$senha', nivel='$nivel', pasta_att='" . $_POST['pasta_nova'] . "' WHERE id='$id'");

            $pasta_velha = "update/" . $_POST['pasta_velha'];
            $pasta_nova = "update/" . $_POST['pasta_nova'];

            rename($pasta_velha, $pasta_nova);

            $sms = getConfig('link') . '/update/' . getData('pasta_att', $id) . '/sms';
            $update = getConfig('link') . '/update/' . getData('pasta_att', $id) . '/config';

            $conn->query("UPDATE configuracoes SET att='$update', sms='$sms' WHERE id_owner='$id'");

            if ($sql) :
                echo "<script>
            alert('Senha do usuário atualizada com sucesso !');
            window.location='" . getConfig('link') . "/usuarios.php';
            </script>";

            endif;
        endif;

    else :
        header("location: /");
    endif;

else :
    header("location: /");
endif;
endif;