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
					//'admin',
					'view',

					'getConsumo',

					'getConsumoLive',
                    'getConsumoLiveTotal',

                    'getConsumoTotal',

                    'getConsumoLastWeek',
                    'getConsumoLastMonth',

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
		$persona = $dispositivo->estacion0->usuario0->personases[0];

		if(isset($_GET['from']) && isset($_GET['to'])){
		    $dateFrom = null;
		    $dateTo = null;
		    if(!is_numeric($_GET['from']))
		        unset($_GET['from']);
            else
                $dateFrom = $_GET['from'];

            if(!is_numeric($_GET['to']))
                unset($_GET['to']);
            else
                $dateTo = $_GET['to'];

            if($dateFrom && $dateTo){
                if($dateFrom > $dateTo){
                    $_GET['from'] = $dateTo;
                    $_GET['to'] = $dateFrom;
                }
            }
        }


		$dateFilter = null;
		if(isset($_GET['from'])) {
            $dateFilter['from'] = $_GET['from'];
            $dateFilter['query'] = '?from='.$_GET['from'];
        }
		if(isset($_GET['to'])){
            $dateFilter['to'] = $_GET['to'];
            $dateFilter['query'] .= (!isset($dateFilter['query']))?'?':'&';
            $dateFilter['query'] .= 'to='.$_GET['to'];
        }

        if(isset($dateFilter['query'])){
            $queryDate = '';
            if(isset($_GET['from']))
                $queryDate .= ' AND UNIX_TIMESTAMP(date_format(fecha, "%Y-%m-%d")) >= '.$_GET['from'];
            if(isset($_GET['to']))
                $queryDate .= ' AND UNIX_TIMESTAMP(date_format(fecha, "%Y-%m-%d")) <= '.$_GET['to'];

            $registro = MyMethods::querySql('select
                (sum(corriente_1) + sum(corriente_2) + sum(corriente_3)) as total,
                (sum(corriente_1)) as corriente_1,
                (sum(corriente_2)) as corriente_2,
                (sum(corriente_3)) as corriente_3
                FROM registros
                WHERE
                    dispositivo = '.$dispositivo->id.
                $queryDate.';');
            $dateFilter['registro'] = $registro;
        }

		$this->render('view', array(
			'dispositivo'=>$dispositivo,
			'persona'=>$persona,

            'dateFilter'=>$dateFilter
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

	public function actionGetConsumoLiveTotal(){
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
            }

            $response = array(array(
                'name'=>'Total',
                'data'=>array()
            ));
            foreach($registros as $key=>$registro){
                $response[0]['data'][] = array(
                    'x'=>$registro['fecha']*1000,
                    'y'=>($registro['corriente_1']+$registro['corriente_2']+$registro['corriente_3'])
                );
            }

            echo CJSON::encode($response);
        }
        else
            throw new CHttpException(404,'The requested page does not exist.');
    }


	public function actionGetConsumoTotal(){
        if(isset($_GET['id'])){
            $dispositivo = $this->loadModel($_GET['id']);

            $charSerie = array();
            $acomulado = [];

            $queryDate = '';
            if(isset($_GET['from']))
                $queryDate .= ' AND UNIX_TIMESTAMP(date_format(fecha, "%Y-%m-%d")) >= '.$_GET['from'];
            if(isset($_GET['to']))
                $queryDate .= ' AND UNIX_TIMESTAMP(date_format(fecha, "%Y-%m-%d")) <= '.$_GET['to'];

            $registros = MyMethods::querySql('select 
                (sum(corriente_1) / count(*)) as corriente_1,
                (sum(corriente_2) / count(*)) as corriente_2,
                (sum(corriente_3) / count(*)) as corriente_3,
                UNIX_TIMESTAMP(date_format(fecha, "%Y-%m-%d %H")) as fecha
                FROM registros
                WHERE
                    dispositivo = '.$dispositivo->id.
                    $queryDate.'
                group by date_format(fecha, "%Y-%m-%d %H")');

            if(isset($_GET['moment']))
                $response = $this->createDataMomentResponse($dispositivo, $charSerie, $registros, $acomulado);
            else
                $response = $this->createDataResponse($charSerie, $registros);

            echo CJSON::encode($response);
        }
        else
            throw new CHttpException(404,'The requested page does not exist.');
    }

    public function actionGetConsumoLastWeek(){
        if(isset($_GET['id'])){
            $dispositivo = $this->loadModel($_GET['id']);

            $lastDayWeek = 6; // Sabado

            $dateMax = MyMethods::querySql('select date_format(fecha, "%Y-%m-%d") as fecha from registros where dispositivo = '.$dispositivo->id.' and date_format(fecha, "%w") = '.$lastDayWeek.' order by fecha desc limit 1;');
            $dateMax = $dateMax[0];

            $dateMin = MyMethods::querySql('select DATE_SUB("'.$dateMax['fecha'].'", INTERVAL 7 DAY) as fecha');
            $dateMin = $dateMin[0];

            $registros = MyMethods::querySql('select
                date_format(fecha, "%Y-%m-%d") as day,
                date_format(fecha, "%k") as hour,
                (sum(((corriente_1 + corriente_2 + corriente_3) / 3)) / count(*)) as promedio
                from registros
                where dispositivo = '.$dispositivo->id.' and date_format(fecha, "%Y-%m-%d") > "'.$dateMin['fecha'].'" and date_format(fecha, "%Y-%m-%d") <= "'.$dateMax['fecha'].'"
                group by day, hour 
                order by fecha ASC;');


            $response = array('Date, Time, Temperature');
            $responseAux = array();

            $fechaAxi = $dateMin['fecha'];

            for($i = 0; $i < 7; $i++){
                $fechaAxi = strtotime ( '+1 day' , strtotime ( $fechaAxi ) ) ;
                $fechaAxi = date ( 'Y-m-j' , $fechaAxi );

                $responseAux[$fechaAxi] = array();
                for($j = 0; $j < 24; $j++){
                    $responseAux[$fechaAxi][] = array($fechaAxi, $j, 0);
                }
            }

            foreach ($registros as $key=>$registro){
                $responseAux[$registro['day']][$registro['hour']][2] = $registro['promedio'];
            }

            foreach($responseAux as $key=>$value){
                foreach ($value as $index=>$data){
                    $response[0] = $response[0].';'.$data[0].','.$data[1].','.$data[2];
                }
            }

            echo CJSON::encode(array('csv'=>$response[0]));
        }
        else
            throw new CHttpException(404,'The requested page does not exist.');
    }

    public function actionGetConsumoLastMonth(){
        if(isset($_GET['id'])){
            $dispositivo = $this->loadModel($_GET['id']);

            $registros = MyMethods::querySql('select
                (sum(((corriente_1 + corriente_2 + corriente_3) / 3)) / count(*)) as promedio,
                date_format(fecha, "%Y-%m-%d") as day,
                date_format(fecha, "%k") as hour
                from registros
                where dispositivo = '.$dispositivo->id.' and 
                date_format(fecha, "%Y-%m") < date_format(now(), "%Y-%m") and
                date_format(fecha, "%Y-%m") > date_format(date_sub(now(), interval 2 MONTH), "%Y-%m")
                group by day, hour 
                order by fecha asc;');

            $monthMySql = MyMethods::querySql('select date_format(date_sub(now(), interval 1 MONTH), "%Y-%m") as date;');
            $monthMySql = explode('-', $monthMySql[0]['date']);

            $days = cal_days_in_month(CAL_GREGORIAN, $monthMySql[1], $monthMySql[0]);

            $response = array('Date, Time, Temperature');
            $responseAux = array();

            for($i = 1; $i <= $days; $i++){
                $fechaAxi = $monthMySql[0].'-'.$monthMySql[1].'-'.str_pad($i,2,'0',STR_PAD_LEFT);
                $responseAux[$fechaAxi] = array();
                for($j = 0; $j < 24; $j++){
                    $responseAux[$fechaAxi][] = array($fechaAxi, $j, 0);
                }
            }

            foreach ($registros as $key=>$registro){
                $responseAux[$registro['day']][$registro['hour']][2] = $registro['promedio'];
            }

            foreach($responseAux as $key=>$value){
                foreach ($value as $index=>$data){
                    $response[0] = $response[0].';'.$data[0].','.$data[1].','.$data[2];
                }
            }

            echo CJSON::encode(array('csv'=>$response[0]));
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
				)
			);
			for($i = 0; $i < count($charSerie['series']); $i++) {
				for($j = 0; $j < count($days); $j++) {
					$charSerie['series'][$i]['data'][] = 0.0;
				}
			}

            $queryDate = '';
            if(isset($_GET['from']))
                $queryDate .= ' AND UNIX_TIMESTAMP(date_format(fecha, "%Y-%m-%d")) >= '.$_GET['from'];
            if(isset($_GET['to']))
                $queryDate .= ' AND UNIX_TIMESTAMP(date_format(fecha, "%Y-%m-%d")) <= '.$_GET['to'];

			$registros = MyMethods::querySql('SELECT
                sum(corriente_1) as corriente_1,
                sum(corriente_2) as corriente_2,
                sum(corriente_3) as corriente_3,
                DATE_FORMAT(fecha, "%w") as day
                FROM registros
                WHERE
                    dispositivo = '.$dispositivo->id.
                    $queryDate.'
                group by DATE_FORMAT(fecha, "%w")
                ORDER BY day ASC');

			foreach ($registros as $key => $registro) {
				$charSerie['series'][0]['data'][$registro['day']] = floatval($registro['corriente_1']);
				$charSerie['series'][1]['data'][$registro['day']] = floatval($registro['corriente_2']);
				$charSerie['series'][2]['data'][$registro['day']] = floatval($registro['corriente_3']);
			}

			echo CJSON::encode(array('options'=>$charSerie));
		}
		else
			throw new CHttpException(404,'The requested page does not exist.');
	}

	public function actionGetConsumoHours(){
		if(isset($_GET['id'])){
			$dispositivo = $this->loadModel($_GET['id']);

			$hours = array('12:00 AM','01:00 AM','02:00 AM','03:00 AM','04:00 AM','05:00 AM','06:00 AM','07:00 AM','08:00 AM','09:00 AM','10:00 AM','11:00 AM','12:00 PM','01:00 PM','02:00 PM','03:00 PM','04:00 PM','05:00 PM','06:00 PM','07:00 PM','08:00 PM','09:00 PM','10:00 PM','11:00 PM');
			$charSerie = array(
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
			);
			for($i = 0; $i < count($charSerie['series']); $i++) {
				for($j = 0; $j < count($hours); $j++) {
					$charSerie['series'][$i]['data'][] = 0.0;
				}
			}

            $queryDate = '';
            if(isset($_GET['from']))
                $queryDate .= ' AND UNIX_TIMESTAMP(date_format(fecha, "%Y-%m-%d")) >= '.$_GET['from'];
            if(isset($_GET['to']))
                $queryDate .= ' AND UNIX_TIMESTAMP(date_format(fecha, "%Y-%m-%d")) <= '.$_GET['to'];

			$registros = MyMethods::querySql('SELECT
                sum(corriente_1) as corriente_1,
                sum(corriente_2) as corriente_2,
                sum(corriente_3) as corriente_3,
                DATE_FORMAT(fecha, "%k") as hour
                FROM registros
                WHERE
                    dispositivo = '.$dispositivo->id.
                    $queryDate.'
                group by DATE_FORMAT(fecha, "%k")
                ORDER BY hour ASC');

			foreach ($registros as $key => $registro) {
				$charSerie['series'][0]['data'][$registro['hour']] = floatval($registro['corriente_1']);
				$charSerie['series'][1]['data'][$registro['hour']] = floatval($registro['corriente_2']);
				$charSerie['series'][2]['data'][$registro['hour']] = floatval($registro['corriente_3']);
			}

			echo CJSON::encode(array('options'=>$charSerie));
		}
		else
			throw new CHttpException(404,'The requested page does not exist.');
	}


	private function createDataResponse($base, $registros){
		$response = array();

        if(isset($_GET['filter'])){
            $filters = explode(',', $_GET['filter']);

            for($i = 0; $i < count($filters); $i++) {
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
		else {
            $model = Dispositivos::model()->findByAttributes(array('id' => $id));
            if($model->estacion0->usuario != Yii::app()->user->getState('_userId'))
                $model = null;
        }
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
