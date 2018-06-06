<?php

namespace app\controllers;

use app\models\Conversaciones;
use app\models\Mensajes;
use app\models\Usuarios;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ConversacionesController implements the CRUD actions for Conversaciones model.
 */
class ConversacionesController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => [
                    'conversacion',
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['conversacion'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Listado con las conversaciones activas con otros usuarios.
     * @return mixed
     */
    public function actionBuzon()
    {
        $id = Yii::$app->user->id;
        $conversaciones = Conversaciones::find()
            ->where(['usuario1_id' => $id])
            ->orWhere(['usuario2_id' => $id])->all();

        return $this->render('buzon', [
            'conversaciones' => $conversaciones,
        ]);
    }

    /**
     * Listado con los mensajes de una conversación.
     * @param  int $id ID de la conversación
     * @return mixed
     */
    public function actionConversacion($id)
    {
        $idAct = Yii::$app->user->id;
        if (($conversacion = $this->findModel($id)) === null) {
            throw new NotFoundHttpException('La conversación no existe.');
        }

        if ($conversacion->usuario1_id !== $idAct && $conversacion->usuario2_id !== $idAct) {
            throw new NotFoundHttpException('No tienes permisos para acceder a esta conversación.');
        }

        if ($conversacion->usuario1_id !== $idAct) {
            $user = Usuarios::findOne($conversacion->usuario1_id);
        } else {
            $user = Usuarios::findOne($conversacion->usuario2_id);
        }

        $mensajes = Mensajes::find()
            ->where(['conversacion_id' => $id])
            ->orderBy(['created_at' => SORT_DESC])->all();

        return $this->render('conversacion', [
            'mensajes' => $mensajes,
            'conversacion' => $conversacion,
            'user' => $user,
        ]);
    }

    /**
     * Finds the Conversaciones model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return Conversaciones the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Conversaciones::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
