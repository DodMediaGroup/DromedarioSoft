<?php

class LugaresController extends Controller
{
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
                    'getCiudades',
                    'getLocalidades'
                ),
                'users'=>array('@'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'=>array(),
                'users'=>array('@'),
                'expression'=>'MyMethods::isAdmin()',
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

    public function actionGetCiudades(){
        if(isset($_GET['departamento'])){
            $ciudades = Lugares::model()->findAllByAttributes(array(
                'lugar'=>trim($_GET['departamento'])
            ), array(
                'order'=>'t.nombre ASC'
            ));
            $response = array();
            foreach ($ciudades as $ciudad){
                $response[] = array(
                    'id'=>$ciudad->id,
                    'nombre'=>$ciudad->nombre
                );
            }
            echo CJSON::encode($response);
        }
        else
            throw new CHttpException(404,'The requested page does not exist.');
    }

    public function actionGetLocalidades(){
        if(isset($_GET['ciudad'])){
            $localidades = Lugares::model()->findAllByAttributes(array(
                'lugar'=>trim($_GET['ciudad'])
            ), array(
                'order'=>'t.nombre ASC'
            ));
            $response = array();
            foreach ($localidades as $localidad){
                $response[] = array(
                    'id'=>$localidad->id,
                    'nombre'=>$localidad->nombre
                );
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
        if(Yii::app()->user->getState('_userRol') == 1)
            $model = Estaciones::model()->findByAttributes(array('id'=>$id));
        else
            $model = Estaciones::model()->findByAttributes(array('id'=>$id,
                'usuario'=>Yii::app()->user->getState('_userId')));

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
