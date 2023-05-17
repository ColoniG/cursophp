<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado Desafio 04</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main>
        <h1>Conversor de Moedas</h1>
        <?php 
            // Cotação vinda da API do Banco Central
            $inicio = date("m-d-Y", strtotime("- 7 days"));
            $fim = date("m-d-Y");  
            $url = 'https://olinda.bcb.gov.br/olinda/servico/PTAX/versao/v1/odata/CotacaoDolarPeriodo(dataInicial=@dataInicial,dataFinalCotacao=@dataFinalCotacao)?@dataInicial=\''.$inicio.'\'&@dataFinalCotacao=\''.$fim.'\'&$top=1&$orderby=dataHoraCotacao%20desc&$format=json&$select=cotacaoCompra,dataHoraCotacao';
            $dados = json_decode(file_get_contents($url), true);
            $cotacao = $dados["value"][0]["cotacaoCompra"];

            // Quantos $$ você tem
            $real = $_GET["numero"];
            
            // Equivalência em Dolar
            $usd = $real/$cotacao;     

            // Mostrar o eesultado
            // Formatação de Moedas com Internacionalização
            $padrao = numfmt_create("pt_BR", NumberFormatter::CURRENCY);

            echo "<p>Seus " . numfmt_format_currency($padrao, $real, "BRL") . " equivalem a <strong> " . numfmt_format_currency($padrao, $usd, "USD") . "</strong></p>";
            
            echo "<p style='font-size: .8em';><strong>*Cotação de R$ " . numfmt_format_currency($padrao, $cotacao, "BRL") . "</strong> informada pelo Banco Central.</p>";
        ?>
        <button onclick="javascript:history.go(-1)" style="color: white;">Voltar</button>
    </main>
</body>
</html>