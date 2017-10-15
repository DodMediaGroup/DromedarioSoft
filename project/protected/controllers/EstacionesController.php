<?php

class EstacionesController extends Controller
{
    private $nomMeses = ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'];


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
				),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array(
					'create', 'create__ajax',

                    'create_operacion_sitio', 'create_operacion_sitio__ajax',
                    'create_mantenimientos', 'create_mantenimientos__ajax',
                    'create_consumo', 'create_consumo__ajax',
                    'create_estado_inicial', 'create_estado_inicial__ajax',
                    'create_censo_carga', 'create_censo_carga__ajax',

                    'autocomplete__json',
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
        $estaciones = SitesExtend::model()->findAll();

        if(!Yii::app()->user->getState('_userRol') == 1){
            $tmpEstaciones = $estaciones;
            $estaciones = [];
            foreach ($tmpEstaciones as $key=>$estacion){
                if($estacion->cliente0->usuario == Yii::app()->user->getState('_userId'))
                    $estaciones[] = $estacion;
            }
        }

		$this->render('admin', array(
			'estaciones'=>$estaciones
		));
	}

	public function actionView($id){
        $estacion = $this->loadModel($id);

        $dispositivos = Dispositivos::model()->findAllByAttributes(
            array('site'=>$estacion->id)
        );
        $this->render('view', array(
            'estacion'=>$estacion,
            'dispositivos'=>$dispositivos
        ));
    }

	public function actionCreate(){
		$load = Yii::app()->getClientScript();
		$load->registerScriptFile(Yii::app()->request->baseUrl.'/js/modules/estaciones.js',CClientScript::POS_END);


		$model = new Sites();
		$cliente = array(
		    'id'=>'',
            'nombre'=>''
        );

		if(isset($_GET['client']) && trim($_GET['client']) != ''){
		    $client = Clientes::model()->findByAttributes(array(
		        'id'=>$_GET['client']
            ));
		    if($client != null){
                $cliente = array(
                    'id'=>$client->id,
                    'nombre'=>'['.$client->nit.'] '.$client->razon_social
                );
                $model->cliente = $client->id;
            }
        }

		$this->render('create', array(
			'model'=>$model,
            'cliente'=>$cliente
		));
	}
	public function actionCreate__ajax(){
		if(Yii::app()->getRequest()->getIsAjaxRequest() && isset($_POST['Sites'])){
            $response = array(
                'status'=>'error',
                'title'=> 'Error validación',
                'message'=>'Error en la validación de los datos!!!'
            );

			$model = new Sites();
			$model->attributes = $_POST['Sites'];

            if($model->validate(null, false)){
                if($model->save()){
                    $response['title'] = 'Hecho';
                    $response['message'] = 'Se agrego correctamente la estación.';
                    $response['status'] = 'success';
                    $response['new'] = $model->id;
                }
            }
            else{
                $response['title'] = 'Error validación';
                $response['message'] = 'Verifique los campos de "Información estación"';
            }

			echo CJSON::encode($response);
		}
		else
			throw new CHttpException(404,'The requested page does not exist.');
	}

	public function actionCreate_operacion_sitio(){
        $load = Yii::app()->getClientScript();
        $load->registerScriptFile(Yii::app()->request->baseUrl.'/js/modules/estaciones.js',CClientScript::POS_END);

        if(isset($_GET['site'])){
            $site = $this->loadModel(trim($_GET['site']));

            if($site->registroSitesOperacion())
                $this->redirect(array('create_mantenimientos','site'=>$site->id));

            $model = new SitesOperacion();
            $modelJornadasSinTurnos = new SitesJornadasLaboralesSinTurnos();
            $modelJornadasTurnos = new SitesJornadasLaboralesTurnos();

            $this->render('operacion_sitio/create', array(
                'site'=>$site,

                'model'=>$model,
                'modelJornadasSinTurnos'=>$modelJornadasSinTurnos,
                'modelJornadasTurnos'=>$modelJornadasTurnos
            ));
        }
        else
            throw new CHttpException(404,'The requested page does not exist.');
    }
    public function actionCreate_operacion_sitio__ajax(){
        if(Yii::app()->getRequest()->getIsAjaxRequest() && isset($_POST['SitesOperacion']) && isset($_POST['SitesJornadasLaboralesSinTurnos'])){
            $response = array(
                'status'=>'error',
                'title'=> 'Error validación',
                'message'=>'Error en la validación de los datos!!!'
            );

            $model = new SitesOperacion();

            $model->attributes = $_POST['SitesOperacion'];
            if($model->validate(null, false)){
                $errors = false;
                if(isset($_POST['SitesJornadasLaboralesTurnos'])){
                    $turnos = array();
                    for($i = 0; $i < count($_POST['SitesJornadasLaboralesTurnos']); $i++){
                        $modelJornadasTurnos = new SitesJornadasLaboralesTurnos();
                        $modelJornadasTurnos->attributes = $_POST['SitesJornadasLaboralesTurnos'][$i];
                        $modelJornadasTurnos->site_operacion = 0;
                        if(!$modelJornadasTurnos->validate(null, false)){
                            $errors = true;
                            $response['message'] = 'Error en la validación de los datos de jornada laboral con turnos';
                            break;
                        }
                        else
                            $turnos[] = $modelJornadasTurnos;
                    }
                }

                $modelJornadasSinTurnos = new SitesJornadasLaboralesSinTurnos();
                $modelJornadasSinTurnos->attributes = $_POST['SitesJornadasLaboralesSinTurnos'];
                $modelJornadasSinTurnos->site_operacion = 0;
                if(!$modelJornadasSinTurnos->validate(null, false)){
                    $errors = true;
                    $response['message'] = 'Error en la validación de los datos de jornada laboral sin turnos';
                }

                if(!$errors){
                    $model->save();

                    $modelJornadasSinTurnos->site_operacion = $model->id;
                    $modelJornadasSinTurnos->save();

                    foreach ($turnos as $key=>$modelTurno){
                        $modelTurno->site_operacion = $model->id;
                        $modelTurno->save();
                    }

                    $response['title'] = 'Hecho';
                    $response['message'] = 'Los datos de Organizacion de la operación se guardo con exito.';
                    $response['status'] = 'success';
                    $response['new'] = '';
                }
            }

            echo CJSON::encode($response);
        }
        else
            throw new CHttpException(404,'The requested page does not exist.');
    }

    public function actionCreate_mantenimientos(){
        $load = Yii::app()->getClientScript();
        $load->registerScriptFile(Yii::app()->request->baseUrl.'/js/modules/estaciones.js',CClientScript::POS_END);

        if(isset($_GET['site'])){
            $site = $this->loadModel(trim($_GET['site']));

            if($site->registroSitesMantenimientos())
                $this->redirect(array('create_consumo','site'=>$site->id));

            $model = new SitesMantenimientos();
            $modelRegistro = new SitesMantenimientosRegistros();
            $modelResponsable = new ClientesPersonas();

            $this->render('mantenimientos/create', array(
                'site'=>$site,

                'model'=>$model,
                'modelRegistro'=>$modelRegistro,
                'modelResponsable'=>$modelResponsable
            ));
        }
        else
            throw new CHttpException(404,'The requested page does not exist.');
    }
    public function actionCreate_mantenimientos__ajax(){
        if(Yii::app()->getRequest()->getIsAjaxRequest()){
            $response = array(
                'status'=>'error',
                'title'=> 'Error validación',
                'message'=>'Error en la validación de los datos!!!'
            );

            if(isset($_POST['SitesMantenimientos'])){
                $errors = false;

                $model = new SitesMantenimientos();
                $model->attributes = $_POST['SitesMantenimientos'];
                if(!$model->validate(null, false)){
                    $errors = true;
                }

                if(isset($_POST['SitesMantenimientosRegistros']) && isset($_POST['ClientesPersonas'])){
                    $modelRegistro = new SitesMantenimientosRegistros();
                    $modelRegistro->attributes = $_POST['SitesMantenimientosRegistros'];
                    $modelRegistro->mantenimiento = 0;
                    $modelRegistro->responsable = 0;
                    if(!$modelRegistro->validate(null, false)){
                        $response['message'] = 'Error en la validación de los datos referentes al mantenimiento';
                        $errors = true;
                    }

                    $modelResponsable = new ClientesPersonas();
                    $modelResponsable->attributes = $_POST['ClientesPersonas'];
                    if(!$modelResponsable->validate(null, false)){
                        $response['message'] = 'Error en la validación de los datos de la persona responsable';
                        $errors = true;
                    }
                }


                if(!$errors){
                    $model->save();

                    if(isset($modelResponsable) && isset($modelRegistro)){
                        $modelResponsable->save();

                        $modelRegistro->mantenimiento = $model->id;
                        $modelRegistro->responsable = $modelResponsable->id;
                        $modelRegistro->save();
                    }

                    $response['title'] = 'Hecho';
                    $response['message'] = 'Los datos se guardaron correctamente';
                    $response['status'] = 'success';
                    $response['new'] = '';
                }
            }

            echo CJSON::encode($response);
        }
        else
            throw new CHttpException(404,'The requested page does not exist.');
    }

    public function actionCreate_consumo(){
        $load = Yii::app()->getClientScript();
        $load->registerScriptFile(Yii::app()->request->baseUrl.'/js/modules/estaciones.js',CClientScript::POS_END);

        if(isset($_GET['site'])){
            $site = $this->loadModel(trim($_GET['site']));

            if($site->registroSitesConsumos())
                $this->redirect(array('create_estado_inicial','site'=>$site->id));

            $model = new SitesConsumos();

            $energeticos = Energeticos::model()->findAll();

            $this->render('consumo/create', array(
                'site'=>$site,

                'model'=>$model,

                'energeticos'=>$energeticos,
                'nomMeses'=>$this->nomMeses
            ));
        }
        else
            throw new CHttpException(404,'The requested page does not exist.');
    }
    public function actionCreate_consumo__ajax(){
        if(Yii::app()->getRequest()->getIsAjaxRequest() && isset($_POST['SitesConsumos'])){
            $response = array(
                'status'=>'error',
                'title'=> 'Error validación',
                'message'=>'Error en la validación de los datos!!!'
            );

            $model = new SitesConsumos();
            $model->attributes = $_POST['SitesConsumos'];
            $model->fecha_realizado = new CDbExpression('NOW()');

            if($model->validate(null, false)){
                $energeticos = Energeticos::model()->findAll();
                $modelsEnergeticos = array();
                $errors = false;

                foreach ($energeticos as $key=>$energetico){
                    if(isset($_POST['SitesConsumosEnergeticos']['energetico_'.$energetico->id])){
                        $modelEnergetico = new SitesConsumosEnergeticos();
                        $modelEnergetico->attributes = $_POST['SitesConsumosEnergeticos']['energetico_'.$energetico->id];
                        $modelEnergetico->energetico = $energetico->id;
                        $modelEnergetico->site_consumo = 0;
                        $modelEnergetico->consumo_meses = CJSON::encode($_POST['SitesConsumosEnergeticos']['energetico_'.$energetico->id]['meses']);

                        if($modelEnergetico->validate(null, false))
                            $modelsEnergeticos[] = $modelEnergetico;
                        else{
                            $response['message'] = 'Error en la validación de los datos de '.$energetico->nombre;
                            $errors = true;
                            break;
                        }
                    }
                }

                if(!$errors){
                    $model->save();

                    foreach ($modelsEnergeticos as $key=>$modelEnergetico){
                        $modelEnergetico->site_consumo = $model->id;
                        $modelEnergetico->save();
                    }

                    $response['title'] = 'Hecho';
                    $response['message'] = 'Los datos se guardaron correctamente';
                    $response['status'] = 'success';
                    $response['new'] = '';
                }
            }

            echo CJSON::encode($response);
        }
        else
            throw new CHttpException(404,'The requested page does not exist.');
    }

    public function actionCreate_estado_inicial(){
        $load = Yii::app()->getClientScript();
        $load->registerScriptFile(Yii::app()->request->baseUrl.'/js/modules/estaciones.js',CClientScript::POS_END);

        if(isset($_GET['site'])){
            $site = $this->loadModel(trim($_GET['site']));

            if($site->registroSitesEstadosIniciales())
                $this->redirect(array('create_censo_carga','site'=>$site->id));

            $model = new SitesEstadosIniciales();

            $items = EstadosInicialesItems::model()->findAll();

            $this->render('estado_inicial/create', array(
                'site'=>$site,

                'model'=>$model,

                'items'=>$items
            ));
        }
        else
            throw new CHttpException(404,'The requested page does not exist.');
    }
    public function actionCreate_estado_inicial__ajax(){
        if(Yii::app()->getRequest()->getIsAjaxRequest() && isset($_POST['SitesEstadosIniciales']) && isset($_POST['SitesEstadosInicialesItems'])){
            $response = array(
                'status'=>'error',
                'title'=> 'Error validación',
                'message'=>'Error en la validación de los datos!!!'
            );

            $model = new SitesEstadosIniciales();
            $model->attributes = $_POST['SitesEstadosIniciales'];

            if($model->validate(null, false)){
                $errors = false;

                $items = EstadosInicialesItems::model()->findAll();
                $modelsItem = array();
                foreach ($items as $key=>$item){
                    if(isset($_POST['SitesEstadosInicialesItems']['item_'.$item->id]['item']) && trim($_POST['SitesEstadosInicialesItems']['item_'.$item->id]['item']) != ''){
                        $modelItem = new SitesEstadosInicialesItems();
                        $modelItem->attributes = $_POST['SitesEstadosInicialesItems']['item_'.$item->id];
                        $modelItem->item = $item->id;
                        $modelItem->estado_inicial = 0;
                        if($modelItem->validate(null, false))
                            $modelsItem[] = $modelItem;
                        else{
                            $response['message'] = 'Error en la validación del item "'.$item->item.'"';
                            $errors = true;
                            break;
                        }
                    }
                }

                $modelsSistemasInfo = array();
                if(isset($_POST['SitesEstadosInicialesSistemasInf'])){
                    for($i = 0; $i < count($_POST['SitesEstadosInicialesSistemasInf']); $i++){
                        $modelSistemaInfo = new SitesEstadosInicialesSistemasInf();
                        $modelSistemaInfo->attributes = $_POST['SitesEstadosInicialesSistemasInf'][$i];
                        $modelSistemaInfo->estado_inicial = 0;
                        if($modelSistemaInfo->validate(null, false))
                            $modelsSistemasInfo[] = $modelSistemaInfo;
                        else{
                            $response['message'] = 'Error en la validación de los datos de Sistemas de Información';
                            $errors = true;
                            break;
                        }
                    }
                }

                $modelsSistemasMedicion = array();
                if(isset($_POST['SitesEstadosInicialesSistemasMedicion'])){
                    for($i = 0; $i < count($_POST['SitesEstadosInicialesSistemasMedicion']); $i++){
                        $modelSistemaMedicion = new SitesEstadosInicialesSistemasMedicion();
                        $modelSistemaMedicion->attributes = $_POST['SitesEstadosInicialesSistemasMedicion'][$i];
                        $modelSistemaMedicion->estado_inicial = 0;
                        if($modelSistemaMedicion->validate(null, false))
                            $modelsSistemasMedicion[] = $modelSistemaMedicion;
                        else{
                            $response['message'] = 'Error en la validación de los datos de Sistemas de Medicion';
                            $errors = true;
                            break;
                        }
                    }
                }

                if(!$errors){
                    $model->save();

                    foreach ($modelsItem as $key=>$modelItem){
                        $modelItem->estado_inicial = $model->id;
                        $modelItem->save();
                    }

                    foreach ($modelsSistemasInfo as $key=>$modelSistemasInfo){
                        $modelSistemasInfo->estado_inicial = $model->id;
                        $modelSistemasInfo->save();
                    }

                    foreach ($modelsSistemasMedicion as $key=>$modelSistemasMedicion){
                        $modelSistemasMedicion->estado_inicial = $model->id;
                        $modelSistemasMedicion->save();
                    }

                    $response['title'] = 'Hecho';
                    $response['message'] = 'Los datos se guardaron correctamente';
                    $response['status'] = 'success';
                    $response['new'] = '';
                }
            }

            echo CJSON::encode($response);
        }
        else
            throw new CHttpException(404,'The requested page does not exist.');
    }

    public function actionCreate_censo_carga(){
        $load = Yii::app()->getClientScript();
        $load->registerScriptFile(Yii::app()->request->baseUrl.'/js/modules/estaciones.js',CClientScript::POS_END);

        if(isset($_GET['site'])){
            $site = $this->loadModel(trim($_GET['site']));

            if($site->registroSitesCensosCarga())
                $this->redirect(array('admin'));

            $model = new SitesCensosCarga();

            $energeticos = Energeticos::model()->findAll();

            $this->render('censo/create', array(
                'site'=>$site,

                'model'=>$model,

                'energeticos'=>$energeticos
            ));
        }
        else
            throw new CHttpException(404,'The requested page does not exist.');
    }
    public function actionCreate_censo_carga__ajax(){
        if(Yii::app()->getRequest()->getIsAjaxRequest() && isset($_POST['SitesCensosCarga'])){
            $response = array(
                'status'=>'error',
                'title'=> 'Error validación',
                'message'=>'Error en la validación de los datos!!!'
            );

            $model = new SitesCensosCarga();
            $model->attributes = $_POST['SitesCensosCarga'];
            $model->fecha_realizado = new CDbExpression('NOW()');

            if($model->validate(null, false)){
                $errors = false;

                $modelsEnergeticos = array();
                if(isset($_POST['SitesCensoEnergeticos'])){
                    for($i = 0; $i < count($_POST['SitesCensoEnergeticos']); $i++){
                        $modelEnergetico = new SitesCensoEnergeticos();
                        $modelEnergetico->attributes = $_POST['SitesCensoEnergeticos'][$i];
                        $modelEnergetico->censo = 0;
                        if($modelEnergetico->validate(null, false))
                            $modelsEnergeticos[] = $modelEnergetico;
                        else{
                            $response['message'] = 'Error en la validación del item '.($i + 1);
                            $errors = true;
                            break;
                        }
                    }
                }

                if(!$errors){
                    $model->save();

                    foreach ($modelsEnergeticos as $key=>$modelEnergetico){
                        $modelEnergetico->censo = $model->id;
                        $modelEnergetico->save();
                    }

                    $response['title'] = 'Hecho';
                    $response['message'] = 'Los datos se guardaron correctamente';
                    $response['status'] = 'success';
                    $response['new'] = '';
                }
            }

            echo CJSON::encode($response);
        }
        else
            throw new CHttpException(404,'The requested page does not exist.');
    }


    public function actionAutocomplete__json(){
        if(Yii::app()->getRequest()->getIsAjaxRequest() && isset($_GET['term'])){
            $response = array();

            $clientes = Clientes::model()->findAll(array(
                'condition'=>'t.nit LIKE "%'.$_GET['term'].'%" OR t.razon_social LIKE "%'.$_GET['term'].'%"',
                'order'=>'t.razon_social ASC'
            ));

            foreach ($clientes as $key => $cliente) {
                $sites = SitesExtend::model()->findAllByAttributes(array(
                    'cliente'=>$cliente->id,
                    'completo'=>1
                ));
                foreach ($sites as $index => $site){
                    if($site->registroCompleto()){
                        $response[] = array(
                            'id'=>$site->id,
                            'label'=>'['.$cliente->nit.' - '.$cliente->razon_social.'] '.$site->nombre,
                            'value'=>'['.$cliente->razon_social.'] '.$site->nombre
                        );
                    }
                }
            }

            echo CJSON::encode($response);
        }
        else
            throw new CHttpException(404,'The requested page does not exist.');
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
        $model = SitesExtend::model()->findByAttributes(array('id'=>$id));
        if(!(Yii::app()->user->getState('_userRol') == 1) && $model != null)
            if($model->cliente0->usuario != Yii::app()->user->getState('_userId'))
                $model = null;

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
