<?php 

//Referenciar o Dompdf namespace
use Dompdf\Dompdf;

//Instanciar e usar a classe dompdf 
$dompdf = new Dompdf(['enable_remote' => true]);

$dados = "";

//Instanciar o metodo LoadHtml e enviar o conteudo pdf
//$dompdf->loadHtml('Rigas - gerar PDF com PHP');

//Comfigurar o tamanho e a orientaçao do papel
$dompdf->setPaper('A4', 'potrait');

//Renderizar o HTML como PDF
//$dompdf->render();

//Gerar o PDF
//$dompdf->stream();

?>