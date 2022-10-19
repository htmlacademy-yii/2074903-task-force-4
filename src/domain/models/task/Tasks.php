<?php

namespace omarinina\domain\models\task;

use omarinina\domain\models\Cities;
use omarinina\domain\models\user\Users;
use omarinina\domain\models\Categories;
use omarinina\domain\models\Files;
use Yii;
use omarinina\domain\traits\TimeCounter;
use omarinina\domain\actions\AcceptAction;
use omarinina\domain\actions\CancelAction;
use omarinina\domain\actions\DenyAction;
use omarinina\domain\actions\RespondAction;
use omarinina\domain\actions\AbstractAction;
use omarinina\domain\exception\task\IdUserException;
use omarinina\domain\exception\task\CurrentActionException;
use omarinina\domain\exception\task\AvailableActionsException;

/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property string $createAt
 * @property string $name
 * @property string $description
 * @property string|null $expiryDate
 * @property int $budget
 * @property int $categoryId
 * @property int $cityId
 * @property int $status
 * @property int|null $executorId
 * @property int $clientId
 *
 * @property Categories $category
 * @property Users $client
 * @property Users $executor
 * @property Responds[] $responds
 * @property Reviews $review
 * @property TaskStatuses $taskStatus
 * @property TaskFiles[] $taskFiles
 * @property Files[] $files
 * @property Cities $city
 *
 */
class Tasks extends \yii\db\ActiveRecord
{
    public const NEW_STATUS = 'new';
    public const IN_WORK_STATUS = 'in work';

    use TimeCounter;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['createAt', 'expiryDate'], 'safe'],
            [['name',  'budget', 'categoryId', 'status', 'clientId', 'description'], 'required'],
            [['description'], 'string'],
            [['categoryId', 'status', 'executorId', 'clientId', 'cityId'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['budget'], 'integer', 'max' => 128],
            [['categoryId'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::class, 'targetAttribute' => ['categoryId' => 'id']],
            [['clientId'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['clientId' => 'id']],
            [['executorId'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['executorId' => 'id']],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => TaskStatuses::class, 'targetAttribute' => ['status' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'createAt' => 'Create At',
            'name' => 'Name',
            'description' => 'Description',
            'expiryDate' => 'Expiry Date',
            'budget' => 'Budget',
            'categoryId' => 'Category ID',
            'cityId' => 'City ID',
            'status' => 'Status',
            'executorId' => 'Executor ID',
            'clientId' => 'Client ID',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Categories::class, ['id' => 'categoryId']);
    }

    /**
     * Gets query for [[Client]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Users::class, ['id' => 'clientId']);
    }

    /**
     * Gets query for [[Executor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExecutor()
    {
        return $this->hasOne(Users::class, ['id' => 'executorId']);
    }

    /**
     * Gets query for [[Responds]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getResponds()
    {
        return $this->hasMany(Responds::class, ['taskId' => 'id']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReview()
    {
        return $this->hasOne(Reviews::class, ['taskId' => 'id']);
    }

    /**
     * Gets query for [[TaskStatus]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaskStatus()
    {
        return $this->hasOne(TaskStatuses::class, ['id' => 'status']);
    }

    /**
     * Gets query for [[TaskFiles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaskFiles()
    {
        return $this->hasMany(TaskFiles::class, ['taskId' => 'id']);
    }

    /**
     *  Gets query for [[Files]].
     *
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getFiles()
    {
        return $this->hasMany(Files::class, ['id' => 'fileId'])
            ->viaTable('taskFiles', ['taskId' => 'id']);
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(Cities::class, ['id' => 'cityId']);
    }

    /**
     * @param string $currentAction
     * @param int $idUser
     * @return void
     * @throws AvailableActionsException changes in this task status
     * @throws CurrentActionException Exception when user tries to choose action
     * which is unavailable for this task status
     * @throws IdUserException Exception when user doesn't have rights to add
     */
    public function changeStatusByAction(string $currentAction, int $idUser): void
    {
        if ($this->isValidAction($currentAction, $idUser)) {
            $idNewStatus = $this->getLinkActionToStatus()[$currentAction]->id;
            $this->status = $idNewStatus;
            $this->save(false);
        }
        if (!array_key_exists($currentAction, $this->getLinkActionToStatus())) {
            throw new CurrentActionException();
        }
        if ($this->getAvailableActions($idUser)->getInternalName() !== $currentAction) {
            throw new IdUserException();
        }
    }

    /**
     * @param int $idUser
     * @return AbstractAction|null
     * @throws AvailableActionsException Exception when task has such status
     * which doesn't have any available action for any users
     * @throws IdUserException Exception when user doesn't have rights to add
     * changes in this task status
     */
    public function getAvailableActions(int $idUser): ?AbstractAction
    {
        if (!array_key_exists($this->taskStatus->id, $this->getLinkStatusToAction())) {
            throw new AvailableActionsException();
        }
        $availableAction = array_values(array_filter(
            $this->getLinkStatusToAction()[$this->taskStatus->id],
            function (AbstractAction $action) use ($idUser) {
                return $action->isAvailableForUser($idUser);
            }
        ))[0] ?? null;
        if (!$availableAction) {
            return null;
        }
        return $availableAction;
    }

    /**
     * @return array
     */
    private function getLinkActionToStatus(): array
    {
        return [
            CancelAction::getInternalName() => TaskStatuses::findOne(['taskStatus' => CancelAction::getInternalName()]),
            AcceptAction::getInternalName() => TaskStatuses::findOne(['taskStatus' => AcceptAction::getInternalName()]),
            DenyAction::getInternalName() => TaskStatuses::findOne(['taskStatus' => DenyAction::getInternalName()])
        ];
    }

    //Also the client has two additional buttons when he receives responds by executors.
    //Potential this logic can be realised with this class, isn't it?

    /**
     * @return array
     */
    private function getLinkStatusToAction(): array
    {
        return [
            TaskStatuses::findOne(['taskStatus' => self::NEW_STATUS])->id => [
                new CancelAction($this),
                new RespondAction($this)
            ],
            TaskStatuses::findOne(['taskStatus' => self::IN_WORK_STATUS])->id => [
                new AcceptAction($this),
                new DenyAction($this)
            ]
        ];
    }

    /**
     * @param string $currentAction
     * @param int $idUser
     * @return bool
     * @throws AvailableActionsException
     * @throws IdUserException
     */
    private function isValidAction(string $currentAction, int $idUser): bool
    {
        if (array_key_exists($currentAction, $this->getLinkActionToStatus())) {
            return $this->getAvailableActions($idUser)->getInternalName() === $currentAction;
        }
        return false;
    }


}
