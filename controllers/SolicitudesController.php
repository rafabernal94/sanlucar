<?php

namespace app\controllers;

use app\models\Pasajeros;
use app\models\Solicitudes;
use app\models\Trayectos;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

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
        $idTrayecto = Yii::$app->request->post('id-trayecto');
        $model = new Solicitudes();
        $model->usuario_id = Yii::$app->user->id;
        $model->trayecto_id = $idTrayecto;

        if ($model->save()) {
            Yii::$app->session->setFlash('success', 'Plaza solicitada correctamente.');
            return $this->redirect(['trayectos/detalles', 'id' => $idTrayecto]);
        }
    }

    /**
     * Acepta una solicitud de unión pendiente.
     * @param int $id
     * @return mixed
     */
    public function actionAceptar($id)
    {
        $model = $this->findModel($id);
        $model->aceptada = true;

        if ($model->save()) {
            $pasajero = new Pasajeros();
            $pasajero->usuario_id = $model->usuario_id;
            $pasajero->trayecto_id = $model->trayecto_id;
            if ($pasajero->save()) {
                $trayecto = Trayectos::findOne($model->trayecto_id);
                $trayecto->plazas -= 1;
                if ($trayecto->save()) {
                    return $this->redirect(['trayectos/detalles', 'id' => $trayecto->id]);
                }
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
