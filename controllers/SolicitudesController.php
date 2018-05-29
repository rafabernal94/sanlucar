<?php

namespace app\controllers;

use app\models\Pasajeros;
use app\models\Solicitudes;
use app\models\Trayectos;
use Yii;
use yii\filters\VerbFilter;
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
