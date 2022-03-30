<?php

namespace Drupal\reservation\Controller;

use Drupal\Core\Controller\ControllerBase;

class ReservationController extends ControllerBase {

  public function content() {
    return array(
      '#type' => 'markup',
      '#markup' => t('Welcome to reservation page'),
    );
  }
}
