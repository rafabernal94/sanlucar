<?php

namespace app\models;

/**
 * This is the model class for table "preferencias".
 *
 * @property int $id
 * @property bool $musica
 * @property bool $mascotas
 * @property bool $ninos
 * @property bool $fumar
 * @property int $trayecto_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Trayectos $trayecto
 */
class Preferencias extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'preferencias';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['musica', 'mascotas', 'ninos', 'fumar', 'trayecto_id'], 'required'],
            [['musica', 'mascotas', 'ninos', 'fumar'], 'boolean'],
            [['trayecto_id'], 'default', 'value' => null],
            [['trayecto_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['trayecto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Trayectos::className(), 'targetAttribute' => ['trayecto_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'musica' => 'Música',
            'mascotas' => 'Mascotas',
            'ninos' => 'Niños',
            'fumar' => 'Fumar',
            'trayecto_id' => 'Trayecto Id',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrayecto()
    {
        return $this->hasOne(Trayectos::className(), ['id' => 'trayecto_id'])->inverseOf('preferencias');
    }
}
