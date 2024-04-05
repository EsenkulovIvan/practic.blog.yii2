<?php

namespace app\models;

use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "tbl_post".
 *
 * @property int $id
 * @property string $title
 * @property string $content
 * @property string|null $tags
 * @property int $status
 * @property int|null $create_time
 * @property int|null $update_time
 * @property int $author_id
 *
 * @property User $author
 * @property Comment[] $comments
 */
class Post extends \yii\db\ActiveRecord
{
    const STATUS_DRAFT=1;
    const STATUS_PUBLISHED=2;
    const STATUS_ARCHIVED=3;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_post';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'content', 'status',], 'required'],
            [['status'], 'in', 'range' => [1, 2, 3]],
            [['title'], 'string', 'max' => 128],
            ['tags', 'match', 'pattern'=>'/^[а-яА-ЯёЁa-zA-Z\s,]+$/', 'message'=>'В тегах можно использовать только буквы.'],
            ['tags', 'normalizeTags'],
            [['create_time'], 'date', 'format' => 'php:Y-m-d'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Наименование статьи',
            'content' => 'Содержание',
            'tags' => 'Теги',
            'status' => 'Статус',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'author_id' => 'Author ID',
        ];
    }

    /**
     * Gets query for [[Author]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::class, ['id' => 'author_id']);
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::class, ['post_id' => 'id'])->where(['status' => Comment::STATUS_APPROVED])->orderBy(['create_time' => SORT_DESC]);
    }

    public function getCommentsCount()
    {
        return $this->hasMany(Comment::class, ['post_id' => 'id'])->where(['status' => Comment::STATUS_APPROVED])->count();
    }

    public function normalizeTags($attribute,$params)
    {
        $this->tags=Tag::array2string(array_unique(Tag::string2array($this->tags)));
    }

   /* public function getUrl()
    {
        return Url::to(['post/view', 'id' => $this->id, 'title' => $this->title]);
    }*/
}
