<?php

    include_once "default.inc.php";
    require_once "Conexao.php";

    $excluirTodos = isset($_POST['exctds']) ? $_POST['exctds'] : "0";

    // echo $excluirTodos;

		$pdo = Conexao::getInstance();

		if($excluirTodos=='PA'){ 
			$consulta = $pdo->query("DELETE FROM clinica WHERE tipoConsulta LIKE'Particular'; ");
		}else if($excluirTodos=='SUS'){
				$consulta = $pdo->query("DELETE FROM clinica WHERE tipoConsulta LIKE'SUS'; ");
		}else if($excluirTodos=='PL'){   
				$consulta = $pdo->query("DELETE FROM clinica WHERE tipoConsulta LIKE'Plano de Saúde'; ");
		}else if($excluirTodos=='SO'){
				$consulta = $pdo->query("DELETE FROM clinica WHERE tipoConsulta LIKE'Social'; ");
		}

		header('location:index.php');

?>
