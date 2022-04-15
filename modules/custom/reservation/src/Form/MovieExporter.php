<?php

namespace Drupal\reservation\Form;

use Drupal;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use \Drupal\node\Entity\Node;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Serializer\Encoder\XmlEncoder;

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

        return parent::buildForm($form, $form_state);
    }
  
    public function submitForm(array &$form, FormStateInterface $form_state) {

        $extension =  $form_state->getValue('extension') ;
        $selectedMoviesForExport = $form_state->getValue('movieOptions') ;
        $checkedMovies = [];
        foreach($selectedMoviesForExport as $checked) { //getting values of every checkbox
            if($checked !== 0) { //check if checkbox is selected 
                array_push($checkedMovies,$checked+1); //push checked keys into array and itterates them for one, becouse node::load will not work with 0
            }
        }

        $nodes =Node::loadMultiple($checkedMovies) ;
        $arrayMovies = [] ;
            foreach($nodes as $node) {
                $title = $node->title->value;
                $days = $node->field_available_days->referencedEntities();
                foreach($days as &$day) {
                    $day = $day->getName();
                }
                $genres = $node->field_movie_type->referencedEntities();
                foreach($genres as &$genre) {
                    $genre = $genre->getName();
                }
                $disc = $node->field_description->value;
                $arrayMovie = [
                    'Title' => $title ,
                    'Discription' => strip_tags($disc) ,
                    'Available days' =>  implode(' ', $days) ,
                    'Genre' => implode(' ',$genres) ,
                ];
                
                if(empty($title)) {
                    return FALSE ;
                }else {
                    array_push($arrayMovies,$arrayMovie);
                    }
            
                }

        if($extension == "csv") { 
            $csvName = "testing.csv";
            $fileHandle = fopen($csvName, 'w') or die('Can\'t create .csv file, try again later.');
            foreach($arrayMovies as $movie) {
                fputcsv($fileHandle,$movie) ;
            }
            fclose($fileHandle);
        }else {
            $xmlEncoder = new XmlEncoder();
            header("Content-type: text/xml");
            header("Content-Disposition: attachment; filename=testing.xml");
            $xmlFile = $xmlEncoder->encode($arrayMovie, 'xml');
            exit($xmlFile);
        }

        parent::submitForm($form, $form_state);

    }
}

?>
