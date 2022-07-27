<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);
ob_start();
session_start();
if (strcmp(basename($_SERVER["SCRIPT_NAME"]), basename(__FILE__)) === 0){
header("location: /");
exit;
}
date_default_timezone_set('America/Sao_Paulo');

#Configurações do banco de dados
define("NOME_DB","conectanovo");
define("NOME_SERVER_DB",'localhost');
define("USUARIO_DB",'root');
define("SENHA_DB",'0dd3bdd77a');

#Conexão com o banco de dados
try{
    $conn = new PDO("mysql:host=".NOME_SERVER_DB."; dbname=".NOME_DB."",
    USUARIO_DB,
    SENHA_DB,
    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"));
}catch(PDOException $e){
    echo "<center><h3>Banco de dados desconectado !<br>".$e->getMessage();
    exit;
}

#Variaveis já definidas
$sid = isset($_SESSION['logado'])?$_SESSION['logado']: '';
$acao = isset($_GET['acao'])?$_GET['acao']: '';
$uid = getIdBySid($sid); 

require_once($_SERVER['DOCUMENT_ROOT'] . "/config/Mobile_Detect.php");
$detect = new Mobile_Detect;
require_once($_SERVER['DOCUMENT_ROOT'] . "/config/conteudo.php");