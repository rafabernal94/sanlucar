<?php

namespace app\controllers;

use app\models\Coches;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * CochesController implements the CRUD actions for Coches model.
 */
class CochesController extends Controller
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
                    'eliminar' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['crear', 'mis-coches'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['crear', 'mis-coches'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Crea un nuevo modelo de Coches.
     * @return mixed
     */
    public function actionCrear()
    {
        $model = new Coches();
        $model->usuario_id = Yii::$app->user->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Tu coche ha sido añadido correctamente.');
            return $this->redirect(['coches/mis-coches']);
        }

        return $this->render('crear', [
            'model' => $model,
        ]);
    }

    /**
     * Elimina un modelo de Coches.
     * @return mixed
     * @param mixed $id
     */
    public function actionEliminar($id)
    {
        if (($model = Coches::findOne($id)) === null) {
            throw new NotFoundHttpException('El coche no existe');
        }
        $model->delete();
        Yii::$app->session->setFlash('success', 'El coche ha sido eliminado correctamente.');
        return $this->redirect(['/coches/mis-coches']);
    }

    /**
     * Lista los coches de un determinado usuario.
     * @return mixed
     */
    public function actionMisCoches()
    {
        $usuario = Yii::$app->user->identity;
        $coches = $usuario->usuarioId->coches;

        return $this->render('mis_coches', [
            'coches' => $coches,
        ]);
    }

    /**
     * Finds the Coches model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return Coches the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Coches::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
