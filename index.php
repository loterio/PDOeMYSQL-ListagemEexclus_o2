<!DOCTYPE html>
<?php 
    include_once "default.inc.php";
    require_once "Conexao.php";
    $title = "Clínica Médica";
    
    // pegando valores do formulário
    $excluirTodos=isset($_POST['exctds'])?$_POST['exctds']:null;

    $tipoBusca=isset($_POST['tipoDeBusca'])?$_POST['tipoDeBusca']:null;

    $dataInicial=isset($_POST['dataInicial'])?$_POST['dataInicial']:null;
    $dataFinal=isset($_POST['dataFinal'])?$_POST['dataFinal']:null;

    $tipoSelect=isset($_POST['selectTipoConsulta'])?$_POST['selectTipoConsulta']:null;

    $valorInicial=isset($_POST['valorInicial'])?$_POST['valorInicial']:null;
    $valorFinal=isset($_POST['valorFinal'])?$_POST['valorFinal']:null;
?>
<html>
<head> 
    <meta charset="UTF-8">
    <title> <?php echo $title; ?> </title>
    <link rel="stylesheet" href="st.css">
</head>
<body>

<form method="post">
  <div>
    <input type="radio" name='tipoDeBusca' value='0' <?php if($tipoBusca=='0') echo 'checked'; ?>>Data da Consulta <br/>
    <input type="date" name='dataInicial' value='<?php echo $dataInicial; ?>' placeholder='Data inicial'>
    <input type="date" name='dataFinal' value='<?php echo $dataFinal; ?>' placeholder='Data final'>
  </div>
  <hr>
  <div>
    <input type="radio" name='tipoDeBusca' value='1' <?php if($tipoBusca=='1') echo 'checked'; ?>>Tipo de Plano <br/> <?php // echo $tipoSelect; ?>
    <select name="selectTipoConsulta">
			<option value="0"></option>
      <option value="PA" <?php if($tipoSelect == 'PA') echo 'selected'; ?>>Particular</option>
      <option value="SUS" <?php if($tipoSelect == 'SUS') echo 'selected'; ?>>SUS</option>
      <option value="PL" <?php if($tipoSelect == 'PL') echo 'selected'; ?>>Plano de Saúde</option>
      <option value="SO" <?php if($tipoSelect == 'SO') echo 'selected'; ?>>Social</option>
    </select> 
  </div>
  <hr>
  <div>
    <input type="radio" name='tipoDeBusca' value='2' <?php if($tipoBusca=='2') echo 'checked'; ?>>Valor da Consulta <br/>
    <input type="text" name='valorInicial' value='<?php echo $valorInicial; ?>' placeholder='Valor inicial'>
    <input type="text" name='valorFinal' value='<?php echo $valorFinal; ?>' placeholder='Valor final'>
  </div><br/>
  <input type="submit" value='buscar'><br/><br/>
  <hr>
</form>

<form action="action.php" method="post">

		<div>
 	  <!-- <input type="radio" name='exctds' value='1' <?php // if($tipoBusca=='1') echo 'checked'; ?>>Tipo de Plano <br/>  -->	
			Excluir consultas do
			<select name="exctds">
				<option value="0"></option>
				<option value="PA" <?php if($excluirTodos == 'PA') echo 'selected'; ?>>Particular</option>
				<option value="SUS" <?php if($excluirTodos == 'SUS') echo 'selected'; ?>>SUS</option>
				<option value="PL" <?php if($excluirTodos == 'PL') echo 'selected'; ?>>Plano de Saúde</option>
				<option value="SO" <?php if($excluirTodos == 'SO') echo 'selected'; ?>>Social</option>
			</select>
			<button>excluir</button>
		</div>

</form> 
<hr>
<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Paciente</th>
            <th>Médico</th>
            <th>Data da Consulta</th>
            <th>Tipo de Consulta</th>
            <th>Valor</th>
            <th>Desconto</th>
            <th>Valor Final</th>
            <th>Excluir</th>
        </tr>
    </thead>
    <tbody>
    <?php 
        include 'functions.php';

				$pdo = Conexao::getInstance();
				$consulta = $pdo->query("SELECT * FROM clinica; ");

        if($tipoBusca=='0'){ // data da consulta

            $dataInicial="'".$dataInicial."'";
            $dataFinal="'".$dataFinal."'";
            $consulta = $pdo->query("SELECT * FROM clinica WHERE dataConsulta BETWEEN $dataInicial AND $dataFinal ORDER BY dataConsulta; ");

        }else if($tipoBusca=='1'){ // tipo de plano tipos: PA SUS PL SO 

            if($tipoSelect=='PA'){
                $tipoSelect='Particular';    
                $consulta = $pdo->query("SELECT * FROM clinica WHERE tipoConsulta LIKE'$tipoSelect'; ");
            }else if($tipoSelect=='SUS'){
                $tipoSelect='SUS';    
                $consulta = $pdo->query("SELECT * FROM clinica WHERE tipoConsulta LIKE'$tipoSelect'; ");
            }else if($tipoSelect=='PL'){
                $tipoSelect='Plano de Saúde';    
                $consulta = $pdo->query("SELECT * FROM clinica WHERE tipoConsulta LIKE'$tipoSelect'; ");
            }else if($tipoSelect=='SO'){
                $tipoSelect='Social';    
                $consulta = $pdo->query("SELECT * FROM clinica WHERE tipoConsulta LIKE'$tipoSelect'; ");
            }else{
                $consulta = $pdo->query("SELECT * FROM clinica; ");
            }
            
        }else if($tipoBusca=='2'){ //valor da consulta
            $consulta = $pdo->query("SELECT * FROM clinica WHERE valor BETWEEN $valorInicial AND $valorFinal ORDER BY valor; ");
        }
        
        $x=0;
        $class='';
        $somaValor=0;
        $somaDesconto=0; 
        $somaFinal=0;
						
				

        while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
          $somaValor+=$linha['valor'];
          $somaDesconto+=desc($linha['tipoConsulta']); 
          $somaFinal+=valFinal($linha['tipoConsulta'], $linha['valor']);     

        echo $x % 2 ? "<tr class='a'>" : "<tr class='b'>"; 
        echo "
            <th>{$linha['codigo']}</th>
            <th>{$linha['paciente']}</th>
            <th>{$linha['medico']}</th>
            <th>".transfDate($linha['dataConsulta'])."</th>
            <th class='".tipoConsulta($linha['tipoConsulta'])."'>{$linha['tipoConsulta']}</th>
            <th>R$ {$linha['valor']}</th>
            <th>R$ ".desc($linha['tipoConsulta'])."</th>
            <th>R$ ".valFinal($linha['tipoConsulta'], $linha['valor'])."</th>";?>
				<th><a href="javascript:excluir('index_acao.php?codigo=<?php echo $linha['codigo'];?>')">X</a></th>
			</tr>
<?php 
    $x++; }
    echo "
    <tr>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th>R$ $somaValor</th>
        <th>R$ $somaDesconto</th>
        <th>R$ $somaFinal</th>
        <th></th>
    </tr>     
    "; 
?>
            
    </tbody>
</table>   

<script>
    function excluir(url){
      if (confirm("Deseja realmente excluir?"))
        location.href = url;
    }
</script>
</body>
</html>