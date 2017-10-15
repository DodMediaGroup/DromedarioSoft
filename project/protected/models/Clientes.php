<?php

/**
 * This is the model class for table "clientes".
 *
 * The followings are the available columns in table 'clientes':
 * @property integer $id
 * @property integer $usuario
 * @property string $razon_social
 * @property string $nit
 * @property string $direccion
 * @property string $telefono
 * @property integer $municipio
 * @property integer $sector
 * @property integer $codigo_actividad_economica
 * @property string $descripcion
 * @property integer $representante_legal
 * @property integer $responsable_programa_sge
 *
 * The followings are the available model relations:
 * @property ClientesPersonas $representanteLegal
 * @property ClientesPersonas $responsableProgramaSge
 * @property Lugares $municipio0
 * @property SectoresEconomicos $sector0
 * @property Usuarios $usuario0
 * @property Sites[] $sites
 */
class Clientes extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'clientes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('usuario, razon_social, nit, municipio, sector, codigo_actividad_economica, representante_legal, responsable_programa_sge', 'required'),
			array('usuario, municipio, sector, codigo_actividad_economica, representante_legal, responsable_programa_sge', 'numerical', 'integerOnly'=>true),
			array('razon_social, direccion', 'length', 'max'=>155),
			array('nit', 'length', 'max'=>20),
			array('telefono', 'length', 'max'=>15),
			array('descripcion', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, usuario, razon_social, nit, direccion, telefono, municipio, sector, codigo_actividad_economica, descripcion, representante_legal, responsable_programa_sge', 'safe', 'on'=>'search'),
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
			'representanteLegal' => array(self::BELONGS_TO, 'ClientesPersonas', 'representante_legal'),
			'responsableProgramaSge' => array(self::BELONGS_TO, 'ClientesPersonas', 'responsable_programa_sge'),
			'municipio0' => array(self::BELONGS_TO, 'Lugares', 'municipio'),
			'sector0' => array(self::BELONGS_TO, 'SectoresEconomicos', 'sector'),
			'usuario0' => array(self::BELONGS_TO, 'Usuarios', 'usuario'),
			'sites' => array(self::HAS_MANY, 'Sites', 'cliente'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'usuario' => 'Usuario',
			'razon_social' => 'Razon Social',
			'nit' => 'Nit',
			'direccion' => 'Direccion',
			'telefono' => 'Telefono',
			'municipio' => 'Municipio',
			'sector' => 'Sector',
			'codigo_actividad_economica' => 'Codigo Actividad Economica',
			'descripcion' => 'Descripcion',
			'representante_legal' => 'Representante Legal',
			'responsable_programa_sge' => 'Responsable Programa Sge',
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
		$criteria->compare('usuario',$this->usuario);
		$criteria->compare('razon_social',$this->razon_social,true);
		$criteria->compare('nit',$this->nit,true);
		$criteria->compare('direccion',$this->direccion,true);
		$criteria->compare('telefono',$this->telefono,true);
		$criteria->compare('municipio',$this->municipio);
		$criteria->compare('sector',$this->sector);
		$criteria->compare('codigo_actividad_economica',$this->codigo_actividad_economica);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('representante_legal',$this->representante_legal);
		$criteria->compare('responsable_programa_sge',$this->responsable_programa_sge);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Clientes the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
