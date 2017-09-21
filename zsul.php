<?php include_once("conecta.php"); ?>


<?php

$secao[0]='44';
$secao[1]='52';
for($s=0;$s<=1;$s++){



$url="http://www.zonasulatende.com.br/WebForms/Lista-Facetada.aspx?Qtd=3000&CodSecao=".$secao[$s]."";
$content=file_get_contents($url);
$content1=explode('lnkProd',$content);

$t=1;

while($content1[(2*$t)]){

$preco2=explode('R$ ',$content1[(2*$t)]);
$preco=explode('</p',$preco2[1]);
$qtd2=explode('"peso">',$content1[(2*$t)]);
$qtd=explode('</p>',$qtd2[1]);
$item3=explode('title="',$preco2[0]);
$item2=explode('"',$item3[1]);
$item2=utf8_decode($item2[0].$qtd[0]);
$item=str_replace("  "," ",$item2);
$texto=str_replace(",",".",$preco[0]);
$precos=str_replace(" ","",$texto)*1;
$data=date('Y-m-d');
$t++;
if($precos>0.1){
$insere = "INSERT INTO mercado (mercado,item,preco,data)"."VALUES('zsul','$item','$precos','$data')";
mysqli_query($conecta,$insere);
}
}}

?>

                      