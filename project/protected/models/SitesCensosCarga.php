<?php

/**
 * This is the model class for table "sites_censos_carga".
 *
 * The followings are the available columns in table 'sites_censos_carga':
 * @property integer $id
 * @property integer $site
 * @property string $fecha_realizado
 *
 * The followings are the available model relations:
 * @property SitesCensoEnergeticos[] $sitesCensoEnergeticoses
 * @property Sites $site0
 */
class SitesCensosCarga extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sites_censos_carga';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('site, fecha_realizado', 'required'),
			array('site', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, site, fecha_realizado', 'safe', 'on'=>'search'),
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
			'sitesCensoEnergeticoses' => array(self::HAS_MANY, 'SitesCensoEnergeticos', 'censo'),
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
			'fecha_realizado' => 'Fecha Realizado',
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
		$criteria->compare('fecha_realizado',$this->fecha_realizado,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SitesCensosCarga the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
