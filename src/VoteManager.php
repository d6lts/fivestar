<?php

namespace Drupal\fivestar;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Entity\FieldableEntityInterface;
use Drupal\Core\Session\AccountProxyInterface;

/**
 * Contain methods for manage votes.
 *
 * @package Drupal\fivestar
 */
class VoteManager {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * The current user.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;

  /**
   * The vote storage.
   *
   * @var \Drupal\votingapi\Entity\Vote
   */
  protected $voteStorage;

  /**
   * Constructs a new VoteManager object.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   * @param \Drupal\Core\Session\AccountProxyInterface $current_user
   *   The current user.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager, AccountProxyInterface $current_user) {
    $this->entityTypeManager = $entity_type_manager;
    $this->currentUser = $current_user;
    $this->voteStorage = $entity_type_manager->getStorage('vote');
  }

  /**
   * Get vote types.
   *
   * @return array
   */
  public function getVoteTypes() {
    $options = [];
    $vote_type_storage = $this->entityTypeManager->getStorage('vote_type');

    foreach ($vote_type_storage->loadMultiple() as $vote_type) {
      $options[$vote_type->id()] = $vote_type->label();
    }

    return $options;
  }

  /**
   * Add vote.
   *
   * @param \Drupal\Core\Entity\FieldableEntityInterface $entity
   * @param int $rating
   * @param string $vote_type
   * @param int|null $uid
   *
   * @return \Drupal\votingapi\Entity\Vote
   */
  public function addVote(FieldableEntityInterface $entity, $rating, $vote_type = 'vote', $uid = NULL) {
    $uid = is_numeric($uid) ? $uid : $this->currentUser->id();
    $rating = ($rating > 100) ? 100 : $rating;

    $vote = $this->voteStorage->create(['type' => $vote_type]);
    $vote->setVotedEntityId($entity->id());
    $vote->setVotedEntityType($entity->getEntityTypeId());
    $vote->setOwnerId($uid);
    $vote->setValue($rating);
    $vote->save();

    return $vote;
  }

  /**
   * Delete vote.
   */
  public function deleteVote() {
  }

  /**
   * Get votes by criteria.
   *
   * @param array $criteria
   *   $criteria['entity_id']
   *   $criteria['entity_type']
   *   $criteria['type'] Vote type.
   *   $criteria['user_id']
   *   $criteria['vote_source']
   *
   * @return array
   *   Which contain vote ids.
   */
  public function getVotesByCriteria(array $criteria) {
    if (empty($criteria)) {
      return [];
    }

    return $this->voteStorage->loadByProperties($criteria);
  }

}
