<?php

namespace app\controllers;

use app\models\Pasajeros;
use app\models\Solicitudes;
use app\models\Trayectos;
use app\models\Usuarios;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * SolicitudesController implements the CRUD actions for Solicitudes model.
 */
class SolicitudesController extends Controller
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
     * Crea un nuevo modelo de Solicitudes.
     * @return mixed
     */
    public function actionCrear()
    {
        $idTrayecto = Yii::$app->request->post('idTrayecto');
        $model = new Solicitudes();
        $model->usuario_id = Yii::$app->user->id;
        $model->trayecto_id = $idTrayecto;
        $trayecto = Trayectos::findOne($idTrayecto);
        $conductor = Usuarios::findOne($trayecto->conductor_id);

        $this->enviarEmail($conductor, $trayecto);

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $model->save();
    }

    /**
     * Acepta una solicitud de unión pendiente.
     * @return mixed
     */
    public function actionAceptar()
    {
        $idSolicitud = Yii::$app->request->post('idSolicitud');
        $model = $this->findModel($idSolicitud);
        $model->aceptada = true;

        if ($model->save()) {
            $pasajero = new Pasajeros();
            $pasajero->usuario_id = $model->usuario_id;
            $pasajero->trayecto_id = $model->trayecto_id;
            if ($pasajero->save()) {
                $trayecto = Trayectos::findOne($model->trayecto_id);
                $trayecto->plazas -= 1;
                $trayecto->save();

                Yii::$app->response->format = Response::FORMAT_JSON;
                $resultado = [
                    $this->renderAjax('/trayectos/lista_pasajeros', [
                        'trayecto' => $trayecto,
                    ]),
                    $this->renderAjax('/trayectos/lista_solicitudes', [
                        'trayecto' => $trayecto,
                    ]),
                ];
                return $resultado;
            }
        }
    }

    /**
     * Envia un email cuando se crea una solicitud.
     * @param  Usuarios $usuario Usuario al que se envie el email
     * @param  Trayectos $trayecto Trayecto al que pertenece la solicitud
     * @return bool True si el email se ha enviado correctamente
     */
    public function enviarEmail($usuario, $trayecto)
    {
        $asunto = 'Nueva solicitud';
        $enlace = Html::a(
            'Ver solicitud',
            Url::to(['trayectos/detalles', 'id' => $trayecto->id], true)
        );
        $cuerpo = "¡Hola $usuario->nombre!<br>
            Tienes una nueva solicitud en un trayecto.<br><br>$enlace";
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
     * Finds the Solicitudes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return Solicitudes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Solicitudes::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
