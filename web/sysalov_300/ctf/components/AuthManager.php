<?php

namespace app\components;
 
use nord\yii\account\models\Account;
use yii\rbac\Assignment;
use yii\rbac\DbManager;
use Yii;
 
class AuthManager extends DbManager
{
    public function getAssignments($userId)
    {
        if ($userId && $user = $this->getUser($userId)) {
            $assignment = new Assignment();
            $assignment->userId = $userId;
            $assignment->roleName = $user->role;
            return [$assignment->roleName => $assignment];
        }
        return [];
    }
 
    public function getAssignment($roleName, $userId)
    {
        if ($userId && $user = $this->getUser($userId)) {
            if ($user->role == $roleName) {
                $assignment = new Assignment();
                $assignment->userId = $userId;
                $assignment->roleName = $user->role;
                return $assignment;
            }
        }
        return null;
    }
 
    public function getUserIdsByRole($roleName)
    {
        return Account::find()->andWhere(['role' => $roleName])->select('id')->column();
    }
 
    public function assign($role, $userId)
    {
        if ($userId && $user = $this->getUser($userId)) {
            $assignment = new Assignment([
                'userId' => $userId,
                'roleName' => $role->name,
                'createdAt' => time(),
            ]);
            $this->setRole($user, $role->name);
            return $assignment;
        }
        return null;
    }
 
    public function revoke($role, $userId)
    {
        if ($userId && $user = $this->getUser($userId)) {
            if ($user->role == $role->name) {
                $this->setRole($user, null);
                return true;
            }
        }
        return false;
    }
 
    public function revokeAll($userId)
    {
        if ($userId && $user = $this->getUser($userId)) {
            $this->setRole($user, null);
            return true;
        }
        return false;
    }
 
    /**
     * @param integer $userId
     * @return null|\yii\web\IdentityInterface|Account
     */
    private function getUser($userId)
    {
        $webUser = Yii::$app->get('user', false);
        if ($webUser && !$webUser->getIsGuest() && $webUser->getId() == $userId) {
            return $webUser->getIdentity();
        } else {
            return Account::find()->andWhere(['id' => $userId])->one();
        }
    }
 
    /**
     * @param User $user
     * @param string $roleName
     */
    private function setRole(User $user, $roleName)
    {
        $user->role = $roleName;
        $user->updateAttributes(['role' => $roleName]);
    }
}