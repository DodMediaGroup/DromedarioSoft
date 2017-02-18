<?php

class DispositivosController extends Controller
{
	private $corrientesDevice = 3; //Numero corrientes en la base de datos

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array(
					'admin',
					'view',

					'getConsumo',
					'getConsumoLive',

					'getConsumoDays',
					'getConsumoHours'
				),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array(
					'create', 'create__ajax'
				),
				'users'=>array('@'),
				'expression'=>'MyMethods::isAdmin()',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionAdmin(){
		if(Yii::app()->user->getState('_userRol') == 1)
			$dispositivos = Dispositivos::model()->findAll();
		else
			$dispositivos = Dispositivos::model()->findAllByAttributes(array('usuario'=>Yii::app()->user->getState('_userId')));

		$this->render('admin', array(
			'dispositivos'=>$dispositivos
		));
	}

	public function actionCreate(){
		$load = Yii::app()->getClientScript();
		$load->registerScriptFile(Yii::app()->request->baseUrl.'/js/modules/dispositivos.js',CClientScript::POS_END);


		$model = new Dispositivos;

		$this->render('create', array(
			'model'=>$model,
		));
	}
	public function actionCreate__ajax(){
		if(Yii::app()->getRequest()->getIsAjaxRequest() && isset($_POST['Dispositivos'])){
			$response = array('status'=>'error');
			$error = false;

			$model = new Dispositivos;
			$model->attributes = $_POST['Dispositivos'];

			$generarLlave = true;
			while ($generarLlave) {
				$model->llave = MyMethods::generarCadenaSeguridad(15);
				$dispositivo = Dispositivos::model()->findByAttributes(array('llave'=>$model->llave));
				if($dispositivo == null)
					$generarLlave = false;
			}

			if($model->validate(null, false)){
				if($model->save()){
					$response['title'] = 'Echo';
	            	$response['message'] = 'Se agrego correctamente el dispositivo.';
	            	$response['status'] = 'success';
				}
			}
			else{
            	$response['title'] = 'Error validación';
            	$response['message'] = 'Verifique los campos de "Información dispositivo"';
            }

			echo CJSON::encode($response);
		}
		else
			throw new CHttpException(404,'The requested page does not exist.');
	}



	public function actionView($id){
        $load = Yii::app()->getClientScript();
        $load->registerScriptFile(Yii::app()->request->baseUrl.'/js/modules/dispositivos.js',CClientScript::POS_END);

		$dispositivo = $this->loadModel($id);
		$persona = $dispositivo->usuario0->personases[0];

		$this->render('view', array(
			'dispositivo'=>$dispositivo,
			'persona'=>$persona
		));
	}



	public function actionGetConsumo(){
		if(isset($_GET['id'])){
			$id = $_GET['id'];
			$dispositivo = $this->loadModel($_GET['id']);

			$charSerie = array(
				'name'=>$dispositivo->nombre,
				'type'=>'spline',
				'data'=>array()
			);

			if(isset($_GET['start'])){
				$start = $_GET['start'];
				$start = $start / 1000;
			}
			else{
				$firstRegistro = MyMethods::querySql('SELECT UNIX_TIMESTAMP(fecha) AS fecha FROM registros WHERE dispositivo = '.$dispositivo->id.' ORDER BY fecha ASC LIMIT 1');
				foreach ($firstRegistro as $key => $registro) {
					$start = $registro['fecha'];
				}
			}
			if(isset($_GET['end'])){
				$end = $_GET['end'];
				$end = $end / 1000;
			}
			else{
				$lastRegistro = MyMethods::querySql('SELECT UNIX_TIMESTAMP(fecha) AS fecha FROM registros WHERE dispositivo = '.$dispositivo->id.' ORDER BY fecha DESC LIMIT 1');
				foreach ($lastRegistro as $key => $registro) {
					$end = $registro['fecha'];
				}
			}

			$range = $end - $start;

			// 1 Hora Carga consumo todos los registros
			if($range < (1 * 3600)){
				$registros = MyMethods::querySql('SELECT corriente_1, corriente_2, corriente_3, UNIX_TIMESTAMP(fecha) AS fecha FROM registros WHERE dispositivo = '.$dispositivo->id.' AND fecha BETWEEN FROM_UNIXTIME('.$start.') AND FROM_UNIXTIME('.$end.') ORDER BY fecha ASC');
			}
			// 1 Dia Carga consumo cada minuto
			else if($range < (1 * 24 * 3600)){
				$registros = MyMethods::querySql('SELECT sum(corriente_1) as corriente_1, sum(corriente_2) as corriente_2, sum(corriente_3) as corriente_3, UNIX_TIMESTAMP(DATE_FORMAT(fecha, "%Y-%m-%d %H:%i")) as fecha FROM registros WHERE dispositivo = '.$dispositivo->id.' AND fecha BETWEEN FROM_UNIXTIME('.$start.') AND FROM_UNIXTIME('.$end.') group by UNIX_TIMESTAMP(DATE_FORMAT(fecha, "%Y-%m-%d %H:%i")) ORDER BY fecha ASC');
			}
			// 30 Dias Carga consumo cada hora
			else if($range < (30 * 24 * 3600)){
				$registros = MyMethods::querySql('SELECT sum(corriente_1) as corriente_1, sum(corriente_2) as corriente_2, sum(corriente_3) as corriente_3, UNIX_TIMESTAMP(DATE_FORMAT(fecha, "%Y-%m-%d %H")) as fecha FROM registros WHERE dispositivo = '.$dispositivo->id.' AND fecha BETWEEN FROM_UNIXTIME('.$start.') AND FROM_UNIXTIME('.$end.') group by UNIX_TIMESTAMP(DATE_FORMAT(fecha, "%Y-%m-%d %H")) ORDER BY fecha ASC');
			}
			// 1 año Carga consumo cada dia
			else if($range < (12 * 31 * 24 * 3600)){
				$registros = MyMethods::querySql('SELECT sum(corriente_1) as corriente_1, sum(corriente_2) as corriente_2, sum(corriente_3) as corriente_3, UNIX_TIMESTAMP(DATE_FORMAT(fecha, "%Y-%m-%d")) as fecha FROM registros WHERE dispositivo = '.$dispositivo->id.' AND fecha BETWEEN FROM_UNIXTIME('.$start.') AND FROM_UNIXTIME('.$end.') group by UNIX_TIMESTAMP(DATE_FORMAT(fecha, "%Y-%m-%d")) ORDER BY fecha ASC');
			}
			// Carga consumo mensual
			else{
				//SELECT sum(consumo) as consumo, UNIX_TIMESTAMP(DATE_FORMAT(fecha, "%Y-%m-%d")) as fecha FROM `registros` WHERE 1 group by UNIX_TIMESTAMP(DATE_FORMAT(fecha, "%Y-%m-%d"))
				$registros = MyMethods::querySql('SELECT sum(corriente_1) as corriente_1, sum(corriente_2) as corriente_2, sum(corriente_3) as corriente_3, UNIX_TIMESTAMP(DATE_FORMAT(fecha, "%Y-%m")) as fecha FROM registros WHERE dispositivo = '.$dispositivo->id.' group by UNIX_TIMESTAMP(DATE_FORMAT(fecha, "%Y-%m")) ORDER BY fecha ASC');
			}

			$response = $this->createDataResponse($charSerie, $registros);

			echo CJSON::encode($response);
		}
		else
			throw new CHttpException(404,'The requested page does not exist.');
	}

	public function actionGetConsumoLive(){
		if(isset($_GET['id'])){
			$dispositivo = $this->loadModel($_GET['id']);

			$charSerie = array();
			$acomulado = [];

			if(!isset($_GET['last'])){
				$registros = MyMethods::querySql('SELECT id, corriente_1, corriente_2, corriente_3, UNIX_TIMESTAMP(fecha) AS fecha FROM registros WHERE dispositivo = '.$dispositivo->id.' AND fecha > DATE_SUB(CURRENT_TIMESTAMP(), INTERVAL 10 MINUTE) ORDER BY fecha ASC');

				if(count($registros) == 0){
					$lastRegistro = Registros::model()->findByAttributes(array('dispositivo'=>$dispositivo->id), array('order'=>'t.fecha DESC', 'limit'=>1));
					if($lastRegistro != null){
						$registros = MyMethods::querySql('SELECT id, corriente_1, corriente_2, corriente_3, UNIX_TIMESTAMP(fecha) AS fecha FROM registros WHERE dispositivo = '.$dispositivo->id.' AND fecha > DATE_SUB("'.$lastRegistro->fecha.'", INTERVAL 10 MINUTE) ORDER BY fecha ASC');
					}
				}
			}
			else{
				$registros = MyMethods::querySql('SELECT id, corriente_1, corriente_2, corriente_3, UNIX_TIMESTAMP(fecha) AS fecha FROM registros WHERE dispositivo = '.$dispositivo->id.' AND UNIX_TIMESTAMP(fecha) > "'.($_GET['last'] / 1000).'"');

				if(isset($_GET['moment'])){
                    $acomulado = MyMethods::querySql('select count(*) as count, sum(corriente_1) as corriente_1, sum(corriente_2) as corriente_2, sum(corriente_3) as corriente_3 from ( SELECT corriente_1, corriente_2, corriente_3 FROM registros WHERE dispositivo = '.$dispositivo->id.' AND UNIX_TIMESTAMP(fecha) < '.($_GET['last'] / 1000).' ORDER BY fecha DESC LIMIT '.$_GET['moment'].') t;');
                    $acomulado = $acomulado[0];
                }
			}

			if(isset($_GET['moment']))
			    $response = $this->createDataMomentResponse($dispositivo, $charSerie, $registros, $acomulado);
			else
                $response = $this->createDataResponse($charSerie, $registros);

			echo CJSON::encode($response);
		}
		else
			throw new CHttpException(404,'The requested page does not exist.');
	}

	public function actionGetConsumoDays(){
		if(isset($_GET['id'])){
			$id = $_GET['id'];
			$dispositivo = $this->loadModel($_GET['id']);

			$days = array('Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado');
			$charSerie = array(
				'name'=>$dispositivo->nombre,
				'title'=>array(
					'text'=>null
				),
				'series'=>array(
					array(
						'name'=>'Corriente_1',
						'data'=>[]
					),
					array(
						'name'=>'Corriente_2',
						'data'=>[]
					),
					array(
						'name'=>'Corriente_3',
						'data'=>[]
					)
				),
				'xAxis'=> array(
					'categories'=>$days,
				),
				'yAxis'=> array(
					'title'=> array(
						'text'=> 'Consumo'
					)
				),
			);
			for($i = 0; $i < count($charSerie['series']); $i++) {
				for($j = 0; $j < count($days); $j++) {
					$charSerie['series'][$i]['data'][] = 0.0;
				}
			}

			$registros = MyMethods::querySql('SELECT sum(corriente_1) as corriente_1, sum(corriente_2) as corriente_2, sum(corriente_3) as corriente_3, DATE_FORMAT(fecha, "%w") as day FROM registros WHERE dispositivo = '.$dispositivo->id.' group by DATE_FORMAT(fecha, "%w") ORDER BY day ASC');

			foreach ($registros as $key => $registro) {
				$charSerie['series'][0]['data'][$registro['day']] = floatval($registro['corriente_1']);
				$charSerie['series'][1]['data'][$registro['day']] = floatval($registro['corriente_2']);
				$charSerie['series'][2]['data'][$registro['day']] = floatval($registro['corriente_3']);
			}

			echo CJSON::encode($charSerie);
		}
		else
			throw new CHttpException(404,'The requested page does not exist.');
	}

	public function actionGetConsumoHours(){
		if(isset($_GET['id'])){
			$id = $_GET['id'];
			$dispositivo = $this->loadModel($_GET['id']);

			$hours = array('12:00 AM','01:00 AM','02:00 AM','03:00 AM','04:00 AM','05:00 AM','06:00 AM','07:00 AM','08:00 AM','09:00 AM','10:00 AM','11:00 AM','12:00 PM','01:00 PM','02:00 PM','03:00 PM','04:00 PM','05:00 PM','06:00 PM','07:00 PM','08:00 PM','09:00 PM','10:00 PM','11:00 PM');
			$charSerie = array(
				'name'=>$dispositivo->nombre,
				'title'=>array(
					'text'=>null
				),
				'series'=>array(
					array(
						'name'=>'Corriente_1',
						'data'=>[]
					),
					array(
						'name'=>'Corriente_2',
						'data'=>[]
					),
					array(
						'name'=>'Corriente_3',
						'data'=>[]
					)
				),
				'xAxis'=> array(
					'categories'=>$hours,
				),
				'yAxis'=> array(
					'title'=> array(
						'text'=> 'Consumo'
					)
				),
			);
			for($i = 0; $i < count($charSerie['series']); $i++) {
				for($j = 0; $j < count($hours); $j++) {
					$charSerie['series'][$i]['data'][] = 0.0;
				}
			}

			$registros = MyMethods::querySql('SELECT sum(corriente_1) as corriente_1, sum(corriente_2) as corriente_2, sum(corriente_3) as corriente_3, DATE_FORMAT(fecha, "%k") as hour FROM registros WHERE dispositivo = '.$dispositivo->id.' group by DATE_FORMAT(fecha, "%k") ORDER BY hour ASC');

			foreach ($registros as $key => $registro) {
				$charSerie['series'][0]['data'][$registro['hour']] = floatval($registro['corriente_1']);
				$charSerie['series'][1]['data'][$registro['hour']] = floatval($registro['corriente_2']);
				$charSerie['series'][2]['data'][$registro['hour']] = floatval($registro['corriente_3']);
			}

			echo CJSON::encode($charSerie);
		}
		else
			throw new CHttpException(404,'The requested page does not exist.');
	}


	private function createDataResponse($base, $registros){
		$response = array();

        if(isset($_GET['filter'])){
            $filters = explode(',', $_GET['filter']);

            for($i = 0; $i < count($filters); $i++){
                $response[] = new ArrayObject($base);
            }

            foreach ($registros as $key => $registro) {
                foreach ($filters as $key => $filter) {
                    $filter = trim($filter);
                    $response[$key]['name'] = ucwords($filter);

                    $point = array('x'=>($registro['fecha']*1000), 'y'=>floatval($registro[$filter]));
                    $response[$key]['data'][] = $point;
                }
            }
		}

		return $response;
	}
	private function createDataMomentResponse($dispositivo, $base, $registros, $acomulado){
        $response = array();

        if(isset($_GET['filter'])){
            $filters = explode(',', $_GET['filter']);

            for($i = 0; $i < count($filters); $i++){
                $response[] = new ArrayObject($base);
            }

            foreach ($registros as $key => $registro) {
                $acomulado['count'] = (isset($acomulado['count']))?(intval($acomulado['count']) + 1):1;
                foreach ($filters as $key => $filter) {
                    $filter = trim($filter);
                    $response[$key]['name'] = ucwords($filter);

                    $acomulado[$filter] = (isset($acomulado[$filter]))?floatval($acomulado[$filter]) + floatval($registro[$filter]):floatval($registro[$filter]);
                    $value = $acomulado[$filter] / $acomulado['count'];

                    $point = array('x'=>($registro['fecha']*1000), 'y'=>$value);
                    $response[$key]['data'][] = $point;
                }
            }
        }

        return $response;
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Almacenes the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		if(Yii::app()->user->getState('_userRol') == 1)
			$model = Dispositivos::model()->findByAttributes(array('id'=>$id));
		else
			$model = Dispositivos::model()->findByAttributes(array('id'=>$id, 'usuario'=>Yii::app()->user->getState('_userId')));

		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Almacenes $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='almacenes-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
