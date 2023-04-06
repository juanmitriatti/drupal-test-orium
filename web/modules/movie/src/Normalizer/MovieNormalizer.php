<?php
namespace Drupal\movie\Normalizer;

use Drupal\serialization\Normalizer\NormalizerBase;

class MovieNormalizer extends NormalizerBase {
  /**
   * {@inheritdoc}
   */
  public function normalize($entity, $format = NULL, array $context = []) {
    // Normalize the entity.
    $normalized = [
      'id' => $entity->id(),
      'name' => $entity->getName(),
      'description' => $entity->getDescription(),
    ];

    return $normalized;
  }

  /**
   * {@inheritdoc}
   */
  public function supportsNormalization($data, $format = NULL) {
    // Check if the data is an instance of your entity.
    return $data instanceof movie;
  }
}
