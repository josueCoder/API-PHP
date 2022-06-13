
<?php
header('Content-Type:application/json') ;             #avisar que le enviamos JSON  


// #validar si el cliente recibio un token
// if ( !array_key_exists( 'HTTP_X_TOKEN', $_SERVER ) ) {

// 	die;
// }

// #validar en el servidor de autenticacion
// $url='http://localhost:8001';
// // $url = 'https://'.$_SERVER['HTTP_HOST'].'/auth';

// $ch = curl_init( $url );
// curl_setopt( 
//     $ch, 

//     CURLOPT_HTTPHEADER, 
//     [
// 	"X-Token: {$_SERVER['HTTP_X_TOKEN']}"
//     ]
// );
// curl_setopt( 
//     $ch, 
//     CURLOPT_RETURNTRANSFER, 
//     true 
// );
// $ret = curl_exec( $ch );


// if ( $ret !== 'true' ) {
	

// 	die;
// }

//Definimos los recursos disponibles
$allowedResourceTypes=[
    'books',
    'authors',
    'genres',
];

//validando que el recurso este disponible
$resourceType=$_GET['resource_type'];
if(!in_array($resourceType,$allowedResourceTypes)){
    http_response_code(400);
    echo json_encode(
		[
			'error' => "$resourceType is un unkown",
		]
	);
    die;
}
//Defino los recursos
$books=[
    1=>[
        'titulo'=>'Lo que el viento se llevo',
        'id_autor'=>2,
        'id_genero'=>2,
    ],
    2=>[
        'titulo'=>'Cien años de soledad',
        'id_autor'=>1,
        'id_genero'=>1,
    ],
    3=>[
        'titulo'=>'La ciudad y los perros',
        'id_autor'=>3,
        'id_genero'=>1,
    ]
];

//levantamos el id del recurso buscado
$resourceId=array_key_exists('resource_id',$_GET)? $_GET['resource_id'] : '';


//Generamos la respuesta asumiendo que el pedido es correcto
switch(strtoupper($_SERVER['REQUEST_METHOD'])){
    case 'GET':
        if(empty($resourceId)){

            echo json_encode($books);
        }else{
            if(array_key_exists($resourceId,$books)){
                echo json_encode($books[$resourceId]);
            }else{
                http_response_code(404);
            }
        }

        break;
    case 'POST':
        $json=file_get_contents('php://input');

        //add
        $books[]=json_decode($json,true);

        // echo array_keys($books)[count($books)-1];
       
        echo json_encode($books);
        break;
    case 'PUT':
        #validar que hallamos recibo el ID del recurso
        if(!empty($resourceId) && array_key_exists($resourceId,$books)){
            $json=file_get_contents('php://input');

            #tranformamos el json a un nuevo elemento
            $books[$resourceId]=json_decode($json,true);
            #retornamos la coleccion
            echo json_encode($books);
        }
        break;
    case 'DELETE':
        
        //validamos el recurso exista
        if(!empty($resourceId)&& array_key_exists($resourceId,$books)){
            unset($books[$resourceId]);
        }

        echo json_encode($books);

        break;

}

