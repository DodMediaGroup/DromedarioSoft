<?php

/**
 * This is the model class for table "sites_mantenimientos_registros".
 *
 * The followings are the available columns in table 'sites_mantenimientos_registros':
 * @property integer $id
 * @property integer $mantenimiento
 * @property integer $tipo
 * @property string $frecuencia
 * @property string $descripcion
 * @property integer $responsable
 *
 * The followings are the available model relations:
 * @property ClientesPersonas $responsable0
 * @property MantenimientosTipos $tipo0
 * @property SitesMantenimientos $mantenimiento0
 */
class SitesMantenimientosRegistros extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sites_mantenimientos_registros';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('mantenimiento, tipo, frecuencia, responsable', 'required'),
			array('mantenimiento, tipo, responsable', 'numerical', 'integerOnly'=>true),
			array('frecuencia', 'length', 'max'=>45),
			array('descripcion', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, mantenimiento, tipo, frecuencia, descripcion, responsable', 'safe', 'on'=>'search'),
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
			'responsable0' => array(self::BELONGS_TO, 'ClientesPersonas', 'responsable'),
			'tipo0' => array(self::BELONGS_TO, 'MantenimientosTipos', 'tipo'),
			'mantenimiento0' => array(self::BELONGS_TO, 'SitesMantenimientos', 'mantenimiento'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'mantenimiento' => 'Mantenimiento',
			'tipo' => 'Tipo',
			'frecuencia' => 'Frecuencia',
			'descripcion' => 'Descripcion',
			'responsable' => 'Responsable',
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
		$criteria->compare('mantenimiento',$this->mantenimiento);
		$criteria->compare('tipo',$this->tipo);
		$criteria->compare('frecuencia',$this->frecuencia,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('responsable',$this->responsable);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SitesMantenimientosRegistros the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
