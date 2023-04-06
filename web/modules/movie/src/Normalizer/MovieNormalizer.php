<?php
namespace Drupal\movie\Normalizer;

use Drupal\serialization\Normalizer\NormalizerBase;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class MovieNormalizer extends NormalizerBase implements NormalizerInterface {
  /**
   * The interface or class that this Normalizer supports.
   *
   * @var string|array
   */
  
  /**
   * {@inheritdoc}
   */
  public function normalize($entity, $format = NULL, array $context = []) {
    $genre='';
    $genre_entities = $entity->get('genre')->referencedEntities();
    foreach ($genre_entities as $genre_entity) {
      $genre .= $genre_entity->get('name')->value.' ';  
    }
    // Normalize the entity.
    return [
      'id' => $entity->id(),
      'title' =>  $entity->get('title')->value,
      'release_date' => $entity->get('release_date')->value,
      'genre' => $genre,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function supportsNormalization($data, $format = NULL) {
    // Check if the data is an instance of your entity.
    return $data instanceof \Drupal\movie\Entity\Movie;
  }
}
