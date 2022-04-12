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

    $reservation = Drupal::request()->query->get('reservation') ;

    if (isset($reservation)) {
      $connection = \Drupal::database();

      $title = $_POST["title"];
      $day = $_POST["day"];
      $genre = $_POST["genre"];
      $name = $_POST["name"];
      $date = date('Y-m-d H:i:s') ;

      $result = $connection->insert('reservations')
      ->fields([
        'day_of_reservation' => $day,
        'time_of_reservation' => $date,
        'reserved_movie_name' => $title,
        'reserved_movie_genre' => $genre,
        'customer_name' => $name,
        ])->execute();

    }
     

    return array(
       '#theme' => 'reservation',
       '#movies' => $movies,
       '#title' => 'Welcome to movie reservation page',
       '#genres' => $genres ,
     );
  }

 
}
