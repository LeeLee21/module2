<?php

namespace Drupal\guestbook\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Url;

/**
 * GuestBook ID.
 */

class DeleteForm extends ConfirmFormBase
{

    public $userid;

    /**
     * {@inheritdoc}
     */

    public function getFormId()
    {
        return 'Delete';
    }

    /**
     * {@inheritdoc}
     */

    public function getQuestion()
    {
        return t('Do you want to Delete?');
    }

    /**
     * {@inheritdoc}
     */

    public function getCancelUrl()
    {
        return new Url('guestbook.front');
    }

    /**
     * {@inheritdoc}
     */

    public function getDescription()
    {
        return t('Do you want to delete ?');
    }

    /**
     * {@inheritdoc}
     */

    public function getConfirmText()
    {
        return t('Delete');
    }

    /**
     * {@inheritdoc}
     */

    public function getCancelText()
    {
        return t('Cancel');
    }

    /**
     * {@inheritdoc}
     */

    public function buildForm(array $form, FormStateInterface $form_state, $userid = null)
    {
        $this->id = $userid;
        return parent::buildForm($form, $form_state);
    }

    /**
     * {@inheritdoc}
     */

    public function validateForm(array &$form, FormStateInterface $form_state)
    {
        parent::validateForm($form, $form_state);
    }

    /**
     * {@inheritdoc}
     */

    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $query = \Drupal::database();
        $query->delete('guestbook')
        ->condition('id', $this->id)
        ->execute();
        \Drupal::messenger()->addStatus('You delete your review');
        $form_state->setRedirect('guestbook.front');
    }
}
