<?php include_once("conecta.php"); 
$secao[0]='C4205_C4254/legumes';
$secao[1]='C4205_C4275/verduras';
$secao[2]='C4205_C4252/frutas';
$secao[3]='C4205_C4263/frutas-especiais';
$secao[4]='C4205_C4277/ovos';
$secao[5]='C4212_C4382/feira';
$secao[6]='C4205_C4251/frutas-secas';
for($s=0;$s<=6;$s++){


for($u=0;$u<=5;$u++){
$url="http://www.paodeacucar.com.br/secoes/".$secao[$s]."?p=".$u."&qt=36&gt=list&ftr=";
$content=file_get_contents($url);
$content1=explode('<span class="value">',$content);

for($i=1;$i<=36;$i++){
$content2=explode('<',$content1[$i]);

$content4=explode('showcase-item__name',$content1[$i-1]);
$content5=explode('</a>',$content4[1]);
$content6=explode('>',$content5[0]);
$item=html_entity_decode($content6[2]);
$texto=str_replace(",",".",$content2[0]);
$precos[$i]=str_replace(" ","",$texto)*1;
$data=date('Y-m-d');
if($precos[$i]>0.1){
$insere = "INSERT INTO mercado (mercado,item,preco,data)"."VALUES('pda','$item','$precos[$i]','$data')";
mysqli_query($conecta,$insere);
}}}}


?>

                      