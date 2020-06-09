<?php

/**
 * @file
 * Provides API documentation for the fivestar module.
 */

/**
 * Hook to add custom widgets to Fivestar.
 *
 * This hook allows other modules to create additional custom widgets for
 * the fivestar module.
 *
 * @return array
 *   An associative array of widget definitions. Each key must be formatted
 *   as a machine name (ie no spaces, use underscores, etc).
 *
 * @see fivestar_fivestar_widgets()
 */
function hook_fivestar_widgets() {
  // Letting fivestar know about my Cool and Awesome Stars.
  $widgets = [
    'awesome' => [
      'library' => 'mymodule/awesome',
      'label' => t('Awesome Stars'),
    ],
    'cool' => [
      'library' => 'mymodule/cool',
      'label' => t('Cool Stars'),
    ],
  ];

  return $widgets;
}

/**
 * Hook to alter access to voting in Fivestar.
 *
 * This hook is called before every vote is cast through Fivestar. It allows
 * modules to allow or deny voting on any type of entity, such as nodes, users,
 * or comments.
 *
 * @param string $entity_type
 *   Type entity.
 * @param string $id
 *   Identifier within the type.
 * @param string $vote_type
 *   The VotingAPI tag string.
 * @param int $uid
 *   The user ID trying to cast the vote.
 *
 * @return bool|null
 *   Returns TRUE if voting is supported on this object.
 *   Returns NULL if voting is not supported on this object by this module.
 *   If needing to absolutely deny all voting on this object, regardless
 *   of permissions defined in other modules, return FALSE. Note if all
 *   modules return NULL, stating no preference, then access will be denied.
 *
 * @see fivestar_validate_target()
 * @see fivestar_fivestar_access()
 */
function hook_fivestar_access($entity_type, $id, $vote_type, $uid) {
  if ($uid == 1) {
    // We are never going to allow the admin user case a fivestar vote.
    return FALSE;
  }
}
