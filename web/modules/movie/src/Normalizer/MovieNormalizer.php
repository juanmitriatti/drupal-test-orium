<?php
namespace Drupal\movie\Normalizer;

use Drupal\serialization\Normalizer\NormalizerBase;

class MovieNormalizer extends NormalizerBase {
  /**
   * {@inheritdoc}
   */
  public function normalize($entity, $format = NULL, array $context = []) {
    //$normalized = parent::serialize($data, $format, $context);
dump($entity);
   $normalized = [];
    foreach($entity as $ent) { 
      // Normalize the entity.
    /*  $normalized = [
        'id' => $ent['id'],
        'title' => $ent['title'],
        'release_date' => $ent['release_date'],
        'genre' => $ent['genre'],
      ];*/
      $normalized[] = $ent['id'];
      echo $ent['id'];
    }
    return $normalized;
  }

  /**
   * {@inheritdoc}
   */
  public function supportsNormalization($data, $format = NULL) {
    // Check if the data is an instance of your entity.
    return TRUE;
    return $data instanceof movie;
  }
}
