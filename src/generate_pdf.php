<?php 

//Referenciar o Dompdf namespace
//use Dompdf\Dompdf;

//Instanciar e usar a classe dompdf 
//$dompdf = new Dompdf(['enable_remote' => true]);

//$dados = "";

//Instanciar o metodo LoadHtml e enviar o conteudo pdf
//$dompdf->loadHtml('Rigas - gerar PDF com PHP');

//Comfigurar o tamanho e a orientaçao do papel
//$dompdf->setPaper('A4', 'potrait');

//Renderizar o HTML como PDF
//$dompdf->render();

//Gerar o PDF
//$dompdf->stream();

require "../vendor/autoload.php";
require "../config/conection_db.php";

if (isset($_GET['os_id'])) {
    $os_id = mysqli_real_escape_string($osdatabase, $_GET['os_id']);
    $sql = "SELECT * FROM ordem_servico_doc WHERE os_id = $os_id";
    $query = mysqli_query($osdatabase, $sql);

    if (mysqli_num_rows($query) > 0) { 
        $ordem_servico = mysqli_fetch_array($query);
    }
}




use Dompdf\Dompdf;
use Dompdf\Options;

if (isset($_GET['os_id'])) {

    $os_id = mysqli_real_escape_string($osdatabase, $_GET['os_id']);
    $sql = "SELECT * FROM ordem_servico_doc WHERE os_id = $os_id";
    $query = mysqli_query($osdatabase, $sql);
    
    if (mysqli_num_rows($query) > 0) {
        $ordem_servico = mysqli_fetch_array($query);
        

$options = new Options();
$options->setChroot(__DIR__); // Define o diretório base para arquivos CSS, imagens, etc.
$options->set('isRemoteEnabled', true); // Habilita carregar arquivos externos, como imagens

$dompdf = new Dompdf($options);

// 🔥 **Captura o HTML gerado pelo PHP**
ob_start();
$html = $ordem_servico['os_id'] ;

$dompdf->loadHtml($html);

$dompdf->render();

header('Content-type: application/pdf');
echo $dompdf->output();

    }
}



?>
