<?php

/**
* @return
* Contains \Drupal\guestbook\Controller\FirstPageController.
*/

namespace Drupal\guestbook\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\file\Entity\File;

/**
* Provides route responses for the DrupalBook module.
*/
class GuestBookController extends ControllerBase
{

/**
* Returns a simple page.
*
* @return array
*   A simple renderable array.
*/
    public function content()
    {
        $form = \Drupal::formBuilder()->getForm('\Drupal\guestbook\Form\GuestBookForm');
        return [
          '#theme' => 'guest_book_form',
          '#form' => $form,
          '#guest_book_list' => $this->GuestBookdb(),

        ];
    }

    public function GuestBookdb()
    {
      // Get data from database.
        $query = \Drupal::database();
        $result = $query->select('guestbook', 'g')
        ->fields('g', [
          'id',
          'name',
          'email',
          'phone_number',
          'response',
          'avatar',
          'image',
          'timestamp',
        ])
        ->orderBy('timestamp', 'DESC')
        ->execute()->fetchAll();

        $data = [];

        foreach ($result as $row) {
            $file = File::load($row->avatar);
            if (is_null($file)) {
                $row->avatar = '';
                $avatar_variables = [
                '#theme' => 'image',
                '#uri' => '/modules/custom/guestbook/images/default_user.png',
                '#width' => 100,
                ];
            } else {
                $avatar_uri = $file->getFileUri();
                $avatar_variables = [
                '#theme' => 'image',
                "#uri" => $avatar_uri,
                '#alt' => 'Profile avatar',
                '#title' => 'Profile avatar',
                '#width' => 100,
                ];
            }
            $image = File::load($row->image);
            if (!isset($image)) {
                $row->image = '';
                $image_variables = [
                '#theme' => 'image',
                '#uri' => 'empty_image',
                '#width' => 100,
                ];
            } else {
                $uri = $image->getFileUri();
                $uri = file_create_url($uri);
                $image_variables = [
                '#theme' => 'image',
                '#uri' => $uri,
                '#alt' => 'Review image',
                '#title' => 'Review image',
                '#width' => 150,
                ];
            }

          /**
           * Get data.
           */
            $data[] = [
              '#theme' => 'guest_book_list',
              '#name' => $row->name,
              '#email' => $row->email,
              '#phone_number' => $row->phone_number,
              '#response' => $row->response,
              '#avatar' => [
                'data' => $avatar_variables,
              ],
              '#image' => [
                'data' => $image_variables,
              ],
              '#timestamp' => $row->timestamp,
              '#id' => $row->id,
              /*'edit' => t('Edit'),
              'delete' => t('Delete'),*/
              '#uri' => isset($uri) ? $uri : '',
            ];
        }
        return $data;
    }
}
