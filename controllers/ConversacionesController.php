<?php

namespace app\controllers;

use app\models\Conversaciones;
use app\models\Mensajes;
use app\models\Usuarios;
use Yii;
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
        if (($conversacion = $this->findModel($id)) === null) {
            throw new NotFoundHttpException('La conversación no existe.');
        }

        if ($conversacion->usuario1_id !== Yii::$app->user->id) {
            $user = Usuarios::findOne($conversacion->usuario1_id);
        } else {
            $user = Usuarios::findOne($conversacion->usuario2_id);
        }

        $mensajes = Mensajes::find()
            ->where(['conversacion_id' => $id])
            ->orderBy(['created_at' => SORT_DESC])->all();

        return $this->render('conversacion', [
            'mensajes' => $mensajes,
            'user' => $user,
        ]);
    }

    /**
     * Creates a new Conversaciones model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Conversaciones();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Conversaciones model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Conversaciones model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
