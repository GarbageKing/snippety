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
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', /*'id_language',*/ 'id_user', 'is_public'], 'integer'],
            [['s_title', 's_description', 's_code', 's_date', 'id_language'], 'safe'],
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
    public function search($params)
    {
        $query = Snippets::find();
        
        $query->joinWith(['idLanguage']);
                //->join('JOIN',
                //'languages as l',
		//'l.id = snippets.id_language');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            //'id_language' => $this->id_language,
            'id_user' => $this->id_user,
            's_date' => $this->s_date,
            'is_public' => $this->is_public,
        ]);

        $query->andFilterWhere(['like', 's_title', $this->s_title])
            ->andFilterWhere(['like', 's_description', $this->s_description])
            ->andFilterWhere(['like', 's_code', $this->s_code])
            ->andFilterWhere(['like', /*'languages.name'*/'id_language', $this->id_language]);

        return $dataProvider;
    }
}
