<?php

namespace frontend\controllers;

use common\components\TokenHelper;
use common\models\UserToken;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class UserTokenController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $userId = Yii::$app->user->identity->getId();
        if(!$userId)
            $this->goBack();
        $dataProvider = new ActiveDataProvider([
            'query' => UserToken::find()->where(['userId'=>$userId])->orderBy('created'),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionGenerate(){
        $userId = Yii::$app->user->identity->getId();
        $token = TokenHelper::createUserToken($userId);
        Yii::$app->getSession()->setFlash('success', 'Token Generated: ' . $token->token);

        return $this->redirect(['index']);
    }

    /**
     * Deletes an existing Person model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Person model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserToken the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserToken::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
