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
 * @property string $estrellas
 * @property bool $vista
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
            [['valorador_id', 'valorado_id', 'texto', 'estrellas'], 'required'],
            [['valorador_id', 'valorado_id'], 'default', 'value' => null],
            [['valorador_id', 'valorado_id'], 'integer'],
            [['estrellas'], 'number'],
            [['vista'], 'boolean'],
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
            'texto' => 'Valoración',
            'estrellas' => 'Estrellas',
            'vista' => 'Vista',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Devuelve el número de valoraciones no vistas por el usuario conectado.
     * @return int El número de valoraciones sin ver
     */
    public static function getPendientes()
    {
        return self::find()
            ->where(['valorado_id' => Yii::$app->user->id])
            ->andWhere(['vista' => false])
            ->count();
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
