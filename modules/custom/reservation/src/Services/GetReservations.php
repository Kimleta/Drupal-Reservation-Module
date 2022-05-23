<?php

namespace Drupal\reservation\Services;

use Drupal;

class GetReservations {

    public function getReservations() {

        $connection = Drupal::database();

        $reservationQuery = $connection->query("SELECT `reserved_movie_name`,`day_of_reservation` FROM `reservations`");
        $reservationQueryResult = $reservationQuery->fetchAll();
        $decodedReservationQuery = json_decode(json_encode($reservationQueryResult), true);

        $reservedDays = [];
        foreach ($decodedReservationQuery as $key => $value) {
            $reservedDays[$value['reserved_movie_name']][$key] = $value['day_of_reservation'];
        }

        foreach ($reservedDays as $key => $value) {
            $reservedDays[$key] = array_count_values($value);
        }

        return $reservedDays ;

    }


}


?>