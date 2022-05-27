<?php
// echo "<pre>";
// print_r($_POST);
// echo "</pre>";
include_once '../connect.php';
include_once '../sessioncheck.php';
$date = $_POST['data'];
$indiceTime = $_POST['indiceTime'];
$indiceData = $_POST['indiceData'];
$email = $_SESSION['email'];
$userID = $_SESSION['id'];
$registros = $_POST['registros'];
$variaveis = $_POST['variaveis'];
$formato = $_POST['formato'];
$time;

$expressaoDataBR = "/(([^0-9][1-9][^0-9])|(0[1-9])|([1-2][0-9])|(3[0-1]))[-\/](([1-9])|(1[0-2]))[-\/](([0-9]{4})|([0-9]{2}))/";
$expressaoDataUS = "/((0[1-9])|(1[0-2])|^[1-9])[-\/](([^0-9][1-9][^0-9])|(0[1-9])|([1-2][0-9])|(3[0-1]))[-\/](([0-9]{4})|([0-9]{2}))/";
$expressaoAnoantes = "/((19[7-9][0-9])|(20[0-6][0-9])[-\/](([1-9][^0-9])|(1[0-2]))[-\/](([1-9]$)|([1-2][0-9])|(3[0-1])|(0[1-9])))/";


if($indiceData == -1){//data fixa 
    //verifica se ja existe no para a data atual
    $query = "MATCH (d:Data) WHERE d.data = '$date' RETURN id(d)";
    $result = $client->run($query);
    		
    //cria no para a data caso nao exista
    if (!count($result)){
        $query="CREATE (d:Data {data: '$date'}) RETURN d";
        $result = $client->run($query);
        // echo"<p>data fixa criada</p>";
    }
    // else{
    //     echo"<p>ja existe a data</p>";
    // }
}

for ($i=1;$i<=$registros;$i++){
    $lati = $_POST['l'.$i.'lat'];
    $longi = $_POST['l'.$i.'long'];
    //verifica se existe no para a localizacao
    $query = "MATCH (l:Localizacao) WHERE l.latitude = $lati AND l.longitude = $longi RETURN l";    
    $result = $client->run($query);
    // echo"<p>verifica local</p>";
    //cria no para a localizacao caso nao exista  
    if (!count($result)){
        $query = "CREATE (l:Localizacao {latitude:$lati, longitude:$longi})"
                ." WITH l CALL spatial.addNode('layer',l) YIELD node RETURN node";
        // echo"<p>$query</p>";        
        $result = $client->run($query);
        // echo"<p>criou local</p>";
    }
    
    if($indiceData > -1){//data variavel
        // echo"<p>data variavel</p>";
        $date = $_POST['l'.$i.'var'.$indiceData];
        $date = str_replace("/","-",$date);
		$parts = explode('-', $date);
		
        if($formato == "dd-mm-yyyy"){
            if(preg_match($expressaoDataBR, $date)>0){
                if($parts[2]<100){
                    if($parts[2] > 70){
                        $parts[2] = "19$parts[2]";
                    }
                    else{
                        $parts[2] = "20$parts[2]";
                    }
                }
                $date ="$parts[2]-$parts[1]-$parts[0]";
            }
            else{//nao esta no formato indicado
                // echo"<p>formato diferente</p>";
                header("location:armazenardados.php?formatoErro");
            }
            
        }
        else if($formato == "mm-dd-yyyy"){
            if(preg_match($expressaoDataUS, $date)>0){
                if($parts[2]<100){
                    if($parts[2] > 70){
                        $parts[2] = "19$parts[2]";
                    }
                    else{
                        $parts[2] = "20$parts[2]";
                    }
                }
                $date = "$parts[2]-$parts[0]-$parts[1]";
            }
            else{//nao esta no formato indicado
                // echo"<p>formato diferente</p>";
                header("location:armazenardados.php?formatoErro");
            }
        }
        else if($formato == "yyyy-mm-dd"){
            if(preg_match($expressaoAnoantes, $date)>0){
                if($parts[0]<100){
                    if($parts[0] > 70){
                        $parts[0] = "19$parts[0]";
                    }
                    else{
                        $parts[0] = "20$parts[0]";
                    }
                }
                $date = "$parts[0]-$parts[1]-$parts[2]";
            }
            else{//nao esta no formato indicado
                // echo"<p>formato diferente</p>";
                header("location:armazenardados.php?formatoErro");
            }
        }	
        
        //verifica se existe a data
        $query = "MATCH (d:Data) WHERE d.data = '$date' RETURN id(d)";
        $result = $client->run($query);		
        //cria no para a data caso nao exista
        if (!count($result)){
            $query="CREATE (d:Data {data: '$date'}) RETURN d";
            $result = $client->run($query);
            // echo"<p>data variavel criada</p>";		
        }
    }

    if($indiceTime > -1){
        $time = $_POST['l'.$i.'var'.$indiceTime];
        // echo"<p>com tempo</p>";
    }

    // echo"<p>ok</p>";
    //verifica se existe hyperedge      
    $medicaoResumo =" $lati$longi$date";
    if(!empty($time)){
        $medicaoResumo.="$time";
    } 
    $medicaoResumo .= "$userID";
    $medicaoID = hash("sha256",$medicaoResumo);
    
    $query = "MATCH (m) WHERE m.resumo='$medicaoID' RETURN m ";
    // echo"<p>$query</p>";
    $result = $client->run($query);
     
    if (!empty($result)){
        //cria hyperedge
        $query =  "MATCH (l:Localizacao) WHERE l.latitude=$lati AND l.longitude =$longi"
        ." WITH l MATCH (d:Data) WHERE d.data='$date' "
        ."CREATE (l)<-[o:Onde]-(m:Medicao{resumo:'$medicaoID'})-[q:Quando";
        if(!empty($time)){
            $query .= "{horario:'$time'}";
        }
        $query .= "]->(d) WITH m MATCH (u:User) WHERE u.email='$email' CREATE (u)<-[p:Proprietario]-(m)"; 
        // echo "<p>$query</p>";
        $result = $client->run($query);
        // echo"<p>hyperedge criada</p>";		
    
    }
    // else{
    //     echo"<p>ja tem he</p>";
    // }
    
     
    for($j=1;$j<=$variaveis;$j++){
        if($j!=$indiceData && $j!=$indiceTime){
            $tipo = $_POST['var'.$j];
            $valor = $_POST['l'.$i.'var'.$j];
            $medida = $_POST['medida'.$j];
            
            //verifica se eh duplicata
            $query = "MATCH (v:Variavel) WHERE v.valor=$valor AND v.tipo='$tipo'";
            if($medida != ""){
                $query.=" AND v.unidadeMedida='$medida'";
            }
            $query.=" RETURN v";
            // echo"<p>$query</p>";
            $result= $client->run($query);
            if(!count($result)){//nao existe 
                $query ="CREATE (v:Variavel{tipo:'$tipo',valor:$valor,unidadeMedida:'$medida'})";
                // echo"<p>$query</p>";
                $result= $client->run($query);
            }
            
            //verifica se ja esta ligada a medicao
            $query = "MATCH (m:Medicao)-[oq:Oque]->(v:Variavel) WHERE m.resumo='$medicaoID'".
            " AND v.tipo='$tipo' AND v.valor=$valor";
            if($medida!=""){
                $query .= " AND v.unidadeMedida = '$medida'";
            }
            
            $query .= " RETURN m";
            // echo "<p>$query</p>";
            $result= $client->run($query);
            
            if(!count($result)){//nao esta ligada a hyperedge
                $query = "MATCH (m) WHERE m.resumo='$medicaoID'"
                ." WITH m MATCH (v:Variavel) WHERE v.tipo = '$tipo' AND v.valor = $valor";
                if($medida!=""){
                    $query.=" AND v.unidadeMedida=$medida";
                }
                $query.=" CREATE (m)-[oq:Oque]->(v)";	
                // echo"<p>adiciona variavel</p>";
                // echo "<p>$query</p>";
                $client->run($query);
            }
            
        }      
    }            
}
// echo "</pre>";
$path = "/bdap2/BDAP/armazenardados/";
header("location:".$path."armazenardados.php?insert");
?>