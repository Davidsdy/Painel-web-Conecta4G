<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/config/config.php");

function isUser($uid)
{
    global $conn;
    $sql = $conn->query("SELECT * FROM usuarios WHERE id='$uid'")->rowCount();
    if ($sql > 0) {
        return true;
    } else {
        return false;
    }
}
function getNickById($uid)
{
    global $conn;
    $sql = $conn->query("SELECT nome FROM usuarios WHERE id='$uid'")->fetch();
    return @$sql[0];
}
function getLoginById($uid)
{
    global $conn;
    $sql = $conn->query("SELECT login FROM usuarios WHERE id='$uid'")->fetch();
    return @$sql[0];
}
function getIdByNick($nick)
{
    global $conn;
    $sql = $conn->query("SELECT id FROM usuarios WHERE login='$nick'")->fetch();
    return $sql[0];
}
function getFolderById($uid)
{
    global $conn;
    $sql = $conn->query("SELECT pasta_att FROM usuarios WHERE id='$uid'")->fetch();
    return @$sql[0];
}
function getBan($uid)
{
    global $conn;
    $sql = $conn->query("SELECT * FROM usuarios WHERE id='$uid'")->fetch();
    if ($sql['banido'] == 0) {
        return false;
    } else {
        return true;
    }
}
function getData($valor, $uid)
{
    global $conn;
    $sql = $conn->query("SELECT $valor FROM usuarios WHERE id='$uid'")->fetch();
    return $sql[$valor];
}

function getIdBySid($sid)
{
    global $conn;
    $sql = $conn->query("SELECT uid FROM sessao WHERE id='$sid'")->fetch();
    @$uid = $sql[0];
    return $uid;
}
function getSxtm()
{
    global $conn;
    $sql = $conn->query("SELECT valor FROM configs WHERE nome='sesexp'")->fetch();
    return $sql['valor'];
}
function getLogged($sid)
{
    global $conn;
    $conn->query("DELETE FROM sessao WHERE expira<'" . time() . "'");
    $sql = $conn->query("SELECT * FROM sessao WHERE id='$sid'")->rowCount();

    if ($sql > 0) {
        if (!getUser(getIdBySid($sid))) {
            return false;
        }
        $xtm = time() + 2000;
        $conn->query("UPDATE sessao SET expira='$xtm'WHERE id='$sid'");
        return true;
    } else {
        return false;
    }
}
function getAdm($uid)
{
    global $conn;
    $sql = $conn->query("SELECT nivel FROM usuarios WHERE id='" . $uid . "'")->fetch();
    if ($sql[0] == '2' or $uid == '1') {
        return true;
    } else {
        return false;
    }
}
function getOwner($uid)
{
    global $conn;
    $sql = $conn->query("SELECT nivel FROM usuarios WHERE id='" . $uid . "'")->fetch();
    if ($sql[0] == '3' or $uid == '1') {
        return true;
    } else {
        return false;
    }
}
function getUser($uid)
{
    global $conn;
    $sql = $conn->query("SELECT * FROM usuarios WHERE id='" . $uid . "'")->rowCount();
    if ($sql > 0) {
        return true;
    } else {
        return false;
    }
}
function getConfig($name)
{
    global $conn;
    $sql = $conn->query("SELECT valor FROM configs WHERE nome='$name'")->fetch();
    return $sql['valor'];
}
function addVersion($user)
{
    global $conn;
    $sql = $conn->query("SELECT versao FROM configuracoes WHERE id_owner='$user'")->fetch();
    $cc = $sql[0] + 1;
    $res = $conn->query("UPDATE configuracoes SET versao='$cc' WHERE id_owner='$user'");
}
function addSms($user)
{
    global $conn;
    $sql = $conn->query("SELECT att FROM mensagens WHERE id_owner='$user'")->fetch();
    $cc = $sql[0] + 1;
    $res = $conn->query("UPDATE mensagens SET att='$cc' WHERE id_owner='$user'");
}
function getConfigUser($valor, $user)
{
    global $conn;
    $sql = $conn->query("SELECT * FROM configuracoes WHERE id_owner='$user'");
    if ($sql->rowCount() > 0) {
        $sql = $conn->query("SELECT $valor FROM configuracoes WHERE id_owner='$user'")->fetch();
        return $sql[$valor];
    } else {
    }
}
function isLogged($sid)
{
    if (getLogged($sid) == false) {
        header("location: /");
    }
}
function download($arquivo)
{
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream;");
    header("Content-Length:" . filesize($arquivo));
    header("Content-disposition: attachment; filename=" . $arquivo);
    header("Pragma: no-cache");
    header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0");
    header("Expires: 0");
    readfile($arquivo);
    flush();
}
function delTree($dir)
{
    $files = array_diff(scandir($dir), array('.', '..'));
    foreach ($files as $file) {
        (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
    }
    return rmdir($dir);
}
