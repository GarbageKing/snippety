<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Snippets;

/**
 * SnippetsSearch represents the model behind the search form about `app\models\Snippets`.
 */
class SnippetsSearch extends Snippets
{
    public $commentsCount;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_user', 'is_public'], 'integer'],
            [['s_title', 's_description', 's_code', 's_date', 'id_language', 'commentsCount'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params, $is_private=false)
    {
        if(!$is_private){
            $query = Snippets::find()->where('snippets.is_public=1');  
        }else{
            $query = Snippets::find()->where('snippets.id_user='.Yii::$app->user->getId()); //snippets.is_public=0 and 
        }
                
        $subQuery = Comments::find()
        ->select('id_snippet, COUNT(id_snippet) as ccount')
        ->groupBy('id_snippet');
        $query->leftJoin(['commentsCount' => $subQuery], 'commentsCount.id_snippet = id');
        
        $subQuery2 = Snippetlikes::find()
        ->select('id_snippet,'
                . '( COUNT(case is_like when 1 then 1 else null end) - COUNT(case is_like when 0 then 1 else null end) ) as lcount')                
        ->groupBy('id_snippet');
        $query->leftJoin(['snippetLikesCount' => $subQuery2], 'snippetLikesCount.id_snippet = id');
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['commentsCount'] = [
        'asc' => ['commentsCount.ccount' => SORT_ASC],
        'desc' => ['commentsCount.ccount' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['snippetLikesCount'] = [
        'asc' => ['COALESCE(snippetLikesCount.lcount, 0)' => SORT_ASC],
        'desc' => ['COALESCE(snippetLikesCount.lcount, 0)' => SORT_DESC],
        ];
                
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,            
            'id_user' => $this->id_user,
            's_date' => $this->s_date,
            'is_public' => $this->is_public,
        ]);

        $query->andFilterWhere(['like', 's_title', $this->s_title])
            ->andFilterWhere(['like', 's_description', $this->s_description])
            ->andFilterWhere(['like', 's_code', $this->s_code])
            ->andFilterWhere(['like', 'id_language', $this->id_language]);
            
        return $dataProvider;
    }
}
