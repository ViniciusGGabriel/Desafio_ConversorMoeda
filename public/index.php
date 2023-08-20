<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Link css Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

<!-- Link main css -->
    <link rel="stylesheet" href="../src/style.css">

    <title>Conversor de moedas Euro e Dollar</title>
</head>

<body class="bg-dark">

    <?php
        /* Pega os valores dos inputs */
        if (isset($_REQUEST['valor']) && isset($_REQUEST['moeda'])) {
            $valor = floatval($_REQUEST['valor']);
            $moeda = $_REQUEST['moeda'];
            /* URL API */
            /* Euro */
            $url1 = 'https://olinda.bcb.gov.br/olinda/servico/PTAX/versao/v1/odata/CotacaoMoedaPeriodo(moeda=@moeda,dataInicial=@dataInicial,dataFinalCotacao=@dataFinalCotacao)?@moeda=\'EUR\'&@dataInicial=\'08-13-2023\'&@dataFinalCotacao=\'08-20-2023\'&$top=1&$orderby=dataHoraCotacao%20desc&$format=json&$select=cotacaoCompra,cotacaoVenda,dataHoraCotacao';
            /* Dollar */
            $url2 = 'https://olinda.bcb.gov.br/olinda/servico/PTAX/versao/v1/odata/CotacaoDolarPeriodo(dataInicial=@dataInicial,dataFinalCotacao=@dataFinalCotacao)?@dataInicial=\'08-13-2023\'&@dataFinalCotacao=\'08-20-2023\'&$top=1&$orderby=dataHoraCotacao%20desc&$format=json&$select=cotacaoCompra,cotacaoVenda,dataHoraCotacao';
            /* Taxas e resultas */
            $taxaE = json_decode(file_get_contents($url1), true);
            $taxaD = json_decode(file_get_contents($url2), true);
            $taxaEuro = $taxaE["value"][0]["cotacaoCompra"];
            $taxaDollar = $taxaD["value"][0]["cotacaoCompra"];
            $resultado = 0;

            if ($moeda == 'Euro') {
                $resultado = $valor / $taxaEuro;
            } elseif ($moeda == 'Dollar') {
                $resultado = $valor / $taxaDollar;
            }
        }
    ?>

<!-- Tela de escolha de moeda que será usada -->
<div class="d-flex justify-content-center mt-2">
        <div class="container bg-light rounded-1 m-2 p-3 w-50 ">
            <h1 class="text-white bg-dark rounded-1 p-1 text-center">Convertor de moedas</h1>
            <form action="<?=$_SERVER['PHP_SELF']?>" method="get" class="w-100 d-flex justify-content-evenly">
                <label for="valor">Valor em R$:</label>
                <input type="number" name="valor" id="ivalor" class="ms-1 w-40" step="0.010">

                <label for="moeda">Moeda:</label>
                <select name="moeda" id="imoeda" class="ms-1 w-25">
                    <option value="Euro">Euro</option>
                    <option value="Dollar">Dollar</option>
                </select>

                <input type="submit" value="enviar">
            </form>
        </div>
</div>

<div class=" d-flex justify-content-center">
    <section class="bg-light w-50 rounded-1 text-center p-5 fs-5">
        
            <?php
                echo "$valor Reais convertido para $moeda é igual a " .number_format($resultado, 0, ",", ".");
            ?>

    </section>
</div>

<!-- Link script main -->
<script src="../src/components/main.js"></script>

<!-- Link script bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>