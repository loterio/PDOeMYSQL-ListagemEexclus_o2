<?php 

  function desc($type) {  
    $var=0;
    if($type=='Particular'){
      $var=10;
      return $var;
    }else if($type=='SUS'){
      $var=20;
      return $var;
    }else if($type=='Plano de Saúde'){
      $var=30;
      return $var;
    }else if($type=='Social'){
      $var=40;
      return $var;
    }
  }

  function valFinal($type, $val){
    $var=0;
    $valorFinal=$val;

    if($type=='Particular'){
      $var=10;
    }else if($type=='SUS'){
      $var=20;
    }else if($type=='Plano de Saúde'){
      $var=30;
    }else if($type=='Social'){
      $var=40;
    }

    $valorFinal-=$var;
    return $valorFinal;
  }

  function transfDate($data) {
    $date=explode('-', $data);
    return "$date[2]/$date[1]/$date[0]";
  }

  function tipoConsulta($tipo) { // tipos: PA SUS PL SO 
    if($tipo=='Particular'){
      return 'PA';
    }else if($tipo=='SUS'){
      return 'SUS';
    }else if($tipo=='Plano de Saúde'){
      return 'PL';
    }else if($tipo=='Social'){
      return 'SO';
    }else{
      
    }
  }

?>