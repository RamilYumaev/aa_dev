<?php
namespace testing\actions\traits;

use testing\actions\RewardStatusAction;
use testing\helpers\TestAttemptHelper;

trait TestAttemptActionsTrait
{
    public function actions() {
        return [
            'gold' => [
                'class'=>RewardStatusAction::class,
                'rewardStatus'=> TestAttemptHelper::GOLD
            ],
            'silver' => [
                'class'=>RewardStatusAction::class,
                'rewardStatus'=> TestAttemptHelper::SILVER
            ],
            'bronze' => [
                'class'=>RewardStatusAction::class,
                'rewardStatus'=> TestAttemptHelper::BRONZE
            ],
            'nomination' => [
                'class'=>RewardStatusAction::class,
                'rewardStatus'=> TestAttemptHelper::NOMINATION
            ],
            'member' => [
                'class'=>RewardStatusAction::class,
                'rewardStatus'=> TestAttemptHelper::MEMBER
            ],
            'remove' => [
                'class'=>RewardStatusAction::class,
                'rewardStatus'=> TestAttemptHelper::REWARD_NULL
            ]];
    }
}