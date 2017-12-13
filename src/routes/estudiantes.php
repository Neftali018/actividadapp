<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

// Obtener todos los estudiantes
$app->get('/api/estudiantes', function(Request $request, Response $response){

	//echo "Estudiantes";
	$sql = "select * from estudiante";
	try{
		// Obtener el objeto DB 
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->query($sql);
        $estudiantes = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($estudiantes);

	} catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Obtener un estudiante por no de control
$app->get('/api/estudiantes/{n_control}', function(Request $request, Response $response){
    $n_control = $request->getAttribute('n_control');

    $sql = "SELECT * FROM estudiante WHERE n_control = $n_control";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $estudiante = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($estudiante);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


// Agregar un estudiante
$app->post('/api/estudiantes/add', function(Request $request, Response $response){
    $n_control = $request->getParam('n_control');
    $nombre_estudiante = $request->getParam('nombre_estudiante');
    $a_paterno = $request->getParam('a_paterno');
    $a_materno = $request->getParam('a_materno');
    $semestre = $request->getParam('semestre');
    $carrera_clave = $request->getParam('carrera_clave');

    $sql = "INSERT INTO estudiante (n_control, nombre_estudiante, a_paterno, a_materno, semestre, carrera_clave) VALUES (:n_control, :nombre_estudiante, :a_paterno, :a_materno, :semestre, :carrera_clave)";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':n_control',      $n_control);
        $stmt->bindParam(':nombre_estudiante',         $nombre_estudiante);
        $stmt->bindParam(':a_paterno',      $a_paterno);
        $stmt->bindParam(':a_materno',      $a_materno);
        $stmt->bindParam(':semestre',       $semestre);
        $stmt->bindParam(':carrera_clave',  $carrera_clave);

        $stmt->execute();

        echo '{"notice": {"text": "Estudiante agregado"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});



// Actualizar estudiante
$app->put('/api/estudiantes/update/{n_control}', function(Request $request, Response $response){
    $n_control = $request->getParam('n_control');
    $nombre_estudiante = $request->getParam('nombre_estudiante');
    $a_paterno = $request->getParam('a_paterno');
    $a_materno = $request->getParam('a_materno');
    $semestre = $request->getParam('semestre');
    $carrera_clave = $request->getParam('carrera_clave');

    $sql = "UPDATE estudiante SET
                n_control               = :n_control,
                nombre_estudiante       = :nombre_estudiante,
                svn_auth_get_parameter(key)rno   			= :a_paterno,
                a_materno 			 	= :a_materno,
                semestre                = :semestre,
                carrera_clave           = :carrera_clave
            WHERE n_control = $n_control";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':n_control',      $n_control);
        $stmt->bindParam(':nombre_estudiante',         $nombre_estudiante);
        $stmt->bindParam(':a_paterno',      $a_paterno);
        $stmt->bindParam(':a_materno',      $a_materno);
        $stmt->bindParam(':semestre',       $semestre);
        $stmt->bindParam(':carrera_clave',  $carrera_clave);

        $stmt->execute();

        echo '{"notice": {"text": "Estudiante actualizado"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


// Borrar estudiante
$app->delete('/api/estudiantes/delete/{n_control}', function(Request $request, Response $response){
    $n_control = $request->getAttribute('n_control');

    $sql = "DELETE FROM estudiante WHERE n_control = $n_control";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "Estudiante eliminado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

//CARRERA

// Obtener todas las carreras

$app->get('/api/carrera', function(Request $request, Response $response){
	//echo "materias";
	$sql = "select * from carrera";

	try{
		// Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $carrera = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
      echo json_encode($carrera);
      
	} catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Obtener carreras por clave carrera
$app->get('/api/carrera/{clave}', function(Request $request, Response $response){
    $clave = $request->getAttribute('clave');

    $sql = "SELECT * FROM carrera WHERE clave = $clave";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $carrera = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($carrera);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});




// Agregar una carrera
$app->post('/api/carrera/add', function(Request $request, Response $response){
    $clave = $request->getParam('clave');
    $nombre = $request->getParam('nombre');


    $sql = "INSERT INTO carrera (clave, nombre) VALUES (:clave, :nombre)";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':clave', $clave);
        $stmt->bindParam(':nombre',$nombre);


        $stmt->execute();

        echo '{"notice": {"text": "carrera agregada"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


// Actualizar carrera
$app->put('/api/carrera/update/{clave}', function(Request $request, Response $response){
    $clave = $request->getParam('clave');
    $nombre = $request->getParam('nombre');


    $sql = "UPDATE carrera SET
                clave        = :clave,
                nombre       = :nombre

            WHERE clave = '".$clave."'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':clave',   $clave);
        $stmt->bindParam(':nombre',  $nombre);


        $stmt->execute();

        echo '{"notice": {"text": "carrera actualizado"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


// Borrar carrera
$app->delete('/api/carrera/delete/{clave}', function(Request $request, Response $response){
    $clave = $request->getAttribute('clave');

    $sql = "DELETE FROM carrera WHERE clave = '".$clave."'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "carrera eliminada"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


//DEPARTAMENTO

// Obtener todos los departamentos

$app->get('/api/departamento', function(Request $request, Response $response){
	//echo "departamento";
	$sql = "select * from departamento";

	try{
		// Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $departamento = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
      //  echo json_encode($departamento);
      echo json_encode($departamento);
	} catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


// Obtener un departamento por clave
$app->get('/api/departamento/{clave_departamento}', function(Request $request, Response $response){
    $clave_departamento = $request->getAttribute('clave_departamento');

    $sql = "SELECT * FROM departamento WHERE clave_departamento = $clave_departamento";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $departamento = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($departamento);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


// Agregar un departamento
$app->post('/api/departamento/add', function(Request $request, Response $response){
    $clave_departamento = $request->getParam('clave_departamento');
    $nombre_departamento = $request->getParam('nombre_departamento');
		$trabajador_rfc = $request->getParam('trabajador_rfc');


    $sql = "INSERT INTO departamento (clave_departamento, nombre_departamento, trabajador_rfc) VALUES (:clave_departamento, :nombre_departamento, :trabajador_rfc)";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':clave_departamento', $clave_departamento);
        $stmt->bindParam(':nombre_departamento',$nombre_departamento);
				$stmt->bindParam(':trabajador_rfc',$trabajador_rfc);


        $stmt->execute();

        echo '{"notice": {"text": "departamento agregado"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});



// Actualizar departamento
$app->put('/api/departamento/update/{clave_departamento}', function(Request $request, Response $response){
    $clave_departamento = $request->getParam('clave_departamento');
    $nombre_departamento = $request->getParam('nombre_departamento');
		$trabajador_rfc=$request->getParam('trabajador_rfc');


    $sql = "UPDATE departamento SET
                clave_departamento      = :clave_departamento,
                nombre_departamento       = :nombre_departamento,
								trabajador_rfc = :trabajador_rfc

            WHERE clave_departamento = '".$clave_departamento."'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':clave_departamento',   $clave_departamento);
        $stmt->bindParam(':nombre_departamento',  $nombre_departamento);
				$stmt->bindParam(':trabajador_rfc',  $trabajador_rfc);


        $stmt->execute();

        echo '{"notice": {"text": "departamento actualizado"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Borrar departamento
$app->delete('/api/departamento/delete/{clave_departamento}', function(Request $request, Response $response){
    $clave_departamento = $request->getAttribute('clave_departamento');

    $sql = "DELETE FROM departamento WHERE clave_departamento = '".$clave_departamento."'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "departamento eliminado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


//instituto

$app->get('/api/instituto', function(Request $request, Response $response){
    //echo "institu";
    $sql = "select * from instituto";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $instituto = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($instituto);
        
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


// Obtener un instituto por no de clave
$app->get('/api/instituto/{clave}', function(Request $request, Response $response){
    $clave = $request->getAttribute('clave');

    $sql = "SELECT * FROM instituto WHERE clave = '".$clave."'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $instituto = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($instituto);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


// Agregar un instituto
$app->post('/api/instituto/add', function(Request $request, Response $response){
    $clave = $request->getParam('clave');
    $nombre = $request->getParam('nombre');


    $sql = 	"INSERT INTO instituto (clave, nombre) VALUES (:clave, :nombre)";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':clave',      $clave);
        $stmt->bindParam(':nombre',         $nombre);


        $stmt->execute();

        echo '{"notice": {"text": "instituto agregado"}';

    } catch(PDOException $e){

        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


// Actualizar instituto
$app->put('/api/instituto/update/{clave}', function(Request $request, Response $response){
    $clave = $request->getParam('clave');
    $nombre = $request->getParam('nombre');



    $sql = "UPDATE instituto SET
                clave       = :clave,
                nombre      = :nombre
								

            WHERE clave = '".$clave."'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':clave',   $clave);
        $stmt->bindParam(':nombre',  $nombre);



        $stmt->execute();

        echo '{"notice": {"text": "instituto actualizado"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


// Borrar instituto
$app->delete('/api/instituto/delete/{clave}', function(Request $request, Response $response){
    $clave = $request->getAttribute('clave');

    $sql = "DELETE FROM instituto WHERE clave = '".$clave."'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "instituto eliminado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});



//actividades

//todas las actividades
$app->get('/api/actividad_comp', function(Request $request, Response $response){
    //echo "trabajador";
    $sql = "select * from actividad_comp";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $actividad_comp = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($actividad_comp);
        
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Obtener una actividad por clave
$app->get('/api/actividad_comp/{clave_act}', function(Request $request, Response $response){
    $clave_act = $request->getAttribute('clave_act');

    $sql = "SELECT * FROM actividad_comp WHERE clave_act = $clave_act";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $actividad_comp = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($actividad_comp);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Agregar una actividad
$app->post('/api/actividad_comp/add', function(Request $request, Response $response){
    $clave_act = $request->getParam('clave_act');
    $nombre_act = $request->getParam('nombre_act');



    $sql = 	"INSERT INTO actividad_comp (clave_act, nombre_act) VALUES (:clave_act,:nombre_act)";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':clave_act', $clave_act);
        $stmt->bindParam(':nombre_act', $nombre_act);



        $stmt->execute();

        echo '{"notice": {"text": "actividad agregada"}';

    } catch(PDOException $e){

        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


// Actualizar actividad
$app->put('/api/actividad_comp/update/{clave_act}', function(Request $request, Response $response){
    $clave_act = $request->getParam('clave_act');
    $nombre_act = $request->getParam('nombre_act');
    



    $sql = "UPDATE actividad_comp SET
           clave_act          = :clave_act,
           nombre_act        = :nombre_act
          
								

            WHERE clave_act = $clave_act";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':clave_act',   $clave_act);
        $stmt->bindParam(':nombre_act',  $nombre_act);




        $stmt->execute();

        echo '{"notice": {"text": "actividad actualizada"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Borrar actividad
$app->delete('/api/actividad_comp/delete/{clave_act}', function(Request $request, Response $response){
    $clave_act = $request->getAttribute('clave_act');

    $sql = "DELETE FROM actividad_comp WHERE clave_act = $clave_act";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "actividad eliminada"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


//trabajador

//todos los trabajadores
$app->get('/api/trabajador', function(Request $request, Response $response){
    //echo "trabajador";
    $sql = "select * from trabajador";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $trabajador = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($trabajador);
        
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Obtener un trabajador por rfc
$app->get('/api/trabajador/{rfc}', function(Request $request, Response $response){
    $rfc = $request->getAttribute('rfc');

    $sql = "SELECT * FROM trabajador WHERE rfc = $rfc";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $trabajador = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($trabajador);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Agregar un trabajador
$app->post('/api/trabajador/add', function(Request $request, Response $response){
    $rfc = $request->getParam('rfc');
    $nombre = $request->getParam('nombre');
    $a_paterno = $request->getParam('a_paterno');
    $a_materno = $request->getParam('a_materno');
    $clase_presupuestal = $request->getParam('clase_presupuestal');


    $sql = 	"INSERT INTO trabajador (rfc,nombre,a_paterno,a_materno,clase_presupuestal) VALUES (:rfc,:nombre,:a_paterno,:a_materno,:clase_presupuestal)";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':rfc',          $rfc);
        $stmt->bindParam(':nombre',       $nombre);
        $stmt->bindParam(':a_paterno',              $a_paterno);
        $stmt->bindParam(':a_materno',              $a_materno);
        $stmt->bindParam(':clase_presupuestal',      $clase_presupuestal);


        $stmt->execute();

        echo '{"notice": {"text": "trabajador agregado"}';

    } catch(PDOException $e){

        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});




// Actualizar trabajador
$app->put('/api/trabajador/update/{rfc}', function(Request $request, Response $response){
    $rfc = $request->getParam('rfc');
    $nombre = $request->getParam('nombre');
    $a_paterno = $request->getParam('a_paterno');
    $a_materno = $request->getParam('a_materno');
    $clase_presupuestal = $request->getParam('clase_presupuestal');



    $sql = "UPDATE trabajador SET
           rfc           = :rfc,
           nombre         = :nombre,
           a_paterno                = :a_paterno,
           a_materno               = :a_materno,
           clase_presupuestal        = :clase_presupuestal
								

            WHERE rfc = $rfc";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':rfc',   $rfc);
        $stmt->bindParam(':nombre',  $nombre);
        $stmt->bindParam(':a_paterno',   $a_paterno);
        $stmt->bindParam(':a_materno',   $a_materno);
        $stmt->bindParam(':clase_presupuestal',   $clase_presupuestal);



        $stmt->execute();

        echo '{"notice": {"text": "trabajor actualizado"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Borrar trabajador
$app->delete('/api/trabajador/delete/{rfc}', function(Request $request, Response $response){
    $rfc = $request->getAttribute('rfc');

    $sql = "DELETE FROM trabajador WHERE rfc = $rfc";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "trabajador eliminado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

//INSTRUCTOR
// todos los instructores

$app->get('/api/instructor', function(Request $request, Response $response){
	//echo "Estudiantes";
	$sql = "select * from instructor";

	try{
		// Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $instructor = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
      echo json_encode($instructor);
      
	} catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


// Obtener un instructor por rfc
$app->get('/api/instructor/{rfc_inst}', function(Request $request, Response $response){
    $rfc_inst = $request->getAttribute('rfc_inst');

    $sql = "SELECT * FROM instructor WHERE rfc_inst = $rfc_inst";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $instructor = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($instructor);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


// Agregar un instructor
$app->post('/api/instructor/add', function(Request $request, Response $response){
    $rfc_inst = $request->getParam('rfc_inst');
    $nombre = $request->getParam('nombre');
    $a_paterno = $request->getParam('a_paterno');
    $a_materno = $request->getParam('a_materno');
    $actividad_comple = $request->getParam('actividad_comple');
    

    $sql =  "INSERT INTO instructor (rfc_inst, nombre, a_paterno, a_materno, actividad_comple) VALUES (:rfc_inst, :nombre, :a_paterno, :a_materno, :actividad_comple)";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':rfc_inst',      $rfc_inst);
        $stmt->bindParam(':nombre',         $nombre);
        $stmt->bindParam(':a_paterno',      $a_paterno);
        $stmt->bindParam(':a_materno',      $a_materno);
        $stmt->bindParam(':actividad_comple',       $actividad_comple);
        

        $stmt->execute();

        echo '{"notice": {"text": "Instructor agregado"}';

    } catch(PDOException $e){

        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Actualizar instructor
$app->put('/api/instructor/update/{rfc_inst}', function(Request $request, Response $response){
    $rfc_inst = $request->getParam('rfc_inst');
    $nombre = $request->getParam('nombre');
    $a_paterno = $request->getParam('a_paterno');
    $a_materno = $request->getParam('a_materno');
    $actividad_comple = $request->getParam('actividad_comple');
    

    $sql = "UPDATE instructor SET
                rfc_inst                = :rfc_inst,
                nombre                  = :nombre,
                a_paterno               = :a_paterno,
                a_materno               = :a_materno,
                actividad_comple        = :actividad_comple
                
            WHERE rfc_inst = $rfc_inst";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':rfc_inst',      $rfc_inst);
        $stmt->bindParam(':nombre',         $nombre);
        $stmt->bindParam(':a_paterno',      $a_paterno);
        $stmt->bindParam(':a_materno',      $a_materno);
        $stmt->bindParam(':actividad_comple',       $actividad_comple);
       

        $stmt->execute();

        echo '{"notice": {"text": "instructor actualizado"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


// Borrar instructor
$app->delete('/api/instructor/delete/{rfc_inst}', function(Request $request, Response $response){
    $rfc_inst = $request->getAttribute('rfc_inst');

    $sql = "DELETE FROM instructor WHERE rfc_inst = $rfc_inst";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "instructor eliminado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});












