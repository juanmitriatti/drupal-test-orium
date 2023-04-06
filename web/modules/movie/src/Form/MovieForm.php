<?php

namespace Drupal\movie\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for the movie entity edit forms.
 */
class MovieForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildForm($form, $form_state);

    $form['#attached'] = array(
      'library' => array('movie/validation'),
      'drupalSettings' => array(),
    );

     // Group inputs in a fieldset.
     $form['movie_fieldset'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Movie Fieldset'),
      '#collapsible' => TRUE,
      '#collapsed' => FALSE,
    ];

    // Move existing inputs into the fieldset.
    $form['title']['#group'] = 'movie_fieldset';
    $form['genre']['#group'] = 'movie_fieldset';
    $form['release_date']['#group'] = 'movie_fieldset';

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
    $release_date = $form_state->getValue('release_date')[0]['value'];
    $current_time = \Drupal::time()->getRequestTime();

    if ($release_date->getTimeStamp() > $current_time) {
      $form_state->setErrorByName('release_date', $this->t('The release date cannot be a future date.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $result = parent::save($form, $form_state);

    $entity = $this->getEntity();

    $message_arguments = ['%label' => $entity->toLink()->toString()];
    $logger_arguments = [
      '%label' => $entity->label(),
      'link' => $entity->toLink($this->t('View'))->toString(),
    ];

    switch ($result) {
      case SAVED_NEW:
        $this->messenger()->addStatus($this->t('New movie %label has been created.', $message_arguments));
        $this->logger('movie')->notice('Created new movie %label', $logger_arguments);
        break;

      case SAVED_UPDATED:
        $this->messenger()->addStatus($this->t('The movie %label has been updated.', $message_arguments));
        $this->logger('movie')->notice('Updated movie %label.', $logger_arguments);
        break;
    }

    $form_state->setRedirect('entity.movie.canonical', ['movie' => $entity->id()]);

    return $result;
  }

}
