<?php

namespace Drupal\reservation\Controller;

use Drupal;
use Drupal\Core\Controller\ControllerBase;
use \Drupal\node\Entity\Node;
use Symfony\Component\HttpFoundation\Request;

class ReservationController{

  public function content() {

    $genres = Drupal::entityTypeManager()
     ->getStorage('taxonomy_term')
     ->loadByProperties(['vid' => 'movie_type']);


    $genre_id = Drupal::request()->query->get('movie_type') ;

    $query = Drupal::entityQuery('node')
     ->condition('type', 'movie');

    if (!empty($genre_id)){
      $query->condition('field_movie_type', $genre_id);
     }  

    $movies = Node::loadMultiple($query->execute());
     

    return array(
       '#theme' => 'reservation',
       '#movies' => $movies,
       '#title' => 'Welcome to movie reservation page',
       '#genres' => $genres ,
     );
  }

 
}
