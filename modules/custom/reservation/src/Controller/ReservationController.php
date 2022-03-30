<?php

namespace Drupal\reservation\Controller;

use Drupal;
use Drupal\Core\Controller\ControllerBase;
use \Drupal\node\Entity\Node;

class ReservationController{

  public function content() {

     $movies = \Drupal::entityTypeManager()
     ->getStorage('node')
     ->loadByProperties(['type' => 'movie']);

    return array(
       '#theme' => 'reservation',
       '#movies' => $movies,
       '#title' => 'Welcome to movie reservation page',
     );
  }
}
