<?php

namespace app\controllers;

use app\models\Conversaciones;
use app\models\Mensajes;
use app\models\Usuarios;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * MensajesController implements the CRUD actions for Mensajes model.
 */
class MensajesController extends Controller
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
        ];
    }

    /**
     * Creates a new Mensajes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @param mixed $receptor
     */
    public function actionCrear($receptor = null)
    {
        $idAct = Yii::$app->user->id;
        $model = new Mensajes();

        if ($receptor !== null) {
            if (($usuario = Usuarios::findOne($receptor)) === null) {
                throw new NotFoundHttpException('El usuario receptor no existe.');
            }
            $conversacion = Conversaciones::find()
                ->where(['usuario1_id' => $idAct])->andWhere(['usuario2_id' => $receptor])->one();

            if ($conversacion === null) {
                $conversacion = Conversaciones::find()
                    ->where(['usuario1_id' => $receptor])->andWhere(['usuario2_id' => $idAct])->one();
                if ($conversacion === null) {
                    $conversacion = new Conversaciones([
                            'usuario1_id' => $idAct,
                            'usuario2_id' => $receptor,
                        ]);
                    $conversacion->save();
                }
            }
        }
        $model->usuario_id = $idAct;
        $model->conversacion_id = $conversacion->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Mensaje enviado correctamente.');
            $this->enviarEmail($usuario, $conversacion);
            return $this->redirect(['conversaciones/conversacion', 'id' => $conversacion->id]);
        }

        return $this->renderAjax('crear', [
            'model' => $model,
        ]);
    }

    /**
     * Crea un modelo de Mensajes dentro de una conversación.
     * @return mixed
     */
    public function actionNuevo()
    {
        $id = Yii::$app->request->post('conversacion_id');
        $mensaje = Yii::$app->request->post('mensaje');

        if (($conversacion = Conversaciones::findOne($id)) !== null) {
            $model = new Mensajes();
            $model->usuario_id = Yii::$app->user->id;
            $model->conversacion_id = $id;
            $model->mensaje = $mensaje;
            if ($conversacion->usuario1_id !== Yii::$app->user->id) {
                $user_id = $conversacion->usuario1_id;
            } else {
                $user_id = $conversacion->usuario2_id;
            }
            $receptor = Usuarios::findOne($user_id);

            if ($model->save()) {
                $mensajes = Mensajes::find()
                        ->where(['conversacion_id' => $id])
                        ->orderBy(['created_at' => SORT_DESC])->all();
                $this->enviarEmail($receptor, $conversacion);
                return $this->renderAjax('lista_mensajes', [
                        'mensajes' => $mensajes,
                ]);
            }
        }
    }

    /**
     * Envia un email cuando se crea un mensaje.
     * @param  Usuarios $usuario  Usuario al que se envie el email
     * @param  Conversaciones $conversacion Conversación del mensaje
     * @param mixed $conversacion
     * @return bool True si el email se ha enviado correctamente
     */
    public function enviarEmail($usuario, $conversacion)
    {
        $asunto = 'Mensaje nuevo';
        $enlace = Html::a(
            'Ver mensaje',
            Url::to(['conversaciones/conversacion', 'id' => $conversacion->id], true)
        );
        $cuerpo = "¡Hola $usuario->nombre!<br>
            Te han enviado un mensaje nuevo.<br><br>$enlace";
        return Yii::$app->mailer->compose('template', [
            'usuario' => $usuario,
            'cuerpo' => $cuerpo,
        ])
        ->setFrom(Yii::$app->params['adminEmail'])
        ->setTo($usuario->email)
        ->setSubject($asunto)
        ->send();
    }

    /**
     * Finds the Mensajes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return Mensajes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Mensajes::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
