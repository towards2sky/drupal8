<?php
/**
 * @file
 * contains \Drupal\rsvplist\Plugin\Block\RSVPBlock
 */

namespace Drupal\rsvplist\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Provides a 'RSVP' List Block
 *
 * @Block(
 *   id = "rsvp_block",
 *   admin_label = @Translation("RSVP Block"),
 *   category = @Translation("Blocks")
 * )
 */
class RSVPBlock extends BlockBase {

 public function build()
 {
     // TODO: Implement build() method.
     return \Drupal::formBuilder()->getForm('Drupal\rsvplist\Form\RSVPForm');

 }

 public function blockAccess(AccountInterface $account)
 {
     $node = \Drupal::routeMatch()->getParameter('node');
     $nid = $node->nid->value;
     /** @var \Drupal\rsvplist\EnablerService $enabler */
     $enabler = \Drupal::service('rsvplist.enabler');
     if(is_numeric($nid)) {
         if($enabler->isEnabled($node)) {
             return AccessResult::allowedIfHasPermission($account, 'view rsvplist');
         }
     }
     return AccessResult::forbidden();
     //return parent::blockAccess($account); // TODO: Change the autogenerated stub
 }
}


