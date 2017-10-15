<?php

/**
 * This is the model class for table "sites_estados_iniciales_sistemas_inf".
 *
 * The followings are the available columns in table 'sites_estados_iniciales_sistemas_inf':
 * @property integer $id
 * @property integer $estado_inicial
 * @property string $nombre
 * @property string $descripcion
 *
 * The followings are the available model relations:
 * @property SitesEstadosIniciales $estadoInicial
 */
class SitesEstadosInicialesSistemasInf extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sites_estados_iniciales_sistemas_inf';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('estado_inicial, nombre, descripcion', 'required'),
			array('estado_inicial', 'numerical', 'integerOnly'=>true),
			array('nombre', 'length', 'max'=>155),
			array('descripcion', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, estado_inicial, nombre, descripcion', 'safe', 'on'=>'search'),
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
			'estadoInicial' => array(self::BELONGS_TO, 'SitesEstadosIniciales', 'estado_inicial'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'estado_inicial' => 'Estado Inicial',
			'nombre' => 'Nombre',
			'descripcion' => 'Descripcion',
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
		$criteria->compare('estado_inicial',$this->estado_inicial);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('descripcion',$this->descripcion,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SitesEstadosInicialesSistemasInf the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
