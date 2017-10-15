<?php

/**
 * This is the model class for table "sites".
 *
 * The followings are the available columns in table 'sites':
 * @property integer $id
 * @property string $nombre
 * @property integer $cliente
 * @property integer $completo
 *
 * The followings are the available model relations:
 * @property Clientes $cliente0
 * @property SitesCensosCarga[] $sitesCensosCargas
 * @property SitesConsumos[] $sitesConsumoses
 * @property SitesEstadosIniciales[] $sitesEstadosIniciales
 * @property SitesMantenimientos[] $sitesMantenimientoses
 * @property SitesOperacion[] $sitesOperacions
 */
class Sites extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sites';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, cliente', 'required'),
			array('cliente, completo', 'numerical', 'integerOnly'=>true),
			array('nombre', 'length', 'max'=>155),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nombre, cliente, completo', 'safe', 'on'=>'search'),
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
			'cliente0' => array(self::BELONGS_TO, 'Clientes', 'cliente'),
			'sitesCensosCargas' => array(self::HAS_MANY, 'SitesCensosCarga', 'site'),
			'sitesConsumoses' => array(self::HAS_MANY, 'SitesConsumos', 'site'),
			'sitesEstadosIniciales' => array(self::HAS_MANY, 'SitesEstadosIniciales', 'site'),
			'sitesMantenimientoses' => array(self::HAS_MANY, 'SitesMantenimientos', 'site'),
			'sitesOperacions' => array(self::HAS_MANY, 'SitesOperacion', 'site'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nombre' => 'Nombre',
			'cliente' => 'Cliente',
			'completo' => 'Completo',
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
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('cliente',$this->cliente);
		$criteria->compare('completo',$this->completo);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Sites the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
