<?php

/**
 * @file
 * Contains \Drupal\guestform\Form\.
 */

namespace Drupal\guestbook\Form;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\MessageCommand;
use Drupal\Core\Ajax\RedirectCommand;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\file\Entity\File;

/**
 * Class GuestBookForm.
 *
 * Provides a guestbook form.
 */

class GuestBookForm extends FormBase
{

    /**
     * GuestBook ID.
     */
    public function getFormId()
    {
        return 'GuestBookForm';
    }

    /**
     * Form for guestbook.
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $form['name'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Your name:'),
        '#placeholder' => $this->t('min-2 symbols, max-100'),
        '#description' => $this->t('min-2 symbols, max-100'),
        '#required' => true,
        '#ajax' => [
          'callback' => '::nameValidateAjax',
          'event' => 'change',
        ],
        ];
        $form['name_message-status'] = [
          '#type' => 'markup',
          '#markup' => '<div class="name-message-status"></div>',
        ];

        $form['email'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Your email:'),
        '#required' => true,
        '#description' => $this->t('Can only contain Latin letters, Hyphens, or Underscores.'),
        '#placeholder' => $this->t('Can only contain Latin letters, Hyphens, or Underscores.'),
        '#ajax' => [
          'callback' => '::emailValidateAjax',
          'event' => 'change',
        ],
        ];
        $form['email-message-status'] = [
          '#type' => 'markup',
          '#markup' => '<div class="email-message-status"></div>',
        ];

        $form['phone_number'] = [
          '#type' => 'tel',
          '#title' => $this->t('Your phone number:'),
          '#placeholder' => $this->t('+380501234567'),
          '#required' => true,
          '#ajax' => [
            'callback' => '::telValidateAjax',
            'event' => 'change',
          ],
        ];
        $form['phone-message-status'] = [
          '#type' => 'markup',
          '#markup' => '<div class="phone-message-status"></div>',
        ];

        $form['response'] = [
          '#type' => 'textarea',
          '#required' => true,
          '#title' => $this->t('Response:'),
          '#placeholder' => $this->t('response:'),
        ];

        $form['avatar'] = [
          '#type' => 'managed_file',
          '#description' => $this->t('jpeg, png, jpg and < 2MB'),
          '#title' => $this->t('Your Avatar:'),
          '#upload_location' => 'public://images/',
          '#upload_validators' => [
            'file_validate_extensions' => ['png jpeg jpg'],
            'file_validate_size' => ['2097152'],
          ],
        ];

        $form['image'] = [
          '#type' => 'managed_file',
          '#title' => $this->t('Image to review:'),
          '#description' => $this->t('jpeg, png, jpg and < 5MB'),
          '#upload_location' => 'public://',
          '#upload_validators' => [
            'file_validate_extensions' => ['jpeg jpg png'],
            'file_validate_size' => ['5242880'],
          ],
        ];

        $form['actions']['#type'] = 'actions';

        $form['actions']['submit'] = [
          '#type' => 'submit',
          '#value' => $this->t('Add Review'),
          '#button_type' => 'primary',
          '#ajax' => [
            'callback' => '::ajaxSubmitCallback',
            'event' => 'click',
          ],
        ];

        /*$form['message-status'] = [
          '#type' => 'markup',
          '#markup' => '<div id="message-status"></div>',
        ];*/
        return $form;
    }

    /**
     * Validations for fields in guestbook
     */

    public function validateForm(array &$form, FormStateInterface $form_state)
    {
        $emailValidate = $form_state->getValue('email');
        $telValidate = $form_state->getValue('phone_number');
        if (strlen($form_state->getValue('name')) < 2) {
            $form_state->setErrorByName('name', $this->t('✗ Name is too short.'));
        }
        if (strlen($form_state->getValue('name')) > 100) {
            $form_state->setErrorByName('name', $this->t('✗ Name is too long'));
        }
        if (!preg_match('/^[A-Za-z1-9-_]+[@]+[a-z]+[.]+[a-z]+$/', $emailValidate)) {
            $form_state ->setErrorByName('email', $this->t('✗ Email is not valid'));
        }
        if (!filter_var($telValidate, FILTER_VALIDATE_INT) || !preg_match('/^\+?3?8?(0\d{9})$/', $telValidate)) {
            $form_state->setErrorByName('phone_number', $this->t('Enter the phone number correctly'));
        }
    }

    /**
     * Name validation
     */

    public function nameValidateAjax(array &$form, FormStateInterface $form_state)
    {
        $ajaxresponse = new AjaxResponse();
        if (strlen($form_state->getValue('name')) < 2) {
            $ajaxresponse->addCommand(new HtmlCommand('.name-message-status', '✗ Name is too short'));
        } elseif (strlen($form_state->getValue('name')) > 100) {
            $ajaxresponse->addCommand(new HtmlCommand('.name-message-status', '✗ Name is too long'));
        } else {
            $ajaxresponse->addCommand(new HtmlCommand('.name-message-status', '✓ Correct Name'));
        }
        return $ajaxresponse;
    }

    /**
     * Email Validation
     */

    public function emailValidateAjax(array $form, FormStateInterface $form_state)
    {
        $ajaxresponse = new AjaxResponse();
        $emailValidate = $form_state->getValue('email');
        if (!preg_match('/^[A-Za-z1-9-_]+[@]+[a-z]+[.]+[a-z]+$/', $emailValidate)) {
            $ajaxresponse ->addCommand(new HtmlCommand('.email-message-status', '✗ Wrong Email'));
        } else {
            $ajaxresponse->addCommand(new HtmlCommand('.email-message-status', '✓ Correct Email'));
        }
        return $ajaxresponse;
    }

    /**
     * Telephone number validation
     */

    public function telValidateAjax(array $form, FormStateInterface $form_state)
    {
        $ajaxresponse = new AjaxResponse();
        $telValidate = $form_state->getValue('phone_number');
        if (!filter_var($telValidate, FILTER_VALIDATE_INT) || !preg_match('/^\+?3?8?(0\d{9})$/', $telValidate)) {
            $ajaxresponse->addCommand(new HtmlCommand('.phone-message-status', '✗ Wrong number'));
        } else {
            $ajaxresponse->addCommand(new HtmlCommand('.phone-message-status', '✓ Correct phone number'));
        }
        return $ajaxresponse;
    }

    /**
     * Ajax Submit Validation
     */

    public function ajaxSubmitCallback(array $form, FormStateInterface $form_state)
    {
        $ajaxresponse = new AjaxResponse();
        if ($form_state->hasAnyErrors()) {
            foreach ($form_state->getErrors() as $errorname) {
                $ajaxresponse ->addCommand(new MessageCommand($errorname, '#message-status', [], false));
            }
            \Drupal::messenger()->deleteAll();
        } else {
            $url = Url::fromRoute('guestbook.front');
            $command = new RedirectCommand($url->toString());
            $ajaxresponse->addCommand($command);
            $ajaxresponse ->addCommand(new MessageCommand($this->t('✓ Your added your review')));
        }
        return $ajaxresponse;
    }

    /**
     * Function Submit
     */

    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $avatar = $form_state->getValue('avatar');
        $image = $form_state->getValue('image');
        $data = [
        'name' => $form_state->getValue('name'),
        'email' => $form_state->getValue('email'),
        'phone_number' => $form_state->getValue('phone_number'),
        'response' => $form_state->getValue('response'),
        'avatar' => $avatar[0],
        'image' => $image[0],
        'timestamp' => time(),
        ];
        if (is_null($avatar[0])) {
            $data['avatar'] = 0;
        } else {
            $avatarfile = File::load($avatar[0]);
            $avatarfile->setPermanent();
            $avatarfile->save();
        }
        if (is_null($image[0])) {
            $data['image'] = 0;
        } else {
            $imagefile = File::load($image[0]);
            $imagefile->setPermanent();
            $imagefile->save();
        }
        $query = \Drupal::database()->insert('guestbook');
        $query
        ->fields($data)
        ->execute();
        $this->messenger()->addStatus($this->t('Successfully'));
        $form_state->setRedirect('guestbook.front');
    }
}
