<?php include_once("conecta.php"); ?>
<?php include_once("pdf-to-txt.php"); ?>
 
<?php 
 set_time_limit(0);
	for($u=1;$u<=1;$u++)//até 24 paginas
	{ 	$url="http://www.ceasa.rj.gov.br/ceasa_portal/view/ListarCotacoes.asp?pagina=".$u." ";

		$content=file_get_contents($url);
		$content=explode("data_hora",$content);
			for($z=1;$z<=20;$z++)//até 20 itens por página
			{  	$contentx=explode('href="',$content[$z]);
				$contentx=explode('"',$contentx[1]);
				$contentx2=str_replace(" ","%20",$contentx[0]);
			 	

$data2=str_replace("  "," ",$contentx[0]);
$data2=str_replace("precos","preco",$data2);
$data2=str_replace("preco - ","preco ",$data2);
$data2=str_replace("(1)"," ",$data2);	
$data2=str_replace("  "," ",$data2);
$data2=str_replace("-"," ",$data2);	
$data2=explode('preco ',$data2);
$data2=explode('.pdf',$data2[1]);
$data2=explode(' ',$data2[0]);
$data3=$data2[2]."-".$data2[1]."-".$data2[0];

	    $texto=pdf2text($contentx2);
		$texto=str_replace("x-nonex-none","x-none",$texto);
		$texto=str_replace(",",".",$texto);
		$texto3=explode('(',$texto);
		$y=0;
		unset($texto4);
		$texto4=array();
			for($t=1;$t<count($texto3);$t++)
			{	$texto2=explode(")",$texto3[$t]);
				if($texto2[0]=="x-none"){
				$y++;
				$texto4[$y]=NULL;
				}else{
					if($texto2[0]=="x-none")
					{	echo " ";
					}else{
						$texto4[$y]=$texto4[$y].$texto2[0];
					}
				}
			}

$timestamp2 = date('Y-m-d',strtotime(str_replace('/', '-', $data3))); 
$timestamp  = date('Y-m-d',strtotime(str_replace('/', '-', $texto4[2]))); 
if($timestamp2>$timestamp){$timestamp3=$timestamp2;}else{$timestamp3=$timestamp;}

$get_cod="SELECT distinct  cod_item FROM `ceasa_aux` WHERE 1";
$result_cod=mysqli_query($conecta,$get_cod) or die ('Erro ao consultar cod');

	while($row_cod=mysqli_fetch_array($result_cod)){

			$pos=NULL;
			$pos=array_search($row_cod[0],$texto4);
                if($pos>1 AND $texto4[$pos+3]>0){
				$unid = $texto4[$pos+1];
				if($texto4[$pos+3]>0){$p_med = $texto4[$pos+3];}else{$p_med=NULL;}

	$cod2=$row_cod[0];  
$get_item="SELECT  cod_item,item,desc2 FROM mercado WHERE  cod_item='".$cod2."'";
$result_item=mysqli_query($conecta,$get_item) or die ('Erro ao consultar item3');				
$row_item=mysqli_fetch_array($result_item);
$desc2=$row_item[desc2];
$item2=$row_item[item];

$insere5 = "INSERT INTO `mercado`(`mercado`, `cod_item`, `desc2`, `item`, `preco`, `data`) "." VALUES ('ceasa','$cod2','$desc2','$item2','$p_med','$timestamp3')";
mysqli_query($conecta,$insere5);

}}}}
		

	
?>
