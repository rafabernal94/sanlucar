<?php

namespace app\models;

/**
 * This is the model class for table "mensajes".
 *
 * @property int $id
 * @property int $usuario_id
 * @property int $conversacion_id
 * @property string $mensaje
 * @property string $created_at
 *
 * @property UsuariosId $usuario
 */
class Mensajes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mensajes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuario_id', 'conversacion_id', 'mensaje'], 'required'],
            [['usuario_id', 'conversacion_id'], 'default', 'value' => null],
            [['usuario_id', 'conversacion_id'], 'integer'],
            [['created_at'], 'safe'],
            [['mensaje'], 'string', 'max' => 255],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => UsuariosId::className(), 'targetAttribute' => ['usuario_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'usuario_id' => 'Usuario ID',
            'conversacion_id' => 'Conversacion ID',
            'mensaje' => 'Mensaje',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarioId()
    {
        return $this->hasOne(UsuariosId::className(), ['id' => 'usuario_id'])->inverseOf('mensajes');
    }
}
