<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mensajes".
 *
 * @property int $id
 * @property int $emisor_id
 * @property int $receptor_id
 * @property string $mensaje
 * @property string $created_at
 *
 * @property UsuariosId $emisor
 * @property UsuariosId $receptor
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
            [['emisor_id', 'receptor_id', 'mensaje'], 'required'],
            [['emisor_id', 'receptor_id'], 'default', 'value' => null],
            [['emisor_id', 'receptor_id'], 'integer'],
            [['created_at'], 'safe'],
            [['mensaje'], 'string', 'max' => 255],
            [['emisor_id'], 'exist', 'skipOnError' => true, 'targetClass' => UsuariosId::className(), 'targetAttribute' => ['emisor_id' => 'id']],
            [['receptor_id'], 'exist', 'skipOnError' => true, 'targetClass' => UsuariosId::className(), 'targetAttribute' => ['receptor_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'emisor_id' => 'Emisor ID',
            'receptor_id' => 'Receptor ID',
            'mensaje' => 'Mensaje',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmisor()
    {
        return $this->hasOne(UsuariosId::className(), ['id' => 'emisor_id'])->inverseOf('mensajes');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceptor()
    {
        return $this->hasOne(UsuariosId::className(), ['id' => 'receptor_id'])->inverseOf('mensajes0');
    }
}
