<?php

namespace Drupal\reservation\Controller;

use Drupal;
use Drupal\comment\Entity\Comment;
use Drupal\reservation\Services\GetReservations;
use Drupal\reservation\Services\XMLroute;
use Symfony\Component\HttpFoundation\Request;
use \Drupal\node\Entity\Node;

class ReservationController
{

    public function content()
    {

        $connection = Drupal::database();

        $getReservations = new GetReservations();

        $reservations = $getReservations->getReservations();

        $genres = Drupal::entityTypeManager()
            ->getStorage('taxonomy_term')
            ->loadByProperties(['vid' => 'movie_type']);

        $genre_id = Drupal::request()->query->get('movie_type');

        $query = Drupal::entityQuery('node')
            ->condition('type', 'movie');

        if (!empty($genre_id)) {
            $query->condition('field_movie_type', $genre_id);
        }

        $movies = Node::loadMultiple($query->execute());

        $reservation = Drupal::request()->query->get('reservation');

        if (isset($reservation)) {

            $dataArray = Drupal::request()->get('dataArray');

            $title = $dataArray[0];
            $day = $dataArray[1];
            $genre = $dataArray[2];
            $name = $dataArray[3];
            $date = date('Y-m-d H:i:s');

            $result = $connection->insert('Reservations')
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
            '#genres' => $genres,
            '#reservations' => $reservations,
        );
    }

    public function importBookContent()
    {

        $xmlrouter = new XMLroute();

        $getBooks = $xmlrouter->processXML();

        $query = Drupal::entityQuery('node')
            ->condition('type', 'book');

        $books = Node::loadMultiple($query->execute());

        foreach ($getBooks as $book) {
            $bookComments = $book["comments"]["userComment"];
            if ($bookComments) {
                if (is_array($bookComments)) {
                    foreach ($bookComments as &$bookComment) {
                        $bookComment = trim($bookComment);
                    }
                } else {
                    $bookComments = trim($bookComments);
                }
            }

            $data = Drupal::entityTypeManager()
                ->getStorage('node')
                ->loadByProperties([
                    'type' => 'book',
                    'field_isbn' => $book["@attributes"]["ISBN"],
                ]);

            if (!$data) {
                $nodeBook = Node::create([
                    'type' => 'book',
                    'field_isbn' => $book["@attributes"]["ISBN"],
                    'title' => $book["title"],
                    'field_price' => $book["price"],
                ]);

                $nodeBook->save();

                $nid = $nodeBook->id(); //Get id of created node

                // I  didn't wanted to repeat same code , so I initialized just once $values, and depedent if $bookComents is array
                // we change value of specific key, in this case , value of key "comment_body"

                $values = [
                    'entity_type' => 'node',
                    'entity_id' => $nid,
                    'field_name' => 'comment',
                    'uid' => 0,
                    'comment_type' => 'comment',
                    'subject' => 'Subject',
                    'comment_body' => '',
                    'status' => 1,
                ];

                if ($bookComments && is_array($bookComments)) { // check if there is comment and check if there is more comments
                    foreach ($bookComments as $comment) { //if answer is TRUE , than loop into array
                        $values['comment_body'] = $comment; // change value of specific key
                        $commentor = Comment::create($values);
                        $commentor->save();
                    }
                } else { //if answer is FALSE, then just change value of specific key
                    $values['comment_body'] = $bookComments;
                    $commentor = Comment::create($values);
                    $commentor->save();
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
