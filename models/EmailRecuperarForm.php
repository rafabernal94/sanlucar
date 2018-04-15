<?php

namespace app\models;

use yii\base\Model;

class EmailRecuperarForm extends Model
{
    /**
     * Email del usuario a restaurar su contraseña.
     * @var string
     */
    public $email;

    public function formName()
    {
        return '';
    }

    public function rules()
    {
        return [
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => Usuarios::className(),
                'message' => 'No existe ningún usuario registrado con este email.',
            ],
        ];
    }
}
