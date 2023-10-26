<?php
@session_start();
/*Incluimos el fichero de la clase*/
	$conexion = mysql_connect("localhost", "tspvcomm", "CR@P1030!EFM0ti");
	//$conexion = mysql_connect("127.0.0.1", "root", "12345");
	$date = date_create(); 
	mysql_select_db("tspvcomm_proveedores", $conexion);
	$prmProveedor=$_POST['prmProveedor'];
	$prmOrden=$_POST['prmOrden'];
	$prmGuzman=$_POST['prmGuzman'];
	$prmNota=$_POST['prmNota'];
	$arr = array();
	$cadena="";
	//$_SESSION["temporadagzm"]="19-19";
	if ($prmGuzman!=1) {
		$temp="SELECT CCVE_TEMPORADA FROM CTL_TEMPORADAS WHERE NACTIVO=1 AND CSUCURSAL='001'";
	}else{
		$temp="SELECT CCVE_TEMPORADA FROM CTL_TEMPORADAS WHERE NACTIVO=1 AND CSUCURSAL='003'";
	}	
    $restemp=mysql_query($temp, $conexion) or die ("Error con la temporada");
    $temporada=mysql_result($restemp,0,0); 
	$crelacionado=($prmNota==1 ? "CRELACIONADONC" : "CRELACIONADO");
	
	$query="SELECT CORDENCOMPRA,".$crelacionado." FROM inv_ocpendientes WHERE CCVE_TEMPORADA='".$temporada."' AND ".$crelacionado."='S' ";
        if($prmProveedor!=""){
            $query=$query . " AND CCVE_PROVEEDOR='".str_pad($prmProveedor,  6, "0",STR_PAD_LEFT)."'";    
        }
        if($prmOrden!=""){
            
            $query=$query . " AND CORDENCOMPRA='".$temporada.str_pad($prmOrden,  10, "0",STR_PAD_LEFT)."'";   
        }
        //var_dump($query);
        $res=mysql_query($query)or die ("Error");;
        $totalRows = mysql_num_rows($res);
        $row = mysql_fetch_assoc($res);
        $filas=0;
        /*if($totalRows==0){
            header("location: reactivaoc.php?msg=1");
        }    
    }
    else{
        header("location: reactivaoc.php?msg=3");
    }*/
	
    if($row!=0){
    	do{
		$fila=@$filas/2;
		if (is_int($fila)) { $estilo = 'bg1'; } else { $estilo = 'bg2'; }
		$cadena.="<tr id=".$filas." class=".$estilo.">";
		$cadena.="<td>".@$row['CORDENCOMPRA']."</td>";
		if ($row[$crelacionado]=='S'){
			$cadena.="<td>Inactiva</td>";
			$cadena.='<td><button class="btndrop" type="button" onclick="updRegistro('."'".$row['CORDENCOMPRA']."'".','.$filas.');" id="x">✓</button></td>';
			//$cadena.="<td><input type='checkbox' name='check_list[]' value=".@$row['CORDENCOMPRA']."><td> ";
		} 
		$cadena.="</tr>";
		@$filas++; 
		}while (@$row = mysql_fetch_assoc($res));
    }else{

    }
	
	
	echo $cadena;


?>