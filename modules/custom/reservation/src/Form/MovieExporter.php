<?php

namespace Drupal\reservation\Form;

use Drupal;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use \Drupal\node\Entity\Node;
use Symfony\Component\Validator\Constraints\Length;

class MovieExporter extends ConfigFormBase {
    
    protected function getEditableConfigNames() {

        return ['reservation.MovieExporter'];

        }

    public function getFormId() {

        return 'MovieExporter_form';

        }

    public function buildForm(array $form, FormStateInterface $form_state) {

        $config = $this->config('reservation.MovieExporter');

        $query = Drupal::entityQuery('node')
            ->condition('type', 'movie');
            
        $movies = Node::loadMultiple($query->execute());

        $form['extension'] = array(
            '#type' => 'select',
            '#title' => $this->t('Select extansion in which you want to export movies :'),
            '#options' => array(
                'csv' => ('CSV') ,
                'xml' => ('XML') ,
            ),
        );
        
        $form['movieOptions'] = array(
            '#type' => 'checkboxes',
            '#title' => ('Select what movies you want to export'),
            '#options' => array() ,
           );
        
        foreach($movies as $movie) {
            $title = $movie->getTitle();
            $form['movieOptions']['#options'][] = $title;
        }

        $test = 1 ;
        return parent::buildForm($form, $form_state);
    }
  
    public function submitForm(array &$form, FormStateInterface $form_state) {

        $extension =  $form_state->getValue('extension') ;
        $selectedMoviesForExport = $form_state->getValue('movieOptions') ;
        $checkedMovies = [] ;
        foreach($selectedMoviesForExport as $checked) { //getting values of every checkbox
            if ($checked !== 0) { //check if checkbox is selected 
                array_push($checkedMovies,$checked); //push checked keys into array
            }
        }

        $arrayT = [];
        foreach($checkedMovies as $checkedMovie) { //loading node of checked movies 
            $node =Node::load($checkedMovie) ;
            $title =$node->getTitle();
            $days = $node->field_available_days->referencedEntities();
            $genre = $node->field_movie_type->referencedEntities();
            $disc = $node->field_description->value;
            $nodeArray = [
                'Title' => $title ,
                'Discription' => $disc ,
                'Available days' => $days ,
                'Genre' => $genre ,
            ];

            if(!isset($title)) {
                return FALSE ;
            } else {
                array_push($arrayT,$nodeArray) ;
            }


        }

        $test = 1 ;

        parent::submitForm($form, $form_state);

    }
}

?>
