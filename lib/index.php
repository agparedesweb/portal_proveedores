<?php
/*$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://192.168.1.22:8000/api/consultacajachica");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query(1));
$res = curl_exec($ch);
curl_close($ch);
$res = file_get_contents("http://192.168.1.22:8000/api/consultacajachica");
echo $res;*/
 //datos a enviar
            $data = array("prmTipo" => "1","prmOrden" => "17-180000010300","prmSucursal" => "001");
            $ch = curl_init("http://177.244.36.158:7373/api/actualizaocportal");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
            //curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            $response = curl_exec($ch);

            curl_setopt ($ch, CURLOPT_PROXY, "http://177.244.36.158:7373"); // su URL de proxy
            curl_setopt ($ch, CURLOPT_PROXYPORT, "80"); 
            //obtenemos la respuesta
            
            $curl_errno = curl_errno($ch);
            $curl_error = curl_error($ch);
            if ($curl_errno > 0) {
                    echo "cURL Error ($curl_errno): $curl_error\n";
            } else {
                    echo "Data received\n";
            }   
            curl_close($ch);
            if(!$response) {
                return false;
            }else{
                var_dump($response);
            }

            /*$data = array("id" => "47");
            //url contra la que atacamos
            $ch = curl_init("http://192.168.1.22:8000/api/consultacajachica");
            //a true, obtendremos una respuesta de la url, en otro caso, 
            //true si es correcto, false si no lo es
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            //establecemos el verbo http que queremos utilizar para la petición
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            //enviamos el array data
            curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
            //obtenemos la respuesta
            $response = curl_exec($ch);
            // Se cierra el recurso CURL y se liberan los recursos del sistema
            curl_close($ch);
            if(!$response) {
                return false;
            }else{
                var_dump($response);
            }*/




/*class CurlRequest
    {
        public function sendPost()
        {
            //datos a enviar
            $data = array("a" => "a");
            //url contra la que atacamos
            $ch = curl_init("http://localhost/API/post");
            //a true, obtendremos una respuesta de la url, en otro caso, 
            //true si es correcto, false si no lo es
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            //establecemos el verbo http que queremos utilizar para la petición
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            //enviamos el array data
            curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
            //obtenemos la respuesta
            $response = curl_exec($ch);
            // Se cierra el recurso CURL y se liberan los recursos del sistema
            curl_close($ch);
            if(!$response) {
                return false;
            }else{
                return $response;
            }
        }

        public function sendPut()
        {
            //datos a enviar
            $data = array("a" => "a");
            //url contra la que atacamos
            $ch = curl_init("http://localhost/WebService/API_Rest/api.php");
            //a true, obtendremos una respuesta de la url, en otro caso, 
            //true si es correcto, false si no lo es
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            //establecemos el verbo http que queremos utilizar para la petición
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            //enviamos el array data
            curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
            //obtenemos la respuesta
            $response = curl_exec($ch);
            // Se cierra el recurso CURL y se liberan los recursos del sistema
            curl_close($ch);
            if(!$response) {
                return false;
            }else{
                var_dump($response);
            }
        }

        public function sendGet()
        {
            //datos a enviar
            $data = array("a" => "a");
            //url contra la que atacamos
            $ch = curl_init("http://localhost/WebService/API_Rest/api.php");
            //a true, obtendremos una respuesta de la url, en otro caso, 
            //true si es correcto, false si no lo es
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            //establecemos el verbo http que queremos utilizar para la petición
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            //enviamos el array data
            curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
            //obtenemos la respuesta
            $response = curl_exec($ch);
            // Se cierra el recurso CURL y se liberan los recursos del sistema
            curl_close($ch);
            if(!$response) {
                return false;
            }else{
                var_dump($response);
            }
        }

        public function sendDelete()
        {
            //datos a enviar
            $data = array("a" => "a");
            //url contra la que atacamos
            $ch = curl_init("http://localhost/WebService/API_Rest/api.php");
            //a true, obtendremos una respuesta de la url, en otro caso, 
            //true si es correcto, false si no lo es
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            //establecemos el verbo http que queremos utilizar para la petición
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
            //enviamos el array data
            curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
            //obtenemos la respuesta
            $response = curl_exec($ch);
            // Se cierra el recurso CURL y se liberan los recursos del sistema
            curl_close($ch);
            if(!$response) {
                return false;
            }else{
                var_dump($response);
            }
        }
    }

    $new = new CurlRequest();

    $resultado = $new ->sendPost();
    var_dump($resultado);
*/
?>
<!DOCTYPE html>
<html>
<head>
	<title>Prueba</title>
</head>
<body>
<p>Hola mundo</p>
</body>
</html>