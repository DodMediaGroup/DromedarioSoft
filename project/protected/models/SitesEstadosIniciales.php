<?php

/**
 * This is the model class for table "sites_estados_iniciales".
 *
 * The followings are the available columns in table 'sites_estados_iniciales':
 * @property integer $id
 * @property integer $site
 * @property string $contratos_energeticos
 *
 * The followings are the available model relations:
 * @property Sites $site0
 * @property SitesEstadosInicialesItems[] $sitesEstadosInicialesItems
 * @property SitesEstadosInicialesSistemasInf[] $sitesEstadosInicialesSistemasInfs
 * @property SitesEstadosInicialesSistemasMedicion[] $sitesEstadosInicialesSistemasMedicions
 */
class SitesEstadosIniciales extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sites_estados_iniciales';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('site', 'required'),
			array('site', 'numerical', 'integerOnly'=>true),
			array('contratos_energeticos', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, site, contratos_energeticos', 'safe', 'on'=>'search'),
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
			'site0' => array(self::BELONGS_TO, 'Sites', 'site'),
			'sitesEstadosInicialesItems' => array(self::HAS_MANY, 'SitesEstadosInicialesItems', 'estado_inicial'),
			'sitesEstadosInicialesSistemasInfs' => array(self::HAS_MANY, 'SitesEstadosInicialesSistemasInf', 'estado_inicial'),
			'sitesEstadosInicialesSistemasMedicions' => array(self::HAS_MANY, 'SitesEstadosInicialesSistemasMedicion', 'estado_inicial'),
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
			'contratos_energeticos' => 'Contratos Energeticos',
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
		$criteria->compare('contratos_energeticos',$this->contratos_energeticos,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SitesEstadosIniciales the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
