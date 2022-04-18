<?php

namespace Drupal\reservation\Controller;

use Drupal;
use Drupal\Core\Controller\ControllerBase;
use \Drupal\node\Entity\Node;
use Symfony\Component\HttpFoundation\Request;
use Drupal\reservation\Services\XMLroute;
use Drupal\paragraphs\Entity\Paragraph;
use Drupal\comment\Entity\Comment;

class ReservationController{

  public function content() {

    $genres = Drupal::entityTypeManager()
     ->getStorage('taxonomy_term')
     ->loadByProperties(['vid' => 'movie_type']);


    $genre_id = Drupal::request()->query->get('movie_type') ;

    $query = Drupal::entityQuery('node')
     ->condition('type', 'movie');

    if(!empty($genre_id)) {
      $query->condition('field_movie_type', $genre_id);
     }  

    $movies = Node::loadMultiple($query->execute());

    $reservation = Drupal::request()->query->get('reservation') ;

    if(isset($reservation)) {
      $connection = Drupal::database();

      $title = Drupal::request()->get('title') ;
      $day = Drupal::request()->get('day');
      $genre = Drupal::request()->get('genre');
      $name = Drupal::request()->get('name');
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

  public function bookContent() {

    $xmlrouter = new XMLroute() ;

    $getBooks = $xmlrouter->processXML();
    
    $query = Drupal::entityQuery('node')
      ->condition('type', 'book');

    $books = Node::loadMultiple($query->execute());

    foreach($getBooks as $book) {
      $bookComments = $book["comments"]["userComment"] ;
      if(!empty($bookComments)) {
          if(is_array($bookComments)){
              foreach($bookComments as &$bookComment) {
                  $bookComment = trim($bookComment) ;
              }
            
          }else{
              $bookComments = trim($bookComments) ;
          }
      } 

    $data = Drupal::entityTypeManager()
      ->getStorage('node')
      ->loadByProperties([
        'type' => 'book',
        'field_isbn' => $book["@attributes"]["ISBN"] ]);

      if(!$data) {
        $nodeBook = Node::create([
          'type' => 'book',
          'field_isbn' => $book["@attributes"]["ISBN"] ,
          'title' => $book["title"] ,
          'field_price' => $book["price"] ,
        ]);

        $nodeBook->save();

        

        $nid = $nodeBook->id(); //Get id of created node

        // I  didn't wanted to repeat same code , so I initialized just once $values, and depedent if $bookComents is array
        // we change value of specific key, in this case , value of key "comment_body"

        $values = [   
          'entity_type' => 'node',            
          'entity_id'   => $nid,                
          'field_name'  => 'comment',         
          'uid' => 0,                   
          'comment_type' => 'comment',        
          'subject' => 'Subject',  
          'comment_body' => '',            
          'status' => 1,                      
        ];
        
        if($bookComments) { // check if there is comment
          if(is_array($bookComments)){ //check if there is more comments
            foreach($bookComments as $comment) { //if answer is TRUE , than loop into array
                $values['comment_body'] = $comment; // change value of specific key
                $commentor = Comment::create($values);
                $commentor->save();
            }
          }else{ //if answer is FALSE, then just change value of specific key
            $values['comment_body'] = $bookComments;
            $commentor = Comment::create($values);
            $commentor->save();
          }
        } 
    }

  }

    return array(
      '#theme' => 'book-showcase',
      '#books' => $books,
      '#title' => 'Book Showcase',
     );
  }
 
}
