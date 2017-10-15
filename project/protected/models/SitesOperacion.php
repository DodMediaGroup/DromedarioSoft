<?php

/**
 * This is the model class for table "sites_operacion".
 *
 * The followings are the available columns in table 'sites_operacion':
 * @property integer $id
 * @property integer $site
 * @property integer $produccion_ultimo_anio
 * @property integer $dias_trabajados_anio
 * @property integer $paradas_vacaciones
 * @property string $paradas_vacaciones_descripcion
 * @property integer $paradas_otras
 * @property string $paradas_otras_descripcion
 *
 * The followings are the available model relations:
 * @property SitesJornadasLaboralesSinTurnos[] $sitesJornadasLaboralesSinTurnoses
 * @property SitesJornadasLaboralesTurnos[] $sitesJornadasLaboralesTurnoses
 * @property Sites $site0
 */
class SitesOperacion extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sites_operacion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('site, produccion_ultimo_anio, dias_trabajados_anio', 'required'),
			array('site, produccion_ultimo_anio, dias_trabajados_anio, paradas_vacaciones, paradas_otras', 'numerical', 'integerOnly'=>true),
			array('paradas_vacaciones_descripcion, paradas_otras_descripcion', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, site, produccion_ultimo_anio, dias_trabajados_anio, paradas_vacaciones, paradas_vacaciones_descripcion, paradas_otras, paradas_otras_descripcion', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'sitesJornadasLaboralesSinTurnoses' => array(self::HAS_MANY, 'SitesJornadasLaboralesSinTurnos', 'site_operacion'),
			'sitesJornadasLaboralesTurnoses' => array(self::HAS_MANY, 'SitesJornadasLaboralesTurnos', 'site_operacion'),
			'site0' => array(self::BELONGS_TO, 'Sites', 'site'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'site' => 'Site',
			'produccion_ultimo_anio' => 'Produccion Ultimo Anio',
			'dias_trabajados_anio' => 'Dias Trabajados Anio',
			'paradas_vacaciones' => 'Paradas Vacaciones',
			'paradas_vacaciones_descripcion' => 'Paradas Vacaciones Descripcion',
			'paradas_otras' => 'Paradas Otras',
			'paradas_otras_descripcion' => 'Paradas Otras Descripcion',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('site',$this->site);
		$criteria->compare('produccion_ultimo_anio',$this->produccion_ultimo_anio);
		$criteria->compare('dias_trabajados_anio',$this->dias_trabajados_anio);
		$criteria->compare('paradas_vacaciones',$this->paradas_vacaciones);
		$criteria->compare('paradas_vacaciones_descripcion',$this->paradas_vacaciones_descripcion,true);
		$criteria->compare('paradas_otras',$this->paradas_otras);
		$criteria->compare('paradas_otras_descripcion',$this->paradas_otras_descripcion,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SitesOperacion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
