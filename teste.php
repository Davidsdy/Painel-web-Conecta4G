<?php
$conn = new PDO("mysql:host=localhost;dbname=conectanovo","root","");
?>
<form action="" method="post">
    Texto: <br>
    <textarea name="texto" id="" cols="30" rows="10"></textarea><br>
    <input type="submit" value="Adicionar">
</form>
<?php 

if(isset($_POST['texto'])){
$texto = $_POST['texto'];

$json = '[
    '.$texto.'
  ]
';

$obj = json_decode($json, true);
$qtd = count($obj);

for($i=0; $i < $qtd; $i++){
    $nome = $obj[$i]['Name'];
    $flag = $obj[$i]['FLAG'];
    $payload = $obj[$i]['Payload'];
    $sni = $obj[$i]['SNI'];
    $tlsip = $obj[$i]['TlsIP'];
    $proxyip = $obj[$i]['ProxyIP'];
    $proxyport = $obj[$i]['ProxyPort'];
    $info = $obj[$i]['Info'];
    $conn->query("INSERT INTO testes SET Name='$nome', FLAG='$flag', Payload='$payload', SNI='$sni', TlsIP='$tlsip', ProxyIP='$proxyip', ProxyPort='$proxyport', Info='$info'");
}

echo "OK !";
}
?>