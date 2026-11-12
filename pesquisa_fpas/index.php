<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="cache-control" content="no-cache" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>...:::: Pesquisa FPAS ::::...</title>
  <link rel="shortcut icon" href="../newadm/imagens/favicon.png" type="image/x-icon" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
  <link rel="stylesheet" href="css/estilo.css" />
  <link rel="stylesheet" href="../newadm/include/css/estilo_header_footer.css" />
</head>

<body>
  <?php
  require_once $_SERVER['DOCUMENT_ROOT'] . "/newadm/autoload.php";

  include "../newadm/include/header.php";

  $resultadoFpas = [];
  $mostrarResultado = false;
  $buscaRealizada = false;

  if (isset($_GET['fpas']) && trim($_GET['fpas']) !== "") {
    $buscaRealizada = true;
    $cod_fpas = trim($_GET['fpas']);
    $resultadoFpas = Fpas_DAO::buscarPorFpas($cod_fpas);
    $mostrarResultado = !empty($resultadoFpas);
  } elseif (isset($_GET['fpas'])) {
    $buscaRealizada = true;
  }

  function temValor($valor)
  {
    return $valor !== null && trim((string)$valor) !== '';
  }

  function linhaResultado($titulo, $valor)
  {
    if (temValor($valor)) {
      echo "
        <tr>
          <th>{$titulo}</th>
          <td>" . htmlspecialchars($valor) . "</td>
        </tr>
      ";
    }
  }
  ?>

  <main>
    <div id="atualiza">
      <?php
      $id_ferramentas = 36;
      $todosavisos = Avisos_DAO::buscarAvisos($id_ferramentas);

      foreach ($todosavisos as $avisosatual) {
        echo "
          <li class='lista_atualiza'>
            <p>{$avisosatual->desc_avisos}</p>
          </li>";
      }
      ?>
    </div>

    <div id="ferramenta">
      <div id="tit_ferramenta">
        <h2>Pesquisa FPAS</h2>
        <br>
        Esta ferramenta de pesquisa tem por objetivo auxiliar o usuário na fácil e prática identificação dos valores e dos códigos de terceiros, bem como suas respectivas atividades, também encontra-se em permanente atualização, devido a modificações constantes da legislação que trata do assunto, em caso de dúvida lembramos que nossa consultoria está a disposição para orientações via telefone ou consultas online.
      </div>

      <br>

      <form method="get" action="">
        <div class="formulario">
          <label for="fpas">Digite o FPAS Desejado:</label>
          <input
            class="input"
            type="text"
            id="fpas"
            name="fpas"
            maxlength="14"
            placeholder="000"
            value="<?= isset($_GET['fpas']) ? htmlspecialchars($_GET['fpas']) : '' ?>" />
          <button class="ajuda esconder" type="button">?</button>
        </div>

        <div id="bloco_botao">
          <input class="botao" id="bt_calcular" type="submit" value="Buscar">
        </div>
      </form>

      <?php if ($buscaRealizada && !$mostrarResultado): ?>
        <div id="aviso" class="show_result">
          Nenhum FPAS encontrado com os critérios informados.
        </div>
      <?php endif; ?>

      <div id="resultado" class="<?= $mostrarResultado ? 'show_result' : 'sumir' ?>">
        <div class="overflow">
          <table>
            <thead>
              <tr>
                <th colspan="2" class="titulo_tabela">Resultado FPAS</th>
              </tr>
            </thead>

            <tbody>
              <?php
              if (!empty($resultadoFpas)) {
                $primeiro = true;

                foreach ($resultadoFpas as $item) {

                  if (!$primeiro) {
                    echo "
                      <tr class='separador-fpas'>
                        <td colspan='2'></td>
                      </tr>
                    ";
                  }

                  $primeiro = false;

                  linhaResultado("FPAS", $item->fpas);
                  linhaResultado("Quadro", $item->quadro);
                  linhaResultado("Atividade", $item->atividade);
                  linhaResultado("Contribuição", $item->contribuicao);
                  linhaResultado("Previdência Social", $item->previdencia_social);
                  linhaResultado("SENAR", $item->senar);
                  linhaResultado("Código de Terceiros", $item->codigo_terceiros);
                  linhaResultado("Salário Educação", $item->salario_educacao);
                  linhaResultado("INCRA", $item->incra);
                  linhaResultado("Fundo Aeroviário", $item->fundo_aeroviario);
                  linhaResultado("SEST", $item->sest);
                  linhaResultado("SENAT", $item->senat);
                  linhaResultado("SENAI", $item->senai);
                  linhaResultado("SESI", $item->sesi);
                  linhaResultado("SEBRAE", $item->sebrae);
                  linhaResultado("SESC", $item->sesc);
                  linhaResultado("SENAC", $item->senac);
                  linhaResultado("SERNAR/SESCOOP", $item->sernar_sescoop);
                  linhaResultado("SESCOOP", $item->sescoop);
                  linhaResultado("FNDE", $item->fnde);
                  linhaResultado("DCP", $item->dcp);
                  linhaResultado("Total de Terceiros", $item->total_terceiros);
                  linhaResultado("Observações", $item->observacoes);
                }
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </main>

  <?php include "../newadm/include/footer.php"; ?>
  <script src="../newadm/include/js/script.js"></script>
</body>

</html>