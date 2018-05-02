<?php

namespace app\controllers;

use app\models\Coches;
use app\models\Usuarios;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

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
                'only' => ['crear', 'mis-coches', 'modificar'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['crear', 'mis-coches', 'modificar'],
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
     * Modifica un modelo de Coches.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException Si no encuentra el modelo
     */
    public function actionModificar($id)
    {
        $model = $this->findModel($id);

        if ($model->usuario_id !== Yii::$app->user->id) {
            throw new NotFoundHttpException('No tienes permisos para modificar este coche.');
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'El coche se ha modificado correctamente.');
            return $this->redirect(['coches/mis-coches']);
        }

        return $this->render('modificar', [
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
        $coches = $usuario->usuarioId->getCoches()
            ->orderBy(['created_at' => SORT_ASC])->all();

        return $this->render('mis_coches', [
            'coches' => $coches,
        ]);
    }

    /**
     * Permite al usuario seleccionar un coche como favorito.
     * @return int Devuelve 1 si se ha guardado correctamente
     */
    public function actionFavoritoAjax()
    {
        if (($idCoche = Yii::$app->request->post('idCoche')) === null) {
            throw new NotFoundHttpException('Falta el id del coche.');
        }

        if (($coche = Coches::findOne($idCoche)) === null) {
            throw new NotFoundHttpException('El coche no existe.');
        }

        $usuario = Usuarios::findOne(Yii::$app->user->id);
        $usuario->coche_fav = $idCoche;

        Yii::$app->response->format = Response::FORMAT_JSON;
        if ($usuario->save()) {
            return 1;
        }
        return 0;
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
