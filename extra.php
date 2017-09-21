<?php include_once("conecta.php"); ?>


<?php
$data=date('Y-m-d');

$secao[0]='C12_C2261/hortifruti/frutas-citricas';
$secao[1]='C12_C2242/hortifruti/banana';
$secao[2]='C12_C2305/hortifruti/cogumelos-e-derivados-de-soja';
$secao[3]='C12_C2284/hortifruti/cebola-e-alho';
$secao[4]='C12_C2299/hortifruti/folhagens-e-processados-organicos';
$secao[5]='C12_C2267/hortifruti/frutas-especiais';
$secao[6]='C12_C2274/hortifruti/frutas-organicas';
$secao[7]='C12_C2276/hortifruti/frutas-secas-e-processadas';
$secao[8]='C12_C2263/hortifruti/frutas-tropicais';
$secao[9]='C12_C2303/hortifruti/hortalicas-para-tempero';
$secao[10]='C12_C2281/hortifruti/legumes-desembalados';
$secao[11]='C12_C2286/hortifruti/legumes-organicos';
$secao[12]='C12_C2289/hortifruti/legumes-embalados';
$secao[13]='C12_C2244/hortifruti/maca';
$secao[14]='C12_C2254/hortifruti/mamao';
$secao[15]='C12_C2257/hortifruti/melao-e-melancia';
$secao[16]='C12_C2304/hortifruti/ovos';
$secao[17]='C12_C2246/hortifruti/pera';
$secao[18]='C12_C2308/hortifruti/temperos-embalados-e-processados';
$secao[19]='C12_C2259/hortifruti/uva';
$secao[20]='C12_C2296/hortifruti/verduras';


for($s=0;$s<=20;$s++){



$url="http://www.deliveryextra.com.br/secoes/".$secao[$s]."?sort=&rows=200&q=&offset=0";
$content=file_get_contents($url);
$content1=explode('<!-- Imagem Produto Vitrine Grande -->',$content);
for($i=1;$i<=50;$i++){

$content2=explode('<span>',$content1[$i]);
$content3=explode('<strong>',$content2[1]);
$content21=explode('</span',$content2[1]);
$content31=explode('<',$content3[1]);



$item=utf8_decode($content21[0]);
$preco=str_replace(",",".",$content31[0]);
$precos=str_replace(" ","",$preco)*1;

if($precos>0){
$insere = "INSERT INTO mercado (mercado,item,preco,data)"."VALUES('extra','$item','$precos','$data')";
mysqli_query($conecta,$insere);
}

}
}


?>


                      