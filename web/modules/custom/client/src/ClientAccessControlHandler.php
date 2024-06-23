<?php
declare(strict_types=1);

namespace Drupal\client;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Access\AccessResultInterface;
use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;

class ClientAccessControlHandler extends EntityAccessControlHandler
{
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account): AccessResultInterface
  {
    if (!$account->hasPermission(Constants::PERMISSION_ADMINISTER_OWN_CLIENTS)) {
      return AccessResult::forbidden();
    }

    if ($account->id() !== $entity->getOwnerId()) {
      return AccessResult::forbidden();
    };

    return AccessResult::allowedIf(TRUE)
      ->cachePerUser()
      ->addCacheableDependency($entity);
  }

  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL): AccessResultInterface
  {
    return AccessResult::allowedIfHasPermission($account, Constants::PERMISSION_ADMINISTER_OWN_CLIENTS);
  }

}
