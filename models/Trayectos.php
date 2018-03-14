<?php

namespace app\models;

/**
 * This is the model class for table "trayectos".
 *
 * @property int $id
 * @property string $origen
 * @property string $destino
 * @property int $conductor
 * @property string $fecha
 * @property string $plazas
 * @property string $created_at
 * @property string $updated_at
 *
 * @property UsuariosId $conductor0
 */
class Trayectos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'trayectos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['origen', 'destino', 'conductor', 'fecha', 'plazas'], 'required'],
            [['conductor'], 'default', 'value' => null],
            [['conductor'], 'integer'],
            [['fecha', 'created_at', 'updated_at'], 'safe'],
            [['plazas'], 'number'],
            [['origen', 'destino'], 'string', 'max' => 255],
            [['conductor'], 'exist', 'skipOnError' => true, 'targetClass' => UsuariosId::className(), 'targetAttribute' => ['conductor' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'origen' => 'Origen',
            'destino' => 'Destino',
            'conductor' => 'Conductor',
            'fecha' => 'Fecha',
            'plazas' => 'Plazas',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConductor()
    {
        return $this->hasOne(UsuariosId::className(), ['id' => 'conductor'])->inverseOf('trayectos');
    }
}
