<?php

namespace Kanboard\Action;

use Kanboard\Model\TaskModel;

/**
 * Assign a Task to the creator in a specific column
 *
 * @package Kanboard\Action
 * @author  Glukose1
 */
class TaskAssignToUserOnCreationInColumn extends Base
{
    /**
     * Get automatic action description
     *
     * @access public
     * @return string
     */
    public function getDescription()
    {
        return t('Assign the task to its creator for specific columns if no assignee is set manually');
    }

    /**
     * Get the list of compatible events
     *
     * @access public
     * @return array
     */
    public function getCompatibleEvents()
    {
        return array(
            TaskModel::EVENT_CREATE,
        );
    }

    /**
     * Get the required parameter for the action (defined by the user)
     *
     * @access public
     * @return array
     */
    public function getActionRequiredParameters()
    {
        return array(
            'column_id' => t('Column'),
        );
    }

    /**
     * Get the required parameter for the event
     *
     * @access public
     * @return string[]
     */
    public function getEventRequiredParameters()
    {
        return array(
            'task_id',
            'task' => array(
                'project_id',
                'column_id',
                'creator_id',
            ),
        );
    }

    /**
     * Execute the action
     *
     * @access public
     * @param  array   $data   Event data dictionary
     * @return bool            True if the action was executed or false when not executed
     */
    public function doAction(array $data)
    {

        $assignee_id = $this->userModel->getIdByUsername($data['task']['assignee_username']);

        if ($data['task']['assignee_username']) {
            $values = array(
                'id' => $data['task_id'],
                'owner_id' => $assignee_id,
            );
            return $this->taskModificationModel->update($values);
        }

        $values = array(
            'id' => $data['task_id'],
            'owner_id' => $data['task']['creator_id'],
        );

        return $this->taskModificationModel->update($values);
    }

    /**
     * Check if the event data meet the action condition
     *
     * @access public
     * @param  array   $data   Event data dictionary
     * @return bool
     */
    public function hasRequiredCondition(array $data)
    {
        return $data['task']['column_id'] == $this->getParam('column_id');
    }
}
