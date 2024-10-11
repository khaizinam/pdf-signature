<?php

namespace Dev\Projects\Http\Controllers;

use Dev\Base\Http\Actions\DeleteResourceAction;
use Dev\Projects\Http\Requests\ProjectsRequest;
use Dev\Projects\Models\Projects;
use Dev\Base\Facades\PageTitle;
use Dev\Base\Http\Controllers\BaseController;
use Dev\Projects\Tables\ProjectsTable;
use Dev\Projects\Forms\ProjectsForm;

class ProjectsController extends BaseController
{
    public function __construct()
    {
        $this
            ->breadcrumb()
            ->add(trans(trans('plugins/projects::projects.name')), route('projects.index'));
    }

    public function index(ProjectsTable $table)
    {
        $this->pageTitle(trans('plugins/projects::projects.name'));

        return $table->renderTable();
    }

    public function create()
    {
        $this->pageTitle(trans('plugins/projects::projects.create'));

        return ProjectsForm::create()->renderForm();
    }

    public function store(ProjectsRequest $request)
    {
        $form = ProjectsForm::create()->setRequest($request);

        $form->save();

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('projects.index'))
            ->setNextUrl(route('projects.edit', $form->getModel()->getKey()))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(Projects $projects)
    {
        $this->pageTitle(trans('core/base::forms.edit_item', ['name' => $projects->name]));

        return ProjectsForm::createFromModel($projects)->renderForm();
    }

    public function update(Projects $projects, ProjectsRequest $request)
    {
        ProjectsForm::createFromModel($projects)
            ->setRequest($request)
            ->save();

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('projects.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(Projects $projects)
    {
        return DeleteResourceAction::make($projects);
    }
}
