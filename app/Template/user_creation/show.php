<div class="page-header">
    <h2><?= t('New User') ?></h2>
</div>
<form method="post" action="<?= $this->url->href('UserCreationController', 'save') ?>">
    <?= $this->form->csrf() ?>

    <div class="form-columns">
        <div class="form-column">
            <fieldset>
                <legend><?= t('Profile') ?></legend>

                <?= $this->form->label(t('Username'), 'username') ?>
                <?= $this->form->text('username', $values, $errors, array('autofocus', 'required', 'maxlength="191"', 'autocomplete="username"')) ?>

                <?= $this->form->label(t('Name'), 'name') ?>
                <?= $this->form->text('name', $values, $errors, ['autocomplete="name"']) ?>

                <?= $this->form->label(t('Email'), 'email') ?>
                <?= $this->form->email('email', $values, $errors, ['autocomplete="email"']) ?>
            </fieldset>

            <fieldset>
                <legend><?= t('Authentication') ?></legend>
                <?= $this->form->checkbox('is_ldap_user', t('Remote user'), 1, isset($values['is_ldap_user']) && $values['is_ldap_user'] == 1) ?>
                <p class="form-help"><?= t('If checked, this user will use a third-party system for authentication.') ?></p>

                <?= $this->form->label(t('Password'), 'password') ?>
                <?= $this->form->password('password', $values, $errors, ['autocomplete="new-password"']) ?>
                <p class="form-help"><?= t('The password is necessary only for local users.') ?></p>

                <?= $this->form->label(t('Confirmation'), 'confirmation') ?>
                <?= $this->form->password('confirmation', $values, $errors) ?>
            </fieldset>
        </div>

        <div class="form-column">
            <fieldset>
                <legend><?= t('Security') ?></legend>

                <?= $this->form->label(t('Role'), 'role') ?>
                <?= $this->form->select('role', $roles, $values, $errors) ?>

                <?= $this->form->checkbox('disable_login_form', t('Disallow login form'), 1, isset($values['disable_login_form']) && $values['disable_login_form'] == 1) ?>
            </fieldset>

            <fieldset>
                <legend><?= t('Preferences') ?></legend>
                <?= $this->form->label(t('Timezone'), 'timezone') ?>
                <?= $this->form->select('timezone', $timezones, $values, $errors) ?>

                <?= $this->form->label(t('Language'), 'language') ?>
                <?= $this->form->select('language', $languages, $values, $errors) ?>

                <?= $this->form->label(t('Filter'), 'filter') ?>
                <?= $this->form->text('filter', $values, $errors) ?>

                <?php if ($this->app->config('notifications_enabled') == 1): ?>
                    <input type="hidden" name="notifications_enabled" value="1">
                <?php else: ?>
                    <?= $this->form->checkbox('notifications_enabled', t('Enable email notifications'), 1, isset($values['notifications_enabled']) && $values['notifications_enabled'] == 1 ? true : false) ?>
                <?php endif; ?>
            </fieldset>

            <fieldset>
                <legend><?= t('Projects') ?></legend>

                <?= $this->form->label(t('Add this person to this project'), 'project_id') ?>
                <?= $this->form->select('project_id', $projects, $values, $errors) ?>
            </fieldset>
        </div>
    </div>

    <?= $this->modal->submitButtons() ?>
</form>
