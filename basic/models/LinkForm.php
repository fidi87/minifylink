<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LinkForm will be used to create minified link from source link.
 *
 */
class LinkForm extends Model
{
	
	/**
	 *
	 * @var string 
	 */
    public $source_link;
	


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // source_link is required
            [['source_link'], 'required'],
			//source_link should be correct link
            [['source_link'], 'url'],
        ];
    }

	/**
	 * Returns absolute link. It searches the link inside link table. If it founds it will return that link
	 * else it tries create new Link model and return its link  
	 * 
	 * @return string  The absolute link or empty string
	 */
    public function loadLink() {
		//if sourse link is empty it returns empty string
		if(!$this->source_link) {
			return '';
		}
		//loading Link model from DB
		$linkModel= \app\models\Link::find()->where(['source_link'=>$this->source_link])->one();

		//if link has not found in DB, create new model 
		if($linkModel===null) {
			$linkModel=new \app\models\Link;
			$linkModel->source_link=$this->source_link;
			$linkModel->link=$this->generateUniqueUrlKey();
			$linkModel->create_time=new \yii\db\Expression('NOW()');
			$linkModel->save();
		}
		
		//if Link model created successfully and got id return the unique link, else return empty string 
		if($linkModel->id) {
			return \yii\helpers\Url::base(true).'/'.$linkModel->link;
		} else {
			return '';
		}
	}
	
	/**
	 * Generates unique string inside a table Link to use as urlkey
	 * 
	 * @return string Unique string
	 */
	public function generateUniqueUrlKey() {
		$generatedString= $this->generateString();
		
		//load model by generated string
		$existModel= Link::find()->where(['link'=>$generatedString])->one();
		
		//iterate while model exists by generated string
		while($existModel) {
			$generatedString= $this->generateString();
			$existModel= Link::find()->where(['link'=>$generatedString])->one();
		}
		
		return $generatedString;
	}
	
	/**
	 * Return randomly generated string	 * 
	 * 
	 * @param int $length The length of the returned string
	 * 
	 * @return string
	 */
	public function generateString($length=8) {
		$alphaNums = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
		$randstr = '';
		for($i=0; $i < $length; $i++){
			$randstr .= $alphaNums[rand(0, strlen($alphaNums) - 1)];
		}
		return $randstr;
	}
}
