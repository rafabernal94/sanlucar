<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "valoraciones".
 *
 * @property int $id
 * @property int $valorador_id
 * @property int $valorado_id
 * @property string $texto
 * @property string $created_at
 *
 * @property UsuariosId $valorador
 * @property UsuariosId $valorado
 */
class Valoraciones extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'valoraciones';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['valorador_id', 'valorado_id', 'texto'], 'required'],
            [['valorador_id', 'valorado_id'], 'default', 'value' => null],
            [['valorador_id', 'valorado_id'], 'integer'],
            [['created_at'], 'safe'],
            [['texto'], 'string', 'max' => 255],
            [['valorador_id'], 'exist', 'skipOnError' => true, 'targetClass' => UsuariosId::className(), 'targetAttribute' => ['valorador_id' => 'id']],
            [['valorado_id'], 'exist', 'skipOnError' => true, 'targetClass' => UsuariosId::className(), 'targetAttribute' => ['valorado_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'valorador_id' => 'Valorador ID',
            'valorado_id' => 'Valorado ID',
            'texto' => 'Texto',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValorador()
    {
        return $this->hasOne(UsuariosId::className(), ['id' => 'valorador_id'])->inverseOf('valoraciones');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValorado()
    {
        return $this->hasOne(UsuariosId::className(), ['id' => 'valorado_id'])->inverseOf('valoraciones0');
    }
}
