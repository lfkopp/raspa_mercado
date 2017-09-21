<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<?php
set_time_limit(0);
 

function getObjectOptions($object) {             
     $options = array();
    if (preg_match("#<<(.*)>>#ismU", $object, $options)) {

         $options = explode("/", $options[1]);
   

	@array_shift($options);
     $o = array();
        for ($j = 0; $j < @count($options); $j++) {
		
            $options[$j] = preg_replace("#\s+#", " ", trim($options[$j]));
            if (strpos($options[$j], " ") !== false) {
                $parts = explode(" ", $options[$j], 2);
                $o[$parts[0]] = $parts[1];
            } else
                $o[$options[$j]] = true;   }
	    $options = $o;
        unset($o);    }
  return $options;
}
function getDecodedStream($stream, $options) {
    $data = "";
    if (empty($options["Filter"]))
        $data = $stream;
    else {
       $length = !empty($options["Length"]) && strpos($options["Length"], " ") === false ? $options["Length"] : strlen($stream);
        $_stream = substr($stream, 0, $length);

        foreach ($options as $key => $value) {
    
            if ($key == "FlateDecode")
                $_stream = @gzuncompress($_stream);}
        $data = $_stream;}

    return $data;
}



function pdf2text($filename) {
    $infile = @file_get_contents($filename, FILE_BINARY);
    if (empty($infile))
        return "";
    $transformations = array();
    $texts = array();
    preg_match_all("#obj(.*)endobj#ismU", $infile, $objects);
    $objects = @$objects[1];
	$data2=NULL;
    for ($i = 1; $i < count($objects); $i++) {
        $currentObject= $objects[$i];
        if (preg_match("#stream(.*)endstream#ismU", $currentObject, $stream)) {
            $stream = ltrim($stream[1]);
            $options = getObjectOptions($currentObject);
            if (!(empty($options["Length1"]) && empty($options["Type"]) && empty($options["Subtype"])))
                continue;
            $data=NULL;
            $data = getDecodedStream($stream, $options); 
			$data2.=$data;
			}}
			return($data2);}
			

function pdftext($filename) {
$final=NULL;
$final1=NULL;
$texto=pdf2text($filename);
$texto=mb_convert_encoding($texto, 'UTF-8');
$texto3=explode('(',$texto);
for($t=1;$t<count($texto3);$t++){
$texto2=explode(")",$texto3[$t]);
$final[$t]=$texto2[0];
$final1.=$texto2[0];
}
$final[0]=$final1;
return $final1;
 
 }


 ?>

