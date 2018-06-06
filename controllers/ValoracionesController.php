<?php

namespace app\controllers;

use app\models\Usuarios;
use app\models\Valoraciones;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ValoracionesController implements the CRUD actions for Valoraciones model.
 */
class ValoracionesController extends Controller
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
     * Creates a new Valoraciones model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @param null|mixed $valorado
     */
    public function actionCrear($valorado = null)
    {
        $idAct = Yii::$app->user->id;
        $model = new Valoraciones();

        if ($valorado !== null) {
            if (Usuarios::findOne($valorado) === null) {
                throw new NotFoundHttpException('El usuario a valorar no existe.');
            }
            $model->valorado_id = $valorado;
        }
        $model->valorador_id = $idAct;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Valoración creada correctamente.');
            return $this->goHome();
        }

        return $this->renderAjax('crear', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the Valoraciones model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return Valoraciones the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Valoraciones::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
