<?php
/**
 * @file
 * Contains  \Drupal\rsvplist\Form\RSVPSettingsForm
 */

namespace Drupal\rsvplist\Form;

use Drupal\Core\Form\ConfigFormBase;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\Form\FormStateInterface;

/**
 * Define a form to configuration setings
 */

class RSVPSettingsForm extends ConfigFormBase {
    /**
     * {@inheritdoc}
     */
    public function getFormId()
    {
        return 'rsvplist_admin_settings';
    }

    /**
     * {@inheritdoc}
     */
    protected function getEditableConfigNames()
    {
     return ['rsvplist.settings'];
        // TODO: Implement getEditableConfigNames() method.
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state, Request $request = NULL) {
        $types = node_type_get_names();
        $config = $this->config('rsvplist.settings');
        $form['rsvplist_types'] = array(
            '#type' => 'checkboxes',
            '#title' => $this->t('The content types to enable RSVP collection for'),
            '#default_value' => $config->get('allowed_types'),
            '#options' => $types,
            '#description' => t('On the specified node types, an RSVP option will be available and can be enabled while tht node is being edited.'),
        );
        $form['array_filter'] = array('#type' => 'value', '#value' => TRUE);

        return parent::buildForm($form,$form_state);
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
        $allowed_types = array_filter($form_state->getValue('rsvplist_types'));
        sort($allowed_types);
        $this->config('rsvplist.settings')
            ->set('allowed_types', $allowed_types)
            ->save();
        parent::submitForm($form, $form_state);

    }
}