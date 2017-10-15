<?php

/**
 * This is the model class for table "sites_jornadas_laborales_sin_turnos".
 *
 * The followings are the available columns in table 'sites_jornadas_laborales_sin_turnos':
 * @property integer $id
 * @property integer $site_operacion
 * @property string $maniana_de
 * @property string $maniana_a
 * @property string $descanso_de
 * @property string $descanso_a
 * @property string $tarde_de
 * @property string $tarde_a
 * @property integer $numero_trabajadores
 * @property string $observaciones
 *
 * The followings are the available model relations:
 * @property SitesOperacion $siteOperacion
 */
class SitesJornadasLaboralesSinTurnos extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sites_jornadas_laborales_sin_turnos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('site_operacion, maniana_de, maniana_a, descanso_de, descanso_a, tarde_de, tarde_a, numero_trabajadores', 'required'),
			array('site_operacion, numero_trabajadores', 'numerical', 'integerOnly'=>true),
			array('observaciones', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, site_operacion, maniana_de, maniana_a, descanso_de, descanso_a, tarde_de, tarde_a, numero_trabajadores, observaciones', 'safe', 'on'=>'search'),
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
			'siteOperacion' => array(self::BELONGS_TO, 'SitesOperacion', 'site_operacion'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'site_operacion' => 'Site Operacion',
			'maniana_de' => 'Maniana De',
			'maniana_a' => 'Maniana A',
			'descanso_de' => 'Descanso De',
			'descanso_a' => 'Descanso A',
			'tarde_de' => 'Tarde De',
			'tarde_a' => 'Tarde A',
			'numero_trabajadores' => 'Numero Trabajadores',
			'observaciones' => 'Observaciones',
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
		$criteria->compare('site_operacion',$this->site_operacion);
		$criteria->compare('maniana_de',$this->maniana_de,true);
		$criteria->compare('maniana_a',$this->maniana_a,true);
		$criteria->compare('descanso_de',$this->descanso_de,true);
		$criteria->compare('descanso_a',$this->descanso_a,true);
		$criteria->compare('tarde_de',$this->tarde_de,true);
		$criteria->compare('tarde_a',$this->tarde_a,true);
		$criteria->compare('numero_trabajadores',$this->numero_trabajadores);
		$criteria->compare('observaciones',$this->observaciones,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SitesJornadasLaboralesSinTurnos the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
